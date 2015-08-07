<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 14:28
 */

namespace app\models\Game;

use \app\components\ActiveRecord;


class Platform extends ActiveRecord
{
    public function tableName()
    {
        return '{{games_platforms}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('game_id, platform_id', 'required'),
            array('game_id, platform_id, status', 'numerical', 'integerOnly'=>true),
            array('comment', 'length', 'max'=>500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, game_id, platform_id, status, comment', 'safe', 'on'=>'search'),
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
            'game' => array(self::BELONGS_TO, '\app\models\Game', 'game_id'),
            'info' => array(self::BELONGS_TO, '\app\models\Dictionary\Platform', 'platform_id'),
//            'gamesPlatformsMoviesSearches' => array(self::HAS_MANY, 'GamesPlatformsMoviesSearch', 'game_platform_id'),
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
        $criteria->compare('game_id',$this->game_id);
        $criteria->compare('platform_id',$this->platform_id);
        $criteria->compare('status',$this->status);
        $criteria->compare('comment',$this->comment,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}