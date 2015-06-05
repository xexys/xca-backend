<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 12:57
 * To change this template use File | Settings | File Templates.
 */

namespace backend\components;

class Controller extends \common\components\Controller
{
    public $layout = '/layouts/main';
    public $breadcrumbs;

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

}