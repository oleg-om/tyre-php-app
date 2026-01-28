#!/bin/bash
# Проверка ресурсов сервера и конфигурации

echo "=== Проверка ресурсов сервера ==="
echo ""

echo "1. Использование CPU и памяти (top 10 процессов):"
docker stats --no-stream --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.MemPerc}}" 2>/dev/null || echo "Docker stats недоступен"

echo ""
echo "2. Настройки Apache (MaxRequestWorkers):"
docker exec tyre-app-php grep -E "MaxRequestWorkers|ServerLimit|MaxConnectionsPerChild" /etc/apache2/apache2.conf 2>/dev/null || echo "Не найдено"

echo ""
echo "3. Активные подключения MySQL:"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SHOW STATUS LIKE 'Threads_connected';
SHOW STATUS LIKE 'Threads_running';
SHOW STATUS LIKE 'Max_used_connections';
SHOW VARIABLES LIKE 'max_connections';
" kerchshina 2>/dev/null

echo ""
echo "4. Активные запросы MySQL (топ 5):"
docker exec tyre-app-mysql mysql -uroot -proot_password -e "
SELECT 
    ID, USER, HOST, DB, COMMAND, TIME, STATE, 
    LEFT(INFO, 150) as QUERY
FROM information_schema.PROCESSLIST 
WHERE COMMAND != 'Sleep' 
ORDER BY TIME DESC 
LIMIT 5;
" kerchshina 2>/dev/null

echo ""
echo "5. Блокировки таблиц:"
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
LIMIT 5;
" kerchshina 2>/dev/null || echo "Нет активных блокировок"

echo ""
echo "6. Размер логов Apache:"
docker exec tyre-app-php du -sh /var/log/apache2/* 2>/dev/null | head -5 || echo "Логи недоступны"

echo ""
echo "=== Рекомендации ==="
echo "Если CPU > 80% или Memory > 80% - нужно увеличить ресурсы сервера"
echo "Если Threads_connected близко к max_connections - нужно увеличить max_connections"
echo "Если много блокировок - нужно оптимизировать запросы или использовать транзакции"
