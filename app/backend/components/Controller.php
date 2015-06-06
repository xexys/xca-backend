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

class Controller extends \common\components\Controller
{
    public $layout = '/layouts/main';
    public $breadcrumbs;

    private $_viewHelpers = array();

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
        } elseif (strpos($name, '\\') !== false) {
            $className = $name;
        } else {
            $className = '\backend\helpers\view\\' . $name;
        }

        if (!isset($this->_viewHelpers[$className])) {
            $this->_viewHelpers[$className] = new $className($this);
        }

        return $this->_viewHelpers[$className];
    }

}