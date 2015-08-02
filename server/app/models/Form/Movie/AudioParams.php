<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace app\models\Form\Movie;


class AudioParams extends \app\components\FormModel
{
    const BIT_RATE_MODE_CONSTANT = 0;
    const BIT_RATE_MODE_VARIABLE = 1;
    const FORMAT_ID_MP3 = 3;
    const LANGUAGE_ID_ENG = 1;

    public $trackNumber;
    public $formatId = self::FORMAT_ID_MP3;
    public $bitRate;
    public $bitRateMode = self::BIT_RATE_MODE_CONSTANT;
    public $sampleRate = 44100;
    public $channels = '2.0';
    public $languageId = self::LANGUAGE_ID_ENG;

    private static $_formatDictionary;
    private static $_languageDictionary;


    public function rules()
    {
        return array(
            array('bitRate, trackNumber', 'numerical', 'integerOnly' => true, 'allowEmpty' => false),
            array('bitRateMode', 'in', 'range' => array_keys($this->getBitRateModeDictionary()), 'allowEmpty' => false),
            array('formatId', 'in', 'range' => array_keys($this->getFormatDictionary()), 'allowEmpty' => false),
            array('channels', 'in', 'range' => array_keys($this->getChannelDictionary()), 'allowEmpty' => false),
            array('languageId', 'in', 'range' => array_keys($this->getLanguageDictionary()), 'allowEmpty' => false),
            array('sampleRate', 'in', 'range' => array_keys($this->getSampleRateDictionary()), 'allowEmpty' => false),
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
            self::BIT_RATE_MODE_CONSTANT => 'CBR',
            self::BIT_RATE_MODE_VARIABLE => 'VBR',
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
        $sampleRates = array('11025', '22050', '44100', '48000');
        return array_combine($sampleRates, $sampleRates);
    }

    public function getFormatDictionary()
    {
        if (self::$_formatDictionary === null) {
            self::$_formatDictionary = array();

            $data = \app\models\Dictionary\AudioFormat::model()->findAll();

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

            $data = \app\models\Dictionary\Language::model()->findAll(array(
                'order'=>'t.code3 ASC'
            ));

            foreach ($data as $item) {
                self::$_languageDictionary[$item->id] = $item->code3;
            }
        }
        return self::$_languageDictionary;
    }

}