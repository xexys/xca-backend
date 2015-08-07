<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;

use Yii;


abstract class FormFacade extends FormModel
{
    public function behaviors()
    {
        return \CMap::mergeArray(
            parent::behaviors(),
            array(
                'ajaxValidation' => '\app\models\behaviors\AjaxValidation',
                'DAO' => '\app\models\behaviors\DAO',
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

//    protected function _filterParamsKeys($keys, $invalidKeys)
//    {
//        return array_filter($keys, function ($val) use ($invalidKeys) {
//            return !in_array($val, $invalidKeys, true);
//        });
//    }
}