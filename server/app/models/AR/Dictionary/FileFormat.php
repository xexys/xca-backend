<?php

namespace app\models\AR\Dictionary;

use \app\components\ActiveRecord;


class FileFormat extends ActiveRecord
{
    const FORMAT_ID_AVI = 1;
    const FORMAT_ID_MP4 = 3;

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dic_file_formats}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, extension, name', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('extension', 'length', 'max'=>3),
			array('name', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, extension, name', 'safe', 'on'=>'search'),
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
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
