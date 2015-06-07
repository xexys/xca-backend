<?php

use \backend\helpers\Html;

$isCreateItemButtonTop = $params['createItemButtonTop'];
$isCreateItemButtonBottom = $params['createItemButtonBottom'];

if ($isCreateItemButtonTop || $isCreateItemButtonBottom) {
    $label = $params['createItemButtonLabel'] ?: 'Добавить';

    $button = Html::TbLinkButton(array(
        'label' => $label,
        'fa-icon' => 'plus',
        'context' => 'success',
        'url' => $this->controller->createUrl('create')
    ));
}

?>

<div class="grid-view_panel">
<!--    --><?// if ($isCreateItemButtonTop): ?>
<!--        <div class="grid-view_panel-col_left">--><?//= $button; ?><!--</div>-->
<!--    --><?// endif; ?>
    <div class="grid-view_panel-col_right">{summary}</div>
</div>
<div class="grid-view_items">{items}</div>
<div class="grid-view_panel">
    <? if ($isCreateItemButtonBottom): ?>
        <div class="grid-view_panel-col_left"><?= $button; ?></div>
    <? endif; ?>
    <div class="grid-view_panel-col_right">{pager}</div>
</div>