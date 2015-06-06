<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 16:24
 */

namespace backend\components\DataColumn;

use \Yii;
use \CHtml;

class Movie extends \CDataColumn
{
    /**
     * @param \common\models\Movie $movie
     */
    public function title($movie)
    {
        $url = $this->_getViewUrl($movie);
        echo CHtml::link($movie->title, $url);
    }

    /**
     * Возвращает ссылку для перехода к странице просмотра ролика
     * @param \common\models\Movie $movie
     * @return string
     */
    private function _getViewUrl($movie)
    {
        return Yii::app()->controller->getViewHelper('MovieLink')->getViewUrl($movie);
    }
}