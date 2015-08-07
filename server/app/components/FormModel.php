<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;

use Yii;
use \app\helpers\Data as DataHelper;


class FormModel extends \CFormModel
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function fixCssName($name)
    {
        return strtr(DataHelper::camelToSnake($name), '_', '-');
    }

    /**
     * Для использования этого валидатора необходимо задать значение атрибута 'id' для сценария 'update'
     *
     * Пример:
     *   array('textId', 'validateUnique', 'className' => '\app\models\Game', 'attributeName' => 'text_id'),
     *   array('title', 'validateUnique', 'className' => '\app\models\Game'),
     *   array('id', 'required', 'safe' => false, 'on' => self::SCENARIO_UPDATE),
     *
     * @param string $attribute
     * @param array $params
     */
    public function validateUnique($attribute, $params)
    {
        if ($this->getScenario() === self::SCENARIO_UPDATE) {
            $findKey = isset($params['attributeName']) ? $params['attributeName'] : $attribute;
            $current = \CActiveRecord::model($params['className'])->findByPk($this->id);
            if (strtolower($current->$findKey) === strtolower($this->$attribute)) {
                return;
            }
        }

        $validator = \CValidator::createValidator('unique', $this, $attribute, $params);
        $validator->validate($this);
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