<?php

namespace app\models\AR\Dictionary;

use \app\components\ActiveRecord;


class Platform extends ActiveRecord
{
    const PLATFORM_ID_PC = 3;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{dic_platforms}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, full_name, short_name', 'required'),
            array('id', 'numerical', 'integerOnly' => true),
            array('short_name', 'length', 'max' => 20),
            array('full_name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, full_name, short_name', 'safe', 'on' => 'search'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('full_name', $this->full_name, true);
        $criteria->compare('short_name', $this->short_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
