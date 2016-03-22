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


class VideoParams extends Params
{
    const FRAME_RATE_MODE_CONSTANT = 0;
    const FRAME_RATE_MODE_VARIABLE = 1;

    public $formatId = Dictionary\VideoFormat::FORMAT_ID_FOURCC_H264;
    public $width;
    public $height;
    public $bitRate;
    public $frameRate;
    public $frameRateMode = self::FRAME_RATE_MODE_CONSTANT;

    private static $_formatDictionary;

    public function rules()
    {
        return array(
            array('width, height, bitRate, frameRate, frameRateMode, formatId', 'required'),
            array('width, height, bitRate', 'numerical', 'integerOnly' => true),
            array('frameRate', 'in', 'range' => array_keys($this->getFrameRateDictionary())),
            array('frameRateMode', 'in', 'range' => array_keys($this->getFrameRateModeDictionary())),
            array('formatId', 'in', 'range' => array_keys($this->getFormatDictionary())),
        );
    }

    public function getDictionary($key)
    {
        $data = array();

        switch ($key) {
            case 'formatId':
                $data = $this->getFormatDictionary();
                break;
            case 'frameRate':
                $data = $this->getFrameRateDictionary();
                break;
            case 'frameRateMode':
                $data = $this->getFrameRateModeDictionary();
                break;
        }

        return $data;
    }

    public function getFrameRateDictionary()
    {
        $frameRates = array(
            '24',
            '29.97',
            '30',
        );
        return array_combine($frameRates, $frameRates);
    }

    public static function getFrameRateModeDictionary()
    {
        return array(
            self::FRAME_RATE_MODE_CONSTANT => 'CFR',
            self::FRAME_RATE_MODE_VARIABLE => 'VFR',
        );
    }

    public static function getFormatDictionary()
    {
        if (self::$_formatDictionary === null) {
            self::$_formatDictionary = array();

            $data = Dictionary\VideoFormat::model()->findAll(array(
                'order'=>'t.name ASC'
            ));

            // Подисчитываем вхождение названий
            $names = array();
            foreach ($data as $item) {
                $names[] = $item->name;
            }
            $counts = array_count_values($names);

            foreach ($data as $item) {
                $format = $item->name;
                if ($counts[$item->name] > 1) {
                    $format .= ' (' . $item->fourcc . ')';
                }
                self::$_formatDictionary[$item->id] = $format;
            }
        }
        return self::$_formatDictionary;
    }

    protected function _initByParams($params)
    {
        parent::_initByParams($params);

        if ($this->_movieFile->videoParams) {
            $attrs = $this->_movieFile->videoParams->getAttributes();
            $this->setAttributes($attrs);
        }
    }

    protected function _create()
    {
        $attrs = $this->getAttributes();
        $attrs['movieFileId'] = $this->_movieFile->id;

        $model = new Movie\File\VideoParams;
        $model->setAttributes($attrs);

        if (!$model->save()) {
            throw new CException($model->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $attrs = $this->getAttributes();

        $model = $this->_movieFile->videoParams;
        $model->setAttributes($attrs);

        if (!$model->save()) {
            throw new CException($model->getFirstErrorMessage());
        }
    }

    protected function _delete()
    {
        Movie\Video::model()->deleteAllByAttributes(array('movie_id' => $this->_movieModel->id));
    }
}
