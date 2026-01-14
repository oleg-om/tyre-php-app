#!/bin/bash

# Скрипт для восстановления файлов в app/webroot/files
# Использование: ./restore-files.sh [путь_к_директории_с_файлами]

set -e

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Путь к директории с файлами
FILES_DIR=${1:-}

# Проверка аргументов
if [ -z "$FILES_DIR" ]; then
    echo -e "${RED}Ошибка: Укажите путь к директории с файлами${NC}"
    echo "Использование: $0 <путь_к_директории>"
    echo "Пример: $0 /path/to/backup/files"
    echo "Пример: $0 ./backup/files"
    exit 1
fi

# Проверка существования директории
if [ ! -d "$FILES_DIR" ]; then
    echo -e "${RED}Ошибка: Директория $FILES_DIR не найдена${NC}"
    exit 1
fi

# Путь к целевой директории
TARGET_DIR="app/webroot/files"

# Создание целевой директории, если её нет
if [ ! -d "$TARGET_DIR" ]; then
    echo -e "${YELLOW}Создание директории $TARGET_DIR...${NC}"
    mkdir -p "$TARGET_DIR"
fi

echo -e "${YELLOW}Восстановление файлов...${NC}"
echo "Источник: $FILES_DIR"
echo "Назначение: $TARGET_DIR"

# Подсчет файлов
FILE_COUNT=$(find "$FILES_DIR" -type f | wc -l)
echo "Найдено файлов: $FILE_COUNT"

# Копирование файлов
echo -e "${YELLOW}Копирование файлов...${NC}"
if [ "$FILE_COUNT" -gt 0 ]; then
    cp -r "$FILES_DIR"/* "$TARGET_DIR/" 2>/dev/null || {
        # Если копирование с /* не сработало, пробуем другой способ
        find "$FILES_DIR" -mindepth 1 -maxdepth 1 -exec cp -r {} "$TARGET_DIR/" \;
    }
    echo -e "${GREEN}Файлы успешно скопированы!${NC}"
    
    # Подсчет скопированных файлов
    COPIED_COUNT=$(find "$TARGET_DIR" -type f | wc -l)
    echo "Скопировано файлов: $COPIED_COUNT"
    
    # Установка прав доступа
    echo -e "${YELLOW}Установка прав доступа...${NC}"
    chmod -R 755 "$TARGET_DIR"
    
    # Если контейнер запущен, обновляем права в контейнере
    if docker ps | grep -q "tyre-app-php"; then
        echo -e "${YELLOW}Обновление прав в контейнере...${NC}"
        docker exec tyre-app-php chmod -R 777 /var/www/html/app/webroot/files || true
        docker exec tyre-app-php chown -R www-data:www-data /var/www/html/app/webroot/files || true
    fi
    
    echo -e "${GREEN}Файлы успешно восстановлены в $TARGET_DIR!${NC}"
else
    echo -e "${YELLOW}В директории $FILES_DIR не найдено файлов${NC}"
fi
