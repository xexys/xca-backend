<?php

# Корневой каталог со всеми файлами проекта
define('ROOT_DIR', realpath(__DIR__ . '/../'));


# Определяем режим работы - разработка/продакшн
define('PROD_MODE', require(__DIR__ . '/check_prod_mode.php'));
if (!PROD_MODE) require(__DIR__ . '/dev_mode.php');


// Читаем переменные сессии (обязательно закрываем сессию)
//session_start();
//session_write_close();

$yiiDir = realpath('/var/phplib/yii-1.1.14/framework');


// Подключаем базовый класс фреймворка
if (YII_DEBUG) {
    require_once $yiiDir.'/yii.php';
} else {
    require_once $yiiDir.'/yiilite.php';
}

// Определяем псевдонимы
//Yii::setPathOfAlias('root', ROOT_DIR);
Yii::setPathOfAlias('common', realpath(ROOT_DIR . '/common'));


// Базовый класс для web-приложений
Yii::import('common.components.WebApplication');


// Выставляем кодировку для многобойтовых строк
mb_internal_encoding("UTF-8");
//ini_set('mbstring.internal_encoding', 'utf-8');

// Устанавливаем заголовок ответа в utf-8
header("Content-Type: text/html; charset=utf-8");
