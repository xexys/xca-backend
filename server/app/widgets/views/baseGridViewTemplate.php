<?php

$btnHelper = $this->controller->getViewHelper('UI\Button');

$isCreateItemButtonTop = $params['createItemButtonTop'];
$isCreateItemButtonBottom = $params['createItemButtonBottom'];

if ($isCreateItemButtonTop || $isCreateItemButtonBottom) {
    $label = $params['createItemButtonLabel'] ?: 'Добавить';

    $button = $btnHelper->linkButton(array(
        'label' => $label,
        'gl-icon' => 'plus',
        'context' => 'success',
        // TODO: Сделать правильную генерацию урла (сейчас зависит от текущего контроллера а не от модели)
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
    <?php if ($isCreateItemButtonBottom): ?>
        <div class="grid-view_panel-col_left"><?= $button; ?></div>
    <?php endif; ?>
    <div class="grid-view_panel-col_right">{pager}</div>
</div>
