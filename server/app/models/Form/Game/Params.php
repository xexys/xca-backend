<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form\Game;

use \app\components\FormModel;


abstract class Params extends FormModel
{
    protected $_gameModel;

    public function __construct($game)
    {
        $scenario = $game->getIsNewRecord() ? self::SCENARIO_CREATE : self::SCENARIO_UPDATE;
        $this->setScenario($scenario);
        $this->_gameModel = $game;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        if ($this->getScenario() === self::SCENARIO_UPDATE) {
            $this->_setAttributesByGameModel();
        }
    }

    public function getFormKeys()
    {
        return $this->getSafeAttributeNames();
    }

    abstract protected function _setAttributesByGameModel();
}