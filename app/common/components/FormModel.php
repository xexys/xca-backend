<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace common\components;

use Yii;
use \CHtml;
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

    public function fixCssName($name)
    {
        return strtr($this->camelToSnake($name), '_', '-');
    }

    protected function _filterParamsKeys($keys, $invalidKeys)
    {
        return array_filter($keys, function ($val) use ($invalidKeys) {
            return !in_array($val, $invalidKeys, true);
        });
    }

    /**
     * Возвращает массив атрибутов модели с ключами, преобразованными в camelCase
     *
     * @param $model
     * @return array
     */
    public function getModelAttributesSnakeToCamel($model)
    {
        return DataHelper::arrayKeysSnakeToCamel($model->getAttributes());
    }

    /**
     * Возвращает массив атрибутов модели с ключами, преобразованными в snake_case
     *
     * @param $model
     * @return array
     */
    public function getModelAttributesCamelToSnake($model)
    {
        return DataHelper::arrayKeysCamelToSnake($model->getAttributes());
    }
}