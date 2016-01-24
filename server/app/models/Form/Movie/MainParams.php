<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form\Movie;

use \app\models\AR\Game;
use app\components\FormFacadeModel;


class MainParams extends FormFacadeModel
{
    public $gameTitle;
    public $title;
    public $issueYear;

    protected $_movie;

    public function __construct($scenario, $movie)
    {
        $this->_movie = $movie;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        if ($this->getScenario() === self::SCENARIO_UPDATE) {
            $this->_setAttributesByMovieModel();
        }
    }

    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 100),
            array('gameTitle', 'required', 'on' => self::SCENARIO_CREATE),
            array('gameTitle', 'length', 'max' => 50, 'on' => self::SCENARIO_CREATE),
            array('gameTitle', 'validateGameTitleExist', 'on' => self::SCENARIO_CREATE),
            array('issueYear', 'date', 'format' => APP_VALIDATION_YEAR_FORMAT, 'allowEmpty' => true),
        );
    }

    public function validateGameTitleExist($key)
    {
        $gameTitle = $this->gameTitle;
        $game = Game::model()->findByAttributes(array('title' => $gameTitle));

        if ($game && strtolower($game->title) == strtolower($gameTitle)) {
            return;
        }
        $this->addError($key, 'Игры с таким названием не существует в базе данных.');
    }

    public function getFormKeys()
    {
        return $this->getSafeAttributeNames();
    }

    protected function _setAttributesByMovieModel()
    {
        $this->setAttributes($this->_movie->getAttributes());
    }

    protected function _create()
    {
        $game = Game::model()->findByAttributes(array('title' => $this->gameTitle));

        $attrs = $this->getAttributes();
        $attrs['gameId'] = $game->id;
        $movie = $this->_movie;
        $movie->setAttributes($attrs);

        if (!$movie->save()) {
            throw new CException($movie->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $this->_movie->setAttributes($this->getAttributes());

        if (!$this->_movie->save()) {
            throw new CException($this->_movie->getFirstErrorMessage());
        }
    }

    protected function _checkMovieIsNewRecord()
    {
        if ($this->_movie->getIsNewRecord()) {
            throw new CException('The movie must not be a new.');
        }
    }

    protected function _delete()
    {
        $this->_movie->delete();
    }
}
