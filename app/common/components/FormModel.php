<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace common\components;


class FormModel extends \CFormModel
{
    protected function _filterParamsKeys($keys, $invalidKeys)
    {
        return array_filter($keys, function ($val) use ($invalidKeys) {
            return !in_array($val, $invalidKeys, true);
        });
    }
}