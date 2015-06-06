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

class Game extends \CDataColumn
{
    /**
     * @param \common\models\Game $game
     */
    public function title($game)
    {
        $url = $this->_getViewUrl($game);
        echo CHtml::link($game->title, $url);
    }

    /**
     * Возвращает ссылку для перехода к странице просмотра ролика
     * @param \common\models\Game $game
     * @return string
     */
    private function _getViewUrl($game)
    {
        return Yii::app()->controller->getViewHelper('GameLink')->getViewUrl($game);
    }

}
