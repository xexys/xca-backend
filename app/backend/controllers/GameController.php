<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 20:50
 */

namespace backend\controllers;

use \backend\components\Controller;
use \backend\helpers;
use \Yii;
use \common\models\Game;
use \common\components\DataProvider;


class GameController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new DataProvider\Game(array(
            'pagination' => array(
                'pageSize' => 1,
            ),
        ));
        $this->render('index', array(
            'gameDataProvider' => $dataProvider,
        ));

    }
    public function actionView($id)
    {
        $game = $this->_getModelById($id);
        $gameMovieDataProvider = new DataProvider\Movie(array(
            'criteria' => array(
                'condition'=> 'game_id = ' . $game->id
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
        $this->render('/dummy');
    }

    public function actionEdit($id)
    {
        $this->render('/dummy');
    }

    public function actionDelete($id)
    {
        $this->render('/dummy');
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


