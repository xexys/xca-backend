<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 21.06.15
 * Time: 1:22
 */

namespace common\models\Form;

use \Yii;
use \CHtml;
use \CActiveForm;
use \common\models as Model;


class Movie extends \CFormModel
{
    public $mainParams;
    public $videoParams;
    public $audioParams = array();

    public function init()
    {
        $this->mainParams = new Model\Movie();
        $this->videoParams = new Model\Movie\Video();
        $this->audioParams[] = new Model\Movie\Audio();
        $this->audioParams[] = new Model\Movie\Audio();

        parent::init();
    }

    public function rules()
    {
        return array(
            array('mainParams', 'validateModel'),
            array('videoParams', 'validateModel'),
            array('audioParams', 'validateModel'),
        );
    }

    public function setAttributesByPost()
    {
        $request = Yii::app()->getRequest();
        $this->mainParams->setAttributes(array_map('trim', $request->getPost(CHtml::modelName($this->mainParams))));
        $this->videoParams->setAttributes(array_map('trim', $request->getPost(CHtml::modelName($this->videoParams))));
        $audioParamsPostData = $request->getPost(CHtml::modelName($this->audioParams[0]));
        foreach ($audioParamsPostData as $n => $data) {
            if (!isset($this->audioParams[$n])) {
                $this->audioParams[] = new Model\Movie\Audio();
            }
            $this->audioParams[$n]->setAttributes(array_map('trim', $data));
        }
    }

    public function validateModel($key)
    {
        $models = $this->$key;
        if (!is_array($models)) {
            $models = array($models);
        }
        foreach ($models as $model) {
            if (!$model->validate()) {
                $this->addError($key, 'model has errors');
            }
        }
    }

    public function tryAjaxValidation()
    {
        $request = Yii::app()->getRequest();
        if ($request->getIsPostRequest() && $request->getIsAjaxRequest() && $request->getPost('ajax')) {
            header('Content-Type: application/json');
            $json1 = json_decode(CActiveForm::validate(array($this->mainParams, $this->videoParams)), true);
            $json2 = json_decode(CActiveForm::validateTabular($this->audioParams), true);
            echo json_encode(array_merge($json1, $json2));
            Yii::app()->end();
        }
    }

    public function save()
    {
        if ($this->validate()) {

            // Сохранить данные в транзакции

        }
        return false;
    }

    public function getMainInputKeys()
    {
        $keys = array_keys($this->mainParams->getAttributes());
        $invalidKeys = array('id');
        return $this->_filterParamsKeys($keys, $invalidKeys);
    }

    public function getVideoInputKeys()
    {
        $keys = array_keys($this->videoParams->getAttributes());
        $invalidKeys = array('id', 'movie_id');
        return $this->_filterParamsKeys($keys, $invalidKeys);
    }

    public function getAudioInputKeys()
    {
        $keys = array_keys($this->audioParams[0]->getAttributes());
        $invalidKeys = array('id', 'movie_id');
        return $this->_filterParamsKeys($keys, $invalidKeys);
    }

    private function _filterParamsKeys($keys, $invalidKeys)
    {
        return array_filter($keys, function ($val) use ($invalidKeys) {
            return !in_array($val, $invalidKeys, true);
        });
    }
}