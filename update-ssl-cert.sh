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

# Определяем реальные пути к файлам (разрешаем символические ссылки)
FULLCHAIN_PATH=$(readlink -f /etc/letsencrypt/live/${DOMAIN}/fullchain.pem 2>/dev/null || echo "")
PRIVKEY_PATH=$(readlink -f /etc/letsencrypt/live/${DOMAIN}/privkey.pem 2>/dev/null || echo "")

if [ -z "$FULLCHAIN_PATH" ] || [ -z "$PRIVKEY_PATH" ] || [ ! -f "$FULLCHAIN_PATH" ] || [ ! -f "$PRIVKEY_PATH" ]; then
    echo -e "${RED}Ошибка: Не удалось найти файлы сертификатов${NC}"
    echo "Проверьте пути:"
    echo "  fullchain: $FULLCHAIN_PATH"
    echo "  privkey: $PRIVKEY_PATH"
    exit 1
fi

# Монтируем архивную директорию, где находятся реальные файлы
ARCHIVE_DIR=$(dirname "$FULLCHAIN_PATH")
FULLCHAIN_BASENAME=$(basename "$FULLCHAIN_PATH")
PRIVKEY_BASENAME=$(basename "$PRIVKEY_PATH")

echo "Copying certificates from:"
echo "  Fullchain: $FULLCHAIN_PATH -> /ssl/server.crt"
echo "  Privkey: $PRIVKEY_PATH -> /ssl/server.key"
echo "  Archive dir: $ARCHIVE_DIR"

docker run --rm \
    -v ${VOLUME_NAME}:/ssl \
    -v ${ARCHIVE_DIR}:/certs:ro \
    alpine sh -c "
        # Удаляем старые сертификаты
        rm -f /ssl/server.crt /ssl/server.key
        
        # Копируем новые сертификаты
        cp /certs/${FULLCHAIN_BASENAME} /ssl/server.crt
        cp /certs/${PRIVKEY_BASENAME} /ssl/server.key
        
        # Устанавливаем права доступа
        chmod 600 /ssl/server.key
        chmod 644 /ssl/server.crt
        chown root:root /ssl/server.key /ssl/server.crt
        
        # Проверяем, что файлы скопировались
        if [ -f /ssl/server.crt ] && [ -f /ssl/server.key ]; then
            echo 'Certificates copied successfully'
            ls -lh /ssl/
        else
            echo 'ERROR: Failed to copy certificates'
            exit 1
        fi
    " 2>&1

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Сертификаты скопированы в Docker volume${NC}"
    
    # Проверяем, что сертификаты действительно Let's Encrypt
    echo -e "${YELLOW}Проверка сертификата в volume...${NC}"
    CERT_CHECK=$(docker run --rm -v ${VOLUME_NAME}:/ssl alpine sh -c "openssl x509 -in /ssl/server.crt -noout -issuer 2>/dev/null" | grep -i "let's encrypt" || echo "")
    if [ ! -z "$CERT_CHECK" ]; then
        echo -e "${GREEN}✓ Let's Encrypt сертификат подтвержден в volume${NC}"
    else
        echo -e "${YELLOW}⚠ Внимание: Сертификат в volume не является Let's Encrypt${NC}"
        echo "Проверьте содержимое volume:"
        docker run --rm -v ${VOLUME_NAME}:/ssl alpine sh -c "openssl x509 -in /ssl/server.crt -noout -subject -issuer 2>/dev/null || echo 'Cannot read certificate'"
    fi
else
    echo -e "${RED}✗ Ошибка при копировании сертификатов${NC}"
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
