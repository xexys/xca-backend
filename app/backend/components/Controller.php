<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 12:57
 * To change this template use File | Settings | File Templates.
 */

namespace backend\components;

use common\components\ActiveRecord;
use \Yii;
use \CHtml;

class Controller extends \common\components\Controller
{
    public $layout = '/layouts/main';
    public $breadcrumbs;
    public $pageTitleIconClass;

    private $_viewHelpers = array();
    private $_viewHelpersNamespace = '\backend\helpers\view';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                  'roles'=>array('admin'),
            ),
            array('deny',
                  'users'=>array('*'),
            ),
        );
    }

    public function getViewHelper($name)
    {
        if (strpos($name, '.') !== false) {
            $className = Yii::import($name, true);
        } else {
            $className = $this->_viewHelpersNamespace . '\\' . $name;
        }

        if (!isset($this->_viewHelpers[$className])) {
            $this->_viewHelpers[$className] = new $className($this);
        }

        return $this->_viewHelpers[$className];
    }

    public function getViewUIHelper($name)
    {
        return $this->getViewHelper('UI\\' . $name);
    }

    /**
     * Возвращает хелпер для модели
     * @param mixed $model - Модель, полное или короткое имя класса
     * @return mixed
     */
    public function getViewModelLinkHelper($model)
    {
        if ($model instanceof \CActiveRecord) {
            $name = (new \ReflectionClass($model))->getShortName();
        } elseif (is_string($model) && strpos($model, '\\') !== false) {
            $name = (new \ReflectionClass($model))->getShortName();
        } else {
            $name = $model;
        }


        return $this->getViewHelper('ModelLink\\' . $name);
    }
}