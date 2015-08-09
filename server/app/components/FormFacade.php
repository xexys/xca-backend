<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;


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

    public function validateModels($key)
    {
        $models = $this->$key;

        if (!is_array($models) && !$models instanceof ObjectCollection) {
            $models = array($models);
        }

        foreach ($models as $model) {
            if (!$model->validate()) {
                $this->addError($key, 'В моделях были найдены ошибки.');
            }
        }
    }

    public function save()
    {
        if ($this->validate()) {
            return $this->getScenario() == self::SCENARIO_CREATE ? $this->_create() : $this->_update();
        }else {
            return false;
        }
    }

    public function delete()
    {
        throw new \Exception('delete');
    }

    abstract protected function _create();

    abstract protected function _update();

    protected function _filterParamsKeys($keys, $invalidKeys)
    {
        return array_filter($keys, function ($val) use ($invalidKeys) {
            return !in_array($val, $invalidKeys, true);
        });
    }
}