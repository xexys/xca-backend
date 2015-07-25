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
use \common\models;
use \common\helpers\Data as DataHelper;


class Movie extends \CFormModel
{
    public $mainParams;
    public $videoParams;
    public $audioParams = array();

    public function init()
    {
        $this->mainParams = new \backend\models\Form\Movie\MainParams();
        $this->videoParams = new models\Movie\Video();
        $this->audioParams[] = new models\Movie\Audio();

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
        $this->mainParams->setAttributes($request->getPost(CHtml::modelName($this->mainParams)));
        $this->videoParams->setAttributes($request->getPost(CHtml::modelName($this->videoParams)));
        $audioParamsPostData = $request->getPost(CHtml::modelName($this->audioParams[0]));
        foreach ($audioParamsPostData as $n => $data) {
            if (!isset($this->audioParams[$n])) {
                $this->audioParams[$n] = new models\Movie\Audio();
            }
            $this->audioParams[$n]->setAttributes($data);
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
        return $this->_filterParamsKeys($keys, $this->getMainHiddenKeys());
    }

    public function getMainHiddenKeys()
    {
        return array('gameId');
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