<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form\Movie;


class MainParams extends \app\components\FormModel
{
    public $gameTitle;
    public $title;

    public function rules()
    {
        return array(
            array('title, gameTitle', 'required'),
            array('title', 'length', 'max' => 100),
            array('gameTitle', 'length', 'max' => 50),
            array('gameTitle', 'validateGameTitleExist', 'on' => self::SCENARIO_CREATE),
        );
    }

    public function validateGameTitleExist($key)
    {
        $gameTitle = strtolower($this->gameTitle);
        $game = \app\models\Game::model()->findByAttributes(array('title' => $gameTitle));

        if ($game && strtolower($game->title) == $gameTitle) {
            return;
        }
        $this->addError($key, '»гры с таким названием не существует в базе данных.');
    }
}