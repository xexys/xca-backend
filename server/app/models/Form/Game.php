<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 13:53
 */

namespace app\models\Form;

use \Yii;
use \CHtml;
use \CActiveForm;
use \app\models\Game as GameModel;
use \app\helpers\Data as DataHelper;
use \Exception;
use \CException;
use \app\components\ObjectCollection;


class Game extends \app\components\FormFacade
{
    public $mainParams;
    public $platformInfoParamsCollection;

    private $_gameModel;

    public function __construct($gameId = null)
    {
        if ($gameId) {
            $scenario = self::SCENARIO_UPDATE;
            $game = $this->_getGameModelById($gameId);
        } else {
            $scenario = self::SCENARIO_CREATE;
            $game = new GameModel();
        }

        $this->setScenario($scenario);
        $this->_gameModel = $game;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        $scenario = $this->getScenario();

        $this->mainParams = new Game\MainParams($scenario);
        $this->platformInfoParamsCollection = new ObjectCollection;
        $this->platformInfoParamsCollection[] = $this->_createPlatformInfoParams();

        if ($scenario === self::SCENARIO_UPDATE) {
            $this->_setAttributesByGameModel();
        }
    }

    public function rules()
    {
        return array(
            array('mainParams, platformInfoParamsCollection', 'validateParams'),
        );
    }

    public function validateParams($key)
    {
        $models = $this->$key;

        if (!is_array($models) && !$models instanceof ObjectCollection) {
            $models = array($models);
        }

        foreach ($models as $model) {
            if (!$model->validate()) {
                $this->addError($key, 'При заполнении формы возникли ошибки.');
            }
        }
    }

    public function setAttributesByPost()
    {
        $request = Yii::app()->getRequest();

        $mainPostData = $request->getPost($this->_getMainParamsInfoPostKey());
        $this->mainParams->setAttributes(DataHelper::trimRecursive($mainPostData));

        $platformInfoPostData = Yii::app()->getRequest()->getPost($this->_getPlatformInfoParamsPostKey());
        if ($platformInfoPostData) {
            $this->platformInfoParamsCollection->clear();
            foreach ($platformInfoPostData as $n => $data) {
                $platformInfoParams = $this->_createPlatformInfoParams();
                $platformInfoParams->setAttributes(DataHelper::trimRecursive($data));
                // Важно сохранить номер, чтобы правильно сработала ajax валидация
                $this->platformInfoParamsCollection[$n] = $platformInfoParams;
            }
        }
    }

    public function getMainParamsKeys()
    {
        return $this->mainParams->getSafeAttributeNames();
    }

    public function getPlatformInfoParamsKeys()
    {
        return $this->platformInfoParamsCollection->getFirstItem()->getSafeAttributeNames();
    }

    public function getAjaxValidationResponseContent()
    {
        $json1 = json_decode(CActiveForm::validate($this->mainParams, null, false), true);
        $json2 = json_decode(CActiveForm::validateTabular($this->platformInfoParamsCollection->toArray(), null, false), true);
        return json_encode(array_merge($json1, $json2));
    }

    protected function _create()
    {
        $game = $this->_gameModel;

        $game->setAttributes($this->mainParams->getAttributes());

        $transaction = $this->getDb()->beginTransaction();

        try {
            if (!$game->save()) {
                throw new CException($game->getFirstErrorMessage());
            }

            foreach ($this->platformInfoParamsCollection as $platformInfoParams) {
                $attrs = $platformInfoParams->getAttributes();
                $attrs['game_id'] = $game->id;
                $platformInfo = $this->_createPlatformInfo();
                $platformInfo->setAttributes($attrs);
                if (!$platformInfo->save()) {
                    throw new CException($platformInfo->getFirstErrorMessage());
                }
            }

            $transaction->commit();
            return true;

        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    protected function _update()
    {
        $game = $this->_gameModel;

        $game->setAttributes($this->mainParams->getSafeAttributes());

        $transaction = $this->getDb()->beginTransaction();

        try {
            if (!$game->save()) {
                throw new CException($game->getFirstErrorMessage());
            }

            // create + update
            $updateIds = array();

            $platformInfoModels = GameModel\PlatformInfo::model()->findAll(array(
                'index' => 'platform_id',
                'condition' => 'game_id = :game_id',
                'params' => array(':game_id' => $game->id),
            ));

            foreach ($this->platformInfoParamsCollection as $platformInfoParams) {
                $attrs = $platformInfoParams->getAttributes();
                if (isset($platformInfoModels[$platformInfoParams->platformId])) {
                    $platformInfo = $platformInfoModels[$platformInfoParams->platformId];
                    $updateIds[] = $platformInfo->id;
                } else {
                    $platformInfo = $this->_createPlatformInfo();
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

            GameModel\PlatformInfo::model()->deleteAll($criteria);

            $transaction->commit();
            return true;

        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    private function _setAttributesByGameModel()
    {
        // safeOnly = false - чтобы установить значение id
        $this->mainParams->setAttributes($this->_gameModel, false);

        $platformsInfo = $this->_gameModel->platformsInfo;
        if ($platformsInfo) {
            $this->platformInfoParamsCollection->clear();
            foreach ($platformsInfo as $platformInfo) {
                $platformInfoParams = $this->_createPlatformInfoParams();
                $platformInfoParams->setAttributes(DataHelper::trimRecursive($platformInfo->getAttributes()));
                $this->platformInfoParamsCollection[] = $platformInfoParams;
            }
        }
    }

    private function _createPlatformInfoParams()
    {
        return new Game\PlatformInfoParams($this->getScenario());
    }

    private function _createPlatformInfo()
    {
        return new GameModel\PlatformInfo();
    }

    private function _getMainParamsInfoPostKey()
    {
        return CHtml::modelName($this->mainParams);
    }

    private function _getPlatformInfoParamsPostKey()
    {
        return CHtml::modelName($this->platformInfoParamsCollection->getFirstItem());
    }

    private function _getGameModelById($id)
    {
        $game = GameModel::model()->with(array('platformsInfo'))->findByPk($id);
        if (!$game) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $game;
    }
}