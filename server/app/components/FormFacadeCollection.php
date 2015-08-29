<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;

use \Yii;
use \Cmap;
use \app\components\interfaces\FormFacadeMethods;


class FormFacadeCollection extends FormCollection implements FormFacadeMethods
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

    public function save($runValidation = true)
    {
        if (!$runValidation || $this->validate()) {
            $transaction = $this->getDb()->beginTransaction();
            try {
                foreach ($this as $item) {
                    $item->save(false);
                }
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
            foreach ($this as $item) {
                $item->delete();
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    protected function _checkItemInstanceof($item)
    {
        if (!$item instanceof FormFacadeModel) {
            throw new \CException('Item must be instanceof FormFacadeModel');
        }
    }
}
