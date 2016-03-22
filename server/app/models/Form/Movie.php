<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form;

use \app\models\AR\Game;
use app\components\FormFacadeModel;


class Movie extends FormFacadeModel
{
    public $gameId;
    public $gameTitle;
    public $title;
    public $issueYear;

    protected $_movie;

    public function rules()
    {
        return array(
            array('gameId', 'required', 'safe' => false),
            array('title', 'required'),
            array('title', 'length', 'max' => 100),
            array('gameTitle', 'required', 'on' => self::SCENARIO_CREATE),
            array('gameTitle', 'length', 'max' => 50, 'on' => self::SCENARIO_CREATE),
            array('gameTitle', 'validateGameExist', 'on' => self::SCENARIO_CREATE),
            array('issueYear', 'date', 'format' => APP_VALIDATION_YEAR_FORMAT, 'allowEmpty' => true),
        );
    }

    public function validateGameExist($key)
    {
        $game = Game::model()->findByPk($this->gameId);

        if (!$game) {
            $this->addError($key, 'Игры с таким названием не существует в базе данных.');
        }
    }

    public function setAttributesByPost($postData = array())
    {
        parent::setAttributesByPost($postData);

        if (!$this->gameId) {
            $game = Game::model()->findByAttributes(array('title' => $this->gameTitle));

            if ($game) {
                $this->gameId = $game->id;
            }
        }
    }

    protected function _initByParams($params)
    {
        $movie = $params['movie'];
        $game = $params['game'];

        $this->_movie = $movie;

        $this->setAttributes(array(
            'gameId' => $game->id,
            'gameTitle' => $game->title,
            'title' => $movie->title,
            'issueYear' => $movie->issue_year
        ), false);
    }

    protected function _create()
    {
        $attrs = $this->getAttributes();

        $this->_movie->setAttributes($attrs);

        if (!$this->_movie->save()) {
            throw new CException($this->_movie->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $this->_create();
    }
}
