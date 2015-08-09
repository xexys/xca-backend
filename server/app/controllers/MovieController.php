<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 20:50
 */

namespace app\controllers;

use \app\components\CrudController;
use \app\models\Form\Movie as MovieForm;
use \Yii;
use \app\models\Movie;
use \app\models\Game;
use \app\components\DataProvider;


class MovieController extends CrudController
{
    function actionIndex()
    {
        $dataProvider = new DataProvider\Movie(array(
            'criteria' => array(
                'with' => array('game')
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $this->render('index', array(
            'movieDataProvider' => $dataProvider,
        ));

    }

    public function actionView($id)
    {
        $movie = $this->_getModelById($id, array('file', 'video', 'audio'));
        $this->render('view', array('movie' => $movie));
    }


    public function actionCreate($gameId = null)
    {
        $form = new MovieForm;

        $this->_tryAjaxValidation($form);

        $backUrl = $this->_getBackUrl();

        $game = Game::model()->findByPk($gameId);
        if ($game) {
            $form->mainParams->gameTitle = $game->title;
        }

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
        $form = new MovieForm($id);
        $movie = $this->_getModelById($id, array('game'));

        $this->_tryAjaxValidation($form);

        $backUrl = $this->_getBackUrl();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->setAttributesByPost();

            if ($form->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('edit', array(
            'model' => $form,
            'movie' => $movie,
            'backUrl' => $backUrl,
        ));
    }

    public function actionDelete($id)
    {
        $movie = $this->_getModelById($id);
        $movie->delete();
        $url = $this->createUrl('index');
        $this->redirect($url);
    }

    private function _getModelById($id, $with = array())
    {
        $model = Movie::model()->with($with)->findByPk($id);
        if (!$model) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $model;
    }


}


