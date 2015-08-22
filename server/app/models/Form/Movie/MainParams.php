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
}