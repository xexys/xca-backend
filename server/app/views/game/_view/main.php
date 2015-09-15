<?php

$editGameMainInfoUrl = $gameLinkHelper->getEditMainInfoUrl($game);

?>

<div class="section">

    <span class="section_edit-btn">
        <?= $btnHelper->linkButton(array('label' => '', 'gl-icon' => 'pencil', 'context' => 'default', 'size'=>'small', 'url' => $editGameMainInfoUrl)); ?>
<!--        --><?//= $linkHelper->crudEditLink(array('label' => 'Редактировать', 'url' => $editGameMainInfoUrl)); ?>
    </span>

    <h4 class="section_header">Информация об игре</h4>

    <div class="section_content">
        <? foreach ($game->attributes as $key => $val): ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $game->getAttributeLabel($key); ?>
                </div>
                <div class="col-md-9">
                    <?= $val; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>

</div>

