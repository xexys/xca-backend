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
use \app\models\AR\Game as GameAR;
use \app\models\Game;
use \app\components\DataProvider;
use \app\components\FormCollection;
use \app\models\Form;


class GameController extends CrudController
{
    const INDEX_PAGE_SIZE = 15;
    const VIEW_MOVIES_PAGE_SIZE = 10;

    public function actionIndex()
    {
        $gameDataProvider = new DataProvider\Game(array(
            'pagination' => array(
                'pageSize' => self::INDEX_PAGE_SIZE,
            ),
        ));
        $this->render('index', array(
            'gameDataProvider' => $gameDataProvider,
        ));
    }

    public function actionView($id)
    {
        $game = $this->_getARModelById($id);
        $gameMovieDataProvider = new DataProvider\Movie(array(
            'criteria' => array(
                'condition' => 'game_id = ' . $game->id
            ),
            'pagination' => array(
                'pageSize' => self::VIEW_MOVIES_PAGE_SIZE,
            ),
        ));
        $this->render('view', array(
            'game' => $game,
            'gameMovieDataProvider' => $gameMovieDataProvider,
        ));
    }

    public function actionCreate()
    {
        $gameAR = new GameAR;
        $gameParams = $this->_createGameFormParams($gameAR);

        $this->_tryAjaxValidation($gameParams);

        if ($this->_getRequest()->getIsPostRequest()) {
            $gameParams->setAttributesByPost();

            $game = new Game($gameAR);
            $game->setAttributes($gameParams->toArray());

            if ($game->save()) {
                $this->redirect('index');
            }
        }

        $this->render('create', array(
            'gameParams' => $gameParams,
            'backUrl' => $this->_getBackUrl()
        ));
    }

    public function actionEdit($id)
    {
        $gameAR = $this->_getARModelById($id, array('platformsInfo'));
        $gameParams = $this->_createGameFormParams($gameAR);

        $this->_tryAjaxValidation($gameParams);

        $backUrl = $this->_getBackUrl();

        if ($this->_getRequest()->getIsPostRequest()) {
            $gameParams->setAttributesByPost();

            $game = new Game($gameAR);
            $game->setAttributes($gameParams->toArray());

            if ($game->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('edit', array(
            'gameParams' => $gameParams,
            'gameTitle' => $gameAR->title,
            'backUrl' => $backUrl
        ));
    }

    public function actionDelete($id)
    {
        $game = $this->_getARModelById($id);
        $game->delete();
        $url = $this->createUrl('index');
        $this->redirect($url);
    }

    private function _createGameFormParams($gameAR)
    {
        $mainParams = new Form\Game\MainParams($gameAR);
        $platformInfoParams = new Form\Game\PlatformInfoParams($gameAR);

        $params = new FormCollection();
        $params->add('mainParams', $mainParams);
        $params->add('platformInfoParams', $platformInfoParams);

        return $params;
    }

    private function _getARModelById($id, $with = array())
    {
        $model = GameAR::model()->with($with)->findByPk($id);
        if (!$model) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $model;
    }
}
