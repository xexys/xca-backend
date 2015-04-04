<?php

require __DIR__ . '/../app/bootstrap.php';

# Определяем некоторые псевдонимы
Yii::setPathOfAlias('backend', APP_DIR .'/backend');
//Yii::setPathOfAlias('www', ROOT_DIR . '/backend/www');

# We use our custom-made WebApplication component as base class for backend app.
//require_once ROOT_DIR.'/backend/components/BackendWebApplication.php';
Yii::import('backend.components.BackendWebApplication');


// Запуск приложения
Yii::createApplication('BackendWebApplication', APP_DIR.'/backend/config/main.php')->run();
