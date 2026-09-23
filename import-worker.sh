#!/bin/sh
# Запуск фонового воркера импорта/конвертации (контейнер tyre-app-worker).
#
# Том с webroot/xls может создаться с чужим владельцем, а воркер сохраняет туда
# результаты конвертации — поэтому права выставляются под root, а сам воркер
# работает от www-data с пониженным приоритетом CPU и диска.
XLS_DIR=/var/www/html/app/webroot/xls
chown www-data:www-data "$XLS_DIR"
chmod 777 "$XLS_DIR"

# Одна задача на процесс PHP; цикл перезапускает воркер после каждой задачи
exec runuser -u www-data -- sh -c 'while true; do
	nice -n 10 ionice -c2 -n7 php /var/www/html/lib/Cake/Console/cake.php -working /var/www/html/app import_worker --wait 300
	sleep 1
done'
