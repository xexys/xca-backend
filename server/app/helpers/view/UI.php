<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.06.15
 * Time: 22:07
 */

namespace app\helpers\view;


class UI extends \app\helpers\view\Base
{
    /**
     * @return \app\helpers\view\UI\Button
     */
    public function getButtonHelper()
    {
        return $this->_controller->getViewHelper('UI\Button');
    }

    /**
     * @return \app\helpers\view\UI\Icon
     */
    public function getIconHelper()
    {
        return $this->_controller->getViewHelper('UI\Icon');
    }

    /**
     * @return \app\helpers\view\UI\Link
     */
    public function getLinkHelper()
    {
        return $this->_controller->getViewHelper('UI\Link');
    }
}