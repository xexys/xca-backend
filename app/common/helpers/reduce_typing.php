<?php
/**
 * Функции для ускорения набора, для некоторых компонентов
 *
 */

/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 * @return CClientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}

/**
 * This is the shortcut to Yii::app()->user.
 * @return CWebUser
 */
function user()
{
    return Yii::app()->getUser();
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='&')
{
    return Yii::app()->createUrl($route,$params,$ampersand);
}

/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return CHtml::encode($text);
}

/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array())
{
    return CHtml::link($text, $url, $htmlOptions);
}

/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null)
{
    return Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null)
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name)
{
    return Yii::app()->params[$name];
}
/**
 * This is the shortcut to Yii::app()->userAgent
 */
function userAgent()
{
    return Yii::app()->userAgent;
}
/**
 * This is the shortcut to Yii::app()->request
 */
function request()
{
    return Yii::app()->getRequest();
}

/**
 * This is the shortcut to Yii::app()->authManager
 */
function authManager()
{
    return Yii::app()->getAuthManager();
}

/**
 * This is the shortcut to Yii::app()->cache
 */
function cache()
{
    return Yii::app()->getCache();
}

function createCommand($query=null)
{
    return Yii::app()->getDb()->createCommand($query);
}

/**
 * Функция для отладки, печатает переменную с подсветкой синтаксиса
 * @param mixed $var
 */
function dd($var)
{
    CVarDumper::dump($var, 10, true);
    die;
}