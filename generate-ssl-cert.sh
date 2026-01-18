#!/bin/bash
# Генерация SSL сертификата (опционально, только если указан домен)
# Генерирует self-signed сертификат ТОЛЬКО если сертификат не существует
# Не перезаписывает существующие сертификаты (например, Let's Encrypt)

SSL_DIR="/etc/apache2/ssl"
CERT_FILE="$SSL_DIR/server.crt"
KEY_FILE="$SSL_DIR/server.key"

# Генерируем сертификат только если указан домен (опционально)
if [ ! -z "$ALLOWED_DOMAIN" ]; then
    # Создаем директорию для сертификатов если её нет
    mkdir -p "$SSL_DIR"
    
    # Проверяем, существует ли уже сертификат
    if [ ! -f "$CERT_FILE" ] || [ ! -f "$KEY_FILE" ]; then
        echo "Generating self-signed SSL certificate for domain: $ALLOWED_DOMAIN"
        echo "Note: For production, use Let's Encrypt certificates (see setup-letsencrypt.sh)"
        
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
        
        echo "Self-signed SSL certificate generated successfully"
        echo "Certificate: $CERT_FILE"
        echo "Private key: $KEY_FILE"
    else
        # Проверяем, какой тип сертификата установлен
        if openssl x509 -in "$CERT_FILE" -noout -issuer 2>/dev/null | grep -q "Let's Encrypt"; then
            echo "Let's Encrypt certificate found, skipping self-signed generation"
        else
            echo "SSL certificate already exists, skipping generation"
        fi
    fi
else
    echo "SSL certificate generation skipped (no domain specified - optional)"
fi
