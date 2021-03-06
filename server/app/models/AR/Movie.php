<?php

namespace app\models\AR;
use \app\components\ActiveRecord;


class Movie extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{movies}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('game_id, title', 'required'),
            array('game_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('issue_year', 'date', 'format' => APP_VALIDATION_YEAR_FORMAT, 'allowEmpty' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, game_id', 'safe', 'on' => 'search'),
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
            'game' => array(self::BELONGS_TO, '\app\models\AR\Game', 'game_id'),
            'files' => array(self::HAS_MANY, '\app\models\AR\Movie\File', 'movie_id'),
            'images' => array(self::HAS_MANY, '\app\models\AR\Movie\Image', 'movie_id'),
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
        $criteria->compare('game_id', $this->game_id);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
