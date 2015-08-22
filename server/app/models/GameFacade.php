<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.08.15
 * Time: 0:30
 */

namespace app\models;

use \CException;
use \app\components\Model;


class GameFacade extends Model
{
    public $mainParams;
    public $platformInfoParams;

    private $_gameModel;


    public function rules()
    {
        return array(
            array('mainParams, platformInfoParams', '\app\components\validators\ParamsValidator', 'on' => self::SCENARIO_CREATE),
            array('mainParams, platformInfoParams', '\app\components\validators\ParamsValidator', 'allowEmpty' => true, 'on' => self::SCENARIO_UPDATE),
        );
    }

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

    protected function _create()
    {
        $this->_createMainParams();
        $this->_createPlatformInfoParams();
    }

    protected function _update()
    {
        if ($this->mainParams) {
            $this->_updateMainParams();
        }
        if ($this->platformInfoParams) {
            $this->_updatePlatformInfoParams();
        }
    }

    private function _createMainParams()
    {
        $game = $this->_gameModel;
        $game->setAttributes($this->mainParams->getAttributes());

        if (!$game->save()) {
            throw new CException($game->getFirstErrorMessage());
        }
    }

    private function _updateMainParams()
    {
        $this->_createMainParams();
    }

    private function _createPlatformInfoParams()
    {
        if ($this->_gameModel->getIsNewRecord()) {
            throw new CException('The game must not be a new.');
        }

        foreach ($this->platformInfoParams->items as $item) {
            $attrs = $item->getAttributes();
            $attrs['gameId'] = $this->_gameModel->id;
            $platformInfo = new Game\PlatformInfo;
            $platformInfo->setAttributes($attrs);
            if (!$platformInfo->save()) {
                throw new CException($platformInfo->getFirstErrorMessage());
            }
        }
    }

    private function _updatePlatformInfoParams()
    {
        $game = $this->_gameModel;

        // create + update
        $updateIds = array();

        $platformInfoModels = Game\PlatformInfo::model()->findAll(array(
            'index' => 'platform_id',
            'condition' => 'game_id = :game_id',
            'params' => array(':game_id' => $game->id),
        ));

        foreach ($this->platformInfoParams->items as $item) {
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
}