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
use \common\helpers\Data as DataHelper;

class Controller extends \CController
{
    public function filters()
    {
        return array(
            'accessControl',
            'trimPostData',
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

    public function filterTrimPostData($filterChain)
    {
        // Необходимо сделать trim для POST данных, иначе валидация форм через ajax не пройдет, т.к. CActiveForm::validate работает напрямую с массивом $_POST
        DataHelper::trimRecursive($_POST);

        $filterChain->run();
    }

    protected function _getRequest()
    {
        return Yii::app()->getRequest();
    }
}