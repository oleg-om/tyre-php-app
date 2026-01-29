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
    
    # Проверяем конфигурацию Apache
    if apache2ctl configtest 2>&1 | grep -q "Syntax OK"; then
        # Убеждаемся, что порт 443 указан в ports.conf
        if ! grep -q "^Listen 443" /etc/apache2/ports.conf 2>/dev/null; then
            echo "Listen 443" >> /etc/apache2/ports.conf
        fi
        
        # НЕ перезагружаем Apache здесь - он будет запущен apache2-foreground в CMD
        # Apache запустится автоматически после выполнения всех скриптов инициализации
        echo "HTTPS configuration enabled (Apache will start after initialization)"
    else
        echo "WARNING: Apache configuration has errors, SSL may not work"
        apache2ctl configtest 2>&1
    fi
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
    
    # Создаем временный файл, затем перемещаем его (более надежный способ)
    HTACCESS_TMP="/tmp/.htaccess-$$"
    
    # Создаем новый .htaccess с правилами в правильном порядке
    # Все правила должны быть в одном блоке <IfModule mod_rewrite.c>
    # Порядок важен: сначала защита от ботов, потом редиректы, потом ограничение по домену
    {
        echo "<IfModule mod_rewrite.c>"
        echo "    RewriteEngine On"
        echo ""
        echo "    # ============================================"
        echo "    # Защита от ботов и rate limiting"
        echo "    # ============================================"
        echo ""
        echo "    # Блокировка известных ботов и краулеров (кроме основных поисковых)"
        echo "    # Разрешаем только Googlebot и Yandex для SEO"
        echo "    RewriteCond %{HTTP_USER_AGENT} ^.*(GPTBot|ClaudeBot|ChatGPT|OpenAI|anthropic|PetalBot|SemrushBot|AhrefsBot|MJ12bot|DotBot|Baiduspider|Sogou|Exabot|facebot|facebookexternalhit|meta-externalagent|Twitterbot|LinkedInBot|WhatsApp|SkypeUriPreview|Applebot|bingbot|Slurp|DuckDuckBot|BingPreview|ia_archiver|archive\\.org_bot|msnbot|Amazonbot).* [NC]"
        echo "    RewriteRule .* - [F,L]"
        echo ""
        echo "    # Блокировка подозрительных User-Agent (исключая разрешенные поисковые боты)"
        echo "    RewriteCond %{HTTP_USER_AGENT} ^\$ [OR]"
        echo "    RewriteCond %{HTTP_USER_AGENT} ^(curl|wget|python|java|perl|ruby|bash|shell|cmd|powershell).* [NC,OR]"
        echo "    RewriteCond %{HTTP_USER_AGENT} .*(libwww-perl|nikto|scan|sqlmap|nmap|masscan|zmap).* [NC,OR]"
        echo "    # Блокируем ботов, но разрешаем Googlebot и Yandex"
        echo "    RewriteCond %{HTTP_USER_AGENT} !(Googlebot|Yandex|YandexBot|YandexImages|YandexVideo|YandexMedia|YandexBlogs|YandexFavicons|YandexWebmaster|YandexPagechecker|YandexImageResizer|YandexMetrika|YandexDirect|YandexScreenshotBot|YandexAccessibilityBot|YandexMobileScreenShotBot|YandexCalendar|YandexSitelinks|YandexNews|YandexCatalog|YandexAntivirus|YandexMarket|YandexVertis|YandexForDomain|YandexSpravBot|YandexSearchShop|YandexMedianaBot|YandexOntoDB|YandexOntoDBAPI|YandexTurbo|YandexVerticals|YandexNotifier) [NC]"
        echo "    RewriteCond %{HTTP_USER_AGENT} .*(harvest|extract|grab|miner|crawler|spider|bot|scraper).* [NC]"
        echo "    RewriteRule .* - [F,L]"
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
        echo "    # Прямой доступ к статическим файлам (изображения, CSS, JS) - обход CakePHP для производительности"
        echo "    # Если файл существует, отдаем его напрямую"
        echo "    RewriteCond %{REQUEST_FILENAME} -f"
        echo "    RewriteRule ^(img|css|js|files)/(.*)$ - [L]"
        echo ""
        echo "    # CakePHP routing rules"
        echo "    RewriteCond %{REQUEST_FILENAME} !-d"
        echo "    RewriteCond %{REQUEST_FILENAME} !-f"
        echo "    RewriteRule ^ index.php [L]"
        echo "</IfModule>"
        echo ""
        echo "# Ограничение размера запроса (10MB)"
        echo "LimitRequestBody 10485760"
    } > "$HTACCESS_TMP"
    
    # Удаляем старый файл, если он существует и принадлежит root
    if [ -f "$HTACCESS_FILE" ] && [ "$(stat -c '%U' "$HTACCESS_FILE" 2>/dev/null)" = "root" ]; then
        rm -f "$HTACCESS_FILE" 2>/dev/null || true
    fi
    
    # Перемещаем временный файл на место (это атомарная операция)
    mv "$HTACCESS_TMP" "$HTACCESS_FILE" 2>/dev/null || {
        # Если не удалось переместить, пробуем скопировать
        cp "$HTACCESS_TMP" "$HTACCESS_FILE" 2>/dev/null || {
            echo "ERROR: Failed to update .htaccess file"
            rm -f "$HTACCESS_TMP"
            exit 1
        }
        rm -f "$HTACCESS_TMP"
    }
    
    # Устанавливаем права доступа
    chmod 644 "$HTACCESS_FILE" 2>/dev/null || true
    chown www-data:www-data "$HTACCESS_FILE" 2>/dev/null || true
    
    # Проверяем, что файл действительно обновился
    if [ -f "$HTACCESS_FILE" ] && grep -q "Ограничение доступа только с разрешенного домена" "$HTACCESS_FILE" 2>/dev/null; then
        echo ".htaccess file updated successfully"
    else
        echo "WARNING: .htaccess file may not have been updated correctly"
    fi
    
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
    
    # В dev режиме создаем базовый .htaccess без ограничений по домену, но с защитой от ботов
    HTACCESS_FILE="/var/www/html/app/webroot/.htaccess"
    {
        echo "<IfModule mod_rewrite.c>"
        echo "    RewriteEngine On"
        echo ""
        echo "    # ============================================"
        echo "    # Защита от ботов и rate limiting"
        echo "    # ============================================"
        echo ""
        echo "    # Блокировка известных ботов и краулеров (кроме основных поисковых)"
        echo "    # Разрешаем только Googlebot и Yandex для SEO"
        echo "    RewriteCond %{HTTP_USER_AGENT} ^.*(GPTBot|ClaudeBot|ChatGPT|OpenAI|anthropic|PetalBot|SemrushBot|AhrefsBot|MJ12bot|DotBot|Baiduspider|Sogou|Exabot|facebot|facebookexternalhit|meta-externalagent|Twitterbot|LinkedInBot|WhatsApp|SkypeUriPreview|Applebot|bingbot|Slurp|DuckDuckBot|BingPreview|ia_archiver|archive\\.org_bot|msnbot|Amazonbot).* [NC]"
        echo "    RewriteRule .* - [F,L]"
        echo ""
        echo "    # Блокировка подозрительных User-Agent (исключая разрешенные поисковые боты)"
        echo "    RewriteCond %{HTTP_USER_AGENT} ^\$ [OR]"
        echo "    RewriteCond %{HTTP_USER_AGENT} ^(curl|wget|python|java|perl|ruby|bash|shell|cmd|powershell).* [NC,OR]"
        echo "    RewriteCond %{HTTP_USER_AGENT} .*(libwww-perl|nikto|scan|sqlmap|nmap|masscan|zmap).* [NC,OR]"
        echo "    # Блокируем ботов, но разрешаем Googlebot и Yandex"
        echo "    RewriteCond %{HTTP_USER_AGENT} !(Googlebot|Yandex|YandexBot|YandexImages|YandexVideo|YandexMedia|YandexBlogs|YandexFavicons|YandexWebmaster|YandexPagechecker|YandexImageResizer|YandexMetrika|YandexDirect|YandexScreenshotBot|YandexAccessibilityBot|YandexMobileScreenShotBot|YandexCalendar|YandexSitelinks|YandexNews|YandexCatalog|YandexAntivirus|YandexMarket|YandexVertis|YandexForDomain|YandexSpravBot|YandexSearchShop|YandexMedianaBot|YandexOntoDB|YandexOntoDBAPI|YandexTurbo|YandexVerticals|YandexNotifier) [NC]"
        echo "    RewriteCond %{HTTP_USER_AGENT} .*(harvest|extract|grab|miner|crawler|spider|bot|scraper).* [NC]"
        echo "    RewriteRule .* - [F,L]"
        echo ""
        echo "    # Прямой доступ к статическим файлам (изображения, CSS, JS) - обход CakePHP для производительности"
        echo "    # Если файл существует, отдаем его напрямую"
        echo "    RewriteCond %{REQUEST_FILENAME} -f"
        echo "    RewriteRule ^(img|css|js|files)/(.*)$ - [L]"
        echo ""
        echo "    # CakePHP routing rules"
        echo "    RewriteCond %{REQUEST_FILENAME} !-d"
        echo "    RewriteCond %{REQUEST_FILENAME} !-f"
        echo "    RewriteRule ^ index.php [L]"
        echo "</IfModule>"
        echo ""
        echo "# Ограничение размера запроса (10MB)"
        echo "LimitRequestBody 10485760"
    } > "$HTACCESS_FILE"
    
    # Устанавливаем права доступа
    chmod 644 "$HTACCESS_FILE" 2>/dev/null || true
    chown www-data:www-data "$HTACCESS_FILE" 2>/dev/null || true
fi
