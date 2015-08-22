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
use \app\models\GameFacade;
use \app\components\DataProvider;
use \app\components\ParamsCollection;
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
        $game = $this->_getModelById($id);
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
        $game = new Game;

        $gameMainParams = new Form\Game\MainParams($game);
        $gamePlatformInfoParams = new Form\Game\PlatformInfoParams($game);

        $gameParams = new ParamsCollection();
        $gameParams->add('mainParams', $gameMainParams);
        $gameParams->add('platformInfoParams', $gamePlatformInfoParams);

        $this->_tryAjaxValidation($gameParams);

        if ($this->_getRequest()->getIsPostRequest()) {
            $gameParams->setAttributesByPost();

            $gameFacade = new GameFacade($game);
            $gameFacade->setAttributes($gameParams->toArray());

            if ($gameFacade->save()) {
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
        $game = $this->_getModelById($id, array('platformsInfo'));

        $gameMainParams = new Form\Game\MainParams($game);
        $gamePlatformInfoParams = new Form\Game\PlatformInfoParams($game);

        $gameParams = new ParamsCollection();
        $gameParams->add('mainParams', $gameMainParams);
        $gameParams->add('platformInfoParams', $gamePlatformInfoParams);

        $this->_tryAjaxValidation($gameParams);

        $backUrl = $this->_getBackUrl();

        if ($this->_getRequest()->getIsPostRequest()) {
            $gameParams->setAttributesByPost();

            $gameFacade = new GameFacade($game);
            $gameFacade->setAttributes($gameParams->toArray());

            if ($gameFacade->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('edit', array(
            'gameParams' => $gameParams,
            'game' => $game,
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

    private function _getModelById($id, $with = array())
    {
        $model = Game::model()->with($with)->findByPk($id);
        if (!$model) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $model;
    }
}


