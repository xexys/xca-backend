<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:01
 */

namespace app\models\Form\Game;

use \app\components\FormModel;


class MainParams extends FormModel
{
    public $id;
    public $textId;
    public $title;

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
        if ($this->getScenario() === self::SCENARIO_UPDATE) {
            $this->_setAttributesByGameModel();
        }
    }

    public function rules()
    {
        return array(
            array('textId, title', 'required'),
            array('textId', 'length', 'max' => 10),
            array('textId', 'validateUniqueInDatabase', 'className' => '\app\models\AR\Game', 'attributeName' => 'text_id'),
            array('title', 'validateUniqueInDatabase', 'className' => '\app\models\AR\Game'),
            array('textId', 'match', 'pattern' => '/^\s*[a-z][a-z0-9_]+\s*$/',),
            array('title', 'length', 'max' => 50),
            array('id', 'required', 'safe' => false, 'on' => self::SCENARIO_UPDATE),
        );
    }

    public function getFormKeys()
    {
        return $this->getSafeAttributeNames();
    }

    private function _setAttributesByGameModel()
    {
        // safeOnly = false - чтобы установить значение id
        $this->setAttributes($this->_gameModel->getAttributes(), false);
    }
}
