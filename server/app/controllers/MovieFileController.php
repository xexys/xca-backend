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
        $movieFile = $this->_getModelById($id, array('movie', 'movie.game',  'mainParams', 'videoParams', 'audioParams'));

        $this->render('/dummy');

//        $this->render('view', array(
//            'movie' => $movie
//        ));
    }

    /**
     * @param null $movieId
     * @param null $movieFileType - позваляет указать какой тип файла мы хотим создать
     * @throws \Exception
     * @throws \app\components\Exception
     */
    public function actionCreate($movieId = null, $movieFileType = null)
    {
        $movie = Movie::model()->with('game')->findByPk($movieId) ?: new Movie();
        $movieFile = new Movie\File;

        $movieFileForm = $this->_createParamsForm(self::SCENARIO_CREATE, $movie, $movieFile, $movieFileType);

        $this->_tryAjaxValidation($movieFileForm);

        $backUrl = $this->_getBackUrl();

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $movieFileForm->setAttributesByPost();

            if ($movieFileForm->save()) {
                $this->redirect($backUrl);
            }
        }

        $this->render('create', array(
            'movieFileForm' => $movieFileForm,
            'backUrl' => $backUrl,
        ));
    }

    public function actionEdit($id)
    {
        $movie = $this->_getModelById($id, array('game', 'movieFile', 'video', 'audio'));
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
        $movieFile = $this->_getModelById($id);

        $movieFile->delete();

        $url = $this->createUrl('index');
        $this->redirect($url);
    }

    private function _createParamsForm($scenario, $movie, $movieFile, $movieFileType = null)
    {
        $formParams = array(
            'infoParams' =>  $this->_createInfoParamsForm($scenario, $movie, $movieFile, $movieFileType),
            'mainParams' => $this->_createMainParamsForm($scenario, $movieFile),
            'videoParams' => $this->_createVideoParamsForm($scenario, $movieFile),
            'audioParams' => $this->_createAudioParamsForm($scenario, $movieFile),
        );

        return new FormFacadeCollection($formParams);
    }

    private function _createInfoParamsForm($scenario, $movie, $movieFile, $movieFileType = null)
    {
        return new Form\Movie\File\InfoParams($scenario, array(
            'movie' => $movie,
            'movieFile' => $movieFile,
            'movieFileType' => $movieFileType
        ));
    }

    private function _createMainParamsForm($scenario, $movieFile)
    {
        return new Form\Movie\File\MainParams($scenario, array(
            'movieFile' => $movieFile
        ));
    }

    private function _createVideoParamsForm($scenario, $file)
    {
        $videoParams = new Form\Movie\File\VideoParams($scenario, array(
            'movieFile' => $file
        ));

        return $videoParams;
    }

    private function _createAudioParamsForm($scenario, $file)
    {
        $audioParams = new Form\Movie\File\AudioParams($scenario, array(
            'movieFile' => $file
        ));

        return $audioParams;
    }

    private function _getModelById($id, $with = array())
    {
        $model = Movie\File::model()->with($with)->findByPk($id);
        if (!$model) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $model;
    }


}


