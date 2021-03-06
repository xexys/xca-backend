<?php

namespace app\models\AR\Movie\File;
use \app\components\ActiveRecord;


class VideoParams extends ActiveRecord
{
	const FRAME_RATE_MODE_CONSTANT = 0;
	const FRAME_RATE_MODE_VARIABLE = 1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{movies_files_video_params}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movie_file_id, format_id, width, height, bit_rate, frame_rate, frame_rate_mode', 'required'),
			array('movie_file_id, format_id, width, height, bit_rate, frame_rate_mode', 'numerical', 'integerOnly'=>true),
			array('frame_rate, frame_quality', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, movie_file_id, format_id, width, height, bit_rate, frame_rate, frame_rate_mode, frame_quality', 'safe', 'on'=>'search'),
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
			'format' => array(self::BELONGS_TO, '\app\models\AR\Dictionary\VideoFormat', 'format_id'),
			'movie' => array(self::BELONGS_TO, '\app\models\AR\Movie', 'movie_file_id'),
		);
	}

    public function beforeSave()
    {
        $this->_setFrameQuality();
        return parent::beforeSave();
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
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('bit_rate',$this->bit_rate);
		$criteria->compare('frame_rate',$this->frame_rate);
		$criteria->compare('frame_rate_mode',$this->frame_rate_mode);
		$criteria->compare('frame_quality',$this->frame_quality);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function _getCastAttributeTypes()
    {
        return array(
            'frame_rate' => 'float'
        );
    }

    private function _setFrameQuality()
    {
        $frameQuality = ($this->bit_rate * 1000) / ($this->width * $this->height * $this->frame_rate);
        $frameQuality = round($frameQuality, 3);
        $this->frame_quality  = $frameQuality;
    }
}
