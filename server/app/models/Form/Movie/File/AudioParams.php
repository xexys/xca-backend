<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:02
 */

namespace app\models\Form\Movie\File;

use app\components\FormModel;
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

    public function getAjaxValidationResponseContent()
    {
        return CActiveForm::validateTabular($this->items->toArray(), null, false);
    }

    public function createItem()
    {
        return new AudioParamsItem($this->getScenario());
    }

    protected function _getPostKey()
    {
        return CHtml::modelName($this->items->getFirstItem());
    }

    protected function _initByParams($params)
    {
        parent::_initByParams($params);

        $this->items = new FormCollection;

        if ($this->_movieFile->audioParams) {
            foreach ($this->_movieFile->audioParams as $paramsItem) {
                $item = $this->createItem();
                $item->setAttributes($paramsItem->getAttributes());
                $this->items[] = $item;
            }
        } else {
            $this->items[] = $this->createItem();
        }
    }

    protected function _create()
    {
        foreach ($this->items as $audioParams) {
            $attrs = $audioParams->getAttributes();
            $attrs['movieFileId'] = $this->_movieFile->id;

            $model = new Movie\File\AudioParams;
            $model->setAttributes($attrs);

            if (!$model->save()) {
                throw new CException($model->getFirstErrorMessage());
            }
        }
    }

    protected function _update()
    {
        Movie\File\AudioParams::model()->deleteAllByAttributes(array('movie_file_id' => $this->_movieFile->id));

        $this->_create();
    }
}
