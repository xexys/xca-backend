<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:02
 */

namespace app\models\Form\Game;

use \Yii;
use \CHtml;
use \CActiveForm;
use \app\components\FormCollection;
use \app\models\AR\Game;
use \app\helpers\Data as DataHelper;


class PlatformsInfoParams extends Params
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
        return new PlatformsInfoParamsItem($this->getScenario());
    }

    private function _getPostKey()
    {
        return CHtml::modelName($this->items->getFirstItem());
    }

    protected function _setAttributesByGameModel()
    {
        $platformsInfo = $this->_gameModel->platformsInfo;
        if ($platformsInfo) {
            $this->items->clear();
            foreach ($platformsInfo as $platformInfo) {
                $item = $this->createItem();
                $item->setAttributes($platformInfo->getAttributes());
                $this->items[] = $item;
            }
        }
    }

    protected function _create()
    {
        $this->_checkGameIsNewRecord();

        foreach ($this->items as $item) {
            $attrs = $item->getAttributes();
            $attrs['gameId'] = $this->_gameModel->id;
            $platformInfo = new Game\PlatformInfo;
            $platformInfo->setAttributes($attrs);
            if (!$platformInfo->save()) {
                throw new CException($platformInfo->getFirstErrorMessage());
            }
        }
    }

    protected function _update()
    {
        $game = $this->_gameModel;

        // create + update
        $updateIds = array();

        $platformInfoModels = Game\PlatformInfo::model()->findAll(array(
            'index' => 'platform_id',
            'condition' => 'game_id = :game_id',
            'params' => array(':game_id' => $game->id),
        ));

        foreach ($this->items as $item) {
            $attrs = $item->getAttributes();
            if (isset($platformInfoModels[$item->platformId])) {
                $platformInfo = $platformInfoModels[$item->platformId];
                $updateIds[] = $platformInfo->id;
            } else {
                $platformInfo = new Game\PlatformInfo;
                $attrs['gameId'] = $game->id;
            }
            $platformInfo->setAttributes($attrs);
            if (!$platformInfo->save()) {
                throw new CException($platformInfo->getFirstErrorMessage());
            }
        }

        // delete
        $deleteIds = array();
        foreach ($platformInfoModels as $platformInfo) {
            if (!in_array($platformInfo->id, $updateIds)) {
                $deleteIds[] = $platformInfo->id;
            }
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('id', $deleteIds);
        Game\PlatformInfo::model()->deleteAll($criteria);
    }

    protected function _delete()
    {
        Game\PlatformInfo::model()->deleteAllByAttributes(array('game_id' => $this->_gameModel->id));
    }
}