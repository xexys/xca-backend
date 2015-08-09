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
use \app\models\Movie as MovieModel;
use \app\components\ObjectCollection;


class Movie extends \app\components\FormFacade
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
        $this->audioParamsCollection[] = $this->_createAudioParams();

        if ($scenarion === self::SCENARIO_UPDATE) {
            $this->_setAttributesByMovieModel();
        }
    }


    public function rules()
    {
        return array(
            array('mainParams, fileParams, videoParams, audioParamsCollection', 'validateModels'),
        );
    }

    public function setAttributesByPost()
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
                $audioParams = $this->_createAudioParams();
                $audioParams->setAttributes(DataHelper::trimRecursive($data));
                // Важно сохранить номер, чтобы правильно сработала ajax валидация
                $this->audioParamsCollection[$n] = $audioParams;
            }
        }
    }

    public function getAjaxValidationResponseContent()
    {
        $json1 = json_decode(CActiveForm::validate(array($this->mainParams, $this->fileParams, $this->videoParams), null, false), true);
        $json2 = json_decode(CActiveForm::validateTabular($this->audioParamsCollection, null, false), true);
        return json_encode(array_merge($json1, $json2));
    }

    public function getMainParamsKeys()
    {
        return $this->mainParams->attributeNames();
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
        throw new \Exception(self::SCENARIO_CREATE);
    }

    protected function _update()
    {
        throw new \Exception(self::SCENARIO_UPDATE);
    }

    private function _createAudioParams()
    {
        return new Movie\AudioParams($this->getScenario());
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
                $audioParams = $this->_createAudioParams();
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