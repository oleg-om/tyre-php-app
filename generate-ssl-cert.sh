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
    # ВАЖНО: Проверяем размер файлов, чтобы не перезаписывать Let's Encrypt сертификаты
    # Let's Encrypt fullchain обычно больше 2KB, self-signed обычно меньше 2KB
    CERT_EXISTS=false
    CERT_IS_LETSENCRYPT=false
    
    if [ -f "$CERT_FILE" ] && [ -f "$KEY_FILE" ]; then
        CERT_EXISTS=true
        # Проверяем, является ли сертификат Let's Encrypt
        if command -v openssl &> /dev/null; then
            if openssl x509 -in "$CERT_FILE" -noout -issuer 2>/dev/null | grep -qi "let's encrypt\|letsencrypt"; then
                CERT_IS_LETSENCRYPT=true
            fi
        else
            # Если openssl недоступен, проверяем размер файла
            # Let's Encrypt fullchain обычно больше 2KB
            CERT_SIZE=$(stat -c%s "$CERT_FILE" 2>/dev/null || echo "0")
            if [ "$CERT_SIZE" -gt 2000 ]; then
                CERT_IS_LETSENCRYPT=true
            fi
        fi
    fi
    
    if [ "$CERT_EXISTS" = true ] && [ "$CERT_IS_LETSENCRYPT" = true ]; then
        echo "Let's Encrypt certificate found in volume, skipping self-signed generation"
        echo "Certificate: $CERT_FILE"
        echo "Private key: $KEY_FILE"
        # Показываем информацию о сертификате для подтверждения
        if command -v openssl &> /dev/null; then
            openssl x509 -in "$CERT_FILE" -noout -subject -issuer -dates 2>/dev/null || true
        fi
    elif [ "$CERT_EXISTS" = true ]; then
        # Проверяем размер файла - если он больше 2KB, это может быть Let's Encrypt
        CERT_SIZE=$(stat -c%s "$CERT_FILE" 2>/dev/null || echo "0")
        if [ "$CERT_SIZE" -gt 2000 ]; then
            echo "Large certificate file found (${CERT_SIZE} bytes), assuming Let's Encrypt, skipping generation"
            echo "Certificate: $CERT_FILE"
            echo "Private key: $KEY_FILE"
        else
            echo "SSL certificate already exists (self-signed, ${CERT_SIZE} bytes), skipping generation"
            echo "Certificate: $CERT_FILE"
            echo "Private key: $KEY_FILE"
        fi
    else
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
    fi
else
    echo "SSL certificate generation skipped (no domain specified - optional)"
fi
