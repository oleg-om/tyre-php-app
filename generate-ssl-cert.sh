#!/bin/bash
# Проверка SSL сертификатов (только Let's Encrypt, без генерации self-signed)
# Скрипт только проверяет наличие сертификатов в volume
# Self-signed сертификаты НЕ генерируются

SSL_DIR="/etc/apache2/ssl"
CERT_FILE="$SSL_DIR/server.crt"
KEY_FILE="$SSL_DIR/server.key"

# Отладочная информация
echo "SSL certificate check script started"
echo "SSL directory: $SSL_DIR"
echo "Certificate file: $CERT_FILE"
echo "Key file: $KEY_FILE"

# Проверяем, что директория существует
if [ ! -d "$SSL_DIR" ]; then
    echo "Creating SSL directory: $SSL_DIR"
    mkdir -p "$SSL_DIR"
fi

# Проверяем наличие сертификатов
if [ -f "$CERT_FILE" ] && [ -f "$KEY_FILE" ]; then
    CERT_SIZE=$(stat -c%s "$CERT_FILE" 2>/dev/null || echo "0")
    KEY_SIZE=$(stat -c%s "$KEY_FILE" 2>/dev/null || echo "0")
    
    echo "Found existing certificate: size=${CERT_SIZE} bytes, key_size=${KEY_SIZE} bytes"
    
    # Проверяем, является ли сертификат Let's Encrypt
    if command -v openssl &> /dev/null; then
        CERT_ISSUER=$(openssl x509 -in "$CERT_FILE" -noout -issuer 2>/dev/null || echo "")
        CERT_SUBJECT=$(openssl x509 -in "$CERT_FILE" -noout -subject 2>/dev/null || echo "")
        
        if echo "$CERT_ISSUER" | grep -qi "let's encrypt\|letsencrypt"; then
            echo "✓ Let's Encrypt certificate found"
            echo "  Subject: $CERT_SUBJECT"
            echo "  Issuer: $CERT_ISSUER"
        else
            echo "⚠ Warning: Certificate found but it's not Let's Encrypt"
            echo "  Subject: $CERT_SUBJECT"
            echo "  Issuer: $CERT_ISSUER"
            echo "  Note: Self-signed certificates are not generated. Use setup-letsencrypt.sh to get Let's Encrypt certificate."
        fi
    else
        # Если openssl недоступен, проверяем размер файла
        # Let's Encrypt fullchain обычно больше 2KB
        if [ "$CERT_SIZE" -gt 2000 ]; then
            echo "✓ Large certificate file found (${CERT_SIZE} bytes), likely Let's Encrypt"
        else
            echo "⚠ Warning: Small certificate file found (${CERT_SIZE} bytes), may not be Let's Encrypt"
            echo "  Note: Self-signed certificates are not generated. Use setup-letsencrypt.sh to get Let's Encrypt certificate."
        fi
    fi
else
    echo "⚠ No SSL certificates found in $SSL_DIR"
    echo "  Note: Self-signed certificates are not generated."
    echo "  To get Let's Encrypt certificate, run: ./setup-letsencrypt.sh <domain>"
    echo "  Apache will start without SSL (HTTP only)"
fi
