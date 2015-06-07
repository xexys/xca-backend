<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 16:24
 */

namespace backend\components\grid\DataColumn;

use \Yii;
use \CHtml;

class Movie extends \backend\components\grid\DataColumn
{
    /**
     * @param \common\models\Movie $movie
     */
    public function title($movie)
    {
        $url = $this->_getCrudLinkHelper()->getViewUrl($movie);
        echo CHtml::link($movie->title, $url);
    }
}