#!/bin/bash
# Скрипт для проверки нагрузки MySQL во время импорта

echo "=== Проверка нагрузки MySQL ==="
echo ""

echo "1. Активные запросы (топ 20 по времени выполнения):"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SELECT 
    ID, USER, HOST, DB, COMMAND, TIME, STATE, 
    LEFT(INFO, 150) as QUERY
FROM information_schema.PROCESSLIST 
WHERE COMMAND != 'Sleep' 
ORDER BY TIME DESC 
LIMIT 20;
" kerchshina 2>/dev/null || echo "Ошибка подключения"

echo ""
echo "2. Блокировки таблиц:"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SELECT 
    r.trx_id waiting_trx_id,
    r.trx_mysql_thread_id waiting_thread,
    LEFT(r.trx_query, 100) waiting_query,
    b.trx_id blocking_trx_id,
    b.trx_mysql_thread_id blocking_thread,
    LEFT(b.trx_query, 100) blocking_query
FROM information_schema.innodb_lock_waits w
INNER JOIN information_schema.innodb_trx b ON b.trx_id = w.blocking_trx_id
INNER JOIN information_schema.innodb_trx r ON r.trx_id = w.requesting_trx_id
LIMIT 10;
" kerchshina 2>/dev/null || echo "Нет блокировок или ошибка"

echo ""
echo "3. Статистика подключений:"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SHOW STATUS LIKE 'Threads_connected';
SHOW STATUS LIKE 'Threads_running';
SHOW STATUS LIKE 'Max_used_connections';
SHOW VARIABLES LIKE 'max_connections';
" kerchshina 2>/dev/null

echo ""
echo "4. Статистика InnoDB:"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SHOW STATUS LIKE 'Innodb_rows_%';
SHOW STATUS LIKE 'Innodb_buffer_pool%';
" kerchshina 2>/dev/null | head -20

echo ""
echo "5. Медленные запросы (если включен slow query log):"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SHOW VARIABLES LIKE 'slow_query%';
SHOW VARIABLES LIKE 'long_query_time';
" kerchshina 2>/dev/null
