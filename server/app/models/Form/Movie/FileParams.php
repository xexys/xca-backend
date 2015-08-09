<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace app\models\Form\Movie;

use \app\models\Dictionary;


class FileParams extends \app\components\FormModel
{
    public $name;
    public $size;
    public $duration;
    public $formatId = Dictionary\FileFormat::FORMAT_ID_AVI;

    private static $_formatDictionary;

    public function rules()
    {
        return array(
            array('duration, formatId', 'required'),
            array('size, duration', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('formatId', 'in', 'range' => array_keys($this->getFormatDictionary())),
        );
    }

    public function getFormatDictionary()
    {
        if (self::$_formatDictionary === null) {
            self::$_formatDictionary = array();

            $data = Dictionary\FileFormat::model()->findAll(array(
                'order'=>'t.extension ASC'
            ));

            foreach ($data as $item) {
                self::$_formatDictionary[$item->id] = strtoupper($item->extension);
            }
        }
        return self::$_formatDictionary;
    }
} 