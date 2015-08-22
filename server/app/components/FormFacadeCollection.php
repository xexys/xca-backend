<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;

use \Yii;
use \app\components\interfaces\FormMethods;


class FormFacadeCollection extends ObjectCollection implements FormMethods
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

    public function validate()
    {
        $isValid = true;
        foreach ($this as $item) {
            $isValid = $item->validate() && $isValid;
        }
        return $isValid;
    }

    public function save()
    {
        if ($this->validate()) {
            $transaction = $this->getDb()->beginTransaction();
            try {
                foreach ($this as $item) {
                    if (!$item->save()) {
                        throw new CException($item->getFirstErrorMessage());
                    }
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

    public function setAttributesByPost($postData = array())
    {
        foreach ($this as $item) {
            $item->setAttributesByPost($postData);
        }
    }

    public function getAjaxValidationResponseContent()
    {
        $data = array();
        foreach($this as $item) {
            $data[] = json_decode($item->getAjaxValidationResponseContent(), true);
        }
        return json_encode(call_user_func_array('array_merge', $data));
    }

    protected function _checkItemInstanceof($item)
    {
        parent::_checkItemInstanceof($item);

        if (!$item instanceof FormFacade) {
            throw new \CException('Item must be instanceof FormFacade');
        }
    }


}
