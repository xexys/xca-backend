<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 20:50
 */

namespace backend\controllers;

use \backend\components\Controller;
use \Yii;
use \CActiveDataProvider;


class MovieController extends Controller
{
    function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('\common\models\Movie', array(
            'pagination' => array(
                'pageSize' => 1,
            ),
        ));
        $this->render('index', array(
            'movieDataProvider' => $dataProvider,
        ));

    }

    function actionCreate()
    {
        $this->render('/dummy');
    }
}


