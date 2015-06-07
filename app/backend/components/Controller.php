<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 12:57
 * To change this template use File | Settings | File Templates.
 */

namespace backend\components;

use \Yii;
use \CHtml;

class Controller extends \common\components\Controller
{
    public $layout = '/layouts/main';
    public $breadcrumbs;

    private $_viewHelpers = array();
    private $_viewHelpersNamespace = '\backend\helpers\view';

    public function init()
    {
        // Инициализация конвртера префикса используемого в формах для редактирования модели
        if (method_exists($this, '_friendGetFormElementsNamePrefix')) {
            CHtml::setModelNameConverter(array($this, '_friendGetFormElementsNamePrefix'));
        }
        parent::init();
    }

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

}