# Docker Setup для Tyre PHP App

## Требования

- Docker
- Docker Compose

## Быстрый старт

1. Скопируйте файл с переменными окружения:
```bash
cp env.example .env
```

2. Отредактируйте `.env` файл и укажите свои настройки базы данных:
```env
DB_NAME=tyre_db
DB_USER=tyre_user
DB_PASSWORD=your_password
MYSQL_ROOT_PASSWORD=root_password
```

3. Запустите контейнеры:
```bash
docker-compose up -d
```

4. Приложение будет доступно по адресу: http://localhost:8080

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

Для восстановления файлов из бэкапа:
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
