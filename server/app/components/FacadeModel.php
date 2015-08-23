<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.08.15
 * Time: 23:39
 */

namespace app\components;

use \CMap;
use \Exception;
use \CException;


abstract class FacadeModel extends BaseModel
{
    public function behaviors()
    {
        return CMap::mergeArray(
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
        $transaction = $this->getDb()->beginTransaction();
        try {
            $this->_delete();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    abstract protected function _create();

    abstract protected function _update();

    protected function _delete()
    {
        throw new CException('You have to implement method _delete for ' . get_class($this) . ' class.');
    }
}