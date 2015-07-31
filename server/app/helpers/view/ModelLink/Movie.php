<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 21:24
 */

namespace app\helpers\view\ModelLink;


class Movie extends \app\helpers\view\ModelLink
{
    protected $_modelControllerId = 'movie';

    public function getBelongsToGameCreateUrl($game)
    {
        return $this->getCreateUrl(array('gameId'=>$game->id));
    }
}
