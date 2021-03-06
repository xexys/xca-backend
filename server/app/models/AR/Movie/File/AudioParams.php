<?php

namespace app\models\AR\Movie\File;
use \app\components\ActiveRecord;


class AudioParams extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{movies_files_audio_params}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movie_file_id, format_id, bit_rate, bit_rate_mode, channels, language_id, sample_rate, track_number', 'required'),
			array('movie_file_id, format_id, bit_rate, bit_rate_mode, language_id, sample_rate, track_number', 'numerical', 'integerOnly'=>true),
			array('channels', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, movie_file_id, format_id, bit_rate, bit_rate_mode, channels, language_id, sample_rate, track_number', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'movie' => array(self::BELONGS_TO, '\app\models\AR\Movie', 'movie_file_id'),
			'format' => array(self::BELONGS_TO, '\app\models\AR\Dictionary\AudioFormat', 'format_id'),
			'lang' => array(self::BELONGS_TO, '\app\models\AR\Dictionary\Language', 'language_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'movie_file_id' => 'Movie',
			'format_id' => 'Format',
			'bit_rate' => 'Bit Rate',
			'bit_rate_mode' => 'Bit Rate Mode',
			'channels' => 'Channels',
			'language_id' => 'Language',
			'sample_rate' => 'Sample Rate',
			'track_number' => 'Track Number',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('movie_file_id',$this->movie_file_id);
		$criteria->compare('format_id',$this->format_id);
		$criteria->compare('bit_rate',$this->bit_rate);
		$criteria->compare('bit_rate_mode',$this->bit_rate_mode);
		$criteria->compare('channels',$this->channels);
		$criteria->compare('language_id',$this->language_id);
		$criteria->compare('sample_rate',$this->sample_rate);
		$criteria->compare('track_number',$this->track_number);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AudioParams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
