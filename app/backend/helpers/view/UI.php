<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.06.15
 * Time: 22:07
 */

namespace backend\helpers\view;


class UI extends \common\helpers\view\ABase
{
    public function getButtonHelper()
    {
        return $this->_controller->getViewHelper('UI\Button');
    }

    public function getIconHelper()
    {
        return $this->_controller->getViewHelper('UI\Icon');
    }


} 