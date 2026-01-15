#!/bin/bash
# Настройка опционального редиректа HTTP -> HTTPS и ограничения по домену для продакшна

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
    
    # Если указан домен и режим продакшна, добавляем редирект HTTP -> HTTPS
    if [ "$APP_ENV" = "prod" ] && [ ! -z "$ALLOWED_DOMAIN" ]; then
        HTACCESS_DOMAIN="/var/www/html/app/webroot/.htaccess-domain"
        
        cat > "$HTACCESS_DOMAIN" <<EOF
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Редирект HTTP -> HTTPS (только если SSL настроен)
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
EOF
        
        # Вставляем правила в начало .htaccess
        if [ -f /var/www/html/app/webroot/.htaccess ]; then
            cat "$HTACCESS_DOMAIN" /var/www/html/app/webroot/.htaccess > /var/www/html/app/webroot/.htaccess.tmp
            mv /var/www/html/app/webroot/.htaccess.tmp /var/www/html/app/webroot/.htaccess
            rm -f "$HTACCESS_DOMAIN"
        else
            mv "$HTACCESS_DOMAIN" /var/www/html/app/webroot/.htaccess
        fi
        
        echo "HTTPS redirect enabled for: $ALLOWED_DOMAIN"
    fi
    
    echo "HTTPS configuration enabled"
else
    echo "SSL certificate not found, HTTPS will not be available (HTTP only)"
    # Отключаем SSL сайт, если он был включен ранее
    a2dissite default-ssl.conf 2>/dev/null || true
fi

# Ограничение по домену отключено - доступ разрешен с любого домена
echo "Domain restriction disabled - access allowed from any domain"
