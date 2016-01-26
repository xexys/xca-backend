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
    public $gameTitle;
    public $title;
    public $issueYear;

    protected $_movieModel;

    public function __construct($scenario, $movieModel)
    {
        $this->_movieModel = $movieModel;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        $this->_setAttributesByMovieModel();
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

        if (!$game) {
            $this->addError($key, 'Игры с таким названием не существует в базе данных.');
        }
    }

    public function getFormKeys()
    {
        return $this->getSafeAttributeNames();
    }

    protected function _setAttributesByMovieModel()
    {
        $this->setAttributes($this->_movieModel->getAttributes());
    }

    protected function _create()
    {
        $game = Game::model()->findByAttributes(array('title' => $this->gameTitle));

        $attrs = $this->getAttributes();
        $attrs['gameId'] = $game->id;

        $movie = $this->_movieModel;
        $movie->setAttributes($attrs);

        if (!$movie->save()) {
            throw new CException($movie->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $this->_movieModel->setAttributes($this->getAttributes());

        if (!$this->_movieModel->save()) {
            throw new CException($this->_movieModel->getFirstErrorMessage());
        }
    }
}
