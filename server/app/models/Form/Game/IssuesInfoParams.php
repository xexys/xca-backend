<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:02
 */

namespace app\models\Form\Game;

use \Yii;
use \CException;
use \CHtml;
use \CActiveForm;
use \app\components\FormCollection;
use \app\models\AR\Game;
use \app\helpers\Data as DataHelper;


class IssuesInfoParams extends Params
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
        return new IssuesInfoParamsItem($this->getScenario());
    }

    private function _getPostKey()
    {
        return CHtml::modelName($this->items->getFirstItem());
    }

    protected function _setAttributesByGameModel()
    {
        $issuesInfo = $this->_gameModel->issuesInfo;
        if ($issuesInfo) {
            $this->items->clear();
            foreach ($issuesInfo as $issueInfo) {
                $item = $this->createItem();
                $item->setAttributes($issueInfo->getAttributes());
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
            $issueInfo = new Game\IssueInfo;
            $issueInfo->setAttributes($attrs);
            if (!$issueInfo->save()) {
                throw new CException($issueInfo->getFirstErrorMessage());
            }
        }
    }

    protected function _update()
    {
        $game = $this->_gameModel;

        // create + update
        $updateIds = array();

        $issueInfoModels = Game\IssueInfo::model()->findAll(array(
            'index' => 'platform_id',
            'condition' => 'game_id = :game_id',
            'params' => array(':game_id' => $game->id),
        ));

        foreach ($this->items as $item) {
            $attrs = $item->getAttributes();
            if (isset($issueInfoModels[$item->platformId])) {
                $issueInfo = $issueInfoModels[$item->platformId];
                $updateIds[] = $issueInfo->id;
            } else {
                $issueInfo = new Game\IssueInfo;
                $attrs['gameId'] = $game->id;
            }
            $issueInfo->setAttributes($attrs);
            if (!$issueInfo->save()) {
                throw new CException($issueInfo->getFirstErrorMessage());
            }
        }

        // delete
        $deleteIds = array();
        foreach ($issueInfoModels as $issueInfo) {
            if (!in_array($issueInfo->id, $updateIds)) {
                $deleteIds[] = $issueInfo->id;
            }
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('id', $deleteIds);
        Game\IssueInfo::model()->deleteAll($criteria);
    }

    protected function _delete()
    {
        Game\IssueInfo::model()->deleteAllByAttributes(array('game_id' => $this->_gameModel->id));
    }
}