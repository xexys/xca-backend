<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;

use \Yii;
use \CHtml;
use \CActiveForm;
use \CActiveRecord;
use \CFormModel;
use \CValidator;
use \app\components\interfaces\FormMethods;
use \app\components\interfaces\Collectible;
use \app\helpers\Data as DataHelper;


class FormModel extends CFormModel implements FormMethods, Collectible
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    private $_collection;

    public function getCollection()
    {
        return $this->_collection;
    }

    public function setCollection($collection)
    {
        $this->_collection = $collection;
    }

    /**
     * Для использования этого валидатора необходимо задать значение атрибута 'idAttributeName' для сценария 'update'
     *
     * Пример:
     *   array('textId', 'validateUniqueInDatabase', 'className' => '\app\models\AR\Game', 'attributeName' => 'text_id'),
     *   array('title', 'validateUniqueInDatabase', 'className' => '\app\models\AR\Game'),
     *   array('id', 'required', 'safe' => false, 'on' => self::SCENARIO_UPDATE),
     *
     * @param string $attribute
     * @param array $params
     */
    public function validateUniqueInDatabase($attribute, $params)
    {
        if ($this->getScenario() === self::SCENARIO_UPDATE) {
            $idAttributeName = isset($params['idAttributeName']) ? $params['idAttributeName'] : 'id';
            $findKey = isset($params['attributeName']) ? $params['attributeName'] : $attribute;
            $current = CActiveRecord::model($params['className'])->findByPk($this->$idAttributeName);
            if (strtolower($current->$findKey) === strtolower($this->$attribute)) {
                return;
            }
        }

        $validator = CValidator::createValidator('unique', $this, $attribute, $params);
        $validator->validate($this);
    }

    public function validateUniqueInCollection($key)
    {
        $collection = $this->getCollection();

        if ($collection) {
            $keys = array();
            foreach($collection as $model) {
                $keys[] = $model->$key;
            }

            $counts = array_count_values($keys);

            foreach($collection as $model) {
                if ($counts[$model->$key] > 1) {
                    $label = $this->getAttributeLabel($key);
                    $model->addError($key, $label . ' "' . CHtml::encode($model->$key) . '" уже есть в коллекции.');
                }
            }
        }
    }

    public function setAttributesByPost($postData = array())
    {
        $postKey = CHtml::modelName($this);
        $postData = $postData ?: $_POST;

        $data = array();
        if (!empty($postData[$postKey])) {
            $data = $postData[$postKey];
        }

        $this->setAttributes(DataHelper::trimRecursive($data));
    }

    public function getAjaxValidationResponseContent()
    {
        return CActiveForm::validate($this, null, false);
    }

    public function setAttributes($values, $safeOnly = true)
    {
        return parent::setAttributes(DataHelper::arrayKeysSnakeToCamel($values), $safeOnly);
    }

    public function getSafeAttributes($names = null)
    {
        $safeNames = $this->getSafeAttributeNames();
        if ($names) {
            $safeNames = array_intersect($names, $safeNames);
        }
        return $this->getAttributes($safeNames);
    }

//    public function getAttributesInSnakeCase($names = null)
//    {
//        return DataHelper::arrayKeysCamelToSnake($this->getAttributes($names));
//    }

//    public function setAttributesInSnakeCase($values, $safeOnly = true)
//    {
//        return $this->setAttributes($values, $safeOnly);
//    }

}