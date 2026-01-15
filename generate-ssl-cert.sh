#!/bin/bash
# Генерация SSL сертификата для продакшна

SSL_DIR="/etc/apache2/ssl"
CERT_FILE="$SSL_DIR/server.crt"
KEY_FILE="$SSL_DIR/server.key"

if [ "$APP_ENV" = "prod" ] && [ ! -z "$ALLOWED_DOMAIN" ]; then
    # Создаем директорию для сертификатов если её нет
    mkdir -p "$SSL_DIR"
    
    # Проверяем, существует ли уже сертификат
    if [ ! -f "$CERT_FILE" ] || [ ! -f "$KEY_FILE" ]; then
        echo "Generating SSL certificate for domain: $ALLOWED_DOMAIN"
        
        # Генерируем self-signed сертификат
        openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
            -keyout "$KEY_FILE" \
            -out "$CERT_FILE" \
            -subj "/C=RU/ST=State/L=City/O=Organization/CN=$ALLOWED_DOMAIN" \
            2>/dev/null
        
        # Устанавливаем права доступа
        chmod 600 "$KEY_FILE"
        chmod 644 "$CERT_FILE"
        chown root:root "$KEY_FILE" "$CERT_FILE"
        
        echo "SSL certificate generated successfully"
        echo "Certificate: $CERT_FILE"
        echo "Private key: $KEY_FILE"
    else
        echo "SSL certificate already exists, skipping generation"
    fi
else
    echo "SSL certificate generation skipped (dev mode or no domain specified)"
fi
