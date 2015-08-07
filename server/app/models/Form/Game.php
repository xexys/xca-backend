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
                $attributes = $platformInfoParams->getAttributes();
                $attributes['game_id'] = $game->id;
                $platformInfoModel = $this->_createPlatformInfoModel();
                $platformInfoModel->setAttributes($attributes);
                $platformInfoModel->save();
            }

            $transaction->commit();

            return true;

        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    private function _createPlatformInfoModel()
    {
        return new GameModel\PlatformInfo();
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
                $attributes = $platformInfoParams->getAttributes();
                if ($platformInfoParams->id) {
                    $platformInfoModel = $platformInfoModels[$platformInfoParams->id];
                    $updateIds[] = $platformInfoParams->id;
                } else {
                    $platformInfoModel = $this->_createPlatformInfoModel();
                    $attributes['gameId'] = $game->id;
                }
                $platformInfoModel->setAttributes($attributes);
                $platformInfoModel->save();
            }

            foreach (array_diff(array_keys($platformInfoModels), $updateIds) as $key) {
                $platformInfoModels[$key]->delete();
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

        foreach ($this->_gameModel->platforms as $n => $platformModel) {
            if (!isset($this->platformInfoParamsArray[$n])) {
                $this->platformInfoParamsArray[$n] = $this->_createPlatformInfoParams();
            }
            $this->platformInfoParamsArray[$n]->setAttributes($platformModel->getAttributes(), false);
        }
    }

    private function _createPlatformInfoParams()
    {
        return new Game\PlatformInfoParams($this->getScenario());
    }

    private function _getGameModelById($id)
    {
        $game = GameModel::model()->with(array('platforms'))->findByPk($id);
        if (!$game) {
            // TODO: Сделать нормальное исключение
            throw new \CHttpException(404, 'Модель не найдена');
        }
        return $game;
    }
}