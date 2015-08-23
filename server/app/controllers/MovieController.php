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
use \app\components\FormCollection;
use \app\components\DataProvider;
use \app\models\AR\Movie;
use \app\models\AR\Game;
use \app\models\MovieFacade;
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
        $movie = $this->_getModelById($id, array('file', 'video', 'audio'));
        $this->render('view', array('movie' => $movie));
    }


    public function actionCreate($gameId = null)
    {
        $movie = new Movie;
        $movieParams = $this->_createMovieFormParams($movie, $gameId);

        $this->_tryAjaxValidation($movieParams);

        $backUrl = $this->_getBackUrl();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $movieParams->setAttributesByPost();

            $movieFacade = new MovieFacade($movie);
            $movieFacade->setAttributes($movieParams->toArray());

            if ($movieFacade->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('create', array(
            'movieParams' => $movieParams,
            'backUrl' => $backUrl,
        ));
    }

    public function actionEdit($id)
    {
        $movie = $this->_getModelById($id, array('game', 'file', 'video', 'audio'));
        $movieParams = $this->_createMovieFormParams($movie);

        $this->_tryAjaxValidation($movieParams);

        $backUrl = $this->_getBackUrl();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $movieParams->setAttributesByPost();

            $movieFacade = new MovieFacade($movie);
            $movieFacade->setAttributes($movieParams->toArray());

            if ($movieFacade->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('edit', array(
            'movieParams' => $movieParams,
            'movie' => $movie,
            'backUrl' => $backUrl,
        ));
    }

    public function actionDelete($id)
    {
        $movie = $this->_getModelById($id);
        $movieFacade = new MovieFacade($movie);
        $movieFacade->delete();
        $url = $this->createUrl('index');
        $this->redirect($url);
    }

    private function _createMovieFormParams($movie, $gameId = null)
    {
        $mainParams = new Form\Movie\MainParams($movie);
        if ($gameId) {
            $game = Game::model()->findByPk($gameId);
            if ($game) {
                $mainParams->setAttributes(array('gameTitle' => $game->title));
            }
        }
        $fileParams = new Form\Movie\FileParams($movie);
        $videoParams = new Form\Movie\VideoParams($movie);
        $audioParams = new Form\Movie\AudioParams($movie);

        $params = new FormCollection();
        $params->add('mainParams', $mainParams);
        $params->add('fileParams', $fileParams);
        $params->add('videoParams', $videoParams);
        $params->add('audioParams', $audioParams);

        return $params;
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


