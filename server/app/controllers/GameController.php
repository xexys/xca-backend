<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 20:50
 */

namespace app\controllers;

use \Yii;
use \app\components\CrudController;
use \app\components\DataProvider;
use \app\components\FormCollection;
use \app\models\AR\Game;
use \app\models\GameFacade;
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
        $gameParams = $this->_createGameFormParams($game);

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
        $gameParams = $this->_createGameFormParams($game);

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
            'gameTitle' => $game->title,
            'backUrl' => $backUrl
        ));
    }

    public function actionDelete($id)
    {
        $game = $this->_getModelById($id);
        $gameFacade = new GameFacade($game);
        $gameFacade->delete();
        $url = $this->createUrl('index');
        $this->redirect($url);
    }

    private function _createGameFormParams($game)
    {
        $mainParams = new Form\Game\MainParams($game);
        $platformsInfoParams = new Form\Game\PlatformsInfoParams($game);

        $params = new FormCollection();
        $params->add('mainParams', $mainParams);
        $params->add('platformsInfoParams', $platformsInfoParams);

        return $params;
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
