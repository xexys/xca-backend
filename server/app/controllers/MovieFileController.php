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
use \app\models\AR\Movie;
use \app\models\AR\Game;
use \app\models\Form;


class MovieFileController extends CrudController
{
    const INDEX_PAGE_SIZE = 15;

    function actionIndex()
    {
        $dataProvider = new DataProvider\Movie\File(array(
            'criteria' => array(
                'with' => array('mainParams', 'movie.game')
            ),
            'pagination' => array(
                'pageSize' => self::INDEX_PAGE_SIZE,
            ),
        ));
        $this->render('index', array(
            'movieFileDataProvider' => $dataProvider,
        ));

    }

    public function actionView($id)
    {
        $movie = $this->_getModelById($id, array('game', 'file.mainParams', 'file.videoParams', 'file.audioParams'));

        $this->render('view', array(
            'movie' => $movie
        ));
    }


    public function actionCreate($movieId = null, $type = null)
    {
        $movie = Movie::model()->findByPk($movieId) ?: new Movie();
        $movieFile = new Movie\File;
        $movieFileFormParams = $this->_createParamsForm(self::SCENARIO_CREATE, $movie, $movieFile, $type);

        $this->_tryAjaxValidation($movieFileFormParams);

        $backUrl = $this->_getBackUrl();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $movieFileFormParams->setAttributesByPost();

            if ($movieFileFormParams->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('create', array(
            'movieFile' => $movieFile,
            'movieFileFormParams' => $movieFileFormParams,
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

            if ($movieParams->save()) {
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

        $movieParams = new FormFacadeCollection(array(
            $this->_createAudioParamsForm($movie),
            $this->_createVideoParamsForm($movie),
            $this->_createMovieFileParams($movie),
            $this->_createMainParamsForm($movie),
        ));
        $movieParams->delete();

        $url = $this->createUrl('index');
        $this->redirect($url);
    }

    private function _createMovieFileForm() {

    }

    private function _createParamsForm($scenario, $file, $type = null)
    {
        $formParams = array(
            'description' =>  $this->_createDescriptionForm($scenario, $file, $type),
            'mainParams' => $this->_createMainParamsForm($scenario, $file),
            'videoParams' => $this->_createVideoParamsForm($scenario, $file),
            'audioParams' => $this->_createAudioParamsForm($scenario, $file),
        );

        return new FormFacadeCollection($formParams);
    }

    private function _createDescriptionForm($scenario, $file, $type = null)
    {
        return new Form\File\Description($scenario, $file, type);

    }

    private function _createMainParamsForm($file)
    {
        $formMainParams = new Form\Movie\File\MainParams($movie);
        $mainParams = $file->mainParams ?: new Movie\File\MainParams();

        if ($gameId) {
            $game = Game::model()->findByPk($gameId);
            if ($game) {
                $mainParams->setAttributes(array('gameTitle' => $game->title));
            }
        }
        return $mainParams;
    }

    private function _createMovieFileParams($movie)
    {
        return new Form\Movie\FileParams($movie);
    }

    private function _createVideoParamsForm($movie)
    {
        return new Form\Movie\VideoParams($movie);
    }

    private function _createAudioParamsForm($movie)
    {
        return new Form\Movie\AudioParams($movie);
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


