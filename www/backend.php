<?php

require __DIR__ . '/../app/bootstrap.php';

# Определяем некоторые псевдонимы
Yii::setPathOfAlias('backend', APP_DIR .'/backend');
//Yii::setPathOfAlias('www', ROOT_DIR . '/backend/www');


//Yii::setPathOfAlias('backend.Components', APP_DIR .'/backend/components');

# We use our custom-made WebApplication component as base class for backend app.
//require_once APP_DIR.'/backend/components/WebApplication.php';
//Yii::import('backend.components.WebApplication');


// Запуск приложения
Yii::createApplication('backend\components\WebApplication', APP_DIR.'/backend/config/main.php')->run();
