<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.08.15
 * Time: 0:30
 */

namespace app\models;

use \CException;
use \app\components\FacadeModel;
use \app\models\AR\Game;


class GameFacade extends FacadeModel
{
    public $mainParams;
    public $platformsInfoParams;

    private $_game;

    public function __construct($game)
    {
        $scenario = $game->getIsNewRecord() ? self::SCENARIO_CREATE : self::SCENARIO_UPDATE;
        $this->setScenario($scenario);
        $this->_game = $game;

        parent::__construct($scenario);
    }

    public function rules()
    {
        return array(
            array('mainParams, platformsInfoParams', '\app\components\validators\ModelsValidator', 'on' => self::SCENARIO_CREATE),
            array('mainParams, platformsInfoParams', '\app\components\validators\ModelsValidator', 'allowEmpty' => true, 'on' => self::SCENARIO_UPDATE),
        );
    }

    protected function _create()
    {
        $this->_createMainParams();
        $this->_createPlatformsInfoParams();
    }

    protected function _update()
    {
        if ($this->mainParams) {
            $this->_updateMainParams();
        }
        if ($this->platformsInfoParams) {
            $this->_updatePlatformsInfoParams();
        }
    }

    private function _createMainParams()
    {
        $this->_game->setAttributes($this->mainParams->getAttributes());

        if (!$this->_game->save()) {
            throw new CException($this->_game->getFirstErrorMessage());
        }
    }

    private function _updateMainParams()
    {
        $this->_createMainParams();
    }

    private function _createPlatformsInfoParams()
    {
        if ($this->_game->getIsNewRecord()) {
            throw new CException('The game must not be a new.');
        }

        foreach ($this->platformsInfoParams->items as $item) {
            $attrs = $item->getAttributes();
            $attrs['gameId'] = $this->_game->id;
            $platformInfo = new Game\PlatformInfo;
            $platformInfo->setAttributes($attrs);
            if (!$platformInfo->save()) {
                throw new CException($platformInfo->getFirstErrorMessage());
            }
        }
    }

    private function _updatePlatformsInfoParams()
    {
        $game = $this->_game;

        // create + update
        $updateIds = array();

        $platformInfoModels = Game\PlatformInfo::model()->findAll(array(
            'index' => 'platform_id',
            'condition' => 'game_id = :game_id',
            'params' => array(':game_id' => $game->id),
        ));

        foreach ($this->platformsInfoParams->items as $item) {
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