<?php

cs()->registerPackages('yii, requirejs, bootstrap, jquery.watermark, tinymce, jquery.ui')
    ->registerCssFile(app()->baseUrl . '/css/marking.css')
    ->registerCssFile(app()->baseUrl . '/css/app.css')
    ->registerScriptFile(app()->baseUrl . '/js/app/config.js') // Пуск приложения
    ->registerGlobalVariables(array('appBaseUrl' => app()->getBaseUrl(true)));
//->registerScriptFile(app()->baseUrl.'/js/script.js');

if (YII_DEBUG) {
    cs()->registerPackage('print_r');
}

$controllerId = strtolower($this->id);
$actionId = strtolower($this->action->id);

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= h($this->pageTitle) ?></title>
</head>
<body>
<div id="wrapper" class="container-fluid">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="brand" href="<?= app()->homeUrl ?>">medyan.ru</a>
                <ul class="nav pull-right">
                    <li class="<?= in_array($controllerId, array('section1', 'question', 'answer')) ? 'active' : '' ?>">
                        <a href="<?= url('section1') ?>">Раздел 1</a>
                    </li>
                    <li class="<?= $controllerId == 'section2' || $controllerId == 'material' ? 'active' : '' ?>">
                        <a href="<?= url('section2') ?>">Раздел 2</a>
                    </li>
                    <li class="<?= $actionId == 'board' ? 'active' : '' ?>">
                        <a href="<?= url('site/board') ?>">Стена</a>
                    </li>
                    <li class="<?= $actionId == 'area' ? 'active' : '' ?>">
                        <a class="app-user-area-btn" href="<?= url('/user/area') ?>">Личный кабинет</a>
                    </li>
                    <?php if (!user()->isGuest): ?>
                        <li>
                            <a href="<?= url('user/logout') ?>">Выход (<?= user()->name ?>)</a>
                        </li>
                    <?php else: ?>
                        <li class="<?= $actionId == 'login' ? 'active' : '' ?>">
                            <a class="app-login-btn" href="<?= url('user/login') ?>">Вход</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div id="content">

        <?php

        // Панель для отладки приложения
        $this->renderPartial('/layouts/_tester_panel');

        ?>

        <?php if (user()->hasFlash('success')): ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= user()->getFlash('success') ?>
            </div>

        <?php endif; ?>

        <?php if (user()->isBanned): ?>
            <div class="alert alert-error">
                <?php //<button type="button" class="close" data-dismiss="alert">&times;</button> ?>
                <strong>Внимание!</strong> Ваш аккаунт заблокирован до <?= user()->model->banned_expire ?>
            </div>
        <?php endif;

        $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'homeLink' => CHtml::link('Главная', app()->homeUrl),
            'links' => $this->breadcrumbs,
        ));

        echo $content;
        ?>
    </div>
</div>
<div id="footer" class="container-fluid app-footer-links">
    <hr>
    <p>
        <a href="<?= $this->createUrl('site/about') ?>">О сайте</a>
        <a href="<?= $this->createUrl('site/help') ?>">Помощь</a>
        <a href="<?= $this->createUrl('site/rules') ?>">Правила</a>
        <a href="<?= $this->createUrl('site/feedback') ?>">Обратная связь</a>
    </p>

    <p class="copyright">medyan.ru&copy;<?= date('Y') ?></p>
    <h5 class="alert alert-info"><?php printf("Время генерации %0.5f секунд. Памяти использовано: %0.2f MB", Yii::getLogger()->getExecutionTime(), memory_get_peak_usage() / (1024 * 1024)); ?>
    </h5>
</div>

</body>
</html>
