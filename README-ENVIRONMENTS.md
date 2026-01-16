# Конфигурация окружений (Dev/Prod)

Приложение поддерживает два окружения: **development** (dev) и **production** (prod).

## Различия между окружениями

### Development (dev)
- Порт: **8080**
- Доступ: без ограничений по домену
- Контейнеры: `tyre-app-php`, `tyre-app-mysql`
- Volumes: `tyre-app-mysql-data`, `tyre-app-files`, `tyre-app-ssl`
- MySQL порт: **3307**

### Production (prod)
- Порт HTTP: **80** (автоматический редирект на HTTPS, если SSL настроен)
- Порт HTTPS: **443**
- SSL: автоматическая генерация self-signed сертификата (опционально)
- Редирект: HTTP → HTTPS (автоматически, если SSL настроен)
- Доступ: с любого домена (ограничение по домену отключено)
- Контейнеры: `tyre-app-php`, `tyre-app-mysql`
- Volumes: `tyre-app-mysql-data`, `tyre-app-files`, `tyre-app-ssl`
- MySQL порт: **3306**

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
HTTP_PORT=8080
HTTPS_PORT=443
MYSQL_PORT=3307
```

3. Запустите контейнеры:
```bash
docker-compose up -d
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
HTTP_PORT=80
HTTPS_PORT=443
MYSQL_PORT=3306
```

3. Запустите контейнеры:
```bash
docker-compose up -d
```

4. Приложение будет доступно по адресу: http://example.com или https://example.com
   - HTTP запросы автоматически перенаправляются на HTTPS (если SSL сертификат настроен)
   - SSL сертификат генерируется автоматически при первом запуске (если указан ALLOWED_DOMAIN)

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
docker-compose up -d

# Остановка
docker-compose down

# Просмотр логов
docker-compose logs -f

# Перезапуск
docker-compose restart
```

### Production
```bash
# Запуск
docker-compose up -d

# Остановка
docker-compose down

# Просмотр логов
docker-compose logs -f

# Перезапуск
docker-compose restart
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
docker-compose down

# Обновите .env файл
# APP_ENV=prod
# ALLOWED_DOMAIN=example.com
# HTTP_PORT=80
# HTTPS_PORT=443
# MYSQL_PORT=3306

# Запустите prod окружение
docker-compose up -d
```

### С prod на dev
```bash
# Остановите prod окружение
docker-compose down

# Обновите .env файл
# APP_ENV=dev
# ALLOWED_DOMAIN=
# HTTP_PORT=8080
# HTTPS_PORT=443
# MYSQL_PORT=3307

# Запустите dev окружение
docker-compose up -d
```

## SSL сертификаты

### Self-signed сертификат (по умолчанию)

При первом запуске продакшн окружения автоматически генерируется self-signed SSL сертификат:
- Сертификат сохраняется в Docker volume `tyre-app-ssl-prod`
- Действителен 365 дней
- Браузеры могут показывать предупреждение о безопасности

### Использование Let's Encrypt (рекомендуется для продакшна)

Для получения валидного SSL сертификата от Let's Encrypt используйте автоматический скрипт:

#### Автоматическая настройка (рекомендуется)

```bash
# 1. Убедитесь, что домен указывает на ваш сервер (A запись -> IP сервера)
# 2. Запустите скрипт настройки
./setup-letsencrypt.sh example.com
```

Скрипт автоматически:
- Установит certbot (если не установлен)
- Проверит DNS настройки
- Остановит контейнер PHP
- Получит сертификат от Let's Encrypt
- Скопирует сертификаты в Docker volume
- Запустит контейнер обратно
- Настроит автоматическое обновление через cron

#### Ручная настройка

Если предпочитаете настройку вручную:

1. Убедитесь, что домен указывает на ваш сервер
2. Установите certbot:
```bash
sudo apt-get update
sudo apt-get install certbot
```

3. Остановите контейнер PHP:
```bash
docker compose stop tyre-app-php
```

4. Получите сертификат:
```bash
sudo certbot certonly --standalone -d example.com -d www.example.com
```

5. Скопируйте сертификаты в Docker volume:
```bash
docker run --rm \
  -v tyre-app-ssl:/ssl \
  -v /etc/letsencrypt/live/example.com:/certs:ro \
  alpine sh -c "
    cp /certs/fullchain.pem /ssl/server.crt
    cp /certs/privkey.pem /ssl/server.key
    chmod 600 /ssl/server.key
    chmod 644 /ssl/server.crt
  "
```

6. Запустите контейнер:
```bash
docker compose up -d tyre-app-php
```

#### Обновление сертификата

Сертификат обновляется автоматически через cron. Для ручного обновления:

```bash
./update-ssl-cert.sh example.com
```

### Просмотр SSL сертификата

```bash
# Просмотр содержимого volume
docker run --rm -v tyre-php-app_tyre-app-ssl-prod:/ssl alpine ls -la /ssl

# Просмотр информации о сертификате
docker run --rm -v tyre-php-app_tyre-app-ssl-prod:/ssl alpine sh -c "openssl x509 -in /ssl/server.crt -text -noout"
```

## Важные замечания

1. **Общие volumes**: Dev и Prod используют одни и те же volumes (`tyre-app-mysql-data`, `tyre-app-files`, `tyre-app-ssl`). При переключении между окружениями убедитесь, что остановили предыдущее окружение.
2. **Порты**: Убедитесь, что порты 80, 443 и 8080 не заняты другими приложениями
3. **MySQL порты**: В dev MySQL доступен на порту 3307, в prod - на 3306
4. **HTTPS редирект**: HTTP запросы автоматически перенаправляются на HTTPS только если SSL сертификат настроен
5. **SSL сертификат**: Self-signed сертификат генерируется автоматически (если указан ALLOWED_DOMAIN), но для продакшна рекомендуется использовать Let's Encrypt
6. **Доступ по домену**: Ограничение доступа по домену отключено - приложение доступно с любого домена/IP

## Troubleshooting

### Приложение недоступно в продакшне
- Проверьте, что контейнеры запущены: `docker-compose ps`
- Проверьте логи: `docker-compose logs -f`
- Убедитесь, что порты 80 и 443 свободны
- Проверьте, что Apache запущен внутри контейнера: `docker exec tyre-app-php ps aux | grep apache`

### Конфликт портов
- Убедитесь, что порт 80 (prod) или 8080 (dev) свободен
- Измените порт в `.env` файле (HTTP_PORT, HTTPS_PORT, MYSQL_PORT)
