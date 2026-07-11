#!/bin/bash
#
# Обновление Let's Encrypt SSL и применение сертификата в Docker volume.
#
# Использование:
#   ./update-ssl-cert.sh [домен]
#   ./update-ssl-cert.sh example.com
#   FORCE_RENEW=1 ./update-ssl-cert.sh example.com   # принудительно выпустить новый сертификат
#
# Важно про срок действия:
#   Let's Encrypt ВСЕГДА выдаёт сертификат максимум на ~90 дней.
#   Увеличить срок через certbot нельзя — это правило CA.
#   Надёжный способ: автообновление раз в 1–2 месяца (cron через setup-cron.sh).
#
set -euo pipefail

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
cd "$SCRIPT_DIR"

if [ -f .env ]; then
    set -a
    # shellcheck disable=SC1091
    . ./.env
    set +a
fi

DOMAIN="${1:-${ALLOWED_DOMAIN:-}}"
CONTAINER_NAME="tyre-app-php"
FORCE_RENEW="${FORCE_RENEW:-0}"
STOPPED_APP=0

log()  { echo -e "${BLUE}$*${NC}"; }
ok()   { echo -e "${GREEN}✓ $*${NC}"; }
warn() { echo -e "${YELLOW}⚠ $*${NC}"; }
err()  { echo -e "${RED}✗ $*${NC}" >&2; }

die() {
    err "$*"
    exit 1
}

cleanup() {
    if [ "$STOPPED_APP" -eq 1 ]; then
        warn "Возвращаю приложение после ошибки..."
        start_app || true
    fi
}
trap cleanup EXIT

require_cmd() {
    command -v "$1" >/dev/null 2>&1 || die "Не найдена команда: $1"
}

compose_cmd() {
    if docker compose version >/dev/null 2>&1; then
        echo "docker compose"
    elif command -v docker-compose >/dev/null 2>&1; then
        echo "docker-compose"
    else
        die "Не найден docker compose / docker-compose"
    fi
}

resolve_volume_name() {
    local vol=""
    if docker inspect "$CONTAINER_NAME" >/dev/null 2>&1; then
        vol="$(docker inspect -f '{{range .Mounts}}{{if eq .Destination "/etc/apache2/ssl"}}{{.Name}}{{end}}{{end}}' "$CONTAINER_NAME" 2>/dev/null || true)"
    fi
    if [ -n "$vol" ]; then
        echo "$vol"
        return
    fi

    local project
    project="$(basename "$SCRIPT_DIR")"
    echo "${project}_tyre-app-ssl"
}

cert_expiry_epoch() {
    local file="$1"
    local end
    end="$(openssl x509 -in "$file" -noout -enddate 2>/dev/null | cut -d= -f2)"
    date -d "$end" +%s 2>/dev/null || date -j -f "%b %d %T %Y %Z" "$end" +%s 2>/dev/null
}

days_left() {
    local file="$1"
    local exp now
    exp="$(cert_expiry_epoch "$file")"
    now="$(date +%s)"
    echo $(( (exp - now) / 86400 ))
}

show_cert_info() {
    local label="$1"
    local file="$2"
    echo ""
    log "--- $label ---"
    openssl x509 -in "$file" -noout -subject -issuer -dates 2>/dev/null || warn "Не удалось прочитать: $file"
}

port80_in_use() {
    if command -v ss >/dev/null 2>&1; then
        ss -ltn "( sport = :80 )" 2>/dev/null | grep -q ':80'
        return $?
    fi
    if command -v lsof >/dev/null 2>&1; then
        lsof -iTCP:80 -sTCP:LISTEN >/dev/null 2>&1
        return $?
    fi
    return 1
}

stop_app() {
    local dc
    dc="$(compose_cmd)"
    log "Останавливаю $CONTAINER_NAME, чтобы освободить порт 80 для ACME..."
    $dc stop "$CONTAINER_NAME" >/dev/null 2>&1 || true
    # На случай, если контейнер висит без compose
    docker stop "$CONTAINER_NAME" >/dev/null 2>&1 || true
    STOPPED_APP=1

    local i=0
    while port80_in_use && [ $i -lt 30 ]; do
        sleep 1
        i=$((i + 1))
    done

    if port80_in_use; then
        warn "Порт 80 всё ещё занят. Кто слушает:"
        if command -v ss >/dev/null 2>&1; then
            ss -ltnp "( sport = :80 )" || true
        else
            lsof -iTCP:80 -sTCP:LISTEN || true
        fi
        die "Освободите порт 80 и повторите"
    fi
    ok "Порт 80 свободен"
}

start_app() {
    local dc
    dc="$(compose_cmd)"
    log "Запускаю $CONTAINER_NAME..."
    $dc up -d "$CONTAINER_NAME" >/dev/null
    STOPPED_APP=0

    local i=0
    while ! docker exec "$CONTAINER_NAME" true >/dev/null 2>&1 && [ $i -lt 60 ]; do
        sleep 1
        i=$((i + 1))
    done
    docker exec "$CONTAINER_NAME" true >/dev/null 2>&1 || die "Контейнер $CONTAINER_NAME не запустился"
    ok "Контейнер запущен"
}

reload_apache_ssl() {
    log "Перезагружаю Apache, чтобы подхватил новые файлы сертификата..."
    # graceful часто оставляет старый SSL в воркерах — делаем полный restart apache в контейнере
    if docker exec "$CONTAINER_NAME" apache2ctl configtest >/dev/null 2>&1; then
        docker exec "$CONTAINER_NAME" apache2ctl stop >/dev/null 2>&1 || true
        sleep 1
        docker exec "$CONTAINER_NAME" apache2ctl start >/dev/null 2>&1 \
            || docker exec "$CONTAINER_NAME" service apache2 start >/dev/null 2>&1 \
            || true
    fi
    # Надёжный fallback: recreate контейнера (volume уже с новым сертификатом)
    local dc
    dc="$(compose_cmd)"
    $dc up -d --force-recreate "$CONTAINER_NAME" >/dev/null
    sleep 3
    ok "Apache/контейнер пересоздан с новым сертификатом"
}

copy_certs_to_volume() {
    local volume="$1"
    local fullchain="$2"
    local privkey="$3"
    local fullchain_real privkey_real

    fullchain_real="$(readlink -f "$fullchain" 2>/dev/null || realpath "$fullchain" 2>/dev/null || echo "$fullchain")"
    privkey_real="$(readlink -f "$privkey" 2>/dev/null || realpath "$privkey" 2>/dev/null || echo "$privkey")"

    [ -r "$fullchain_real" ] || die "Нет доступа к $fullchain_real (нужен sudo?)"
    [ -r "$privkey_real" ] || die "Нет доступа к $privkey_real (нужен sudo?)"

    log "Копирую сертификаты в volume: $volume"
    echo "  fullchain: $fullchain_real"
    echo "  privkey:   $privkey_real"

    if ! docker volume inspect "$volume" >/dev/null 2>&1; then
        docker volume create "$volume" >/dev/null
    fi

    # Копируем через sudo cat — live/*.pem часто readable только root
    local tmp_dir
    tmp_dir="$(mktemp -d)"
    sudo cat "$fullchain_real" > "$tmp_dir/fullchain.pem"
    sudo cat "$privkey_real" > "$tmp_dir/privkey.pem"
    chmod 600 "$tmp_dir/privkey.pem"
    chmod 644 "$tmp_dir/fullchain.pem"

    docker run --rm \
        -v "${volume}:/ssl" \
        -v "$tmp_dir/fullchain.pem:/source_fullchain:ro" \
        -v "$tmp_dir/privkey.pem:/source_privkey:ro" \
        alpine sh -c '
            set -e
            rm -f /ssl/server.crt /ssl/server.key /ssl/.server.crt /ssl/.server.key
            cat /source_fullchain > /ssl/server.crt
            cat /source_privkey > /ssl/server.key
            chmod 644 /ssl/server.crt
            chmod 600 /ssl/server.key
            grep -q "BEGIN CERTIFICATE" /ssl/server.crt
            grep -q "BEGIN" /ssl/server.key
            sync
            ls -lh /ssl/server.crt /ssl/server.key
        '

    rm -rf "$tmp_dir"
    ok "Сертификаты записаны в volume"
}

verify_live_https() {
    local domain="$1"
    local expected_end="$2"
    local live_end=""

    log "Проверяю сертификат, который реально отдаёт https://$domain ..."
    sleep 2

    live_end="$(echo | openssl s_client -servername "$domain" -connect "${domain}:443" 2>/dev/null \
        | openssl x509 -noout -enddate 2>/dev/null | cut -d= -f2 || true)"

    if [ -z "$live_end" ]; then
        warn "Не удалось получить сертификат с :443 (возможно, DNS/firewall)."
        warn "Проверьте вручную: echo | openssl s_client -servername $domain -connect $domain:443 2>/dev/null | openssl x509 -noout -dates"
        return 1
    fi

    echo "  Ожидаемый notAfter (из LE): $expected_end"
    echo "  Фактический notAfter (:443): $live_end"

    if [ "$live_end" = "$expected_end" ]; then
        ok "Клиентский HTTPS отдаёт обновлённый сертификат"
        return 0
    fi

    err "HTTPS на :443 отдаёт ДРУГОЙ сертификат (не тот, что только что выпущен)."
    warn "Возможные причины: CDN/прокси перед сервером, другой контейнер на 443, кэш браузера."
    return 1
}

# -------------------- main --------------------

[ -n "$DOMAIN" ] || die "Укажите домен: $0 <домен>  или ALLOWED_DOMAIN в .env"

require_cmd docker
require_cmd openssl

if ! command -v certbot >/dev/null 2>&1; then
    die "certbot не установлен. Установите: sudo apt-get install -y certbot"
fi

CERT_DIR="/etc/letsencrypt/live/${DOMAIN}"
FULLCHAIN="${CERT_DIR}/fullchain.pem"
PRIVKEY="${CERT_DIR}/privkey.pem"
VOLUME_NAME="$(resolve_volume_name)"

log "Обновление SSL для: $DOMAIN"
echo "  Volume:    $VOLUME_NAME"
echo "  Container: $CONTAINER_NAME"
echo "  Force:     $FORCE_RENEW"
echo ""
warn "Let's Encrypt выдаёт сертификат максимум на ~90 дней — увеличить срок нельзя."
warn "Автообновление (cron) — правильный способ держать HTTPS валидным."
echo ""

NEED_RENEW=0
if ! sudo test -f "$FULLCHAIN"; then
    die "Сертификат не найден: $FULLCHAIN. Сначала: ./setup-letsencrypt.sh $DOMAIN"
fi

# Читаем текущий сертификат через sudo (права root)
TMP_CURRENT="$(mktemp)"
sudo cat "$FULLCHAIN" > "$TMP_CURRENT"
CURRENT_DAYS="$(days_left "$TMP_CURRENT" || echo 0)"
CURRENT_END="$(openssl x509 -in "$TMP_CURRENT" -noout -enddate 2>/dev/null | cut -d= -f2 || echo unknown)"
show_cert_info "Текущий сертификат на диске (Let's Encrypt)" "$TMP_CURRENT"
echo "  Осталось дней: $CURRENT_DAYS"

if [ "$FORCE_RENEW" = "1" ]; then
    NEED_RENEW=1
    warn "FORCE_RENEW=1 — принудительный выпуск нового сертификата"
elif [ "$CURRENT_DAYS" -le 30 ]; then
    NEED_RENEW=1
    warn "До истечения ≤ 30 дней — нужно обновление"
else
    ok "До истечения > 30 дней. Новый выпуск не обязателен."
    echo "  Чтобы выпустить новый сейчас: FORCE_RENEW=1 $0 $DOMAIN"
fi

# Всегда останавливаем app перед ACME standalone (и перед dry/renew)
stop_app

if [ "$NEED_RENEW" -eq 1 ]; then
    log "Запрашиваю новый сертификат у Let's Encrypt (standalone, порт 80)..."
    # --force-renewal: иначе certbot может отказать, если до конца > порога renew
    RENEW_ARGS=(certonly --standalone --preferred-challenges http
        --cert-name "$DOMAIN"
        -d "$DOMAIN"
        --agree-tos --non-interactive
        --force-renewal)

    if command -v dig >/dev/null 2>&1 && dig +short "www.$DOMAIN" 2>/dev/null | grep -q .; then
        RENEW_ARGS+=(-d "www.$DOMAIN")
    fi

    if ! sudo certbot "${RENEW_ARGS[@]}"; then
        die "certbot не смог обновить сертификат"
    fi
    ok "certbot выпустил новый сертификат"
else
    log "Пропускаю выпуск нового сертификата — копирую текущий в Docker volume"
fi

# Перечитываем после возможного renew
sudo cat "$FULLCHAIN" > "$TMP_CURRENT"
NEW_END="$(openssl x509 -in "$TMP_CURRENT" -noout -enddate 2>/dev/null | cut -d= -f2)"
NEW_DAYS="$(days_left "$TMP_CURRENT")"
show_cert_info "Сертификат после операции" "$TMP_CURRENT"
echo "  Осталось дней: $NEW_DAYS"

ISSUER="$(openssl x509 -in "$TMP_CURRENT" -noout -issuer 2>/dev/null || true)"
echo "$ISSUER" | grep -qi "let's encrypt\|letsencrypt\|r3\|r10\|r11\|e1\|e5\|e6\|e7\|e8\|e9" \
    || warn "Issuer не похож на Let's Encrypt: $ISSUER"

copy_certs_to_volume "$VOLUME_NAME" "$FULLCHAIN" "$PRIVKEY"

# Проверка содержимого volume
TMP_VOL="$(mktemp)"
docker run --rm -v "${VOLUME_NAME}:/ssl" alpine cat /ssl/server.crt > "$TMP_VOL"
VOL_END="$(openssl x509 -in "$TMP_VOL" -noout -enddate 2>/dev/null | cut -d= -f2)"
show_cert_info "Сертификат в Docker volume" "$TMP_VOL"
[ "$VOL_END" = "$NEW_END" ] || die "В volume другой notAfter ($VOL_END), чем у LE ($NEW_END)"

start_app
reload_apache_ssl

# Проверка файла внутри контейнера
TMP_CTR="$(mktemp)"
docker exec "$CONTAINER_NAME" cat /etc/apache2/ssl/server.crt > "$TMP_CTR" 2>/dev/null \
    || die "Не удалось прочитать /etc/apache2/ssl/server.crt из контейнера"
CTR_END="$(openssl x509 -in "$TMP_CTR" -noout -enddate 2>/dev/null | cut -d= -f2)"
show_cert_info "Сертификат в контейнере (файл)" "$TMP_CTR"
[ "$CTR_END" = "$NEW_END" ] || die "В контейнере другой notAfter ($CTR_END), чем у LE ($NEW_END)"

verify_live_https "$DOMAIN" "$NEW_END" || true

rm -f "$TMP_CURRENT" "$TMP_VOL" "$TMP_CTR"

echo ""
ok "Готово."
echo -e "${BLUE}Проверьте в браузере (лучше инкогнито): https://${DOMAIN}${NC}"
echo -e "${BLUE}Или: echo | openssl s_client -servername ${DOMAIN} -connect ${DOMAIN}:443 2>/dev/null | openssl x509 -noout -dates${NC}"
echo ""
echo "Срок Let's Encrypt ~90 дней. Для автообновления:"
echo "  ./setup-cron.sh"
echo "Принудительный выпуск нового сертификата:"
echo "  FORCE_RENEW=1 ./update-ssl-cert.sh ${DOMAIN}"

trap - EXIT
exit 0
