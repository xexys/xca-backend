<?php

require __DIR__ . '/../server/bootstrap.php';

// Запуск приложения
$config = Yii::getPathOfAlias('app.config.main') . '.php';
Yii::createApplication('\app\components\WebApplication', $config)->run();
