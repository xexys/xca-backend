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
                'DAO' => '\app\components\behaviors\DAO',
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
            $transaction = $this->getDb()->beginTransaction();
            try {
                $this->getScenario() === self::SCENARIO_CREATE ? $this->_create() : $this->_update();
                $transaction->commit();
                return true;
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        } else {
            return false;
        }
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