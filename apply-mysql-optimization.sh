#!/bin/bash
# Скрипт для применения оптимизации MySQL
# 1. Добавляет индексы для оптимизации запросов
# 2. Перезапускает MySQL с новой конфигурацией

set -e

echo "=== Применение оптимизации MySQL ==="

# Получаем имя базы данных из переменных окружения или используем значение по умолчанию
DB_NAME=${DB_NAME:-kerchshina}
MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD:-root_password}

echo "База данных: $DB_NAME"

# Проверяем, запущен ли контейнер MySQL
if ! docker ps | grep -q tyre-app-mysql; then
    echo "Ошибка: Контейнер tyre-app-mysql не запущен"
    exit 1
fi

echo ""
echo "=== Шаг 1: Добавление индексов ==="
echo "Применяю индексы из mysql-optimize-indexes.sql..."
echo "Если индекс уже существует, будет ошибка - это нормально, просто пропустите его"
echo ""

# Применяем индексы (игнорируем ошибки о существующих индексах)
docker exec -i tyre-app-mysql mysql -uroot -p"$MYSQL_ROOT_PASSWORD" "$DB_NAME" < mysql-optimize-indexes.sql 2>&1 | grep -v "Duplicate key name" || true

echo ""
echo "=== Шаг 2: Перезапуск MySQL с новой конфигурацией ==="
echo "Перезапускаю контейнер MySQL..."
docker compose restart tyre-app-mysql

echo ""
echo "Ожидание запуска MySQL (10 секунд)..."
sleep 10

echo ""
echo "=== Проверка статуса MySQL ==="
docker compose ps tyre-app-mysql

echo ""
echo "=== Проверка индексов ==="
docker exec tyre-app-mysql mysql -uroot -p"$MYSQL_ROOT_PASSWORD" -e "
SELECT 
    TABLE_NAME,
    INDEX_NAME,
    GROUP_CONCAT(COLUMN_NAME ORDER BY SEQ_IN_INDEX) AS COLUMNS
FROM information_schema.STATISTICS 
WHERE TABLE_SCHEMA = '$DB_NAME' 
AND TABLE_NAME = 'products'
AND INDEX_NAME LIKE 'idx_%'
GROUP BY TABLE_NAME, INDEX_NAME
ORDER BY INDEX_NAME;
" "$DB_NAME"

echo ""
echo "=== Готово! ==="
echo "MySQL оптимизирован и перезапущен."
echo "Проверьте производительность через несколько минут."
