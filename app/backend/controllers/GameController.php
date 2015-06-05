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


class GameController extends Controller
{
    function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('\common\models\Game', array(
            'pagination' => array(
                'pageSize' => 1,
            ),
        ));
        $this->render('index', array(
            'gameDataProvider' => $dataProvider,
        ));

    }

    function actionCreate()
    {
        $this->render('/dummy');
    }
}


