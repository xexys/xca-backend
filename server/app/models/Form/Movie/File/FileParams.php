<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace app\models\Form\Movie;

use \app\models\AR\Movie;
use \app\models\AR\Dictionary;


class FileParams extends Params
{
    public $name;
    public $size;
    public $duration;
    public $formatId = Dictionary\FileFormat::FORMAT_ID_AVI;

    private static $_formatDictionary;

    public function rules()
    {
        return array(
            array('duration, size, formatId', 'required'),
            array('duration, size', 'numerical', 'integerOnly' => true),
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

    protected function _setAttributesByMovieModel()
    {
        $this->setAttributes($this->_movieModel->file->getAttributes());
    }

    protected function _create()
    {
        $this->_checkMovieIsNewRecord();

        $attrs = $this->getAttributes();
        $attrs['movieId'] = $this->_movieModel->id;
        $movieFile = new Movie\File;
        $movieFile->setAttributes($attrs);

        if (!$movieFile->save()) {
            throw new CException($movieFile->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $attrs = $this->getAttributes();
        $movieFile = $this->_movieModel->file;
        $movieFile->setAttributes($attrs);

        if (!$movieFile->save()) {
            throw new CException($movieFile->getFirstErrorMessage());
        }
    }

    protected function _delete()
    {
        Movie\File::model()->deleteAllByAttributes(array('movie_id' => $this->_movieModel->id));
    }
}