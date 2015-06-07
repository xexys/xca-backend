<?php

/**
 * This is the model class for table "games".
 *
 * The followings are the available columns in table 'game_list':
 * @property integer $id
 * @property string $title
 *
 */

namespace common\models;

use \common\components\ActiveRecord;


class Game extends ActiveRecord
{
    public function findByTextId($textId)
    {
        return $this->findByAttributes(array('text_id' => $textId));
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{game_list}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('text_id, title', 'required'),
            array('text_id', 'length', 'max' => 10),
            array('text_id', 'unique'),
            array('text_id', 'match', 'pattern' => '/^[a-z0-9_]+$/',),
            array('title', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title', 'safe', 'on' => 'search'),
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
            'movies' => array(self::HAS_MANY, '\common\models\Movie', 'game_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
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
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
