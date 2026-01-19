#!/bin/bash
# Скрипт для проверки производительности приложения

echo "=== PHP Opcache Status ==="
docker exec tyre-app-php php -r "
if (function_exists('opcache_get_status')) {
    \$status = @opcache_get_status();
    if (\$status && isset(\$status['opcache_enabled'])) {
        echo 'Opcache enabled: ' . (\$status['opcache_enabled'] ? 'YES' : 'NO') . PHP_EOL;
        if (isset(\$status['opcache_statistics'])) {
            echo 'Cache hits: ' . \$status['opcache_statistics']['hits'] . PHP_EOL;
            echo 'Cache misses: ' . \$status['opcache_statistics']['misses'] . PHP_EOL;
            \$hit_rate = isset(\$status['opcache_statistics']['opcache_hit_rate']) ? \$status['opcache_statistics']['opcache_hit_rate'] : 0;
            echo 'Hit rate: ' . round(\$hit_rate, 2) . '%' . PHP_EOL;
        }
        if (isset(\$status['memory_usage'])) {
            echo 'Memory used: ' . round(\$status['memory_usage']['used_memory'] / 1024 / 1024, 2) . ' MB' . PHP_EOL;
            echo 'Memory free: ' . round(\$status['memory_usage']['free_memory'] / 1024 / 1024, 2) . ' MB' . PHP_EOL;
        }
        if (isset(\$status['opcache_statistics']['num_cached_scripts'])) {
            echo 'Cached scripts: ' . \$status['opcache_statistics']['num_cached_scripts'] . PHP_EOL;
        }
    } else {
        echo 'Opcache status not available (may be disabled in CLI mode)' . PHP_EOL;
        echo 'Checking configuration...' . PHP_EOL;
        echo 'opcache.enable: ' . ini_get('opcache.enable') . PHP_EOL;
        echo 'opcache.memory_consumption: ' . ini_get('opcache.memory_consumption') . ' MB' . PHP_EOL;
        echo 'opcache.max_accelerated_files: ' . ini_get('opcache.max_accelerated_files') . PHP_EOL;
    }
} else {
    echo 'Opcache extension not loaded' . PHP_EOL;
}
"

echo -e "\n=== Disk I/O Test ==="
echo "Writing 100MB test file to /var/www/html/app/tmp..."
time docker exec tyre-app-php dd if=/dev/zero of=/var/www/html/app/tmp/iotest bs=1M count=100 oflag=direct 2>&1 | tail -1
docker exec tyre-app-php rm -f /var/www/html/app/tmp/iotest

echo -e "\n=== MySQL Query Cache ==="
docker exec tyre-app-mysql mysql -uroot -p"${MYSQL_ROOT_PASSWORD:-root_password}" -e "
SHOW VARIABLES LIKE 'query_cache%';
SHOW STATUS LIKE 'Qcache%';
" 2>/dev/null | grep -E "query_cache|Qcache" | head -10

echo -e "\n=== Apache Processes ==="
echo "Total Apache processes: $(docker exec tyre-app-php ps aux | grep apache | wc -l)"
docker exec tyre-app-php ps aux | grep apache | head -5

echo -e "\n=== Memory Usage ==="
docker stats --no-stream --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}" 2>/dev/null | head -3

echo -e "\n=== PHP Configuration ==="
docker exec tyre-app-php php -r "
echo 'memory_limit: ' . ini_get('memory_limit') . PHP_EOL;
echo 'realpath_cache_size: ' . ini_get('realpath_cache_size') . PHP_EOL;
echo 'realpath_cache_ttl: ' . ini_get('realpath_cache_ttl') . PHP_EOL;
echo 'opcache.enable: ' . ini_get('opcache.enable') . PHP_EOL;
echo 'opcache.memory_consumption: ' . ini_get('opcache.memory_consumption') . ' MB' . PHP_EOL;
"
