#!/bin/bash
# Скрипт для проверки работы Redis кеша

echo "=== Проверка Redis сервиса ==="
docker compose ps tyre-app-redis

echo -e "\n=== Проверка подключения к Redis ==="
docker exec tyre-app-redis redis-cli ping

echo -e "\n=== Проверка PHP расширения Redis ==="
docker exec tyre-app-php php -m | grep -i redis

echo -e "\n=== Проверка конфигурации CakePHP Cache ==="
docker exec tyre-app-php php -r "
require '/var/www/html/app/webroot/index.php';
\$config = Cache::config('default');
echo 'Cache engine: ' . \$config['engine'] . PHP_EOL;
if (isset(\$config['server'])) {
    echo 'Redis server: ' . \$config['server'] . PHP_EOL;
    echo 'Redis port: ' . \$config['port'] . PHP_EOL;
}
"

echo -e "\n=== Тест записи и чтения из кеша ==="
docker exec tyre-app-php php -r "
require '/var/www/html/app/webroot/index.php';
\$testKey = 'redis_test_' . time();
\$testValue = 'Test value from Redis';

echo 'Writing to cache...' . PHP_EOL;
\$writeResult = Cache::write(\$testKey, \$testValue, 'short');
echo 'Write result: ' . (\$writeResult ? 'SUCCESS' : 'FAILED') . PHP_EOL;

echo 'Reading from cache...' . PHP_EOL;
\$readValue = Cache::read(\$testKey, 'short');
echo 'Read value: ' . (\$readValue ?: 'NULL') . PHP_EOL;
echo 'Match: ' . (\$readValue === \$testValue ? 'YES' : 'NO') . PHP_EOL;

if (\$readValue === \$testValue) {
    echo PHP_EOL . '✓ Redis cache работает правильно!' . PHP_EOL;
} else {
    echo PHP_EOL . '✗ Redis cache не работает' . PHP_EOL;
}

Cache::delete(\$testKey);
"

echo -e "\n=== Статистика Redis ==="
docker exec tyre-app-redis redis-cli INFO stats | grep -E "total_commands_processed|keyspace"

echo -e "\n=== Ключи в Redis (первые 10) ==="
docker exec tyre-app-redis redis-cli KEYS "*" | head -10
