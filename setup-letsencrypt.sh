#!/bin/bash

# Скрипт для первоначальной настройки Let's Encrypt SSL сертификата
# Использование: ./setup-letsencrypt.sh [домен]
# Пример: ./setup-letsencrypt.sh example.com

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

echo -e "${BLUE}Настройка Let's Encrypt SSL сертификата для домена: $DOMAIN${NC}"
echo ""

# Проверка наличия certbot
if ! command -v certbot &> /dev/null; then
    echo -e "${YELLOW}certbot не установлен. Устанавливаю...${NC}"
    sudo apt-get update
    sudo apt-get install -y certbot
    if [ $? -ne 0 ]; then
        echo -e "${RED}Ошибка при установке certbot${NC}"
        exit 1
    fi
    echo -e "${GREEN}✓ certbot установлен${NC}"
fi

# Проверка наличия Docker
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Ошибка: Docker не установлен${NC}"
    exit 1
fi

# Проверка, что домен указывает на этот сервер
echo -e "${YELLOW}Проверка DNS...${NC}"
SERVER_IP=$(curl -s ifconfig.me || curl -s ipinfo.io/ip)
DOMAIN_IP=$(dig +short $DOMAIN | tail -1)

if [ "$DOMAIN_IP" != "$SERVER_IP" ]; then
    echo -e "${RED}⚠ Внимание: Домен $DOMAIN указывает на $DOMAIN_IP, а сервер имеет IP $SERVER_IP${NC}"
    echo -e "${YELLOW}Убедитесь, что DNS настроен правильно перед продолжением${NC}"
    read -p "Продолжить? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
else
    echo -e "${GREEN}✓ DNS настроен правильно ($DOMAIN -> $DOMAIN_IP)${NC}"
fi

# Остановка контейнера PHP для освобождения портов 80 и 443
echo -e "${YELLOW}Остановка контейнера PHP для освобождения портов...${NC}"
# Используем docker compose (без дефиса) если доступен, иначе docker-compose
if command -v docker &> /dev/null && docker compose version &> /dev/null; then
    DOCKER_COMPOSE_CMD="docker compose"
else
    DOCKER_COMPOSE_CMD="docker-compose"
fi

$DOCKER_COMPOSE_CMD stop "$CONTAINER_NAME" 2>/dev/null || true
sleep 2

# Получение сертификата
echo -e "${YELLOW}Получение SSL сертификата от Let's Encrypt...${NC}"
echo -e "${BLUE}Это может занять несколько минут...${NC}"

sudo certbot certonly --standalone \
    --preferred-challenges http \
    -d "$DOMAIN" \
    -d "www.$DOMAIN" \
    --email "admin@$DOMAIN" \
    --agree-tos \
    --non-interactive

if [ $? -ne 0 ]; then
    echo -e "${RED}Ошибка при получении сертификата${NC}"
    echo -e "${YELLOW}Запускаю контейнер обратно...${NC}"
    $DOCKER_COMPOSE_CMD start "$CONTAINER_NAME" 2>/dev/null || $DOCKER_COMPOSE_CMD up -d "$CONTAINER_NAME" 2>/dev/null
    exit 1
fi

echo -e "${GREEN}✓ Сертификат получен успешно${NC}"

# Создание volume если не существует
if ! docker volume inspect "$VOLUME_NAME" &> /dev/null; then
    echo -e "${YELLOW}Создание Docker volume для SSL сертификатов...${NC}"
    docker volume create "$VOLUME_NAME"
fi

# Копирование сертификатов в Docker volume
echo -e "${YELLOW}Копирование сертификатов в Docker volume...${NC}"

# Определяем пути к файлам
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

# Копируем файлы напрямую, читая их содержимое и записывая в volume
docker run --rm \
    -v ${VOLUME_NAME}:/ssl \
    -v "$FULLCHAIN_REAL:/source_fullchain:ro" \
    -v "$PRIVKEY_REAL:/source_privkey:ro" \
    alpine sh -c "
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

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Сертификаты скопированы в Docker volume${NC}"
else
    echo -e "${RED}✗ Ошибка при копировании сертификатов${NC}"
    $DOCKER_COMPOSE_CMD start "$CONTAINER_NAME" 2>/dev/null || $DOCKER_COMPOSE_CMD up -d "$CONTAINER_NAME" 2>/dev/null
    exit 1
fi

# Обновление .env файла
echo -e "${YELLOW}Обновление .env файла...${NC}"
if [ -f .env ]; then
    # Обновляем ALLOWED_DOMAIN если нужно
    if ! grep -q "ALLOWED_DOMAIN=$DOMAIN" .env; then
        sed -i "s/^ALLOWED_DOMAIN=.*/ALLOWED_DOMAIN=$DOMAIN/" .env || \
        echo "ALLOWED_DOMAIN=$DOMAIN" >> .env
        echo -e "${GREEN}✓ .env файл обновлен${NC}"
    fi
else
    echo -e "${YELLOW}⚠ .env файл не найден, создайте его вручную${NC}"
fi

# Полное пересоздание контейнера для применения обновленных сертификатов
echo -e "${YELLOW}Пересоздание контейнера PHP для применения сертификатов...${NC}"
$DOCKER_COMPOSE_CMD stop "$CONTAINER_NAME" 2>/dev/null || true
$DOCKER_COMPOSE_CMD rm -f "$CONTAINER_NAME" 2>/dev/null || true
$DOCKER_COMPOSE_CMD up -d "$CONTAINER_NAME" 2>/dev/null

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Контейнер пересоздан${NC}"
    
    # Ждем запуска контейнера
    echo -e "${YELLOW}Ожидание запуска контейнера...${NC}"
    sleep 5
    
    # Проверяем, что контейнер видит правильные сертификаты
    echo -e "${YELLOW}Проверка сертификата в контейнере...${NC}"
    if docker exec "$CONTAINER_NAME" openssl x509 -in /etc/apache2/ssl/server.crt -noout -issuer 2>/dev/null | grep -qi "let's encrypt\|letsencrypt"; then
        echo -e "${GREEN}✓ Let's Encrypt сертификат активен в контейнере${NC}"
        docker exec "$CONTAINER_NAME" openssl x509 -in /etc/apache2/ssl/server.crt -noout -subject -issuer -dates 2>/dev/null || true
    else
        echo -e "${YELLOW}⚠ Внимание: Контейнер все еще использует старый сертификат${NC}"
        echo "Проверяю содержимое volume и контейнера..."
        echo "Volume:"
        docker run --rm -v ${VOLUME_NAME}:/ssl alpine sh -c "openssl x509 -in /ssl/server.crt -noout -issuer 2>/dev/null || echo 'Cannot read'" 2>/dev/null
        echo "Container:"
        docker exec "$CONTAINER_NAME" openssl x509 -in /etc/apache2/ssl/server.crt -noout -issuer 2>/dev/null || echo "Cannot read"
        echo ""
        echo -e "${YELLOW}Попробуйте полностью пересоздать контейнер:${NC}"
        echo "  docker compose down"
        echo "  docker compose up -d"
    fi
else
    echo -e "${RED}✗ Ошибка при запуске контейнера. Проверьте логи.${NC}"
    exit 1
fi

# Настройка автоматического обновления
echo -e "${YELLOW}Настройка автоматического обновления сертификата...${NC}"
SCRIPT_PATH="$(cd "$(dirname "$0")" && pwd)/update-ssl-cert.sh"

# Проверяем, есть ли уже запись в crontab
if sudo crontab -l 2>/dev/null | grep -q "update-ssl-cert.sh"; then
    echo -e "${GREEN}✓ Автоматическое обновление уже настроено${NC}"
else
    # Добавляем в crontab (проверка каждый день в 3:00)
    (sudo crontab -l 2>/dev/null; echo "0 3 * * * $SCRIPT_PATH $DOMAIN >> /var/log/ssl-renew.log 2>&1") | sudo crontab -
    echo -e "${GREEN}✓ Автоматическое обновление настроено (каждый день в 3:00)${NC}"
fi

echo ""
echo -e "${GREEN}════════════════════════════════════════${NC}"
echo -e "${GREEN}SSL сертификат успешно настроен!${NC}"
echo -e "${BLUE}Домен: $DOMAIN${NC}"
echo -e "${BLUE}Проверьте: https://$DOMAIN${NC}"
echo -e "${BLUE}Проверьте: https://www.$DOMAIN${NC}"
echo ""
echo -e "${YELLOW}Для обновления сертификата вручную:${NC}"
echo -e "${YELLOW}  ./update-ssl-cert.sh $DOMAIN${NC}"
echo -e "${GREEN}════════════════════════════════════════${NC}"
