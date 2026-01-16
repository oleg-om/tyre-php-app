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
    
    HTACCESS_RULES="/tmp/htaccess-rules-$$"
    
    # Экранируем точки в домене для использования в регулярных выражениях
    ESCAPED_DOMAIN=$(echo "$ALLOWED_DOMAIN" | sed 's/\./\\./g')
    
    # Определяем протокол для редиректа www -> domain
    if [ -f "$CERT_FILE" ] && [ -f "$KEY_FILE" ]; then
        # Если SSL настроен, редиректим www на HTTPS версию основного домена
        WWW_REDIRECT="https://${ALLOWED_DOMAIN}%{REQUEST_URI}"
    else
        # Если SSL не настроен, редиректим на HTTP версию
        WWW_REDIRECT="http://${ALLOWED_DOMAIN}%{REQUEST_URI}"
    fi
    
    cat > "$HTACCESS_RULES" <<EOF
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Редирект www.domain.com -> domain.com (приоритет 1)
    # Редиректим www на основной домен с правильным протоколом
    RewriteCond %{HTTP_HOST} ^www\.${ESCAPED_DOMAIN}$ [NC]
    RewriteRule ^(.*)$ ${WWW_REDIRECT} [L,R=301]
    
    # Редирект HTTP -> HTTPS (приоритет 2, только если SSL настроен)
    RewriteCond %{HTTPS} off
    RewriteCond %{REQUEST_URI} !^/\.well-known
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Ограничение доступа только с разрешенного домена (приоритет 3)
    # Разрешаем только основной домен (без www, так как www уже редиректится)
    RewriteCond %{HTTP_HOST} !^${ESCAPED_DOMAIN}$ [NC]
    RewriteRule ^(.*)$ - [F,L]
</IfModule>
EOF
    
    # Пытаемся обновить .htaccess файл
    HTACCESS_FILE="/var/www/html/app/webroot/.htaccess"
    
    # Если файл существует, читаем оригинальные правила CakePHP
    CAKEPHP_RULES=""
    if [ -f "$HTACCESS_FILE" ]; then
        # Извлекаем правила CakePHP (после всех редиректов)
        CAKEPHP_RULES=$(grep -A 10 "RewriteCond %{REQUEST_FILENAME} !-d" "$HTACCESS_FILE" | head -n 5 | grep -v "^--$" || echo "")
    fi
    
    # Создаем новый .htaccess с правилами в правильном порядке
    {
        # Правила домена и редиректов (в начале)
        cat "$HTACCESS_RULES"
        
        # Пустая строка для разделения
        echo ""
        
        # Оригинальные правила CakePHP (если были)
        if [ ! -z "$CAKEPHP_RULES" ]; then
            echo "# CakePHP routing rules"
            echo "$CAKEPHP_RULES"
        else
            # Стандартные правила CakePHP, если их не было
            echo "# CakePHP routing rules"
            echo "<IfModule mod_rewrite.c>"
            echo "    RewriteCond %{REQUEST_FILENAME} !-d"
            echo "    RewriteCond %{REQUEST_FILENAME} !-f"
            echo "    RewriteRule ^ index.php [L]"
            echo "</IfModule>"
        fi
    } > "$HTACCESS_FILE"
    
    # Устанавливаем права доступа
    chmod 644 "$HTACCESS_FILE" 2>/dev/null || true
    chown www-data:www-data "$HTACCESS_FILE" 2>/dev/null || true
    
    rm -f "$HTACCESS_RULES"
    
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
fi
