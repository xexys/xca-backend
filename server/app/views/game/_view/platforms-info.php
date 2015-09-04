<?php

$editGamePlatformsInfoUrl = $gameLinkHelper->getEditPlatformsInfoUrl($game);

?>

<div class="section game-card_platforms-info">

    <span class="section_edit-btn">
<!--        --><?//= $btnHelper->linkButton(array('label' => '', 'gl-icon' => 'pencil', 'context' => 'default', 'size'=>'small', 'url' => $editGameUrl)); ?>
        <?= $linkHelper->crudEditLink(array('label' => 'Редактировать', 'url' => $editGamePlatformsInfoUrl)); ?>
    </span>

    <h4 class="section_header">Выход на платформах</h4>
    <div class="section_content">
        TODO
    </div>
</div>
