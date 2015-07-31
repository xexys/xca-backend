<?php
// Выставляем кодировку для многобайтовых строк
//ini_set('mbstring.internal_encoding', 'utf-8');


// Ускоренный набор
//Yii::import('common.helpers.reduce_typing', true);

Yii::setPathOfAlias('booster', Yii::getPathOfAlias('vendor.clevertech.yii-booster.src'));

// Общие настройки
$config = array(

    'basePath' => realpath(APP_DIR), // Псевдоним application

    'name'=>'Xexys Cinematic Archive',

    // Языковые настройки
    'sourceLanguage'=>"en_US",
    'language'=>"ru",
    'charset'=>"utf-8",


    // Путь к папке временных файлов
    'runtimePath'=>ROOT_DIR . '/runtime',

    //    'controllerMap' => array(
    //        'site' => 'SiteController'
    //    ),

    //    'defaultController'=>'site/index',

    'controllerNamespace' => '\app\controllers',

    // Предзагрузка компонентов
    'preload' => array('log', 'booster'),

    // Автозагрузка классов
    'import'=>array(
//        'vendor.twig.twig.lib.Twig.*'
//        'common.components.base.*',
//        'common.components.db.*',
//        'common.components.web.*',
//        'common.components.auth.*',
//        'common.components.widgets.*',
//        'common.components.widgets.grid.*',
//        'common.helpers.*',
    ),

    // Компоненты приложения
    'components'=>array(

        /**
         * @link http://yiibooster.clevertech.biz
         */
        'booster' => array(
            'class' => 'booster.components.Booster',
        ),

        // Пользователь системы
        'user'=>array(
            'class'=>'\app\components\auth\WebUser',
            'guestName'=>'guest',
            'allowAutoLogin'=>true, // Разрешаем авторизацию на основе cookie
            //            'autoRenewCookie'=>true,
            'loginUrl' => array('/user/login') // Страница с авторизацией
        ),

        // Менеджер авторизации
        'authManager'=>array(
            'class'=>'\app\components\auth\PhpAuthManager',
            'defaultRoles'=>array('guest'), // По умолчанию все гости
            'authFile' => Yii::getPathOfAlias('app.config.rbac') . '.php'
        ),


        // Используем другой рендер
        /*
        'viewRenderer'=>array(
            'class'=>'CPradoViewRenderer',
            'fileExtension'=>'.tpl'
        ),
        */

        // Пользователь системы
        //        'user'=>array(
        //            'class'=>'WebUser',
        //        ),

        // Менеджер авторизации
        //        'authManager'=>array(
        //            'class'=>'PhpAuthManager',
        //            'defaultRoles'=>array('guest') // По умолчанию все гости
        //        ),

        // Компонент для работы с агентом пользователя (браузером)
        //        'userAgent'=>array(
        //            'class'=>"ext.useragent.CBrowserComponent"
        //        ),

        // Расширение для работы с файловой системой
        'file'=>array(
            'class'=>"ext.CFile"
        ),

        'session'=>array(
            'class'=>'CDbHttpSession',
            'connectionID'=>'db',
            'sessionTableName'=>'{{yii_session}}',
        ),

        // Компонент для кэширования данных на основе файлов
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),

        'clientScript'=>array(
//            'behaviors'=>array('ClientScriptBehavior'), // Дополнительные методы
'packages'=> require __DIR__ . '/packages.php'
        ),

        'db'=>array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=xca',
            'emulatePrepare' => true,
            'username' => 'alex',
            'password' => '123',
            'charset' => 'utf8',
            'tablePrefix' => '',
            //            'initSQLs'=>array(
            //                'SET search_path TO public', // Схема по умолчанию
            //                "SET timezone='$postgreTimezone'",  // fix +04 для Postgre 8.4
            //            ),
            // Включить кэширование схем для улучшения производительности
            'schemaCachingDuration'=> 3600*24*365,
            // Включаем логирование параметров (Нужно для работы yii-debug-toolbar)
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),

        /*
        // MySQL
        'db'=>array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=bruma-portal',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
            // Включить кэширование схем для улучшения производительности
            'schemaCachingDuration'=>3600*24,
        ),
        */

        'urlManager'=>array(
            'showScriptName'=>false,
            'urlFormat'=>'path',
        ),

    ),

    'params'=> require __DIR__ . '/params.php',
);


return CMap::mergeArray(
    $config,
    require __DIR__ . '/overrides/' . (PROD_MODE ? 'prod' : 'dev') . '.php'
);
