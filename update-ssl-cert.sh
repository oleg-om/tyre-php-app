#!/bin/bash

# Скрипт для обновления SSL сертификата Let's Encrypt в Docker volume
# Использование: ./update-ssl-cert.sh [домен]
# Пример: ./update-ssl-cert.sh example.com

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Загрузка переменных окружения
if [ -f .env ]; then
    export $(cat .env | grep -v '^#' | xargs)
fi

# Определение домена
DOMAIN=${1:-${ALLOWED_DOMAIN:-}}
VOLUME_NAME="tyre-app-ssl"
CONTAINER_NAME="tyre-app-php"

# Проверка аргументов
if [ -z "$DOMAIN" ]; then
    echo -e "${RED}Ошибка: Укажите домен${NC}"
    echo "Использование: $0 <домен>"
    echo "Пример: $0 example.com"
    echo ""
    echo "Или установите ALLOWED_DOMAIN в .env файле"
    exit 1
fi

echo -e "${BLUE}Обновление SSL сертификата для домена: $DOMAIN${NC}"
echo ""

# Проверка наличия certbot
if ! command -v certbot &> /dev/null; then
    echo -e "${RED}Ошибка: certbot не установлен${NC}"
    echo "Установите certbot:"
    echo "  sudo apt-get update"
    echo "  sudo apt-get install certbot"
    exit 1
fi

# Проверка наличия Docker
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Ошибка: Docker не установлен${NC}"
    exit 1
fi

# Проверка существования сертификатов Let's Encrypt
CERT_DIR="/etc/letsencrypt/live/$DOMAIN"
if [ ! -d "$CERT_DIR" ]; then
    echo -e "${YELLOW}Сертификаты Let's Encrypt для $DOMAIN не найдены${NC}"
    echo "Получите сертификат сначала:"
    echo "  sudo certbot certonly --standalone -d $DOMAIN -d www.$DOMAIN"
    exit 1
fi

# Проверка существования volume
if ! docker volume inspect "$VOLUME_NAME" &> /dev/null; then
    echo -e "${YELLOW}Volume $VOLUME_NAME не найден. Создаю...${NC}"
    docker volume create "$VOLUME_NAME"
fi

# Обновление сертификата (certbot renew проверяет и обновляет только если нужно)
echo -e "${YELLOW}Проверка необходимости обновления сертификата...${NC}"
if sudo certbot renew --dry-run &> /dev/null; then
    echo -e "${GREEN}Сертификат актуален, обновление не требуется${NC}"
else
    echo -e "${YELLOW}Обновление сертификата...${NC}"
    sudo certbot renew --quiet
    if [ $? -ne 0 ]; then
        echo -e "${RED}Ошибка при обновлении сертификата${NC}"
        exit 1
    fi
    echo -e "${GREEN}Сертификат обновлен${NC}"
fi

# Копирование сертификатов в Docker volume
echo -e "${YELLOW}Копирование сертификатов в Docker volume...${NC}"

# Определяем пути к файлам (используем прямые пути, readlink разрешит символические ссылки)
FULLCHAIN_SOURCE="/etc/letsencrypt/live/${DOMAIN}/fullchain.pem"
PRIVKEY_SOURCE="/etc/letsencrypt/live/${DOMAIN}/privkey.pem"

# Проверяем существование файлов
if [ ! -f "$FULLCHAIN_SOURCE" ] || [ ! -r "$FULLCHAIN_SOURCE" ]; then
    echo -e "${RED}Ошибка: Не удалось найти или прочитать fullchain.pem${NC}"
    echo "Путь: $FULLCHAIN_SOURCE"
    exit 1
fi

if [ ! -f "$PRIVKEY_SOURCE" ] || [ ! -r "$PRIVKEY_SOURCE" ]; then
    echo -e "${RED}Ошибка: Не удалось найти или прочитать privkey.pem${NC}"
    echo "Путь: $PRIVKEY_SOURCE"
    exit 1
fi

# Определяем реальные пути (разрешаем символические ссылки)
FULLCHAIN_REAL=$(readlink -f "$FULLCHAIN_SOURCE" 2>/dev/null || realpath "$FULLCHAIN_SOURCE" 2>/dev/null || echo "$FULLCHAIN_SOURCE")
PRIVKEY_REAL=$(readlink -f "$PRIVKEY_SOURCE" 2>/dev/null || realpath "$PRIVKEY_SOURCE" 2>/dev/null || echo "$PRIVKEY_SOURCE")

echo "Copying certificates:"
echo "  Source fullchain: $FULLCHAIN_SOURCE (real: $FULLCHAIN_REAL)"
echo "  Source privkey: $PRIVKEY_SOURCE (real: $PRIVKEY_REAL)"
echo "  Target volume: $VOLUME_NAME"

# Копируем файлы напрямую, читая их содержимое и записывая в volume
# Это гарантирует, что мы копируем реальные файлы, а не символические ссылки
docker run --rm \
    -v ${VOLUME_NAME}:/ssl \
    -v "$FULLCHAIN_REAL:/source_fullchain:ro" \
    -v "$PRIVKEY_REAL:/source_privkey:ro" \
    alpine sh -c "
        # Удаляем старые сертификаты
        rm -f /ssl/server.crt /ssl/server.key
        
        # Копируем содержимое файлов
        cat /source_fullchain > /ssl/server.crt
        cat /source_privkey > /ssl/server.key
        
        # Устанавливаем права доступа
        chmod 600 /ssl/server.key
        chmod 644 /ssl/server.crt
        chown root:root /ssl/server.key /ssl/server.crt
        
        # Проверяем, что файлы скопировались
        if [ -f /ssl/server.crt ] && [ -f /ssl/server.key ]; then
            # Проверяем базовую структуру PEM файлов (наличие BEGIN/END)
            if grep -q 'BEGIN CERTIFICATE' /ssl/server.crt && grep -q 'END CERTIFICATE' /ssl/server.crt; then
                if grep -q 'BEGIN.*PRIVATE KEY' /ssl/server.key && grep -q 'END.*PRIVATE KEY' /ssl/server.key; then
                    echo 'Certificates copied successfully'
                    ls -lh /ssl/
                    echo ''
                    echo 'Certificate file structure validated (PEM format)'
                else
                    echo 'ERROR: Private key is not in PEM format'
                    exit 1
                fi
            else
                echo 'ERROR: Certificate is not in PEM format'
                exit 1
            fi
        else
            echo 'ERROR: Failed to copy certificates'
            exit 1
        fi
    " 2>&1

COPY_RESULT=$?
if [ $COPY_RESULT -eq 0 ]; then
    echo -e "${GREEN}✓ Сертификаты скопированы в Docker volume${NC}"
    
    # Проверяем, что сертификаты действительно Let's Encrypt (используем openssl на хосте)
    echo -e "${YELLOW}Проверка сертификата в volume...${NC}"
    if command -v openssl &> /dev/null; then
        # Временно копируем сертификат из volume для проверки
        TEMP_CERT=$(mktemp)
        docker run --rm -v ${VOLUME_NAME}:/ssl alpine cat /ssl/server.crt > "$TEMP_CERT" 2>/dev/null
        
        if [ -f "$TEMP_CERT" ] && [ -s "$TEMP_CERT" ]; then
            CERT_ISSUER=$(openssl x509 -in "$TEMP_CERT" -noout -issuer 2>/dev/null || echo "")
            CERT_SUBJECT=$(openssl x509 -in "$TEMP_CERT" -noout -subject 2>/dev/null || echo "")
            CERT_DATES=$(openssl x509 -in "$TEMP_CERT" -noout -dates 2>/dev/null || echo "")
            rm -f "$TEMP_CERT"
            
            if echo "$CERT_ISSUER" | grep -qi "let's encrypt\|letsencrypt"; then
                echo -e "${GREEN}✓ Let's Encrypt сертификат подтвержден в volume${NC}"
                echo "  Subject: $CERT_SUBJECT"
                echo "  Issuer: $CERT_ISSUER"
                echo "  Dates: $CERT_DATES"
            else
                echo -e "${RED}✗ ОШИБКА: Сертификат в volume не является Let's Encrypt!${NC}"
                echo "  Subject: $CERT_SUBJECT"
                echo "  Issuer: $CERT_ISSUER"
                echo "  Dates: $CERT_DATES"
                echo ""
                echo -e "${YELLOW}Проверьте исходные файлы Let's Encrypt:${NC}"
                echo "  Fullchain: $FULLCHAIN_SOURCE"
                echo "  Privkey: $PRIVKEY_SOURCE"
                if [ -f "$FULLCHAIN_SOURCE" ]; then
                    echo "  Fullchain issuer: $(openssl x509 -in "$FULLCHAIN_SOURCE" -noout -issuer 2>/dev/null || echo 'Cannot read')"
                fi
                exit 1
            fi
        else
            echo -e "${RED}✗ Не удалось прочитать сертификат из volume для проверки${NC}"
            exit 1
        fi
    else
        echo -e "${YELLOW}⚠ openssl не установлен на хосте, пропускаем проверку issuer${NC}"
        echo -e "${YELLOW}⚠ Рекомендуется установить openssl для проверки сертификатов${NC}"
    fi
else
    echo -e "${RED}✗ Ошибка при копировании сертификатов (код выхода: $COPY_RESULT)${NC}"
    exit 1
fi

# Перезапуск контейнера PHP для применения изменений
echo -e "${YELLOW}Перезапуск контейнера PHP...${NC}"
# Используем docker compose (без дефиса) если доступен, иначе docker-compose
if command -v docker &> /dev/null && docker compose version &> /dev/null; then
    DOCKER_COMPOSE_CMD="docker compose"
else
    DOCKER_COMPOSE_CMD="docker-compose"
fi

if $DOCKER_COMPOSE_CMD restart "$CONTAINER_NAME" 2>/dev/null; then
    echo -e "${GREEN}✓ Контейнер перезапущен${NC}"
    
    # Ждем немного, чтобы Apache запустился
    sleep 3
    
    # Проверяем сертификат в контейнере
    echo -e "${YELLOW}Проверка сертификата в контейнере...${NC}"
    if docker exec "$CONTAINER_NAME" openssl x509 -in /etc/apache2/ssl/server.crt -noout -issuer 2>/dev/null | grep -qi "let's encrypt"; then
        echo -e "${GREEN}✓ Let's Encrypt сертификат активен в контейнере${NC}"
    else
        echo -e "${YELLOW}⚠ Внимание: Контейнер все еще использует старый сертификат${NC}"
        echo "Попробуйте пересобрать контейнер: docker compose down && docker compose up -d --build"
    fi
else
    echo -e "${YELLOW}⚠ Не удалось перезапустить контейнер автоматически${NC}"
    echo "Перезапустите вручную: docker compose restart $CONTAINER_NAME"
fi

echo ""
echo -e "${GREEN}SSL сертификат успешно обновлен!${NC}"
echo -e "${BLUE}Проверьте работу сайта: https://$DOMAIN${NC}"
