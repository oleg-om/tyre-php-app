<?php

$i = 0;

$i++;

// Используем имя контейнера MySQL из Docker сети
$cfg['Servers'][$i]['host'] = getenv('DB_HOST') ? getenv('DB_HOST') : 'tyre-app-mysql';

$cfg['Servers'][$i]['port'] = getenv('DB_PORT') ? getenv('DB_PORT') : '3306';

$cfg['Servers'][$i]['extension'] = 'mysqli';

$cfg['Servers'][$i]['connect_type'] = 'tcp';

$cfg['Servers'][$i]['compress'] = false;

$cfg['Servers'][$i]['auth_type'] = 'config';

// Используем переменные окружения из docker-compose.yml
// Если переменные не установлены, используем значения по умолчанию
$db_user = getenv('DB_USER');
$db_password = getenv('DB_PASSWORD');

// Если переменные окружения не установлены, пробуем использовать старые значения
if (empty($db_user)) {
    $db_user = 'kerchshina_user';
}
if (empty($db_password)) {
    $db_password = 'eX5g!5n5N8Uu';
}

$cfg['Servers'][$i]['user'] = $db_user;
$cfg['Servers'][$i]['password'] = $db_password;

?>