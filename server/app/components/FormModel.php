<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;

use Yii;
use \app\models\interfaces\Collectible;
use \app\helpers\Data as DataHelper;


class FormModel extends \CFormModel implements Collectible
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    private $_collection;

    public function fixCssName($name)
    {
        return strtr(DataHelper::camelToSnake($name), '_', '-');
    }

    public function getCollection()
    {
        return $this->_collection;
    }

    public function setCollection($collection)
    {
        $this->_collection = $collection;
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

    public function validateUniquenessInCollection($key)
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
                    // TODO: Придумать сообщение
                    $model->addError($key, 'У Вас уже есть такая платформа.');
                }
            }
        }
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