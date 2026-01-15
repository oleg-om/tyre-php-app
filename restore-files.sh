#!/bin/bash

# Скрипт для восстановления файлов в app/webroot/files напрямую в Docker контейнер
# Файлы сохраняются в именованном Docker volume (tyre-app-files)
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

# Установка начальных прав доступа для директории
echo -e "${YELLOW}Установка начальных прав доступа...${NC}"
docker exec "$CONTAINER_NAME" chown -R www-data:www-data "$CONTAINER_TARGET_DIR" 2>/dev/null || true
docker exec "$CONTAINER_NAME" chmod -R 777 "$CONTAINER_TARGET_DIR" 2>/dev/null || true

# Подсчет файлов
echo -e "${YELLOW}Подсчет файлов...${NC}"
FILE_COUNT=$(find "$FILES_DIR" -type f | wc -l | tr -d ' ')
echo -e "${GREEN}Найдено файлов: $FILE_COUNT${NC}"
echo ""

if [ "$FILE_COUNT" -eq 0 ]; then
    echo -e "${YELLOW}В директории $FILES_DIR не найдено файлов${NC}"
    exit 0
fi

# Копирование файлов напрямую в контейнер
echo -e "${YELLOW}Копирование файлов в контейнер (это может занять некоторое время)...${NC}"
echo -e "${BLUE}Используется оптимизированный метод передачи через tar...${NC}"

# Запоминаем время начала
START_TIME=$(date +%s)

# Используем tar для максимально быстрой передачи файлов
# Опции tar:
# --no-same-owner - не сохранять владельца (установим позже)
# --no-same-permissions - не сохранять права (установим позже)
# Это значительно ускоряет передачу
(
    cd "$FILES_DIR"
    tar --no-same-owner --no-same-permissions -cf - . 2>/dev/null | \
    docker exec -i "$CONTAINER_NAME" tar --no-same-owner --no-same-permissions -xf - -C "$CONTAINER_TARGET_DIR" 2>/dev/null
)
TAR_EXIT=$?

# Вычисляем время выполнения
END_TIME=$(date +%s)
ELAPSED=$((END_TIME - START_TIME))
MINUTES=$((ELAPSED / 60))
SECONDS=$((ELAPSED % 60))

if [ $TAR_EXIT -eq 0 ]; then
    echo -e "${GREEN}✓ Копирование завершено за ${MINUTES}м ${SECONDS}с${NC}"
else
    echo -e "${YELLOW}⚠ Копирование завершено с предупреждениями (время: ${MINUTES}м ${SECONDS}с)${NC}"
fi

echo ""
echo -e "${GREEN}Файлы успешно скопированы в контейнер!${NC}"

# Подсчет скопированных файлов в контейнере (быстрая проверка)
echo -e "${YELLOW}Проверка скопированных файлов...${NC}"
COPIED_COUNT=$(docker exec "$CONTAINER_NAME" find "$CONTAINER_TARGET_DIR" -type f 2>/dev/null | wc -l | tr -d ' ')
echo "Найдено файлов в контейнере: $COPIED_COUNT"

# Оптимизированная установка прав доступа в контейнере
# Используем find с -exec для более быстрой обработки больших директорий
echo -e "${YELLOW}Установка прав доступа в контейнере (это может занять некоторое время)...${NC}"

# Установка владельца через find (быстрее для больших директорий)
echo -e "${YELLOW}  - Установка владельца www-data:www-data...${NC}"
START_CHOWN=$(date +%s)
if docker exec "$CONTAINER_NAME" find "$CONTAINER_TARGET_DIR" -exec chown www-data:www-data {} + 2>/dev/null; then
    END_CHOWN=$(date +%s)
    CHOWN_TIME=$((END_CHOWN - START_CHOWN))
    echo -e "${GREEN}  ✓ Владелец установлен (за ${CHOWN_TIME}с)${NC}"
else
    # Fallback на стандартный метод, если find с + не поддерживается
    if docker exec "$CONTAINER_NAME" chown -R www-data:www-data "$CONTAINER_TARGET_DIR" 2>/dev/null; then
        echo -e "${GREEN}  ✓ Владелец установлен${NC}"
    else
        echo -e "${YELLOW}  ⚠ Предупреждение: не удалось установить владельца${NC}"
    fi
fi

# Установка прав доступа через find (быстрее для больших директорий)
echo -e "${YELLOW}  - Установка прав доступа 777...${NC}"
START_CHMOD=$(date +%s)
if docker exec "$CONTAINER_NAME" find "$CONTAINER_TARGET_DIR" -exec chmod 777 {} + 2>/dev/null; then
    END_CHMOD=$(date +%s)
    CHMOD_TIME=$((END_CHMOD - START_CHMOD))
    echo -e "${GREEN}  ✓ Права доступа установлены (за ${CHMOD_TIME}с)${NC}"
else
    # Fallback на стандартный метод, если find с + не поддерживается
    if docker exec "$CONTAINER_NAME" chmod -R 777 "$CONTAINER_TARGET_DIR" 2>/dev/null; then
        echo -e "${GREEN}  ✓ Права доступа установлены${NC}"
    else
        echo -e "${YELLOW}  ⚠ Предупреждение: не удалось установить права доступа${NC}"
    fi
fi

echo ""
echo -e "${GREEN}Файлы успешно восстановлены в контейнер $CONTAINER_NAME!${NC}"
echo -e "${GREEN}Путь в контейнере: $CONTAINER_TARGET_DIR${NC}"
