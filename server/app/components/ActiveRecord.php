<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 1:58
 * To change this template use File | Settings | File Templates.
 */

namespace app\components;

use \Yii;
use \CException;
use \app\helpers\Data as DataHelper;


class ActiveRecord extends \CActiveRecord
{
    /**
     * PHP 5.3 or above only
     * @param null $className
     * @return \CActiveRecord
     */
    public static function model($className = null)
    {
        return parent::model($className ?: get_called_class());
    }

    public function getAttributeLabel($attribute)
    {
        // TODO: Реализовать нормально в каждой модели
        return $attribute;
    }

    public function behaviors()
    {
        return \CMap::mergeArray(
            parent::behaviors(),
            array(
                'DAO' => '\app\components\behaviors\DAO',
                'validationError' => '\app\components\behaviors\ValidationError',
            )
        );
    }

    public function setAttributes($values, $safeOnly = true)
    {
        return parent::setAttributes(DataHelper::arrayKeysCamelToSnake($values), $safeOnly);
    }

    public function setAttribute($name, $value)
    {
        parent::setAttribute(DataHelper::camelToSnake($name), $value);
    }

    private function _prepareDateAttributes($formatFrom, $formatTo)
    {
        $columns = $this->getMetaData()->columns;

        foreach ($columns as $attribute => $column) {
            if ($column->dbType === 'timestamp') {

                if ($this->$attribute) {
                    $date = date_create_from_format($formatFrom, $this->$attribute);
                    if (empty($date)) {
                        throw new CException('Can\'t create date from format: '. $formatFrom . ' value: ' . $this->$attribute);
                    }
                    $this->$attribute = $date->format($formatTo);
                } else {
                    $this->$attribute = null;
                }
            }
        }
    }

    protected function beforeSave()
    {
        $this->_prepareDateAttributes(APP_DATE_FORMAT, APP_DB_TIMESTAMP_FORMAT);
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        $this->_prepareDateAttributes(APP_DB_TIMESTAMP_FORMAT, APP_DATE_FORMAT);
        parent::afterSave();
    }

    protected function afterFind()
    {
        $this->_prepareDateAttributes(APP_DB_TIMESTAMP_FORMAT, APP_DATE_FORMAT);

        foreach($this->_getCastAttributeTypes() as $key => $type) {
            $value = $this->getAttribute($key);
            settype($value, $type);
            $this->setAttribute($key, $value);
        }

        parent::afterFind();
    }

    protected function _getCastAttributeTypes()
    {
        return array();
    }

//    /**
//     * Возвращает модель найденную по одному из атрибутов в списке
//     * Последовательно пытается найти записи по каждому атрибуту
//     * @param array $attrs
//     * @return mixed
//     */
//    public function findByOneOfAttributes(array $attrs)
//    {
//        $model = null;
//        foreach($attrs as $key => $val) {
//            $model = $this->findByAttributes(array($key => $val));
//            if ($model) {
//                return $model;
//            }
//        }
//        return $model;
//    }
}