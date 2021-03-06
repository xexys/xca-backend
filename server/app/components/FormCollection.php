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


class FormCollection extends ObjectCollection implements FormMethods
{
    public function __construct($data = null, $readOnly = false)
    {
        parent::__construct($data, $readOnly);

        $this->attachBehaviors($this->behaviors());
    }

    public function behaviors()
    {
        return array();
    }

    public function validate($attributes = null, $clearErrors = true)
    {
        $isValid = true;

        foreach ($this as $item) {
            $isValid = $item->validate($attributes, $clearErrors) && $isValid;
        }

        return $isValid;
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
        if (!$item instanceof FormModel) {
            throw new \CException('Item must be instanceof FormModel');
        }
    }
}
