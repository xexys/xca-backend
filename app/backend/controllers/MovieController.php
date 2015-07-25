<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 20:50
 */

namespace backend\controllers;

use \backend\components\CrudController;
use \backend\models\Form\Movie as MovieForm;
use \Yii;
use \CActiveForm;
use \common\models\Movie;
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
        $movie = $this->_getModelById($id, array('video', 'audio'));
        $this->render('view', array('movie' => $movie));
    }


    public function actionCreate()
    {
        $form = new MovieForm('create');

        $this->_tryAjaxValidation($form);

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
        $movie = $this->_getModelById($id, array('video', 'audio'));

        $form = new MovieForm('update');
        $form->setAttributesByMovie($movie);

        $this->_tryAjaxValidation($form);

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

    public function actionDelete($id)
    {
        $this->render('/dummy');
    }

    protected function _getAjaxValidationResponseContent($form)
    {
        $json1 = json_decode(CActiveForm::validate(array($form->mainParams, $form->videoParams)), true);
        $json2 = json_decode(CActiveForm::validateTabular($form->audioParams), true);
        return json_encode(array_merge($json1, $json2));
    }

    private function _getModelById($id, $with = array())
    {
        $game = Movie::model()->with($with)->findByPk($id);
        if (!$game) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $game;
    }


}


