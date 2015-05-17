<?php

# Корневой каталог со всеми файлами проекта
define('ROOT_DIR', __DIR__ . '/..');

# Корневой каталог с серверной частью проекта
define('APP_DIR', __DIR__);

# Определяем режим работы - разработка/продакшн
define('PROD_MODE', require(__DIR__ . '/check_prod_mode.php'));
if (!PROD_MODE) {
    require(__DIR__ . '/dev_mode.php');
}


// Читаем переменные сессии (обязательно закрываем сессию)
//session_start();
//session_write_close();

//require_once ROOT_DIR . '/vendor/autoload.php';
$yiiDir = APP_DIR . '/vendor/yiisoft/yii/framework';

// Подключаем базовый класс фреймворка
if (YII_DEBUG) {
    require_once $yiiDir . '/yii.php';
} else {
    require_once $yiiDir . '/yiilite.php';
}

// Определяем псевдонимы
Yii::setPathOfAlias('static', ROOT_DIR . '/static');
Yii::setPathOfAlias('common', APP_DIR . '/common');
Yii::setPathOfAlias('vendor', APP_DIR . '/vendor');

// Выставляем кодировку для многобойтовых строк
mb_internal_encoding("UTF-8");
//ini_set('mbstring.internal_encoding', 'utf-8');

// Устанавливаем заголовок ответа в utf-8
header("Content-Type: text/html; charset=utf-8");
