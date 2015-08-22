<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.08.15
 * Time: 23:39
 */

namespace app\components;


abstract class FacadeModel extends BaseModel
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

    public function delete()
    {
        throw new \CException('You have to implement method delete for ' . get_class($this) . ' class.');
    }

    abstract protected function _create();

    abstract protected function _update();
}