#!/bin/bash
# Настройка редиректа HTTP -> HTTPS, редиректа www -> основной домен и ограничения по домену для продакшна

# Настраиваем Apache для HTTPS (опционально, если сертификат есть)
SSL_DIR="/etc/apache2/ssl"
CERT_FILE="$SSL_DIR/server.crt"
KEY_FILE="$SSL_DIR/server.key"

if [ -f "$CERT_FILE" ] && [ -f "$KEY_FILE" ]; then
    echo "SSL certificate found, configuring HTTPS..."
    
    # Определяем домен для SSL конфигурации
    SSL_DOMAIN="${ALLOWED_DOMAIN:-localhost}"
    
    # Создаем конфигурацию SSL виртуального хоста
    cat > /etc/apache2/sites-available/default-ssl.conf <<EOF
<IfModule mod_ssl.c>
    <VirtualHost *:443>
        ServerName ${SSL_DOMAIN}
        ServerAlias www.${SSL_DOMAIN}
        DocumentRoot /var/www/html/app/webroot
        
        <Directory /var/www/html/app/webroot>
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>
        
        SSLEngine on
        SSLCertificateFile ${CERT_FILE}
        SSLCertificateKeyFile ${KEY_FILE}
        
        # Оптимизация производительности
        <IfModule mod_deflate.c>
            AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
        </IfModule>
        
        <IfModule mod_expires.c>
            ExpiresActive On
            ExpiresByType image/jpeg "access plus 1 year"
            ExpiresByType image/png "access plus 1 year"
            ExpiresByType image/gif "access plus 1 year"
            ExpiresByType text/css "access plus 1 month"
            ExpiresByType application/javascript "access plus 1 month"
        </IfModule>
        
        <IfModule mod_headers.c>
            Header set X-Content-Type-Options "nosniff"
            Header set X-XSS-Protection "1; mode=block"
            Header set X-Frame-Options "SAMEORIGIN"
            Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
        </IfModule>
    </VirtualHost>
</IfModule>
EOF
    
    # Включаем SSL сайт
    a2ensite default-ssl.conf 2>/dev/null || true
    echo "HTTPS configuration enabled"
else
    echo "SSL certificate not found, HTTPS will not be available (HTTP only)"
    # Отключаем SSL сайт, если он был включен ранее
    a2dissite default-ssl.conf 2>/dev/null || true
fi

# Настройка ограничения по домену и редиректов для продакшна
if [ "$APP_ENV" = "prod" ] && [ ! -z "$ALLOWED_DOMAIN" ]; then
    echo "Configuring domain restrictions and redirects for production: $ALLOWED_DOMAIN"
    
    # Экранируем точки в домене для использования в регулярных выражениях
    ESCAPED_DOMAIN=$(echo "$ALLOWED_DOMAIN" | sed 's/\./\\./g')
    
    # Определяем протокол для редиректа www -> domain
    if [ -f "$CERT_FILE" ] && [ -f "$KEY_FILE" ]; then
        # Если SSL настроен, редиректим www на HTTPS версию основного домена
        WWW_REDIRECT_PROTO="https"
    else
        # Если SSL не настроен, редиректим на HTTP версию
        WWW_REDIRECT_PROTO="http"
    fi
    
    # Пытаемся обновить .htaccess файл
    HTACCESS_FILE="/var/www/html/app/webroot/.htaccess"
    
    # Создаем новый .htaccess с правилами в правильном порядке
    # Все правила должны быть в одном блоке <IfModule mod_rewrite.c>
    # Порядок важен: сначала редиректы, потом ограничение по домену
    {
        echo "<IfModule mod_rewrite.c>"
        echo "    RewriteEngine On"
        echo ""
        echo "    # Редирект www.domain.com -> domain.com (приоритет 1)"
        echo "    # Редиректим www на основной домен с правильным протоколом"
        echo "    RewriteCond %{HTTP_HOST} ^www\\.${ESCAPED_DOMAIN}\$ [NC]"
        echo "    RewriteRule ^(.*)$ ${WWW_REDIRECT_PROTO}://${ALLOWED_DOMAIN}%{REQUEST_URI} [L,R=301]"
        echo ""
        echo "    # Редирект HTTP -> HTTPS (приоритет 2, только если SSL настроен)"
        echo "    # НЕ применяем редирект для запросов по IP, чтобы избежать ERR_CONNECTION_REFUSED"
        if [ -f "$CERT_FILE" ] && [ -f "$KEY_FILE" ]; then
            echo "    RewriteCond %{HTTPS} off"
            echo "    RewriteCond %{HTTP_HOST} ^${ESCAPED_DOMAIN}\$ [NC]"
            echo "    RewriteCond %{REQUEST_URI} !^/\\.well-known"
            echo "    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]"
        fi
        echo ""
        echo "    # Ограничение доступа только с разрешенного домена (приоритет 3)"
        echo "    # Блокируем все запросы, которые не идут с разрешенного домена"
        echo "    # Это включает запросы по IP адресу (HTTP_HOST будет содержать IP)"
        echo "    RewriteCond %{HTTP_HOST} !^${ESCAPED_DOMAIN}\$ [NC]"
        echo "    RewriteCond %{HTTP_HOST} !^www\\.${ESCAPED_DOMAIN}\$ [NC]"
        echo "    RewriteRule ^(.*)$ - [F,L]"
        echo ""
        echo "    # CakePHP routing rules"
        echo "    RewriteCond %{REQUEST_FILENAME} !-d"
        echo "    RewriteCond %{REQUEST_FILENAME} !-f"
        echo "    RewriteRule ^ index.php [L]"
        echo "</IfModule>"
    } > "$HTACCESS_FILE"
    
    # Устанавливаем права доступа
    chmod 644 "$HTACCESS_FILE" 2>/dev/null || true
    chown www-data:www-data "$HTACCESS_FILE" 2>/dev/null || true
    
    echo "Domain restrictions and redirects enabled for: $ALLOWED_DOMAIN"
    
    echo "Production mode: Access restricted to $ALLOWED_DOMAIN only"
    echo "Redirects configured:"
    echo "  - www.$ALLOWED_DOMAIN -> $ALLOWED_DOMAIN"
    if [ -f "$CERT_FILE" ] && [ -f "$KEY_FILE" ]; then
        echo "  - HTTP -> HTTPS"
    else
        echo "  - HTTP -> HTTPS (disabled - no SSL certificate)"
    fi
else
    echo "Development mode or no domain specified - access allowed from any domain"
    
    # В dev режиме создаем базовый .htaccess без ограничений
    HTACCESS_FILE="/var/www/html/app/webroot/.htaccess"
    {
        echo "<IfModule mod_rewrite.c>"
        echo "    RewriteEngine On"
        echo "    RewriteCond %{REQUEST_FILENAME} !-d"
        echo "    RewriteCond %{REQUEST_FILENAME} !-f"
        echo "    RewriteRule ^ index.php [L]"
        echo "</IfModule>"
    } > "$HTACCESS_FILE"
    
    # Устанавливаем права доступа
    chmod 644 "$HTACCESS_FILE" 2>/dev/null || true
    chown www-data:www-data "$HTACCESS_FILE" 2>/dev/null || true
fi
