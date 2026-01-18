#!/bin/bash

# === НАСТРОЙКИ ===
SOURCE_DIR="/var/www/vhosts/kerchshina.com/app/webroot"
BACKUP_DIR="/home/backup"
ARCHIVE_NAME="backup_$(date +%Y-%m-%d_%H-%M-%S).tar.gz"
REMOTE_NAME="s3:autodom/kerchshina_static"

# === СОЗДАНИЕ АРХИВА ===
mkdir -p "$BACKUP_DIR"
tar -czf "$BACKUP_DIR/$ARCHIVE_NAME" -C "$SOURCE_DIR" .

# === УДАЛЕНИЕ АРХИВА НА S3 ===
rclone delete "$REMOTE_NAME" --include "*.tar.gz"

# === ОТПРАВКА В S3 ===
rclone copy "$BACKUP_DIR/$ARCHIVE_NAME" "$REMOTE_NAME" --progress

# === ОЧИСТКА СТАРЫХ ЛОКАЛЬНЫХ БЭКАПОВ ===
find "$BACKUP_DIR" -type f -name "*.tar.gz" -delete