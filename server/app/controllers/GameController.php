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
use \app\components\FormFacadeCollection;
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
        $formMainParams = new Form\Game\MainParams($game);
        $formPlatformInfoParams = new Form\Game\PlatformInfoParams($game);

        $formSet = new FormFacadeCollection();
        $formSet->add('mainParams', $formMainParams);
        $formSet->add('platformInfoParams', $formPlatformInfoParams);

        $this->_tryAjaxValidation($formSet);

        if ($this->_getRequest()->getIsPostRequest()) {
            $formSet->setAttributesByPost();

            if ($formSet->save()) {
                $this->redirect('index');
            }
        }

        $this->render('create', array(
            'formSet' => $formSet,
            'backUrl' => $this->_getBackUrl()
        ));
    }

    public function actionEdit($id)
    {
        $game = $this->_getModelById($id, array('platformsInfo'));

        $formMainParams = new Form\Game\MainParams($game);
        $formPlatformInfoParams = new Form\Game\PlatformInfoParams($game);

        $formSet = new FormFacadeCollection();
        $formSet->add('mainParams', $formMainParams);
        $formSet->add('platformInfoParams', $formPlatformInfoParams);

        $this->_tryAjaxValidation($formSet);

        $backUrl = $this->_getBackUrl();

        if ($this->_getRequest()->getIsPostRequest()) {
            $formSet->setAttributesByPost();

            if ($formSet->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('edit', array(
            'formSet' => $formSet,
            'game' => $game,
            'backUrl' => $backUrl
        ));
    }

    public function actionDelete($id)
    {
        $form = new GameForm($id);
        $form->delete();
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


