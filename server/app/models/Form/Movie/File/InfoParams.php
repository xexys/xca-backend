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
    public $movieId;
    public $movieTitle;
    public $type;
    public $comment;

    protected $_movieFile;

    public function rules()
    {
        return array(
            array('movieTitle', 'required', 'on' => self::SCENARIO_CREATE),
            array('movieId, type', 'required'),
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

        $this->setAttributes(array(
            'movieId' => $movie->id,
            'type' => $this->_movieFile->type ?: Movie\File::TYPE_MAIN,
            'comment' => $this->_movieFile->comment
        ));
    }

    protected function _create()
    {
        $attrs = array(
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
            Movie\File::TYPE_MAIN => 'Основной',
            Movie\File::TYPE_SOURCE => 'Исходник',
            Movie\File::TYPE_LOCALIZATION=> 'Локализация',
        );
    }

    private function _getTypeDictionaryKeys()
    {
        return array_keys($this->getTypeDictionary());
    }
}
