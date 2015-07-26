<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.06.15
 * Time: 1:22
 */

namespace backend\models\Form;

use \Yii;
use \CHtml;
use \CActiveForm;
use \common\helpers\Data as DataHelper;


class Movie extends \common\components\FormModel
{
    public $mainParams;
    public $videoParams;
    public $audioParams = array();

    public function init()
    {
        $this->mainParams = new Movie\MainParams($this->getScenario());
        $this->videoParams = new Movie\VideoParams($this->getScenario());
        $this->audioParams[] = $this->_createAudioParamsFormModel();

        parent::init();
    }

    public function rules()
    {
        return array(
            array('mainParams', 'validateParams'),
            array('videoParams', 'validateParams'),
            array('audioParams', 'validateParams'),
        );
    }

    public function setAttributesByMovieModel($movie)
    {
        $this->mainParams->setAttributes($this->getModelAttributesSnakeToCamel($movie));
        $this->mainParams->gameTitle = $movie->game->title;

        $this->videoParams->setAttributes($this->getModelAttributesSnakeToCamel($movie->video));

        foreach ($movie->audio as $n => $audio) {
            if (!isset($this->audioParams[$n])) {
                $this->audioParams[$n] = $this->_createAudioParamsFormModel();
            }
            $this->audioParams[$n]->setAttributes($this->getModelAttributesSnakeToCamel($audio));
        }
    }

    public function setAttributesByPost()
    {
        $request = Yii::app()->getRequest();

        $mainParamsPostData = $request->getPost(CHtml::modelName($this->mainParams));
        $this->mainParams->setAttributes(DataHelper::trimRecursive($mainParamsPostData));

        $videoParamsPostData = $request->getPost(CHtml::modelName($this->videoParams));
        $this->videoParams->setAttributes(DataHelper::trimRecursive($videoParamsPostData));

        $audioParamsPostData = $request->getPost(CHtml::modelName($this->audioParams[0]));
        foreach ($audioParamsPostData as $n => $data) {
            if (!isset($this->audioParams[$n])) {
                $this->audioParams[$n] = $this->_createAudioParamsFormModel();;
            }
            $this->audioParams[$n]->setAttributes(DataHelper::trimRecursive($data));
        }
    }

    public function getAjaxValidationResponseContent()
    {
        $json1 = json_decode(CActiveForm::validate(array($this->mainParams, $this->videoParams), null, false), true);
        $json2 = json_decode(CActiveForm::validateTabular($this->audioParams, null, false), true);
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
        return array_keys($this->audioParams[0]->getAttributes());
    }

    private function _createAudioParamsFormModel()
    {
        return new Movie\AudioParams($this->getScenario());
    }
}