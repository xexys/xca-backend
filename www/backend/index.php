<?php

require __DIR__ . '/../../app/bootstrap.php';

# Определяем некоторые псевдонимы
Yii::setPathOfAlias('backend', APP_DIR . '/backend');


// Запуск приложения
$config = Yii::getPathOfAlias('backend.config.main') . '.php';
Yii::createApplication('\backend\components\WebApplication', $config)->run();
