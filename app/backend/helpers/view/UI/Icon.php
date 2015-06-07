<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.06.15
 * Time: 22:40
 */

namespace backend\helpers\view\UI;

use \CHtml;


class Icon extends \common\helpers\view\ABase
{
    public function icon($cssClass)
    {
        return CHtml::tag('i', array('class' => $cssClass), '', true);
    }

    public function faIcon($icon)
    {
        return $this->icon('fa fa-' . $icon);
    }

    public function glIcon($icon)
    {
        return $this->icon('glyphicon glyphicon-' . $icon);
    }

} 