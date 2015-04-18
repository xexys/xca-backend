<?php

namespace common\models;
use \common\components\ActiveRecord;


class Movie extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{movie_list}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('game_id, title, filename, filesize, duration, format_id', 'required'),
            array('game_id, filesize, duration, format_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('filename', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, game_id, title, filename, filesize, duration, format_id', 'safe', 'on' => 'search'),
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
            'images' => array(self::HAS_MANY, '\common\models\Movie\Image', 'movie_id'),
            'game' => array(self::BELONGS_TO, 'common\models\Game', 'game_id'),
            'storage' => array(self::HAS_ONE, 'common\models\Movie\Storage', 'movie_id'),
            'video' => array(self::HAS_ONE, 'common\models\Movie\Video', 'movie_id'),
            'audio' => array(self::HAS_MANY, 'common\models\Movie\Audio', 'movie_id'),
            'format' => array(self::BELONGS_TO, 'common\models\Reference\FileFormat', 'format_id'),
            'mediaInfo' => array(self::HAS_ONE, 'common\models\Movie\MediaInfo', 'movie_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'game_id' => 'Game',
            'title' => 'Title',
            'filename' => 'Filename',
            'filesize' => 'Filesize',
            'duration' => 'Duration',
            'format_id' => 'Format',
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
        $criteria->compare('filename', $this->filename, true);
        $criteria->compare('filesize', $this->filesize);
        $criteria->compare('duration', $this->duration);
        $criteria->compare('format_id', $this->format_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
