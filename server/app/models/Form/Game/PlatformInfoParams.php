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
use \CException;
use \app\components\Params;
use \app\components\ParamsCollection;
use \app\models\Game;
use \app\helpers\Data as DataHelper;


class PlatformInfoParams extends Params
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

        $this->items = new ParamsCollection;
        $this->items[] = $this->createItem();

        if ($scenario === self::SCENARIO_UPDATE) {
            $this->_setAttributesByGameModel();
        }
    }

    public function rules()
    {
        return array(
            array('items', '\app\components\validators\ParamsValidator'),
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