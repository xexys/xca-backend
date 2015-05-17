<?php

$controllerId = strtolower($this->id);
$actionId = strtolower($this->action->id);

$scriptBasePath = Yii::getPathOfAlias('static.dev.backend.pages');

// Публикация стилей
$cssUrl = $this->publishPageScript($scriptBasePath, 'style.css');
if ($cssUrl) {
    Yii::app()->clientScript->registerCssFile($cssUrl);
}

// Публикация скриптов
$jsUrl = $this->publishPageScript($scriptBasePath, 'script.js');
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
