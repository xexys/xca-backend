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


class Game extends \app\components\FormFacade
{
    public $mainParams;
    public $platformInfoParamsArray;

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

        $this->mainParams = new Game\MainParams($this->getScenario());
        $this->platformInfoParamsArray[] = $this->_createPlatformInfoParams();

        if ($this->_gameModel->id) {
            $this->_setAttributesByGameModel();
        }
    }

    public function rules()
    {
        return array(
            array('mainParams, platformInfoParamsArray', 'validateParams'),
        );
    }

    public function validateParams($key)
    {
        $models = $this->$key;
        if (!is_array($models)) {
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

        $mainPostData = $request->getPost(CHtml::modelName($this->mainParams));
        $this->mainParams->setAttributes(DataHelper::trimRecursive($mainPostData));

        $platformInfoPostData = Yii::app()->getRequest()->getPost(CHtml::modelName($this->platformInfoParamsArray[0]));
        foreach ($platformInfoPostData as $n => $data) {
            if (!isset($this->platformInfoParamsArray[$n])) {
                $this->platformInfoParamsArray[$n] = $this->_createPlatformInfoParams();
            }
            $this->platformInfoParamsArray[$n]->setAttributes(DataHelper::trimRecursive($data));
        }
    }

    public function getMainParamsKeys()
    {
        return $this->mainParams->getSafeAttributeNames();
    }

    public function getPlatformInfoParamsKeys()
    {
        return $this->platformInfoParamsArray[0]->getSafeAttributeNames();
    }

    public function getAjaxValidationResponseContent()
    {
        $json1 = json_decode(CActiveForm::validate($this->mainParams, null, false), true);
        $json2 = json_decode(CActiveForm::validateTabular($this->platformInfoParamsArray, null, false), true);
        return json_encode(array_merge($json1, $json2));
    }

    protected function _create()
    {
        $game = $this->_gameModel;

        $game->setAttributes($this->mainParams->getAttributes());

        $transaction = $this->getDb()->beginTransaction();

        try {
            $game->save();

            foreach ($this->platformInfoParamsArray as $platformInfoParams) {
                $attrs = $platformInfoParams->getAttributes();
                $attrs['game_id'] = $game->id;
                $platformInfo = $this->_createPlatformInfo();
                $platformInfo->setAttributes($attrs);
                $platformInfo->save();
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

        $game->setAttributes($this->mainParams->getAttributes());

        $transaction = $this->getDb()->beginTransaction();

        try {
            $game->save();

            $platformInfoModels = GameModel\PlatformInfo::model()->findAll(array(
                'index' => 'id',
                'condition' => 'game_id = :game_id',
                'params' => array(':game_id' => $game->id),
            ));

            $updateIds = array();

            foreach ($this->platformInfoParamsArray as $platformInfoParams) {
                $attrs = $platformInfoParams->getAttributes();
                if ($platformInfoParams->id) {
                    $platformInfo = $platformInfoModels[$platformInfoParams->id];
                    $updateIds[] = $platformInfoParams->id;
                } else {
                    $platformInfo = $this->_createPlatformInfo();
                    $attrs['gameId'] = $game->id;
                }
                $platformInfo->setAttributes($attrs);
                $platformInfo->save();
            }

            $deleteIds = array_diff(array_keys($platformInfoModels), $updateIds);
            foreach ($deleteIds as $id) {
                $platformInfoModels[$id]->delete();
            }

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

        foreach ($this->_gameModel->platformsInfo as $n => $platformInfo) {
            if (!isset($this->platformInfoParamsArray[$n])) {
                $this->platformInfoParamsArray[$n] = $this->_createPlatformInfoParams();
            }
            $this->platformInfoParamsArray[$n]->setAttributes($platformInfo->getAttributes(), false);
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