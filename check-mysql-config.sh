#!/bin/bash
# Проверка конфигурации MySQL для диагностики медленного импорта

echo "=== Проверка конфигурации MySQL ==="
echo ""

echo "1. Критические настройки производительности:"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SHOW VARIABLES LIKE 'innodb_buffer_pool_size';
SHOW VARIABLES LIKE 'innodb_flush_log_at_trx_commit';
SHOW VARIABLES LIKE 'innodb_flush_method';
SHOW VARIABLES LIKE 'innodb_io_capacity';
SHOW VARIABLES LIKE 'innodb_log_file_size';
SHOW VARIABLES LIKE 'max_connections';
SHOW VARIABLES LIKE 'query_cache%';
" kerchshina 2>/dev/null

echo ""
echo "2. Статистика InnoDB:"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SHOW STATUS LIKE 'Innodb_buffer_pool%';
SHOW STATUS LIKE 'Innodb_rows_%';
" kerchshina 2>/dev/null | head -15

echo ""
echo "3. Размер таблицы products:"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SELECT 
    TABLE_NAME,
    TABLE_ROWS,
    ROUND(DATA_LENGTH/1024/1024, 2) AS DATA_MB,
    ROUND(INDEX_LENGTH/1024/1024, 2) AS INDEX_MB,
    ROUND((DATA_LENGTH + INDEX_LENGTH)/1024/1024, 2) AS TOTAL_MB
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'kerchshina' AND TABLE_NAME = 'products';
" kerchshina 2>/dev/null

echo ""
echo "4. Проверка индексов на products:"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SHOW INDEX FROM products WHERE Column_name IN ('model_id', 'brand_id', 'category_id', 'is_active');
" kerchshina 2>/dev/null

echo ""
echo "5. Apache процессы:"
docker exec tyre-app-php ps aux | grep apache | wc -l
echo "Активных процессов Apache: $(docker exec tyre-app-php ps aux | grep apache | grep -v grep | wc -l)"

echo ""
echo "6. PHP настройки:"
docker exec tyre-app-php php -i | grep -E "memory_limit|max_execution_time|realpath_cache" | head -5
