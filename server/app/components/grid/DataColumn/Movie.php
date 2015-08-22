<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 16:24
 */

namespace app\components\grid\DataColumn;

use \Yii;
use \CHtml;

class Movie extends \app\components\grid\DataColumn
{
    /**
     * @param \app\models\AR\Movie $movie
     */
    public function title($movie)
    {
        $url = $this->_getCrudLinkHelper()->getViewUrl($movie);
        echo CHtml::link($movie->title, $url);
    }
}