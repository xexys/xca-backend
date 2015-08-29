<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form\Movie;

use \app\models\AR\Game;


class MainParams extends Params
{
    public $gameTitle;
    public $title;

    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 100),
            array('gameTitle', 'required', 'on' => self::SCENARIO_CREATE),
            array('gameTitle', 'length', 'max' => 50, 'on' => self::SCENARIO_CREATE),
            array('gameTitle', 'validateGameTitleExist', 'on' => self::SCENARIO_CREATE),
        );
    }

    public function validateGameTitleExist($key)
    {
        $gameTitle = $this->gameTitle;
        $game = \app\models\AR\Game::model()->findByAttributes(array('title' => $gameTitle));

        if ($game && strtolower($game->title) == strtolower($gameTitle)) {
            return;
        }
        $this->addError($key, 'Игры с таким названием не существует в базе данных.');
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

    protected function _delete()
    {
        $this->_movieModel->delete();
    }
}
