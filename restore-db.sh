#!/bin/bash

# Скрипт для восстановления базы данных из дампа
# Использование: ./restore-db.sh [путь_к_дампу.sql]

set -e

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Загрузка переменных окружения
if [ -f .env ]; then
    export $(cat .env | grep -v '^#' | xargs)
fi

# Параметры по умолчанию
DB_HOST=${DB_HOST:-tyre-app-mysql}
DB_PORT=${DB_PORT:-3306}
DB_NAME=${DB_NAME:-tyre_db}
DB_USER=${DB_USER:-tyre_user}
DB_PASSWORD=${DB_PASSWORD:-tyre_password}
MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD:-root_password}

# Проверка аргументов
if [ -z "$1" ]; then
    echo -e "${RED}Ошибка: Укажите путь к файлу дампа${NC}"
    echo "Использование: $0 <путь_к_дампу.sql>"
    echo "Пример: $0 dumps/database.sql"
    exit 1
fi

DUMP_FILE=$1

# Проверка существования файла
if [ ! -f "$DUMP_FILE" ]; then
    echo -e "${RED}Ошибка: Файл $DUMP_FILE не найден${NC}"
    exit 1
fi

echo -e "${YELLOW}Восстановление базы данных из дампа...${NC}"
echo "Файл: $DUMP_FILE"
echo "База данных: $DB_NAME"
echo "Хост: $DB_HOST:$DB_PORT"

# Проверка, запущен ли контейнер
if ! docker ps | grep -q "tyre-app-mysql"; then
    echo -e "${YELLOW}Контейнер MySQL не запущен. Запускаю...${NC}"
    docker-compose up -d tyre-app-mysql
    echo -e "${YELLOW}Ожидание готовности MySQL...${NC}"
    sleep 10
fi

# Копирование дампа в контейнер
echo -e "${YELLOW}Копирование дампа в контейнер...${NC}"
docker cp "$DUMP_FILE" tyre-app-mysql:/tmp/dump.sql

# Восстановление базы данных
echo -e "${YELLOW}Восстановление базы данных...${NC}"

# Тщательная очистка существующей базы данных
echo -e "${YELLOW}Очистка существующей базы данных...${NC}"
docker exec -i tyre-app-mysql mysql -uroot -p"$MYSQL_ROOT_PASSWORD" <<EOF
-- Отключаем проверки для ускорения удаления
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;

-- Удаляем базу данных если существует
DROP DATABASE IF EXISTS \`$DB_NAME\`;

-- Включаем проверки обратно
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;

-- Создаем новую базу данных
CREATE DATABASE \`$DB_NAME\` CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Предоставляем права пользователю
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'%';
FLUSH PRIVILEGES;
EOF

# Фильтрация команд пользователей из дампа перед восстановлением
echo -e "${YELLOW}Фильтрация команд пользователей из дампа...${NC}"
docker exec -i tyre-app-mysql bash -c "grep -v -E '^(CREATE USER|DROP USER|GRANT.*ON \*\.\*|REVOKE.*ON \*\.\*|FLUSH PRIVILEGES)' /tmp/dump.sql > /tmp/dump_filtered.sql" || true

# Восстановление из отфильтрованного дампа
echo -e "${YELLOW}Восстановление из дампа...${NC}"
# Отключаем проверки для ускорения восстановления
docker exec -i tyre-app-mysql bash -c "mysql -uroot -p'$MYSQL_ROOT_PASSWORD' '$DB_NAME' --force <<SQL
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET SQL_NOTES = 0;
SOURCE /tmp/dump_filtered.sql;
SET FOREIGN_KEY_CHECKS = 1;
SET UNIQUE_CHECKS = 1;
SQL
" 2>&1 | grep -v "ERROR 1133\|ERROR 1396\|Using a password\|Warning" || true

# Настройка sql_mode
echo -e "${YELLOW}Настройка sql_mode...${NC}"
docker exec -i tyre-app-mysql mysql -uroot -p"$MYSQL_ROOT_PASSWORD" <<EOF
USE \`$DB_NAME\`;
SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode, "ONLY_FULL_GROUP_BY,", ""));
SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode, "ONLY_FULL_GROUP_BY,", ""));
EOF

# Удаление временных файлов из контейнера
docker exec tyre-app-mysql rm -f /tmp/dump.sql /tmp/dump_filtered.sql

echo -e "${GREEN}База данных успешно восстановлена!${NC}"
