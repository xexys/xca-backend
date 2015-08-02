<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;

use Yii;
use \app\helpers\Data as DataHelper;


abstract class FormFacade extends FormModel
{
    public function behaviors()
    {
        return \CMap::mergeArray(
            parent::behaviors(),
            array(
                'ajaxValidation' => '\app\models\behaviors\AjaxValidation',
            )
        );
    }

    public function save()
    {
        if ($this->validate()) {
            return $this->getScenario() == self::SCENARIO_CREATE ? $this->_create() : $this->_update();
        }else {
            return false;
        }
    }

    abstract protected function _create();

    abstract protected function _update();

    /**
     * Возвращает массив атрибутов модели с ключами, преобразованными в camelCase
     *
     * @param $model
     * @return array
     */
    protected function _getModelAttributesSnakeToCamel($model)
    {
        return DataHelper::arrayKeysSnakeToCamel($model->getAttributes());
    }

    /**
     * Возвращает массив атрибутов модели с ключами, преобразованными в snake_case
     *
     * @param $model
     * @return array
     */
    protected function _getModelAttributesCamelToSnake($model)
    {
        return DataHelper::arrayKeysCamelToSnake($model->getAttributes());
    }

//    protected function _filterParamsKeys($keys, $invalidKeys)
//    {
//        return array_filter($keys, function ($val) use ($invalidKeys) {
//            return !in_array($val, $invalidKeys, true);
//        });
//    }
}