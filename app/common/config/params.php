<?php

//// Форматы для отображения даты в представлениях (view)
//defined('APP_DATETIME_FORMAT') or define('APP_DATETIME_FORMAT', 'd.m.Y H:i:s');
//defined('APP_DATE_FORMAT') or define('APP_DATE_FORMAT', 'd.m.Y');
//defined('APP_TIME_FORMAT') or define('APP_TIME_FORMAT', 'H:i:s');
//// Формат для записи временных данных в БД
//defined('APP_TIMESTAMP_FORMAT') or define('APP_TIMESTAMP_FORMAT', 'Y-m-d H:i:s');

return array(
    // TODO: Разнести между фронтендом и бекендом
    'autoLoginDuration'=>3600*24*30, // Автовход пользователя втечение 30 дней

//    // Форматы используемые при валидации дат
//    'dateValidationFormats'=>array(
//        'dd.MM.yyyy hh:mm:ss',
//        'dd.MM.yyyy'
//    )
);