<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 13:53
 */

namespace app\models\Form;

use \Yii;
use \app\models\Game as GameModel;


class Game extends \app\components\FormFacade
{
    public $textId;
    public $title;
    public $platformIds;

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
        if ($this->_gameModel->id) {
            $this->_setAttributesByGameModel();
        }
    }

    public function rules()
    {
        return array(
            array('textId, title', 'required'),
            array('textId', 'length', 'max' => 10),
            // TODO: Сделать unique валидацию для update
            array('textId', 'unique', 'className' => '\app\models\Game', 'attributeName' => 'text_id',),
            array('title', 'unique', 'className' => '\app\models\Game'),
            array('textId', 'match', 'pattern' => '/^[a-z][a-z0-9_]+$/',),
            array('title', 'length', 'max' => 50),
        );
    }

    protected function _create()
    {
        $this->_gameModel->setAttributes($this->_getModelAttributesCamelToSnake($this));
        return $this->_gameModel->save();
    }

    protected function _update()
    {
        throw new \Exception(self::SCENARIO_UPDATE);
    }

    private function _setAttributesByGameModel()
    {
        $this->setAttributes($this->_getModelAttributesSnakeToCamel($this->_gameModel));
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