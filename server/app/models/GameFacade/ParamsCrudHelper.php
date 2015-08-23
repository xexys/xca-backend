<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.08.15
 * Time: 16:15
 */

namespace app\models\GameFacade;

use \app\components\interfaces\FacadeModelCrudHelper;
use \app\models\AR\Game;
use \Exception;
use \CException;


class ParamsCrudHelper implements FacadeModelCrudHelper
{
    private $_mainParams;
    private $_platformsInfoParams;
    
    private $_game;

    public function __construct($game, $params)
    {
        $this->_mainParams = $params['mainParams'];
        $this->_platformsInfoParams = $params['platformsInfoParams'];
        
        $this->_game = $game;
    }

    public function create()
    {
        if ($this->_mainParams) {
            $this->_createMainParams();
        }
        if ($this->_platformsInfoParams) {
            $this->_createPlatformsInfoParams();
        }
    }

    public function update()
    {
        if ($this->_mainParams) {
            $this->_updateMainParams();
        }
        if ($this->_platformsInfoParams) {
            $this->_updatePlatformsInfoParams();
        }
    }

    public function delete()
    {
        $this->_deletePlatformsInfoParams();
        $this->_deleteMainParams();
    }

// ----- PRIVATE ------------------------------------------------------------------------------------------------------

    private function _createMainParams()
    {
        $this->_game->setAttributes($this->_mainParams->getAttributes());

        if (!$this->_game->save()) {
            throw new CException($this->_game->getFirstErrorMessage());
        }
    }

    private function _createPlatformsInfoParams()
    {
        $this->_checkGameIsNewRecord();

        foreach ($this->_platformsInfoParams->items as $item) {
            $attrs = $item->getAttributes();
            $attrs['gameId'] = $this->_game->id;
            $platformInfo = new Game\PlatformInfo;
            $platformInfo->setAttributes($attrs);
            if (!$platformInfo->save()) {
                throw new CException($platformInfo->getFirstErrorMessage());
            }
        }
    }

    private function _updateMainParams()
    {
        $this->_createMainParams();
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

        foreach ($this->_platformsInfoParams->items as $item) {
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

    private function _deleteMainParams()
    {
        $this->_game->delete();
    }

    private function _deletePlatformsInfoParams()
    {
        Game\PlatformInfo::model()->deleteAllByAttributes(array('game_id' => $this->_game->id));
    }

    private function _checkGameIsNewRecord()
    {
        if ($this->_game->getIsNewRecord()) {
            throw new CException('The game must not be a new.');
        }
    }
}