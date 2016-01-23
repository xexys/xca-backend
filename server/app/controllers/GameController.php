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
use \app\components\FormFacadeCollection;
use \app\models\AR\Game;
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
        $game = $this->_getModelById($id, array('issuesInfo.platform'));
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

            if ($gameParams->save()) {
                $this->redirect('index');
            }
        }

        $this->render('create', array(
            'gameParams' => $gameParams,
            'backUrl' => $this->_getBackUrl()
        ));
    }

    public function actionEdit($id, $paramsKeys = null)
    {
        $game = $this->_getModelById($id);
        $gameParams = $this->_createGameFormParams($game, $paramsKeys);

        $this->_tryAjaxValidation($gameParams);

        $backUrl = $this->_getBackUrl();

        if ($this->_getRequest()->getIsPostRequest()) {
            $gameParams->setAttributesByPost();

            if ($gameParams->save()) {
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

        $gameParams = new FormFacadeCollection(array(
            $this->_createGameIssuesInfo($game),
            $this->_createGameMainParams($game)
        ));
        $gameParams->delete();

        $url = $this->createUrl('index');
        $this->redirect($url);
    }

    private function _createGameFormParams($game, $paramsKeys = null)
    {
        if (is_string($paramsKeys)) {
            $paramsKeys = explode(',', $paramsKeys);
        }

        $paramsKeys = $paramsKeys ?: array('mainInfo', 'issuesInfo');

        $params = new FormFacadeCollection();

        if (in_array('mainInfo', $paramsKeys)) {
            $params['mainParams'] = $this->_createGameMainParams($game);
        }
        if (in_array('issuesInfo', $paramsKeys)) {
            $params['issuesInfoParams'] = $this->_createGameIssuesInfo($game);
        }

        return $params;
    }

    private function _createGameMainParams($game) {
        return new Form\Game\MainParams($game);
    }

    private function _createGameIssuesInfo($game) {
        return new Form\Game\IssuesInfoParams($game);
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
