#!/bin/bash

# Скрипт для настройки автоматического обновления SSL сертификата через cron
# Использование: sudo ./setup-cron.sh [домен]

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Загрузка переменных окружения
if [ -f .env ]; then
    export $(cat .env | grep -v '^#' | xargs)
fi

# Определение домена
DOMAIN=${1:-${ALLOWED_DOMAIN:-}}

if [ -z "$DOMAIN" ]; then
    echo -e "${RED}Ошибка: Укажите домен${NC}"
    echo "Использование: sudo $0 <домен>"
    echo "Пример: sudo $0 kerchshina.com"
    echo ""
    echo "Или установите ALLOWED_DOMAIN в .env файле"
    exit 1
fi

# Проверка прав root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Ошибка: Этот скрипт нужно запускать с sudo${NC}"
    exit 1
fi

# Определяем абсолютный путь к скрипту обновления
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
UPDATE_SCRIPT="$SCRIPT_DIR/update-ssl-cert.sh"
LOG_FILE="/var/log/ssl-renew.log"

# Проверяем существование скрипта
if [ ! -f "$UPDATE_SCRIPT" ]; then
    echo -e "${RED}Ошибка: Файл $UPDATE_SCRIPT не найден${NC}"
    exit 1
fi

# Делаем скрипт исполняемым
chmod +x "$UPDATE_SCRIPT"

echo -e "${BLUE}Настройка автоматического обновления SSL сертификата${NC}"
echo -e "${BLUE}Домен: $DOMAIN${NC}"
echo -e "${BLUE}Скрипт: $UPDATE_SCRIPT${NC}"
echo ""

# Проверяем, есть ли уже запись в crontab
if crontab -l 2>/dev/null | grep -q "update-ssl-cert.sh"; then
    echo -e "${YELLOW}В crontab уже есть задача для обновления SSL${NC}"
    echo "Текущая запись:"
    crontab -l 2>/dev/null | grep "update-ssl-cert.sh"
    echo ""
    read -p "Заменить существующую запись? (y/n) " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo -e "${YELLOW}Отменено${NC}"
        exit 0
    fi
    
    # Удаляем старую запись
    crontab -l 2>/dev/null | grep -v "update-ssl-cert.sh" | crontab -
    echo -e "${GREEN}✓ Старая запись удалена${NC}"
fi

# Добавляем новую запись в crontab
# Обновление каждый день в 3:00 ночи
CRON_ENTRY="0 3 * * * cd $SCRIPT_DIR && $UPDATE_SCRIPT $DOMAIN >> $LOG_FILE 2>&1"

(crontab -l 2>/dev/null; echo "$CRON_ENTRY") | crontab -

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Автоматическое обновление настроено!${NC}"
    echo ""
    echo -e "${BLUE}Расписание: каждый день в 3:00${NC}"
    echo -e "${BLUE}Команда: $UPDATE_SCRIPT $DOMAIN${NC}"
    echo -e "${BLUE}Лог-файл: $LOG_FILE${NC}"
    echo ""
    echo "Текущие задачи cron:"
    crontab -l | grep -v "^#"
    echo ""
    echo -e "${YELLOW}Для просмотра логов обновления:${NC}"
    echo -e "${YELLOW}  sudo tail -f $LOG_FILE${NC}"
    echo ""
    echo -e "${YELLOW}Для ручного обновления:${NC}"
    echo -e "${YELLOW}  sudo $UPDATE_SCRIPT $DOMAIN${NC}"
else
    echo -e "${RED}✗ Ошибка при настройке cron${NC}"
    exit 1
fi
