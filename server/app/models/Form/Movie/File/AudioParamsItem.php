<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace app\models\Form\Movie\File;

use \app\models\AR\Dictionary;
use \app\components\FormModel;


class AudioParamsItem extends FormModel
{
    public $trackNumber;
    public $formatId = Dictionary\AudioFormat::FORMAT_ID_MP3;
    public $bitRate;
    public $bitRateMode = Dictionary\AudioFormat::BIT_RATE_MODE_CONSTANT;
    public $sampleRate = 44100;
    public $channels = '2.0';
    public $languageId = Dictionary\Language::LANGUAGE_ID_ENG;

    private static $_formatDictionary;
    private static $_languageDictionary;


    public function rules()
    {
        return array(
            array('trackNumber, bitRate, bitRateMode, formatId, channels, languageId, sampleRate', 'required'),
            array('bitRate, trackNumber', 'numerical', 'integerOnly' => true),
            array('trackNumber', 'validateUniqueInCollection'),
            array('bitRateMode', 'in', 'range' => array_keys($this->getBitRateModeDictionary())),
            array('formatId', 'in', 'range' => array_keys($this->getFormatDictionary())),
            array('channels', 'in', 'range' => array_keys($this->getChannelDictionary())),
            array('languageId', 'in', 'range' => array_keys($this->getLanguageDictionary())),
            array('sampleRate', 'in', 'range' => array_keys($this->getSampleRateDictionary())),
        );
    }

    public function getDictionary($key)
    {
        $data = array();

        switch ($key) {
            case 'formatId':
                $data = $this->getFormatDictionary();
                break;
            case 'bitRateMode':
                $data = $this->getBitRateModeDictionary();
                break;
            case 'channels':
                $data = $this->getChannelDictionary();
                break;
            case 'languageId':
                $data = $this->getLanguageDictionary();
                break;
            case 'sampleRate':
                $data = $this->getSampleRateDictionary();
                break;
        }

        return $data;
    }

    public function getBitRateModeDictionary()
    {
        return array(
            Dictionary\AudioFormat::BIT_RATE_MODE_CONSTANT => 'CBR',
            Dictionary\AudioFormat::BIT_RATE_MODE_VARIABLE => 'VBR',
        );
    }

    /**
     * @link https://en.wikipedia.org/wiki/DVD-Audio
     */
    public function getChannelDictionary()
    {
        return array(
            '1.0' => 'Mono',
            '2.0' => 'Stereo',
            '5.1' => '5.1',
        );
    }

    /**
     * @link https://en.wikipedia.org/wiki/Sampling_(signal_processing)#Sampling_rate
     */
    public function getSampleRateDictionary()
    {
        $sampleRates = array(11025, 22050, 44100, 48000);
        return array_combine($sampleRates, $sampleRates);
    }

    public function getFormatDictionary()
    {
        if (self::$_formatDictionary === null) {
            self::$_formatDictionary = array();

            $data = Dictionary\AudioFormat::model()->findAll(array(
                'order'=>'name ASC'
            ));

            foreach ($data as $item) {
                self::$_formatDictionary[$item->id] = $item->name;
            }
        }
        return self::$_formatDictionary;
    }

    public function getLanguageDictionary()
    {
        if (self::$_languageDictionary === null) {
            self::$_languageDictionary = array();

            $data = Dictionary\Language::model()->findAll(array(
                'order'=>'code3 ASC'
            ));

            foreach ($data as $item) {
                self::$_languageDictionary[$item->id] = $item->code3;
            }
        }
        return self::$_languageDictionary;
    }

}