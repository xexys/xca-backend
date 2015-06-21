<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 20:50
 */

namespace backend\controllers;

use \backend\components\CrudController;
use \Yii;
use \common\models\Movie;
use \common\models\Form\Movie as MovieForm;
use \common\components\DataProvider;


class MovieController extends CrudController
{
    function actionIndex()
    {
        $dataProvider = new DataProvider\Movie(array(
            'criteria' => array(
                'with' => array('game')
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


    public function actionCreate()
    {
        $form = new MovieForm();

        $form->tryAjaxValidation();

        $backUrl = $this->_getBackUrl();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->setAttributesByPost();

            if ($form->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('create', array(
            'model' => $form,
            'backUrl' => $backUrl,
        ));
    }

    public function actionEdit($id)
    {
        $this->render('/dummy');
    }

    public function actionDelete($id)
    {
        $this->render('/dummy');
    }
}


