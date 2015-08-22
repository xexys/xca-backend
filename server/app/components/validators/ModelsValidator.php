<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.08.15
 * Time: 1:07
 */

namespace app\components\validators;

use \CValidator;
use \app\components\ObjectCollection;


class ModelsValidator extends CValidator
{
    public $allowEmpty = false;

    public function validateAttribute($object, $attribute)
    {
        $models = $object->$attribute;

        if ($this->allowEmpty && $this->_isEmpty($models)) {
            return;
        }

        if ($this->_isEmpty($models)) {
            $this->addError($object, $attribute, 'При валидации модели обнаружены ошибки, атрибут пустой.');
            return;
        }

        if (!is_array($models) && !$models instanceof ObjectCollection) {
            $models = array($models);
        }

        foreach ($models as $model) {
            if (!$model->validate()) {
                $this->addError($object, $attribute, 'При валидации модели обнаружены ошибки.');
            }
        }
    }

    private function _isEmpty($value)
    {
        return empty($value);
    }
}