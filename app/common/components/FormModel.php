<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace common\components;

use \common\helpers\Data as DataHelper;


class FormModel extends \CFormModel
{
    public function camelToSnake($str)
    {
        return DataHelper::camelToSnake($str);
    }

    public function snakeToCamel($str)
    {
        return DataHelper::snakeToCamel($str);
    }

    public function nameToCssName($name)
    {
        return strtr($this->camelToSnake($name), '_', '-');
    }

    protected function _filterParamsKeys($keys, $invalidKeys)
    {
        return array_filter($keys, function ($val) use ($invalidKeys) {
            return !in_array($val, $invalidKeys, true);
        });
    }

    protected function _arrayKeysSnakeToCamel($data)
    {
        $attrs = array();
        foreach ($data as $key => $val) {
            $attrs[$this->snakeToCamel($key)] = $val;
        }
        return $attrs;
    }

}