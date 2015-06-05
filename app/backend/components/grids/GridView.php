<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.06.15
 * Time: 21:57
 */

namespace backend\components\grids;
use \Yii;

Yii::import('booster.widgets.TbExtendedGridView', true);

class GridView extends \TbExtendedGridView
{
    public $type = 'bordered hover';

    public $template = <<<TPL
<div class="grid-view_panel">
    <div class="grid-view_panel-left">{createItemBtn}</div>
    <div class="grid-view_panel-right">{summary}</div>
</div>
<div class="grid-view_items">{items}</div>
<div class="grid-view_panel">
    <div class="grid-view_panel-left">{createItemBtn}</div>
    <div class="grid-view_panel-right">{pager}</div>
</div>
TPL;

    public function renderCreateItemBtn()
    {
        $this->controller->widget('\backend\widgets\CreateItemBtn');
    }

} 