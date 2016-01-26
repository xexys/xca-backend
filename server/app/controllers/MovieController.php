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
use \app\models\AR\Movie;
use \app\models\AR\Game;
use \app\models\Form;


class MovieController extends CrudController
{
    const INDEX_PAGE_SIZE = 15;

    function actionIndex()
    {
        $dataProvider = new DataProvider\Movie(array(
            'criteria' => array(
                'with' => array('game')
            ),
            'pagination' => array(
                'pageSize' => self::INDEX_PAGE_SIZE,
            ),
        ));
        $this->render('index', array(
            'movieDataProvider' => $dataProvider,
        ));

    }

    public function actionView($id)
    {
        $movie = $this->_getModelById($id, array('game'));

        $this->render('view', array(
            'movie' => $movie
        ));
    }


    public function actionCreate($gameId = null)
    {
        $movie = new Movie;
        $movieForm = $this->_createMovieForm(self::SCENARIO_CREATE, $movie, $gameId);

        $this->_tryAjaxValidation($movieForm);

        $backUrl = $this->_getBackUrl();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $movieForm->setAttributesByPost();

            if ($movieForm->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('create', array(
            'movieForm' => $movieForm,
            'backUrl' => $backUrl,
        ));
    }

    public function actionEdit($id)
    {
        $movie = $this->_getModelById($id, array('game'));

        $movieForm = $this->_createMovieForm(self::SCENARIO_UPDATE, $movie);

        $this->_tryAjaxValidation($movieForm);

        $backUrl = $this->_getBackUrl();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $movieForm->setAttributesByPost();

            if ($movieForm->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('edit', array(
            'movieForm' => $movieForm,
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

    private function _createMovieForm($scenario, $movie, $gameId = null)
    {
        $movieForm = new Form\Movie($scenario, $movie);
        
        if ($gameId) {
            $game = Game::model()->findByPk($gameId);
            
            if ($game) {
                $movieForm->setAttributes(array('gameTitle' => $game->title));
            }
        }
        return $movieForm;
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


