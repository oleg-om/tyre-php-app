# Быстрый старт для разных окружений

## Development (разработка)

```bash
# 1. Настройка
cp env.example .env
# Отредактируйте .env:
# APP_ENV=dev
# ALLOWED_DOMAIN=
# HTTP_PORT=8080
# HTTPS_PORT=443
# MYSQL_PORT=3307

# 2. Запуск
docker-compose up -d

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
# HTTP_PORT=80
# HTTPS_PORT=443
# MYSQL_PORT=3306

# 2. Запуск
docker-compose up -d

# 3. Доступ
# http://example.com или https://example.com
# HTTP запросы автоматически перенаправляются на HTTPS (если SSL настроен)
```

## Важно для продакшна

- **Порты 80 и 443** - убедитесь, что порты свободны
- **ALLOWED_DOMAIN** - обязательно укажите домен, иначе приложение будет недоступно
- **Доступ только с домена** - все запросы с других доменов/IP получат 403 Forbidden
- **www редирект** - `www.domain.com` автоматически редиректится на `domain.com`
- **HTTPS редирект** - все HTTP запросы автоматически перенаправляются на HTTPS (если SSL настроен)
- **SSL сертификат** - только Let's Encrypt (self-signed не генерируются, используйте `setup-letsencrypt.sh`)
- **Let's Encrypt** - для продакшна рекомендуется использовать Let's Encrypt (см. README-ENVIRONMENTS.md)

Подробная документация: `README-ENVIRONMENTS.md`
