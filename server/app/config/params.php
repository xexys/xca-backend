<?php

// Формат отображения дат, используемый в приложении
define('APP_DATE_FORMAT', 'd.m.Y');
//define('APP_HUMAN_DATE_FORMAT', 'j F Y');
//define('APP_HUMAN_SHORT_DATE_FORMAT', 'j M Y');

/**
 * Формат для валидации дат через объекты FormModel и ActiveRecord
 * @link http://www.unicode.org/reports/tr35/tr35-dates.html#Date_Format_Patterns
 */
define('APP_VALIDATION_DATE_FORMAT', 'dd.MM.yyyy');
define('APP_VALIDATION_DATETIME_FORMAT', 'dd.MM.yyyy hh:mm:ss');
define('APP_VALIDATION_YEAR_FORMAT', 'yyyy');

// Формат для ввода даты через datepicker
define('APP_DATEPICKER_DATE_FORMAT', 'dd.mm.yyyy');
define('APP_DATEPICKER_YEAR_FORMAT', 'yyyy');

// Формат для записи даты в БД
define('APP_DB_TIMESTAMP_FORMAT', 'Y-m-d H:i:s');

return array(
    'autoLoginDuration' => 3600 * 24 * 30, // Автовход пользователя втечение 30 дней
);