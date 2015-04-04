<?php

// Конфигурационный файл для релиза
// Наследуемся от common/config/main.php

return array(

    'basePath' => __DIR__ . '/../..', // Псевдоним application


    //    'controllerMap' => array(
    //        'site' => 'SiteController'
    //    ),

    //    'defaultController'=>'site/index',

    'controllerNamespace' => '\backend\controllers',

    'import' => array(),

    'components' => array(

//            'user'=>array(
//                'allowAutoLogin'=>true, // Разрешаем авторизацию на основе cookie
//                //'autoRenewCookie'=>true,
//                'loginUrl'=>array('/user/login') // Страница с авторизацией
//            ),

//            'errorHandler'=>array(
//                'errorAction'=>'/site/error',
//            ),

//            'urlManager'=>array(
//                'rules'=>array(
//                    //'login'=>"user/login",
//                    //'logout'=>"user/logout",
//                    //'comment/create'=>'questionComment/create',
//                )
//            ),

        // Включаем логирование параметров (Нужно для работы yii-debug-toolbar)
        'db' => array(
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),

//        // Лог
//        'log' => array(
//            'class'  => 'CLogRouter',
//            'routes' => array(
//
//                array(
//                    'class'     => 'common.extensions.yii-debug-toolbar.YiiDebugToolbarRoute',
//                    'ipFilters' => array('127.0.0.1', '192.168.*'),
//                ),
//
//                // Направляем вывод ошибок в файл если не включен режим отладки
//                array(
//                    'class'       => 'CFileLogRoute',
//                    'levels'      => 'error, warning',
//                    'enabled'     => true,
//                    'maxFileSize' => 1024, // Значение в кб
//                    'maxLogFiles' => 10, // Будем хранить не более 10 лог файлов
//                ),
//
//
//            ),
//        ),

    ),
);
