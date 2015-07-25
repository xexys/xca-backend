<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace backend\models\Form\Movie;


class MainParams extends \CFormModel
{
    public $gameTitle;
    public $gameId;
    public $filename;
    public $filesize;
    public $duration;
    public $formatId;

    public function rules()
    {
        return array(
            array('gameTitle, gameId, filename, filesize, duration, formatId', 'required'),
            array('gameId, filesize, duration, formatId', 'numerical', 'integerOnly' => true),
            array('gameTitle', 'length', 'max' => 50),
            array('gameTitle', 'validateGameTitleExits'),
            array('filename', 'length', 'max' => 50),
        );
    }

    public function validateGameTitleExits($key)
    {
        $game = \common\models\Game::model()->findByOneOfAttributes(array(
            'id' => $this->gameId,
            'title' => $this->gameTitle,
        ));

        if ($game && strtolower($game->title) == strtolower($this->gameTitle)) {
            return;
        }
        $this->addError($key, 'Игры с таким названием не существует в базе данных.');
    }

} 