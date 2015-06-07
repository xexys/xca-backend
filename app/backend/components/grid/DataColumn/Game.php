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

class Game extends \backend\components\grid\DataColumn
{
    /**
     * @param \common\models\Game $game
     */
    public function title($game)
    {
        $url = $this->_getCrudLinkHelper()->getViewUrl($game);
        echo CHtml::link($game->title, $url);
    }

}
