<?php

$controllerId = strtolower($this->id);
$actionId = strtolower($this->action->id);

$cssBasePath = Yii::getPathOfAlias('static.dev.backend.pages');
$assetBaseUrl = Yii::app()->getAssetManager()->publish($cssBasePath, false, -1, YII_DEBUG);

$cssFileName = 'style.css';
$cssFile = $assetBaseUrl . '/' . $controllerId . '/' . $actionId . '/' . $cssFileName;
if (!is_file($cssFile)) {
    $cssFile = $assetBaseUrl . '/' . $controllerId . '/' . $cssFileName;
    if (!is_file($cssFile)) {
        $cssFile = $assetBaseUrl . '/' . $cssFileName;
    }
}
Yii::app()->clientScript->registerCssFile($cssFile);

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
