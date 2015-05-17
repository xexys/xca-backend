<?php

$controllerId = strtolower($this->id);
$actionId = strtolower($this->action->id);

$scriptBasePath = Yii::getPathOfAlias('static.dev.backend.pages');
Yii::app()->getAssetManager()->publish($scriptBasePath, false, -1, YII_DEBUG);

// Публикация стилей
$cssUrl = $this->getPageScriptUrl($scriptBasePath, 'style.css');
if ($cssUrl) {
    Yii::app()->clientScript->registerCssFile($cssUrl);
}

// Публикация скриптов
$jsUrl = $this->getPageScriptUrl($scriptBasePath, 'script.js');
if ($jsUrl) {
    Yii::app()->clientScript->registerScriptFile($jsUrl);
}


?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $this->pageTitle ?></title>
</head>
<body>

<?= $content; ?>

</body>
</html>
