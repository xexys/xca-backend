<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 21:07
 */

namespace backend\models;

use \Yii;


class Movie extends \common\models\Movie
{
    public function getViewUrl()
    {
        return Yii::app()->createUrl('movie/view', array('id'=>$this->id));
    }

    public function getEditUrl()
    {
        return Yii::app()->createUrl('movie/edit', array('id'=>$this->id));
    }

    public function getDeleteUrl()
    {
        return Yii::app()->createUrl('movie/delete', array('id'=>$this->id));
    }


} 