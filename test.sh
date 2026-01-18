#!/bin/bash

# Конфигурация
PROJECT="kerchshina.com"
BACKUP_DIR="/home/backup/db"          # Локальная папка для бэкапов

MYSQL_USER="root"
MYSQL_PASS="eX5g!5n5N8Uu"
MYSQL_DB="kerchshina"

MONGO_URI="mongodb://localhost:27017"      # URI MongoDB (можно добавить логин/пароль)

RCLONE_REMOTE="s3"                  # Имя удаленного хранилища в rclone
S3_BUCKET="autodom"              # Имя бакета в REG.RU S3
BACKUP_PREFIX="db.backup_"
BACKUP_NAME="$BACKUP_PREFIX$(date +%Y-%m-%d_%H-%M-%S)"  # Имя бэкапа
MAX_BACKUPS=4                              # Сколько последних бэкапов хранить
DB_TYPE="mysql"  # "mongo" or "mysql"

# Создаем папку для бэкапа
mkdir -p "$BACKUP_DIR"

# 1. Делаем дамп MongoDB или MySQL в зависимости от DB_TYPE
if [ "$DB_TYPE" = "mongo" ]; then
    echo "[$(date)] Creating MongoDB dump..."
    mongodump --uri="$MONGO_URI" --out "$BACKUP_DIR/$BACKUP_NAME"
elif [ "$DB_TYPE" = "mysql" ]; then
    echo "[$(date)] Creating MySQL dump..."
    mysqldump -u "$MYSQL_USER" -p"$MYSQL_PASS" "$MYSQL_DB" > "$BACKUP_DIR/$BACKUP_NAME.sql"
else
    echo "[$(date)] ERROR: Unknown DB_TYPE '$DB_TYPE'"
    exit 1
fi

# 2. Архивируем
echo "[$(date)] Archiving dump..."
if [ "$DB_TYPE" = "mongo" ]; then
    tar -czf "$BACKUP_DIR/$BACKUP_NAME.tar.gz" -C "$BACKUP_DIR" "$BACKUP_NAME"
    rm -rf "$BACKUP_DIR/$BACKUP_NAME"
else
    tar -czf "$BACKUP_DIR/$BACKUP_NAME.tar.gz" -C "$BACKUP_DIR" "$BACKUP_NAME.sql"
    rm -f "$BACKUP_DIR/$BACKUP_NAME.sql"
fi

# 2. Загружаем в S3 через rclone
echo "[$(date)] Uploading to REG.RU S3..."
rclone copy "$BACKUP_DIR/$BACKUP_NAME.tar.gz" "$RCLONE_REMOTE:$S3_BUCKET/$PROJECT/" --progress

# 3. Удаляем локальный бэкап (чтобы не занимать место)
rm -f "$BACKUP_DIR/$BACKUP_NAME.tar.gz"

# 4. Удаляем старые бэкапы в S3 (оставляем только последние $MAX_BACKUPS)
echo "[$(date)] Cleaning old backups in S3..."
BACKUP_LIST=$(rclone lsf "$RCLONE_REMOTE:$S3_BUCKET/$PROJECT/" | sort -r)
BACKUP_COUNT=$(echo "$BACKUP_LIST" | wc -l)

if [ "$BACKUP_COUNT" -gt "$MAX_BACKUPS" ]; then
    OLD_BACKUPS=$(echo "$BACKUP_LIST" | tail -n +$(($MAX_BACKUPS + 1)))
    echo "$OLD_BACKUPS" | while read -r backup; do
        echo "Deleting old backup: $backup"
        rclone delete "$RCLONE_REMOTE:$S3_BUCKET/$PROJECT/$backup"
    done
fi

echo "[$(date)] Backup completed!"