<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:52
 */

namespace app\models\AR\Movie\File;
use \app\components\ActiveRecord;


class MainParams extends ActiveRecord
{
    public function tableName()
    {
        return '{{movies_files_main_params}}';
    }

    public function rules()
    {
        return array(
            array('movie_id, format_id', 'required'),
            array('movie_id, size, duration, format_id', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, movie_id, name, size, duration, format_id', 'safe', 'on'=>'search'),
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
            'format' => array(self::BELONGS_TO, 'app\models\AR\Dictionary\FileFormat', 'format_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'movie_id' => 'Movie',
            'name' => 'Name',
            'size' => 'Size',
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

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('movie_id',$this->movie_id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('size',$this->size);
        $criteria->compare('duration',$this->duration);
        $criteria->compare('format_id',$this->format_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

}