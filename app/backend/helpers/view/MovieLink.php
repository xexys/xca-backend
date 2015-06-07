<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 21:24
 */

namespace backend\helpers\view;

use \Yii;

class MovieLink extends ABaseModelLink
{
    protected $_modelControllerId = 'movie';

    public function getBelongsToGameCreateUrl($game)
    {
        return $this->getCreateUrl(array('gameId'=>$game->id));
    }
}