FROM php:5.6-apache

# Обновление источников пакетов на архивные репозитории (Debian Stretch EOL)
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list.d/*.list 2>/dev/null || true && \
    echo "deb http://archive.debian.org/debian stretch main contrib non-free" > /etc/apt/sources.list && \
    echo "deb http://archive.debian.org/debian-security stretch/updates main contrib non-free" >> /etc/apt/sources.list && \
    echo "Acquire::Check-Valid-Until false;" > /etc/apt/apt.conf.d/99no-check-valid-until && \
    echo "Acquire::AllowInsecureRepositories true;" >> /etc/apt/apt.conf.d/99no-check-valid-until && \
    echo "APT::Get::AllowUnauthenticated true;" >> /etc/apt/apt.conf.d/99no-check-valid-until

# Установка системных зависимостей (по группам для диагностики)
RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && \
    apt-get install -y libmcrypt-dev && \
    apt-get install -y libicu-dev && \
    apt-get install -y libxml2-dev zlib1g-dev && \
    apt-get install -y git unzip apache2-utils openssl && \
    apt-get install -y pkg-config && \
    rm -rf /var/lib/apt/lists/*

# Установка PHP расширений
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) \
    gd \
    mysqli \
    pdo_mysql \
    intl \
    mbstring \
    mcrypt \
    xml \
    opcache

# Установка Redis расширения через PECL (версия 2.2.8 для совместимости с PHP 5.6)
RUN apt-get update && \
    apt-get install -y --no-install-recommends libhiredis-dev && \
    pecl install redis-2.2.8 && \
    docker-php-ext-enable redis && \
    apt-get purge -y libhiredis-dev && \
    rm -rf /var/lib/apt/lists/*

# Установка zip расширения (опционально, если нужно)
# Для PHP 5.6 zip может быть недоступен через стандартный установщик
# RUN apt-get update && apt-get install -y --no-install-recommends libzip-dev \
#     && docker-php-ext-install zip \
#     && apt-get clean \
#     && rm -rf /var/lib/apt/lists/*

# Включение модулей Apache для оптимизации и SSL
RUN a2enmod rewrite auth_basic headers expires deflate ssl reqtimeout

# Настройка PHP (оптимизировано для 3 core / 4GB RAM)
RUN echo "memory_limit = 256M" > /usr/local/etc/php/conf.d/memory.ini \
    && echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/upload.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/upload.ini \
    && echo "max_execution_time = 60" > /usr/local/etc/php/conf.d/execution.ini \
    && echo "max_input_time = 0" >> /usr/local/etc/php/conf.d/execution.ini \
    && echo "date.timezone = Europe/Moscow" > /usr/local/etc/php/conf.d/timezone.ini \
    && echo "realpath_cache_size = 4096K" > /usr/local/etc/php/conf.d/realpath.ini \
    && echo "realpath_cache_ttl = 600" >> /usr/local/etc/php/conf.d/realpath.ini

# Настройка Opcache (оптимизировано для 4GB RAM, увеличенная память для лучшей производительности)
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.enable_cli=0" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=60" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.fast_shutdown=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.enable_file_override=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.optimization_level=0x7FFFBFFF" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.save_comments=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.load_comments=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_wasted_percentage=10" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.use_cwd=1" >> /usr/local/etc/php/conf.d/opcache.ini

# Установка Composer (старая версия для PHP 5.6)
RUN apt-get update && apt-get install -y curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.26 \
    && rm -rf /var/lib/apt/lists/*

# Установка рабочей директории
WORKDIR /var/www/html

# Копирование скриптов инициализации (до копирования приложения)
COPY init-domain-restriction.sh /usr/local/bin/init-domain-restriction.sh
COPY generate-ssl-cert.sh /usr/local/bin/generate-ssl-cert.sh
RUN chmod +x /usr/local/bin/init-domain-restriction.sh /usr/local/bin/generate-ssl-cert.sh

# Копирование файлов приложения
COPY . /var/www/html/

# Создание необходимых директорий и установка прав доступа
# Удаляем .htaccess из app/, так как DocumentRoot уже указывает на webroot
# .htaccess в webroot создается из файла проекта
RUN mkdir -p /var/www/html/app/tmp /var/www/html/app/webroot/files /var/www/html/app/webroot/phpmy /var/www/html/app/webroot/xls \
    && rm -f /var/www/html/app/.htaccess \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/app/tmp \
    && chmod -R 777 /var/www/html/app/webroot/files \
    && chmod -R 777 /var/www/html/app/webroot/xls

# Настройка Apache для CakePHP
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/app/webroot|g' /etc/apache2/sites-available/000-default.conf \
    && echo "" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	<Directory /var/www/html/app/webroot>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		Options Indexes FollowSymLinks" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		AllowOverride All" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		Require all granted" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	</Directory>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "" >> /etc/apache2/apache2.conf \
    && echo "# Настройка портов для HTTP и HTTPS" >> /etc/apache2/apache2.conf \
    && echo "Listen 80" >> /etc/apache2/ports.conf \
    && echo "Listen 443" >> /etc/apache2/ports.conf \
    && echo "" >> /etc/apache2/apache2.conf \
    && echo "# Создание директории для SSL сертификатов" >> /etc/apache2/apache2.conf \
    && mkdir -p /etc/apache2/ssl \
    && echo "" >> /etc/apache2/apache2.conf \
    && echo "# Оптимизация Apache KeepAlive" >> /etc/apache2/apache2.conf \
    && echo "KeepAlive On" >> /etc/apache2/apache2.conf \
    && echo "MaxKeepAliveRequests 100" >> /etc/apache2/apache2.conf \
    && echo "KeepAliveTimeout 5" >> /etc/apache2/apache2.conf \
    && echo "" >> /etc/apache2/apache2.conf \
    && echo "# Оптимизация процессов Apache для высокой нагрузки (mpm_prefork)" >> /etc/apache2/apache2.conf \
    && echo "<IfModule mpm_prefork_module>" >> /etc/apache2/apache2.conf \
    && echo "    StartServers 2" >> /etc/apache2/apache2.conf \
    && echo "    MinSpareServers 2" >> /etc/apache2/apache2.conf \
    && echo "    MaxSpareServers 5" >> /etc/apache2/apache2.conf \
    && echo "    MaxRequestWorkers 80" >> /etc/apache2/apache2.conf \
    && echo "    MaxConnectionsPerChild 5000" >> /etc/apache2/apache2.conf \
    && echo "    ServerLimit 80" >> /etc/apache2/apache2.conf \
    && echo "</IfModule>" >> /etc/apache2/apache2.conf \
    && echo "" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	# Оптимизация производительности - Gzip сжатие" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	<IfModule mod_deflate.c>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json application/xml" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		AddOutputFilterByType DEFLATE image/svg+xml" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		SetEnvIfNoCase Request_URI \\.(?:gif|jpe?g|png)$ no-gzip dont-vary" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		SetEnvIfNoCase Request_URI \\.(?:exe|t?gz|zip|bz2|sit|rar)$ no-gzip dont-vary" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	</IfModule>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	<IfModule mod_expires.c>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		ExpiresActive On" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		ExpiresByType image/jpeg \"access plus 1 year\"" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		ExpiresByType image/png \"access plus 1 year\"" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		ExpiresByType image/gif \"access plus 1 year\"" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		ExpiresByType text/css \"access plus 1 month\"" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		ExpiresByType application/javascript \"access plus 1 month\"" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	</IfModule>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	<IfModule mod_headers.c>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		<FilesMatch \"\\.(jpg|jpeg|png|gif|css|js)$\">" >> /etc/apache2/sites-available/000-default.conf \
    && echo "			Header set Cache-Control \"max-age=31536000, public\"" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		</FilesMatch>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	</IfModule>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	# Timeout настройки для защиты от медленных соединений и долгих операций" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	Timeout 3600" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	RequestReadTimeout header=0-3600,MinRate=1 body=0,MinRate=1" >> /etc/apache2/sites-available/000-default.conf

# Создание скрипта инициализации для генерации .htpasswd
RUN echo '#!/bin/bash' > /usr/local/bin/init-phpmyadmin-auth.sh && \
    echo 'if [ ! -z "$PHPMYADMIN_USER" ] && [ ! -z "$PHPMYADMIN_PASSWORD" ]; then' >> /usr/local/bin/init-phpmyadmin-auth.sh && \
    echo '    htpasswd -cb /var/www/html/app/webroot/phpmy/.htpasswd "$PHPMYADMIN_USER" "$PHPMYADMIN_PASSWORD" 2>/dev/null || \' >> /usr/local/bin/init-phpmyadmin-auth.sh && \
    echo '    echo "$PHPMYADMIN_USER:$(openssl passwd -apr1 "$PHPMYADMIN_PASSWORD")" > /var/www/html/app/webroot/phpmy/.htpasswd' >> /usr/local/bin/init-phpmyadmin-auth.sh && \
    echo '    chown www-data:www-data /var/www/html/app/webroot/phpmy/.htpasswd' >> /usr/local/bin/init-phpmyadmin-auth.sh && \
    echo '    chmod 644 /var/www/html/app/webroot/phpmy/.htpasswd' >> /usr/local/bin/init-phpmyadmin-auth.sh && \
    echo 'fi' >> /usr/local/bin/init-phpmyadmin-auth.sh && \
    chmod +x /usr/local/bin/init-phpmyadmin-auth.sh


EXPOSE 80 443

# Запуск инициализации и Apache
CMD ["/bin/bash", "-c", "/usr/local/bin/init-phpmyadmin-auth.sh && /usr/local/bin/generate-ssl-cert.sh && /usr/local/bin/init-domain-restriction.sh && apache2-foreground"]
