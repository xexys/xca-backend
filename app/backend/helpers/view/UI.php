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
    /**
     * @return \backend\helpers\view\UI\Button
     */
    public function getButtonHelper()
    {
        return $this->_controller->getViewHelper('UI\Button');
    }

    /**
     * @return \backend\helpers\view\UI\Icon
     */
    public function getIconHelper()
    {
        return $this->_controller->getViewHelper('UI\Icon');
    }

    /**
     * @return \backend\helpers\view\UI\Link
     */
    public function getLinkHelper()
    {
        return $this->_controller->getViewHelper('UI\Link');
    }


} 