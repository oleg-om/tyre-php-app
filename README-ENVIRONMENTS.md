# Конфигурация окружений (Dev/Prod)

Приложение поддерживает два окружения: **development** (dev) и **production** (prod).

## Различия между окружениями

### Development (dev)
- Порт: **8080**
- Доступ: без ограничений по домену
- Контейнеры: `tyre-app-php-dev`, `tyre-app-mysql-dev`
- Volumes: `tyre-app-mysql-data-dev`, `tyre-app-files`

### Production (prod)
- Порт HTTP: **80** (автоматический редирект на HTTPS)
- Порт HTTPS: **443**
- SSL: автоматическая генерация self-signed сертификата
- Редирект: HTTP → HTTPS (автоматически)
- Доступ: только с указанного домена (через переменную `ALLOWED_DOMAIN`)
- Контейнеры: `tyre-app-php-prod`, `tyre-app-mysql-prod`
- Volumes: `tyre-app-mysql-data-prod`, `tyre-app-files-prod`, `tyre-app-ssl-prod`
- MySQL порт: **3306** (вместо 3307)

## Быстрый старт

### Development окружение

1. Создайте файл `.env`:
```bash
cp env.example .env
```

2. Убедитесь, что в `.env` указано:
```env
APP_ENV=dev
ALLOWED_DOMAIN=
```

3. Запустите контейнеры:
```bash
docker-compose -f docker-compose.dev.yml up -d
```

4. Приложение будет доступно по адресу: http://localhost:8080

### Production окружение

1. Создайте файл `.env`:
```bash
cp env.example .env
```

2. Укажите настройки для продакшна в `.env`:
```env
APP_ENV=prod
ALLOWED_DOMAIN=example.com
# или с www:
# ALLOWED_DOMAIN=www.example.com
```

3. Запустите контейнеры:
```bash
docker-compose -f docker-compose.prod.yml up -d
```

4. Приложение будет доступно по адресу: https://example.com (только с указанного домена)
   - HTTP запросы автоматически перенаправляются на HTTPS
   - SSL сертификат генерируется автоматически при первом запуске

**Важно:** 
- В продакшне приложение будет возвращать 403 Forbidden для всех запросов, которые не приходят с указанного домена
- Используется self-signed SSL сертификат (браузер может показать предупреждение о безопасности)
- Для продакшна рекомендуется использовать Let's Encrypt сертификат (см. раздел "SSL сертификаты")

## Переменные окружения

### Общие переменные
- `DB_HOST` - хост базы данных
- `DB_PORT` - порт базы данных
- `DB_NAME` - имя базы данных
- `DB_USER` - пользователь базы данных
- `DB_PASSWORD` - пароль базы данных
- `MYSQL_ROOT_PASSWORD` - пароль root для MySQL
- `PHPMYADMIN_USER` - логин для Basic Auth phpMyAdmin
- `PHPMYADMIN_PASSWORD` - пароль для Basic Auth phpMyAdmin

### Специфичные для окружения
- `APP_ENV` - окружение: `dev` или `prod`
- `ALLOWED_DOMAIN` - разрешенный домен для продакшна (оставьте пустым для dev)

## Управление контейнерами

### Development
```bash
# Запуск
docker-compose -f docker-compose.dev.yml up -d

# Остановка
docker-compose -f docker-compose.dev.yml down

# Просмотр логов
docker-compose -f docker-compose.dev.yml logs -f

# Перезапуск
docker-compose -f docker-compose.dev.yml restart
```

### Production
```bash
# Запуск
docker-compose -f docker-compose.prod.yml up -d

# Остановка
docker-compose -f docker-compose.prod.yml down

# Просмотр логов
docker-compose -f docker-compose.prod.yml logs -f

# Перезапуск
docker-compose -f docker-compose.prod.yml restart
```

## Ограничение доступа по домену и HTTPS редирект в продакшне

В продакшне приложение автоматически:
1. Ограничивает доступ только для указанного домена
2. Перенаправляет все HTTP запросы на HTTPS

Правила в `.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Редирект HTTP -> HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
    
    # Ограничение доступа по домену
    RewriteCond %{HTTP_HOST} !^example.com$ [NC]
    RewriteCond %{HTTP_HOST} !^www\.example.com$ [NC]
    RewriteRule ^(.*)$ - [F,L]
</IfModule>
```

Это означает:
- ✅ Разрешены запросы с `example.com` и `www.example.com`
- ✅ Все HTTP запросы автоматически перенаправляются на HTTPS
- ❌ Все остальные домены получат 403 Forbidden

## Переключение между окружениями

### С dev на prod
```bash
# Остановите dev окружение
docker-compose -f docker-compose.dev.yml down

# Обновите .env файл
# APP_ENV=prod
# ALLOWED_DOMAIN=example.com

# Запустите prod окружение
docker-compose -f docker-compose.prod.yml up -d
```

### С prod на dev
```bash
# Остановите prod окружение
docker-compose -f docker-compose.prod.yml down

# Обновите .env файл
# APP_ENV=dev
# ALLOWED_DOMAIN=

# Запустите dev окружение
docker-compose -f docker-compose.dev.yml up -d
```

## SSL сертификаты

### Self-signed сертификат (по умолчанию)

При первом запуске продакшн окружения автоматически генерируется self-signed SSL сертификат:
- Сертификат сохраняется в Docker volume `tyre-app-ssl-prod`
- Действителен 365 дней
- Браузеры могут показывать предупреждение о безопасности

### Использование Let's Encrypt (рекомендуется для продакшна)

Для получения валидного SSL сертификата от Let's Encrypt:

1. Убедитесь, что домен указывает на ваш сервер
2. Установите certbot на хосте:
```bash
sudo apt-get update
sudo apt-get install certbot
```

3. Получите сертификат:
```bash
sudo certbot certonly --standalone -d example.com -d www.example.com
```

4. Скопируйте сертификаты в Docker volume:
```bash
# Остановите контейнер
docker-compose -f docker-compose.prod.yml down

# Скопируйте сертификаты
docker run --rm -v tyre-php-app_tyre-app-ssl-prod:/ssl -v /etc/letsencrypt/live/example.com:/certs alpine sh -c "cp /certs/fullchain.pem /ssl/server.crt && cp /certs/privkey.pem /ssl/server.key && chmod 600 /ssl/server.key && chmod 644 /ssl/server.crt"

# Запустите контейнер
docker-compose -f docker-compose.prod.yml up -d
```

5. Настройте автоматическое обновление сертификата (cron):
```bash
# Добавьте в crontab (sudo crontab -e):
0 0 * * * certbot renew --quiet && docker run --rm -v tyre-php-app_tyre-app-ssl-prod:/ssl -v /etc/letsencrypt/live/example.com:/certs alpine sh -c "cp /certs/fullchain.pem /ssl/server.crt && cp /certs/privkey.pem /ssl/server.key && chmod 600 /ssl/server.key && chmod 644 /ssl/server.crt" && docker-compose -f docker-compose.prod.yml restart tyre-app-php-prod
```

### Просмотр SSL сертификата

```bash
# Просмотр содержимого volume
docker run --rm -v tyre-php-app_tyre-app-ssl-prod:/ssl alpine ls -la /ssl

# Просмотр информации о сертификате
docker run --rm -v tyre-php-app_tyre-app-ssl-prod:/ssl alpine sh -c "openssl x509 -in /ssl/server.crt -text -noout"
```

## Важные замечания

1. **Разные volumes**: Dev и Prod используют разные volumes, поэтому данные не пересекаются
2. **Порты**: Убедитесь, что порты 80, 443 и 8080 не заняты другими приложениями
3. **Домен в продакшне**: Обязательно укажите `ALLOWED_DOMAIN` в продакшне, иначе приложение будет недоступно
4. **MySQL порты**: В dev MySQL доступен на порту 3307, в prod - на 3306
5. **HTTPS редирект**: В продакшне все HTTP запросы автоматически перенаправляются на HTTPS
6. **SSL сертификат**: Self-signed сертификат генерируется автоматически, но для продакшна рекомендуется использовать Let's Encrypt

## Troubleshooting

### Приложение недоступно в продакшне
- Проверьте, что `ALLOWED_DOMAIN` указан правильно
- Убедитесь, что вы обращаетесь к приложению с правильного домена
- Проверьте логи: `docker-compose -f docker-compose.prod.yml logs -f`

### Конфликт портов
- Убедитесь, что порт 80 (prod) или 8080 (dev) свободен
- Измените порт в соответствующем `docker-compose.*.yml` файле при необходимости
