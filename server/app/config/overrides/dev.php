<?php

// Конфигурационный файл для разработки

// Dump :)
Yii::import('app.helpers.dump', true);

return array(

	'modules'=>array(
            'gii'=>array(
                'class'=>'system.gii.GiiModule',
                'password'=>'123',
                'ipFilters' => array('127.0.0.1', '192.168.*'),
            ),
        ),

    'components'=>array(

//            // Включаем логирование параметров
//            'db'=>array(
//                'enableProfiling'=>true,
//                'enableParamLogging'=>true,
//            ),

        'urlManager'=>array(
            'rules'=>array(
                '<route:.*>'=>"<route>", // Показывает GET параметры
            )
        ),

        // Компонент для кэширования данных на основе файлов, в режиме разработки используем заглушку
        'cache'=>array(
            'class'=>'system.caching.CDummyCache',
        ),

        // Лог
        'log' => array(
            'class'  => 'CLogRouter',
            'routes' => array(

                array(
                    'class'     => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => array('127.0.0.1', '192.168.*'),
                ),

                // Направляем вывод ошибок в файл если не включен режим отладки
                array(
                    'class'       => 'CFileLogRoute',
                    'levels'      => 'error, warning',
                    'enabled'     => true,
                    'maxFileSize' => 1024, // Значение в кб
                    'maxLogFiles' => 10, // Будем хранить не более 10 лог файлов
                ),

                array(
                    'class'       => 'CFileLogRoute',
                    'levels'      => 'profile',
                    'logFile'     => 'profile.log',
                    'enabled'     => true,
                    'maxFileSize' => 1024, // Значение в кб
                    'maxLogFiles' => 10, // Будем хранить не более 10 лог файлов
                ),

//                array(
//                    'class'=>'CProfileLogRoute',
//                    'levels'=>'profile',
//                    'enabled'=>true,
//                ),

            ),
        ),
    )
);


// Лог
//$config['components']['log'] = array(
//    'class'=>'CLogRouter',
//    //'enabled'=>false,
//    'routes'=>array(
//
//        array(
//            'class'=>'common.extensions.yii-debug-toolbar.YiiDebugToolbarRoute',
//            'ipFilters'=>array('*'),
//        ),
//
//        array(
//            'class'=>'CFileLogRoute',
//            'levels'=>'error, warning',
//            'enabled'=> true,
//            'maxFileSize'=>1024, // Значение в кб
//            'maxLogFiles'=>10, // Будем хранить не более 10 лог файлов
//        ),
//
//        /*
//        // Направляем результаты профайлинга в ProfileLogRoute (отображается внизу страницы)
//        array(
//            'class'=>'CProfileLogRoute',
//            'levels'=>'profile',
//            'showInFireBug' => true
//        ),
//
//        // Лог сообщений (отображается внизу страницы)
//        array(
//            'class' => 'CWebLogRoute',
//            //'categories' => 'profile',
//            'showInFireBug' => true
//        ),
//        */
//
//    ),
//);
