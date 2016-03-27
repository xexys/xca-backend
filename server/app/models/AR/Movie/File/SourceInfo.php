<?php

namespace app\models\AR\Movie\File;

use \app\components\ActiveRecord;

class SourceInfo extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{movies_files_source_info}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('movie_file_id, game_platform_id', 'required'),
            array('movie_file_id, game_platform_id, is_best', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, movie_file_id, game_platform_id, is_best', 'safe', 'on' => 'search'),
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
            'file' => array(self::BELONGS_TO, 'app\models\AR\Movie\File', 'movie_file_id'),
            'platform' => array(self::BELONGS_TO, '\app\models\AR\Dictionary\GamePlatform', 'platform_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'movie_file_id' => 'Movie File',
            'game_platform_id' => 'Game Platform',
            'is_best' => 'Is Best',
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
        $criteria->compare('movie_file_id', $this->movie_file_id);
        $criteria->compare('game_platform_id', $this->game_platform_id);
        $criteria->compare('is_best', $this->is_best);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}