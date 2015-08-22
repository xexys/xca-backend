<?php

namespace app\models\AR\Dictionary;

use \app\components\ActiveRecord;


class Language extends ActiveRecord
{
    const LANGUAGE_ID_ENG = 1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dic_languages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, code2, code3', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('code2', 'length', 'max'=>2),
			array('code3', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code2, code3', 'safe', 'on'=>'search'),
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
		$criteria->compare('code2',$this->code2,true);
		$criteria->compare('code3',$this->code3,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
