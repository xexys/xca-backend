<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.06.15
 * Time: 19:23
 */

namespace backend\helpers;

use \Yii;


class Html extends \CHtml
{
    /**
     * @param $class
     * @param $params
     * @param bool $captureOutput
     * @return \TbWidget | string
     */
    private static function _boosterWidget($class, $params, $captureOutput = false)
    {
        // Алиас для Font-Awesome
        if (isset($params['fa-icon'])) {
            $params['icon'] = 'fa fa-' . $params['fa-icon'];
            unset($params['fa-icon']);
        }

        // Алиас для Glyphicons
        if (isset($params['gl-icon'])) {
            $params['icon'] = $params['gl-icon'];
            unset($params['gl-icon']);
        }

        return Yii::app()->controller->widget($class, $params, $captureOutput);
    }

    public static function TbButton($params)
    {
        return self::_boosterWidget('booster.widgets.TbButton', $params, true);
    }

    public static function TbLinkButton($params)
    {
        $params['buttonType'] = 'link';
        return self::TbButton($params);
    }

    public static function TbSubmitButton($params)
    {
        $params['buttonType'] = 'submit';
        return self::TbButton($params);
    }

    public static function icon($cssClass)
    {
        return self::tag('i', array('class' => $cssClass), '', true);
    }

    public static function faIcon($icon)
    {
        return self::icon('fa fa-' . $icon);
    }

    public static function glIcon($icon)
    {
        return self::icon('glyphicon glyphicon-' . $icon);
    }


}