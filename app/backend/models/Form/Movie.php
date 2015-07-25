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


class Movie extends \common\components\FormModel
{
    public $mainParams;
    public $videoParams;
    public $audioParams = array();

    public function init()
    {
        $this->mainParams = new Movie\MainParams($this->getScenario());
        $this->videoParams = new Movie\VideoParams($this->getScenario());
        $this->audioParams[] = new Movie\AudioParams($this->getScenario());

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

    public function setAttributesByPost()
    {
        $request = Yii::app()->getRequest();
        $this->mainParams->setAttributes($request->getPost(CHtml::modelName($this->mainParams)));
        $this->videoParams->setAttributes($request->getPost(CHtml::modelName($this->videoParams)));
        $audioParamsPostData = $request->getPost(CHtml::modelName($this->audioParams[0]));
        foreach ($audioParamsPostData as $n => $data) {
            if (!isset($this->audioParams[$n])) {
                $this->audioParams[$n] = new Movie\AudioParams($this->getScenario());
            }
            $this->audioParams[$n]->setAttributes($data);
        }
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

    public function getMainParamKeys()
    {
        return array_keys($this->mainParams->getAttributes());
    }

    public function getVideoParamKeys()
    {
        return array_keys($this->videoParams->getAttributes());
    }

    public function getAudioParamKeys()
    {
        return array_keys($this->audioParams[0]->getAttributes());
    }
}