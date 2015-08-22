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
use \Exception;
use \CException;
use \app\components\FormFacade;
use \app\components\ObjectCollection;
use \app\models\Game;
use \app\helpers\Data as DataHelper;


class PlatformInfoParams extends FormFacade
{
    public $items;
    
    private $_gameModel;

    public function __construct($game)
    {
        if ($game->getIsNewRecord()) {
            $scenario = self::SCENARIO_CREATE;
        } else {
            $scenario = self::SCENARIO_UPDATE;
        }

        $this->setScenario($scenario);
        $this->_gameModel = $game;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        $scenario = $this->getScenario();

        $this->items = new ObjectCollection;
        $this->items[] = $this->createItem();

        if ($scenario === self::SCENARIO_UPDATE) {
            $this->_setAttributesByGameModel();
        }
    }

    public function rules()
    {
        return array(
            array('items', 'validateModels'),
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
        return new PlatformInfoParamsItem($this->getScenario());
    }

    protected function _create()
    {
        if ($this->_gameModel->getIsNewRecord()) {
            throw new CException('The game must not be a new.');
        }

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
        foreach($platformInfoModels as $platformInfo) {
            if (!in_array($platformInfo->id, $updateIds)) {
                $deleteIds[] = $platformInfo->id;
            }
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('id', $deleteIds);
        Game\PlatformInfo::model()->deleteAll($criteria);
    }

    private function _getPostKey()
    {
        return CHtml::modelName($this->items->getFirstItem());
    }

    private function _setAttributesByGameModel()
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
}