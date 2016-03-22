<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace app\models\Form\Movie\File;

use \app\models\AR\Movie;
use \app\models\AR\Dictionary;


class MainParams extends Params
{
    public $size;
    public $duration;
    public $formatId = Dictionary\FileFormat::FORMAT_ID_AVI;
    public $md5;

    private static $_formatDictionary;

    public function rules()
    {
        return array(
            array('duration, size, formatId', 'required'),
            array('duration, size', 'numerical', 'integerOnly' => true),
            array('formatId', 'in', 'range' => array_keys($this->getFormatDictionary())),
            array('md5', 'length', 'min' => 32, 'max' => 32),
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

    protected function _initByParams($params)
    {
        parent::_initByParams($params);

        if ($this->_movieFile->mainParams) {
            $attrs = $this->_movieFile->mainParams->getAttributes();
            $this->setAttributes($attrs);
        }
    }

    protected function _create()
    {
        $attrs = $this->getAttributes();
        $attrs['movieFileId'] = $this->_movieFile->id;

        $model = new Movie\File\MainParams;
        $model->setAttributes($attrs);

        if (!$model->save()) {
            throw new CException($model->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $attrs = $this->getAttributes();

        $model = $this->_movieFile->mainParams;
        $model->setAttributes($attrs);

        if (!$model->save()) {
            throw new CException($model->getFirstErrorMessage());
        }
    }
}
