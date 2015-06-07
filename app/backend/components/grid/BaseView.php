<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 21:57
 */

namespace backend\components\grid;

use \Yii;

Yii::import('booster.widgets.TbExtendedGridView');


class BaseView extends \TbExtendedGridView
{
    public $type = 'bordered hover';

//    public $pager = array('class' => 'booster.widgets.TbPager', 'htmlOptions'=>array('class'=>'grid-view_pagination'));

    /**
     * Шаблон будет создан в результате рендера виджета
     * Принимает значения array('class'=>'className', 'params'=>array()) | true - использовать виджет по умолчанию
     * @var array | bool
     */
    public $templateWidget;

    public function init()
    {
        if ($this->templateWidget) {
            $class = isset($this->templateWidget['class']) ? $this->templateWidget['class'] : '\backend\widgets\GridViewTemplateBuilder';
            $params = isset($this->templateWidget['params']) ? $this->templateWidget['params'] : array();
            $this->template = $this->controller->widget($class, $params, true);
        }

        parent::init();
    }

}