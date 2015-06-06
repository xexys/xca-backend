<?php

$isCreateItemButtonTop = $params['createItemButtonTop'];
$isCreateItemButtonBottom = $params['createItemButtonBottom'];

if ($isCreateItemButtonTop || $isCreateItemButtonBottom) {
    $label = $params['createItemButtonLabel'] ?: 'Добавить';
    $button =  CHtml::link($label, $this->controller->createUrl('create'), array(
        'class' => 'btn btn-primary'
    ));
}

?>

<div class="grid-view_panel">
    <? if ($isCreateItemButtonTop): ?>
        <div class="grid-view_panel-col_left"><?= $button; ?></div>
    <? endif; ?>
    <div class="grid-view_panel-col_right">{summary}</div>
</div>
<div class="grid-view_items">{items}</div>
<div class="grid-view_panel">
    <? if ($isCreateItemButtonBottom): ?>
        <div class="grid-view_panel-col_left"><?= $button; ?></div>
    <? endif; ?>
    <div class="grid-view_panel-col_right">{pager}</div>
</div>