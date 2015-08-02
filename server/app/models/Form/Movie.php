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


class Movie extends \app\components\FormFacade
{
    public $mainParams;
    public $videoParams;
    public $audioParamsArray = array();

    private $_movieModel;

    public function __construct($movieId = null)
    {
        if ($movieId) {
            $scenario = 'update';
            $movie = $this->_getMovieModelById($movieId);
        } else {
            $scenario = 'create';
            $movie = new MovieModel();
        }

        $this->setScenario($scenario);
        $this->_movieModel = $movie;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        $this->mainParams = new Movie\MainParams($this->getScenario());
        $this->videoParams = new Movie\VideoParams($this->getScenario());
        $this->audioParamsArray[] = $this->_createAudioParams();

        $this->_setAttributesByMovieModel();
    }


    public function rules()
    {
        return array(
            array('mainParams', 'validateParams'),
            array('videoParams', 'validateParams'),
            array('audioParamsArray', 'validateParams'),
        );
    }

    public function setAttributesByPost()
    {
        $request = Yii::app()->getRequest();

        $mainParamsPostData = $request->getPost(CHtml::modelName($this->mainParams));
        $this->mainParams->setAttributes(DataHelper::trimRecursive($mainParamsPostData));

        $videoParamsPostData = $request->getPost(CHtml::modelName($this->videoParams));
        $this->videoParams->setAttributes(DataHelper::trimRecursive($videoParamsPostData));

        $audioParamsPostData = $request->getPost(CHtml::modelName($this->audioParamsArray[0]));
        foreach ($audioParamsPostData as $n => $data) {
            if (!isset($this->audioParamsArray[$n])) {
                $this->audioParamsArray[$n] = $this->_createAudioParams();;
            }
            $this->audioParamsArray[$n]->setAttributes(DataHelper::trimRecursive($data));
        }
    }

    public function getAjaxValidationResponseContent()
    {
        $json1 = json_decode(CActiveForm::validate(array($this->mainParams, $this->videoParams), null, false), true);
        $json2 = json_decode(CActiveForm::validateTabular($this->audioParamsArray, null, false), true);
        return json_encode(array_merge($json1, $json2));
    }

    public function validateParams($key)
    {
        $models = $this->$key;
        if (!is_array($models)) {
            $models = array($models);
        }
        foreach ($models as $model) {
            if (!$model->validate()) {
                $this->addError($key, 'form has errors');
            }
        }
    }

    public function save()
    {
        if ($this->validate()) {

            // Сохранить данные в транзакции

        }
        return false;
    }

    public function getMainParamsKeys()
    {
        return array_keys($this->mainParams->getAttributes());
    }

    public function getVideoParamsKeys()
    {
        return array_keys($this->videoParams->getAttributes());
    }

    public function getAudioParamsKeys()
    {
        return array_keys($this->audioParamsArray[0]->getAttributes());
    }

    private function _createAudioParams()
    {
        return new Movie\AudioParams($this->getScenario());
    }

    private function _setAttributesByMovieModel()
    {
        if (!$this->_movieModel->id) {
            return;
        }

        $this->mainParams->setAttributes($this->_getModelAttributesSnakeToCamel($this->_movieModel));
        $this->mainParams->gameTitle = $this->_movieModel->game->title;

        $this->videoParams->setAttributes($this->_getModelAttributesSnakeToCamel($this->_movieModel->video));

        foreach ($this->_movieModel->audio as $n => $audio) {
            if (!isset($this->audioParamsArray[$n])) {
                $this->audioParamsArray[$n] = $this->_createAudioParams();
            }
            $this->audioParamsArray[$n]->setAttributes($this->_getModelAttributesSnakeToCamel($audio));
        }
    }

    private function _getMovieModelById($id)
    {
        $movie = MovieModel::model()->with(array('video', 'audio'))->findByPk($id);
        if (!$movie) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $movie;
    }

}