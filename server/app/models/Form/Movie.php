<?php
/**
 * Форма для создания и редактировния ролика
 *
 * Фасадный объект для работы с несколькими формами и моделями AR
 *
 * User: Alex
 * Date: 21.06.15
 * Time: 1:22
 */

namespace app\models\Form;

use \Yii;
use \CHtml;
use \CActiveForm;
use \app\helpers\Data as DataHelper;
use \app\models\AR\Game as GameModel;
use \app\models\AR\Movie as MovieModel;
use \app\components\ObjectCollection;


class Movie extends \app\components\FormModel
{
    public $mainParams;
    public $fileParams;
    public $videoParams;
    public $audioParamsCollection;

    private $_movieModel;

    public function __construct($movieId = null)
    {
        if ($movieId) {
            $scenario = self::SCENARIO_UPDATE;
            $movie = $this->_getMovieModelById($movieId);
        } else {
            $scenario = self::SCENARIO_CREATE;
            $movie = new MovieModel();
        }

        $this->setScenario($scenario);
        $this->_movieModel = $movie;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        $scenarion = $this->getScenario();

        $this->mainParams = new Movie\MainParams($scenarion);
        $this->fileParams = new Movie\FileParams($scenarion);
        $this->videoParams = new Movie\VideoParams($scenarion);
        $this->audioParamsCollection = new ObjectCollection();
        $this->audioParamsCollection[] = $this->createAudioParams();

        if ($scenarion === self::SCENARIO_UPDATE) {
            $this->_setAttributesByMovieModel();
        }
    }


    public function rules()
    {
        return array(
            array('mainParams, fileParams, videoParams, audioParamsCollection', '\app\components\validators\ModelsValidator'),
        );
    }

    public function setAttributesByPost($postData = array())
    {
        $this->_setParamsByPost($this->mainParams);
        $this->_setParamsByPost($this->fileParams);
        $this->_setParamsByPost($this->videoParams);
        $this->_setAudioParamsByPost();
    }

    private function _setParamsByPost($paramsModel)
    {
        $postData = Yii::app()->getRequest()->getPost(CHtml::modelName($paramsModel));
        $paramsModel->setAttributes(DataHelper::trimRecursive($postData));
    }
    
    private function _setAudioParamsByPost()
    {
        $postKey = CHtml::modelName($this->audioParamsCollection->getFirstItem());
        $postData = Yii::app()->getRequest()->getPost($postKey);
        if ($postData) {
            $this->audioParamsCollection->clear();
            foreach ($postData as $n => $data) {
                $audioParams = $this->createAudioParams();
                $audioParams->setAttributes(DataHelper::trimRecursive($data));
                // Важно сохранить номер, чтобы правильно сработала ajax валидация
                $this->audioParamsCollection[$n] = $audioParams;
            }
        }
    }

    public function getAjaxValidationResponseContent()
    {
        $json1 = json_decode(CActiveForm::validate(array($this->mainParams, $this->fileParams, $this->videoParams), null, false), true);
        $json2 = json_decode(CActiveForm::validateTabular($this->audioParamsCollection->toArray(), null, false), true);
        return json_encode(array_merge($json1, $json2));
    }

    public function getMainParamsKeys()
    {
        $names = $this->mainParams->attributeNames();
        if ($this->getScenario() == self::SCENARIO_UPDATE) {
            $names = $this->_filterParamsKeys($names, array('gameTitle'));
        }
        return $names;
    }

    public function getFileParamsKeys()
    {
        return $this->fileParams->attributeNames();
    }

    public function getVideoParamsKeys()
    {
        return $this->videoParams->attributeNames();
    }

    public function getAudioParamsKeys()
    {
        return $this->audioParamsCollection->getFirstItem()->attributeNames();
    }

    protected function _create()
    {
        $game = GameModel::model()->findByAttributes(array('title'=> $this->mainParams->gameTitle));

        $attrs = $this->mainParams->getAttributes();
        $attrs['gameId'] = $game->id;
        $movie = $this->_movieModel;
        $movie->setAttributes($attrs);

        if (!$movie->save()) {
            throw new CException($movie->getFirstErrorMessage());
        }

        // file
        $attrs = $this->fileParams->getAttributes();
        $attrs['movieId'] = $movie->id;
        $movieFile = new MovieModel\File();
        $movieFile->setAttributes($attrs);

        if (!$movieFile->save()) {
            throw new CException($movieFile->getFirstErrorMessage());
        }

        // TODO: Посчитать frame_quality
        // video
        $attrs = $this->videoParams->getAttributes();
        $attrs['movieId'] = $movie->id;
        $movieVideo = new MovieModel\Video();
        $movieVideo->setAttributes($attrs);

        if (!$movieVideo->save()) {
            throw new CException($movieVideo->getFirstErrorMessage());
        }

        // audio
        $this->_createAndSaveAudioModels();
    }

    protected function _update()
    {
        $movie = $this->_movieModel;
        $movie->setAttributes($this->mainParams->getAttributes());

        if (!$movie->save()) {
            throw new CException($movie->getFirstErrorMessage());
        }

        // file
        $attrs = $this->fileParams->getAttributes();
        $movie->file->setAttributes($attrs);

        if (!$movie->file->save()) {
            throw new CException($movie->file->getFirstErrorMessage());
        }

        // TODO: Посчитать frame_quality
        // video
        $attrs = $this->videoParams->getAttributes();
        $movie->video->setAttributes($attrs);

        if (!$movie->video->save()) {
            throw new CException($movie->video->getFirstErrorMessage());
        }

        // audio
        MovieModel\Audio::model()->deleteAllByAttributes(array('movie_id'=> $movie->id));
        $this->_createAndSaveAudioModels();
    }

    public function createAudioParams()
    {
        return new Movie\AudioParams($this->getScenario());
    }

    private function _createAndSaveAudioModels()
    {
        if ($this->_movieModel->getIsNewRecord()) {
            throw new \CException('Модель уже должна быть сохранена в БД');
        }

        foreach ($this->audioParamsCollection as $audioParams) {
            $attrs = $audioParams->getAttributes();
            $attrs['movieId'] = $this->_movieModel->id;
            $movieAudio = new MovieModel\Audio();
            $movieAudio->setAttributes($attrs);
            if (!$movieAudio->save()) {
                throw new CException($movieAudio->getFirstErrorMessage());
            }
        }
    }

    private function _setAttributesByMovieModel()
    {
        $this->mainParams->title = $this->_movieModel->title;
        $this->mainParams->gameTitle = $this->_movieModel->game->title;

        $this->fileParams->setAttributes($this->_movieModel->file->getAttributes());

        $this->videoParams->setAttributes($this->_movieModel->video->getAttributes());

        $audioArray = $this->_movieModel->audio;
        if ($audioArray) {
            $this->audioParamsCollection->clear();
            foreach ($audioArray as $audio) {
                $audioParams = $this->createAudioParams();
                $audioParams->setAttributes(DataHelper::trimRecursive($audio->getAttributes()));
                $this->audioParamsCollection[] = $audioParams;
            }
        }
    }

    private function _getMovieModelById($id)
    {
        $movie = MovieModel::model()->with(array('game', 'file', 'video', 'audio'))->findByPk($id);
        if (!$movie) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $movie;
    }

}