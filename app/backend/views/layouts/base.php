<?php

$user = Yii::app()->user;
$clientScript = Yii::app()->getClientScript();

$controllerId = strtolower($this->id);
$actionId = strtolower($this->action->id);
$pageId = implode('-', array('page', $controllerId, $actionId));

$scriptBasePath = Yii::getPathOfAlias('static.build.' . (PROD_MODE ? 'prod' : 'dev') . '.backend.bundles');

$clientScript->registerPackage('font-awesome-latest');

// Публикация статики для страниц
Yii::app()->getAssetManager()->publish($scriptBasePath, false, -1, !PROD_MODE);

// Добавление стилей
$cssUrl = $this->getPageScriptUrl($scriptBasePath, 'style.css');
if ($cssUrl) {
    $clientScript->registerCssFile($cssUrl);
}

// Добавление скриптов
$jsUrl = $this->getPageScriptUrl($scriptBasePath, 'script.js');
if ($jsUrl) {
    $clientScript->registerScriptFile($jsUrl);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= Yii::app()->name; ?> - <?= $this->pageTitle ?></title>
</head>
<body>
    <div class="page page_sticky-footer" data-page-id="<?= $pageId; ?>">
        <div class="page_hc-block">
            <div class="page_header">

                <div class="navbar navbar-default navbar-fixed-top navbar-inverse">
                    <div class="container">
    <!--                    TODO: Сделать H1-->
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
            <div class="page_content">
                <?= $this->renderPartial('/layouts/_breadcrumbs'); ?>

                <div class="row">
                    <div class="col-md-2">
                        <?= $this->renderPartial('/layouts/_menu'); ?>
                    </div>
                    <div class="col-md-10">
                        <?= $content; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="page_footer">
            <h5 class="alert alert-info"><?php printf("Время генерации %0.5f секунд. Памяти использовано: %0.2f MB", Yii::getLogger()->getExecutionTime(), memory_get_peak_usage()/(1024*1024));?>
        </div>
    </div>
</body>
</html>
