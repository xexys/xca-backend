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
use \app\components\interfaces\FormFacadeMethods;


abstract class FormFacadeModel extends FormModel implements FormFacadeMethods
{
    public function __construct($scenario, array $params)
    {
        parent::__construct($scenario);

        $this->_initByParams($params);
    }

    public function behaviors()
    {
        return CMap::mergeArray(
            parent::behaviors(),
            array(
                'DAO' => '\app\components\behaviors\DAO',
            )
        );
    }

    public function save($runValidation = true)
    {
        if (!$runValidation || $this->validate()) {
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

    abstract protected function _initByParams($params);

//    public function delete()
//    {
//        $transaction = $this->getDb()->beginTransaction();
//        try {
//            $this->_delete();
//            $transaction->commit();
//        } catch (Exception $e) {
//            $transaction->rollback();
//            throw $e;
//        }
//    }

    abstract protected function _create();

    abstract protected function _update();

//    abstract protected function _delete();
}
