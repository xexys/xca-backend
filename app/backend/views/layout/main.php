<?php

$controllerId = strtolower($this->id);
$actionId = strtolower($this->action->id);

$cssBasePath = Yii::getPathOfAlias('static.dev.frontend.pages');
$assetBaseUrl = Yii::app()->getAssetManager()->publish($cssBasePath, false, -1, YII_DEBUG);
Yii::app()->clientScript->registerCssFile($assetBaseUrl . '/' . $controllerId . '/' . $actionId . '.css');

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
