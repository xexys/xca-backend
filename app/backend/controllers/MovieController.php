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
use \common\models\Movie;
use \common\components\DataProvider;


class MovieController extends Controller
{
    function actionIndex()
    {
        $dataProvider = new DataProvider\Movie(array(
            'criteria'=>array(
                'with'=>array('game')
            ),
            'pagination' => array(
                'pageSize' => 1,
            ),
        ));
        $this->render('index', array(
            'movieDataProvider' => $dataProvider,
        ));

    }

    public function actionView($id)
    {
        $movie = Movie::model()->findByPk($id);
        $this->render('view', array('movie' => $movie));
    }


    function actionCreate()
    {
        $this->render('/dummy');
    }

    function actionEdit()
    {
        $this->render('/dummy');
    }

    function actionDelete()
    {
        $this->render('/dummy');
    }
}


