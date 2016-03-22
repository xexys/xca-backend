<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form\Movie\File;

use \app\models\AR\Movie;

class InfoParams extends Params
{
    const FILE_TYPE_MAIN = 1;
    const FILE_TYPE_SOURCE = 2;
    const FILE_TYPE_LOCALIZATION = 3;

    public $name;
    public $movieId;
    public $movieTitle;
    public $type = self::FILE_TYPE_MAIN;
    public $comment;

    protected $_movieFile;

    public function rules()
    {
        return array(
            array('name', 'length', 'max' => 50),
            array('movieId, type', 'required'),
            array('movieTitle', 'required', 'on' => self::SCENARIO_CREATE),
            array('movieId, movieTitle', 'validateMovieExist'),
            array('type', 'in', 'range' => $this->_getTypeDictionaryKeys()),
            array('comment', 'length', 'max' => 500),
        );
    }

    public function validateMovieExist($key)
    {
        $movie = Movie::model()->findByPk($this->movieId);

        if (!$movie) {
            $this->addError($key, 'Такого ролика не существует в базе данных.');
        }
    }

    protected function _initByParams($params)
    {
        parent::_initByParams($params);

        $movie = $params['movie'];
        $movieFileType = $params['movieFileType'] ?: $this->type;

        $this->setAttributes(array(
            'movieId' => $movie->id,
            'type' => $movieFileType,
            'comment' => $this->_movieFile->comment
        ));
    }

    protected function _create()
    {
        $attrs = array(
            'name' => $this->name,
            'movieId' => $this->movieId,
            'type' => $this->type,
            'comment' => $this->comment,
        );

        $this->_movieFile->setAttributes($attrs);

        if (!$this->_movieFile->save()) {
            throw new CException($this->_movieFile->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $this->_create();
    }

    public function getTypeDictionary()
    {
        return array(
            self::FILE_TYPE_MAIN => 'Основной',
            self::FILE_TYPE_SOURCE => 'Исходник',
            self::FILE_TYPE_LOCALIZATION => 'Локализация'
        );
    }

    private function _getTypeDictionaryKeys()
    {
        return array_keys($this->getTypeDictionary());
    }
}
