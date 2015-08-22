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

class Game extends \app\components\grid\DataColumn
{
    /**
     * @param \app\models\AR\Game $game
     */
    public function title($game)
    {
        $url = $this->_getCrudLinkHelper()->getViewUrl($game);
        echo CHtml::link($game->title, $url);
    }

}
