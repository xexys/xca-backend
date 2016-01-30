<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:02
 */

namespace app\models\Form\Movie\File;

use \Yii;
use \CHtml;
use \CActiveForm;
use \app\components\FormCollection;
use \app\models\AR\Game;
use \app\models\AR\Movie;
use \app\helpers\Data as DataHelper;


class AudioParams extends Params
{
    public $items;
    
    public function init()
    {
        $this->items = new FormCollection;
        $this->items[] = $this->createItem();

        parent::init();
    }

    public function rules()
    {
        return array(
            array('items', '\app\components\validators\ModelsValidator'),
        );
    }

    public function setAttributesByPost($postData = array())
    {
        $postData = Yii::app()->getRequest()->getPost($this->_getPostKey());

        if ($postData) {
            $this->items->clear();

            foreach ($postData as $n => $data) {
                $item = $this->createItem();
                $item->setAttributes(DataHelper::trimRecursive($data));
                // Важно сохранить номер, чтобы правильно сработала ajax валидация
                $this->items[$n] = $item;
            }
        }
    }

    public function getFormKeys()
    {
        return $this->items->getFirstItem()->getSafeAttributeNames();
    }

    public function getAjaxValidationResponseContent()
    {
        return CActiveForm::validateTabular($this->items->toArray(), null, false);
    }

    public function createItem()
    {
        return new AudioParamsItem($this->getScenario());
    }

    private function _getPostKey()
    {
        return CHtml::modelName($this->items->getFirstItem());
    }

    protected function _setAttributesByMovieModel()
    {
        $audioArray = $this->_movieModel->audio;
        if ($audioArray) {
            $this->items->clear();
            foreach ($audioArray as $audio) {
                $item = $this->createItem();
                $item->setAttributes($audio->getAttributes());
                $this->items[] = $item;
            }
        }
    }

    protected function _create()
    {
        $this->_checkMovieIsNewRecord();

        foreach ($this->items as $audioParams) {
            $attrs = $audioParams->getAttributes();
            $attrs['movieId'] = $this->_movieModel->id;
            $movieAudio = new Movie\Audio;
            $movieAudio->setAttributes($attrs);
            if (!$movieAudio->save()) {
                throw new CException($movieAudio->getFirstErrorMessage());
            }
        }
    }

    protected function _update()
    {
        $this->_delete();
        $this->_create();
    }

    protected function _delete()
    {
        Movie\Audio::model()->deleteAllByAttributes(array('movie_id' => $this->_movieModel->id));
    }
}
