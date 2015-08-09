<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 20:50
 */

namespace app\controllers;

use \app\components\CrudController;
use \app\helpers;
use \app\models\Form\Game as GameForm;
use \Yii;
use \app\models\Game;
use \app\components\DataProvider;


class GameController extends CrudController
{
    public function actionIndex()
    {
        $gameDataProvider = new DataProvider\Game(array(
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $this->render('index', array(
            'gameDataProvider' => $gameDataProvider,
        ));
    }

    public function actionView($id)
    {
        $game = $this->_getModelById($id);
        $gameMovieDataProvider = new DataProvider\Movie(array(
            'criteria' => array(
                'condition' => 'game_id = ' . $game->id
            ),
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));
        $this->render('view', array(
            'game' => $game,
            'gameMovieDataProvider' => $gameMovieDataProvider,
        ));
    }

    public function actionCreate()
    {
        $form = new GameForm;

        $this->_tryAjaxValidation($form);

        if ($this->_getRequest()->getIsPostRequest()) {
            $form->setAttributesByPost();

            if ($form->save()) {
                $this->redirect('index');
            }
        }


        $this->render('create', array(
            'model' => $form,
            'backUrl' => $this->_getBackUrl()
        ));
    }

    public function actionEdit($id)
    {
        $form = new GameForm($id);
        $gameTitle = $form->mainParams->title;

        $this->_tryAjaxValidation($form);

        $backUrl = $this->_getBackUrl();

        if ($this->_getRequest()->getIsPostRequest()) {
            $form->setAttributesByPost();

            if ($form->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('edit', array(
            'model' => $form,
            'gameTitle' => $gameTitle,
            'backUrl' => $backUrl
        ));
    }

    public function actionDelete($id)
    {
        // TODO: Сделать удаление через FormFacade чтбы удалить зависимые таблицы
        $game = $this->_getModelById($id);
        $game->delete();
        $url = $this->createUrl('index');
        $this->redirect($url);
    }

    private function _getModelById($id)
    {
        $game = Game::model()->findByPk($id);
        if (!$game) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $game;
    }
}


