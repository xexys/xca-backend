<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 20:50
 */

namespace backend\controllers;

use \backend\components\CrudController;
use \backend\helpers;
use \Yii;
use \common\models\Game;
use \common\components\DataProvider;


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
                'pageSize' => 1,
            ),
        ));
        $this->render('view', array(
            'game' => $game,
            'gameMovieDataProvider' => $gameMovieDataProvider,
        ));
    }

    public function actionCreate()
    {
        $game = new Game();

        $this->_tryAjaxValidation($game);

        if ($this->_getRequest()->getIsPostRequest()) {
            $this->_setAttributesByPost($game);

            if ($game->save()) {
                $this->redirect('index');
            }
        }

        $this->render('create', array(
            'game' => $game,
            'backUrl' => $this->_getBackUrl()
        ));
    }

    public function actionEdit($id)
    {
        $game = $this->_getModelById($id);
        $gameTitle = $game->getAttribute('title');

        $this->_tryAjaxValidation($game);

        $backUrl = $this->_getBackUrl();

        if ($this->_getRequest()->getIsPostRequest()) {
            $this->_setAttributesByPost($game);

            if ($game->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('edit', array(
            'game' => $game,
            'gameTitle' => $gameTitle,
            'backUrl' => $backUrl
        ));
    }

    public function actionDelete($id)
    {
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


