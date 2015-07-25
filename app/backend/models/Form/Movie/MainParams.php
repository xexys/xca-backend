<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace backend\models\Form\Movie;


class MainParams extends \common\components\FormModel
{
    const FORMAT_ID_AVI = 1;
    const FORMAT_ID_MP4 = 3;

    public $gameTitle;
    public $title;
    public $gameId;
    public $filename;
    public $filesize;
    public $duration;
    public $formatId = self::FORMAT_ID_AVI;

    private static $_formatDictionary;

    public function rules()
    {
        return array(
            array('title, gameTitle, duration', 'required'),
            array('filesize, duration', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('gameTitle', 'length', 'max' => 50),
            array('filename', 'length', 'max' => 50),
            array('formatId', 'in', 'range' => array_keys($this->getFormatDictionary()), 'allowEmpty' => false),
            array('gameId', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'update'),
            array('gameTitle', 'validateGameTitleExist', 'on' => 'create'),
        );
    }

    public function validateGameTitleExist($key)
    {
        $gameTitle = strtolower($this->gameTitle);
        $game = \common\models\Game::model()->findByAttributes(array('title' => $gameTitle));

        if ($game && strtolower($game->title) == $gameTitle) {
            return;
        }
        $this->addError($key, 'Игры с таким названием не существует в базе данных.');
    }

    public function getFormatDictionary()
    {
        if (self::$_formatDictionary === null) {
            self::$_formatDictionary = array();

            $data = \common\models\Dictionary\FileFormat::model()->findAll(array(
                'order'=>'t.extension ASC'
            ));

            foreach ($data as $item) {
                self::$_formatDictionary[$item->id] = strtoupper($item->extension);
            }
        }
        return self::$_formatDictionary;
    }
} 