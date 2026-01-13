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
    apt-get install -y git unzip && \
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

# Установка zip расширения (опционально, если нужно)
# Для PHP 5.6 zip может быть недоступен через стандартный установщик
# RUN apt-get update && apt-get install -y --no-install-recommends libzip-dev \
#     && docker-php-ext-install zip \
#     && apt-get clean \
#     && rm -rf /var/lib/apt/lists/*

# Включение mod_rewrite для Apache
RUN a2enmod rewrite

# Настройка PHP
RUN echo "memory_limit = 1024M" > /usr/local/etc/php/conf.d/memory.ini \
    && echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/upload.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/upload.ini \
    && echo "max_execution_time = 300" > /usr/local/etc/php/conf.d/execution.ini \
    && echo "max_input_time = 300" >> /usr/local/etc/php/conf.d/execution.ini \
    && echo "date.timezone = Europe/Moscow" > /usr/local/etc/php/conf.d/timezone.ini

# Установка Composer (старая версия для PHP 5.6)
RUN apt-get update && apt-get install -y curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.26 \
    && rm -rf /var/lib/apt/lists/*

# Установка рабочей директории
WORKDIR /var/www/html

# Копирование файлов приложения
COPY . /var/www/html/

# Создание необходимых директорий и установка прав доступа
# Удаляем .htaccess из app/, так как DocumentRoot уже указывает на webroot
# Создаем .htaccess в webroot для правильной работы mod_rewrite
RUN mkdir -p /var/www/html/app/tmp /var/www/html/app/webroot/img \
    && rm -f /var/www/html/app/.htaccess \
    && echo '<IfModule mod_rewrite.c>' > /var/www/html/app/webroot/.htaccess \
    && echo '    RewriteEngine On' >> /var/www/html/app/webroot/.htaccess \
    && echo '    RewriteCond %{REQUEST_FILENAME} !-d' >> /var/www/html/app/webroot/.htaccess \
    && echo '    RewriteCond %{REQUEST_FILENAME} !-f' >> /var/www/html/app/webroot/.htaccess \
    && echo '    RewriteRule ^ index.php [L]' >> /var/www/html/app/webroot/.htaccess \
    && echo '</IfModule>' >> /var/www/html/app/webroot/.htaccess \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/app/tmp \
    && chmod -R 777 /var/www/html/app/webroot/img

# Настройка Apache для CakePHP
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/app/webroot|g' /etc/apache2/sites-available/000-default.conf \
    && echo "" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	<Directory /var/www/html/app/webroot>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		Options Indexes FollowSymLinks" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		AllowOverride All" >> /etc/apache2/sites-available/000-default.conf \
    && echo "		Require all granted" >> /etc/apache2/sites-available/000-default.conf \
    && echo "	</Directory>" >> /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
