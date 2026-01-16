# Docker Setup для Tyre PHP App

## Требования

- Docker
- Docker Compose

## Окружения

Приложение поддерживает два окружения:
- **Development (dev)** - для разработки (порт 8080, без ограничений)
- **Production (prod)** - для продакшна (порт 80, ограничение по домену)

**Подробная документация:** `README-ENVIRONMENTS.md`

## Быстрый старт (Development)

1. Скопируйте файл с переменными окружения:
```bash
cp env.example .env
```

2. Отредактируйте `.env` файл:
```env
APP_ENV=dev
ALLOWED_DOMAIN=
HTTP_PORT=8080
HTTPS_PORT=443
MYSQL_PORT=3307
DB_NAME=tyre_db
DB_USER=tyre_user
DB_PASSWORD=your_password
MYSQL_ROOT_PASSWORD=root_password
PHPMYADMIN_USER=admin
PHPMYADMIN_PASSWORD=admin_password
```

3. Запустите контейнеры:
```bash
docker-compose up -d
```

4. Приложение будет доступно по адресу: http://localhost:8080
5. phpMyAdmin: http://localhost:8080/phpmy/ (с Basic Auth)

## Быстрый старт (Production)

1. Скопируйте файл с переменными окружения:
```bash
cp env.example .env
```

2. Отредактируйте `.env` файл:
```env
APP_ENV=prod
ALLOWED_DOMAIN=example.com
HTTP_PORT=80
HTTPS_PORT=443
MYSQL_PORT=3306
DB_NAME=tyre_db
DB_USER=tyre_user
DB_PASSWORD=your_password
MYSQL_ROOT_PASSWORD=root_password
PHPMYADMIN_USER=admin
PHPMYADMIN_PASSWORD=admin_password
```

3. Запустите контейнеры:
```bash
docker-compose up -d
```

4. Приложение будет доступно по адресу: http://example.com или https://example.com

## Восстановление базы данных из дампа

1. Поместите файл дампа в директорию `dumps/`

2. Запустите скрипт восстановления:
```bash
chmod +x restore-db.sh
./restore-db.sh dumps/your_dump.sql
```

Или укажите полный путь к дампу:
```bash
./restore-db.sh /path/to/dump.sql
```

## Восстановление публичных файлов

Директории `app/webroot/files` и `app/webroot/img` монтируются как volumes, поэтому файлы сохраняются на хосте.

### Использование скрипта restore-files.sh

Скрипт автоматически копирует файлы и устанавливает правильные права доступа:

```bash
chmod +x restore-files.sh
./restore-files.sh /path/to/backup/files
```

Или укажите относительный путь:
```bash
./restore-files.sh ./backup/files
```

### Ручное восстановление

Для ручного восстановления файлов из бэкапа:
```bash
# Скопируйте файлы в директории
cp -r /path/to/backup/files/* app/webroot/files/
cp -r /path/to/backup/img/* app/webroot/img/
```

## Управление контейнерами

### Остановка
```bash
docker-compose down
```

### Остановка с удалением volumes (ОСТОРОЖНО: удалит данные БД)
```bash
docker-compose down -v
```

### Просмотр логов
```bash
# Все сервисы
docker-compose logs -f

# Только PHP
docker-compose logs -f tyre-app-php

# Только MySQL
docker-compose logs -f tyre-app-mysql
```

### Перезапуск
```bash
docker-compose restart
```

## Доступ к контейнерам

### PHP контейнер
```bash
docker exec -it tyre-app-php bash
```

### MySQL контейнер
```bash
docker exec -it tyre-app-mysql bash
```

### Подключение к MySQL
```bash
docker exec -it tyre-app-mysql mysql -uroot -p
# Пароль из .env файла (MYSQL_ROOT_PASSWORD)
```

Или через клиент на хосте:
```bash
mysql -h 127.0.0.1 -P 3307 -u tyre_user -p
```

## Структура

- `tyre-app-php` - PHP 5.6 контейнер с Apache
- `tyre-app-mysql` - MySQL 5.7 контейнер
- Volume `tyre-app-mysql-data` - данные MySQL
- Volume `app/webroot/files` - публичные файлы (монтируется с хоста)
- Volume `app/webroot/img` - изображения и статические файлы (монтируется с хоста)

## Порты

- `8080` - веб-сервер (PHP/Apache)
- `3307` - MySQL (внешний доступ)

## Переменные окружения

Все настройки базы данных берутся из файла `.env`:

- `DB_HOST` - хост базы данных (по умолчанию: tyre-app-mysql)
- `DB_PORT` - порт базы данных (по умолчанию: 3306)
- `DB_NAME` - имя базы данных
- `DB_USER` - пользователь базы данных
- `DB_PASSWORD` - пароль базы данных
- `MYSQL_ROOT_PASSWORD` - пароль root для MySQL

## Troubleshooting

### Проблемы с правами доступа
```bash
sudo chown -R $USER:$USER app/tmp app/webroot/img
sudo chmod -R 777 app/tmp app/webroot/img
```

### Очистка кеша приложения
```bash
docker exec -it tyre-app-php rm -rf /var/www/html/app/tmp/cache/*
```

### Проверка подключения к БД
```bash
docker exec -it tyre-app-php php -r "echo getenv('DB_HOST');"
```

## Очистка неиспользуемых директорий tyres

Скрипт `cleanup-tyres-dirs.sh` удаляет директории с изображениями шин, которых нет в базе данных.

### Использование

1. **Просмотр (dry-run)** - показывает, что будет удалено, но не удаляет:
```bash
./cleanup-tyres-dirs.sh
```

2. **Реальное удаление**:
```bash
./cleanup-tyres-dirs.sh --execute
```

### Параметры

Скрипт использует переменные окружения из `.env` файла или можно указать вручную:

```bash
# Использование Docker контейнера MySQL
USE_DOCKER=1 ./cleanup-tyres-dirs.sh --execute

# Или прямое подключение к MySQL
DB_HOST=localhost DB_PORT=3306 DB_NAME=tyre_db DB_USER=tyre_user DB_PASSWORD=password ./cleanup-tyres-dirs.sh --execute

# Изменение пути к директории
TYRES_DIR=/path/to/tyres ./cleanup-tyres-dirs.sh --execute
```

### Что делает скрипт

1. Подключается к базе данных
2. Получает список всех `id` из таблицы `products` где `category_id = 1` (шины)
3. Проверяет директории в `/root/backup/files-new/tyres/`
4. Удаляет директории, `id` которых нет в базе данных
5. Показывает статистику: сколько сохранено, сколько удалено, сколько места освобождено

### Безопасность

- По умолчанию скрипт работает в режиме **dry-run** (только просмотр)
- Для реального удаления нужно указать параметр `--execute`
- Скрипт проверяет, что директория существует перед удалением
