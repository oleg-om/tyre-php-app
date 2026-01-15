# Быстрый старт для разных окружений

## Development (разработка)

```bash
# 1. Настройка
cp env.example .env
# Отредактируйте .env: APP_ENV=dev, ALLOWED_DOMAIN=

# 2. Запуск
docker-compose -f docker-compose.dev.yml up -d

# 3. Доступ
# http://localhost:8080
```

## Production (продакшн)

```bash
# 1. Настройка
cp env.example .env
# Отредактируйте .env:
# APP_ENV=prod
# ALLOWED_DOMAIN=example.com

# 2. Запуск
docker-compose -f docker-compose.prod.yml up -d

# 3. Доступ
# https://example.com (только с указанного домена!)
# HTTP запросы автоматически перенаправляются на HTTPS
```

## Важно для продакшна

- **Порты 80 и 443** - убедитесь, что порты свободны
- **ALLOWED_DOMAIN** - обязательно укажите домен, иначе приложение будет недоступно
- **Доступ только с домена** - все запросы с других доменов получат 403 Forbidden
- **HTTPS редирект** - все HTTP запросы автоматически перенаправляются на HTTPS
- **SSL сертификат** - автоматически генерируется self-signed сертификат (браузер может показать предупреждение)
- **Let's Encrypt** - для продакшна рекомендуется использовать Let's Encrypt (см. README-ENVIRONMENTS.md)

Подробная документация: `README-ENVIRONMENTS.md`
