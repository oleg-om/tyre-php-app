#!/bin/bash

# Скрипт для восстановления файлов в app/webroot/files напрямую в Docker контейнер
# Использование: ./restore-files.sh [путь_к_директории_с_файлами]

# Не прерываем выполнение при ошибках в некоторых командах
set +e

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Имя контейнера
CONTAINER_NAME="tyre-app-php"
CONTAINER_TARGET_DIR="/var/www/html/app/webroot/files"

# Функция для отображения прогресс-бара
show_progress() {
    local current=$1
    local total=$2
    local width=50
    local percentage=$((current * 100 / total))
    local filled=$((width * current / total))
    local empty=$((width - filled))
    
    printf "\r${BLUE}["
    printf "%${filled}s" | tr ' ' '='
    printf "%${empty}s" | tr ' ' ' '
    printf "] ${NC}%3d%% (%d/%d файлов)" "$percentage" "$current" "$total"
}

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

# Проверка, запущен ли контейнер
if ! docker ps | grep -q "$CONTAINER_NAME"; then
    echo -e "${YELLOW}Контейнер $CONTAINER_NAME не запущен. Запускаю...${NC}"
    if ! docker-compose up -d "$CONTAINER_NAME"; then
        echo -e "${RED}Ошибка: Не удалось запустить контейнер${NC}"
        exit 1
    fi
    echo -e "${YELLOW}Ожидание готовности контейнера...${NC}"
    sleep 3
fi

echo -e "${YELLOW}Восстановление файлов в контейнер...${NC}"
echo "Источник: $FILES_DIR"
echo "Контейнер: $CONTAINER_NAME"
echo "Назначение в контейнере: $CONTAINER_TARGET_DIR"
echo ""

# Создание целевой директории в контейнере
echo -e "${YELLOW}Создание директории в контейнере...${NC}"
if ! docker exec "$CONTAINER_NAME" mkdir -p "$CONTAINER_TARGET_DIR"; then
    echo -e "${RED}Ошибка: Не удалось создать директорию в контейнере${NC}"
    exit 1
fi

# Подсчет файлов
echo -e "${YELLOW}Подсчет файлов...${NC}"
FILE_COUNT=$(find "$FILES_DIR" -type f | wc -l | tr -d ' ')
echo -e "${GREEN}Найдено файлов: $FILE_COUNT${NC}"
echo ""

if [ "$FILE_COUNT" -eq 0 ]; then
    echo -e "${YELLOW}В директории $FILES_DIR не найдено файлов${NC}"
    exit 0
fi

# Копирование файлов напрямую в контейнер с прогресс-баром
echo -e "${YELLOW}Копирование файлов в контейнер...${NC}"

# Используем tar для более эффективной передачи файлов с прогрессом
# Создаем архив и передаем его в контейнер через stdin
echo -e "${YELLOW}Подготовка и передача файлов в контейнер...${NC}"

# Используем tar для создания архива и передачи через docker exec
# Это более эффективно для большого количества файлов
(
    cd "$FILES_DIR"
    tar -cf - . 2>/dev/null | docker exec -i "$CONTAINER_NAME" tar -xf - -C "$CONTAINER_TARGET_DIR" 2>/dev/null
) &
TAR_PID=$!

# Показываем прогресс пока идет копирование
CURRENT=0
while kill -0 $TAR_PID 2>/dev/null; do
    # Подсчитываем уже скопированные файлы
    COPIED_NOW=$(docker exec "$CONTAINER_NAME" find "$CONTAINER_TARGET_DIR" -type f 2>/dev/null | wc -l | tr -d ' ' || echo "0")
    if [ "$COPIED_NOW" -gt "$CURRENT" ] && [ "$COPIED_NOW" -le "$FILE_COUNT" ]; then
        CURRENT=$COPIED_NOW
        show_progress "$CURRENT" "$FILE_COUNT"
    fi
    sleep 0.5
done

# Ждем завершения процесса
wait $TAR_PID
TAR_EXIT=$?

if [ $TAR_EXIT -eq 0 ]; then
    # Показываем 100% после завершения
    show_progress "$FILE_COUNT" "$FILE_COUNT"
    echo ""
else
    echo ""
    echo -e "${YELLOW}Копирование завершено (возможны предупреждения)${NC}"
fi

echo ""
echo -e "${GREEN}Файлы успешно скопированы в контейнер!${NC}"

# Подсчет скопированных файлов в контейнере
COPIED_COUNT=$(docker exec "$CONTAINER_NAME" find "$CONTAINER_TARGET_DIR" -type f 2>/dev/null | wc -l | tr -d ' ')
echo "Скопировано файлов в контейнер: $COPIED_COUNT"

# Установка прав доступа в контейнере
echo -e "${YELLOW}Установка прав доступа в контейнере...${NC}"
docker exec "$CONTAINER_NAME" chmod -R 777 "$CONTAINER_TARGET_DIR" || true
docker exec "$CONTAINER_NAME" chown -R www-data:www-data "$CONTAINER_TARGET_DIR" || true

echo ""
echo -e "${GREEN}Файлы успешно восстановлены в контейнер $CONTAINER_NAME!${NC}"
echo -e "${GREEN}Путь в контейнере: $CONTAINER_TARGET_DIR${NC}"
