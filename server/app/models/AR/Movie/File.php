<?php

namespace app\models\AR\Movie;
use \app\components\ActiveRecord;


class File extends ActiveRecord
{
    const TYPE_MAIN = 1;
    const TYPE_SOURCE = 2;
    const TYPE_LOCALIZATION= 3;

    public function isSource()
    {
        return ($this->type === self::TYPE_SOURCE);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{movies_files}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('movie_id, type', 'required'),
            array('movie_id, type', 'numerical', 'integerOnly'=>true),
            array('comment', 'length', 'max'=>500),
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
            'movie' => array(self::BELONGS_TO, '\app\models\AR\Movie', 'movie_id'),
            'mainParams' => array(self::HAS_ONE, '\app\models\AR\Movie\File\MainParams', 'movie_file_id'),
            'videoParams' => array(self::HAS_ONE, '\app\models\AR\Movie\File\VideoParams', 'movie_file_id'),
            'audioParams' => array(self::HAS_MANY, '\app\models\AR\Movie\File\AudioParams', 'movie_file_id'),
            'mediaInfo' => array(self::HAS_ONE, '\app\models\AR\Movie\File\MediaInfo', 'movie_file_id'),
            'sourceInfo' => array(self::HAS_ONE, '\app\models\AR\Movie\File\SourceInfo', 'movie_file_id'),
            'storages' => array(self::HAS_MANY, '\app\models\AR\Movie\File\Storage', 'movie_file_id'),
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
        $criteria->compare('movie_id',$this->movie_id);
        $criteria->compare('type',$this->type);
        $criteria->compare('comment',$this->comment,true);
        $criteria->compare('md5',$this->md5,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}