<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.08.15
 * Time: 1:07
 */

namespace app\components\validators;

use \CValidator;


class ParamsValidator extends CValidator
{
    public $allowEmpty = false;

    public function validateAttribute($object, $attribute)
    {
        $params = $object->$attribute;

        if ($this->allowEmpty && $this->_isEmpty($params)) {
            return;
        }

        if ($this->_isEmpty($params)) {
            $this->addError($object, $attribute, 'При валидации параметров обнаружены ошибки, параметр пустой.');
            return;
        }

        if (!is_array($params) && !$params instanceof FormCollection) {
            $params = array($params);
        }

        foreach ($params as $item) {
            if (!$item->validate()) {
                $this->addError($object, $attribute, 'При валидации параметров обнаружены ошибки.');
            }
        }
    }

    private function _isEmpty($value)
    {
        return empty($value);
    }
}