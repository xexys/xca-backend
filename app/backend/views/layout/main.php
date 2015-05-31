<?php

$user = Yii::app()->user;
$controllerId = strtolower($this->id);
$actionId = strtolower($this->action->id);

$cssPageId = implode('-', array('page', $controllerId, $actionId));

$scriptBasePath = Yii::getPathOfAlias('static.dev.backend.pages');

// Публикация ресурсов
Yii::app()->getAssetManager()->publish($scriptBasePath, false, -1, YII_DEBUG);

// Добавление стилей
$cssUrl = $this->getPageScriptUrl($scriptBasePath, 'style.css');
if ($cssUrl) {
    Yii::app()->clientScript->registerCssFile($cssUrl);
}

// Добавление скриптов
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
<body data-page-id="<?= $cssPageId; ?>">
<div id="layout">
    <div id="layout_hc-block">
        <div id="layout_header">

            <div class="navbar navbar-default navbar-fixed-top navbar-inverse">
                <div class="container">
                    <a class="navbar-brand" href="<?= Yii::app()->homeUrl; ?>">
                        <?= Yii::app()->name; ?>
                    </a>

                    <ul class="nav navbar-nav pull-right">
<!--                        <li class="active"><a href="#">Home</a></li>-->
<!--                        <li><a href="#">Link</a></li>-->

                        <?php if (!$user->isGuest): ?>
                            <li>
                                <a href="<?= $this->createUrl('user/logout'); ?>">Выход (<?= $user->name; ?>)</a>
                            </li>
                        <?php else: ?>
                            <li class="<?= $actionId == 'login' ? 'active' : ''; ?>">
                                <a href="<?= $this->createUrl('user/login'); ?>">Вход</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div id="layout_content">
            <?= $content; ?>
        </div>
    </div>
    <div id="layout_footer">
        <h5 class="alert alert-info"><?php printf("Время генерации %0.5f секунд. Памяти использовано: %0.2f MB", Yii::getLogger()->getExecutionTime(), memory_get_peak_usage()/(1024*1024));?>
    </div>
</div>
</body>
</html>
