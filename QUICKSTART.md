# Быстрый старт Docker

## 1. Настройка переменных окружения

```bash
cp env.example .env
```

Отредактируйте `.env` и укажите свои пароли.

## 2. Запуск контейнеров

```bash
docker-compose up -d
```

## 3. Восстановление базы данных

Поместите дамп в `dumps/` и выполните:

```bash
./restore-db.sh dumps/your_dump.sql
```

## 4. Восстановление публичных файлов

Используйте скрипт для автоматического восстановления:
```bash
./restore-files.sh /path/to/backup/files
```

Или вручную:
```bash
cp -r /path/to/backup/files/* app/webroot/files/
```

## 5. Доступ к приложению

Откройте в браузере: http://localhost:8080

## Полезные команды

```bash
# Просмотр логов
docker-compose logs -f

# Остановка
docker-compose down

# Перезапуск
docker-compose restart
```

Подробная документация в `README-DOCKER.md`
