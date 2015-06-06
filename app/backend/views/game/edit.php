<?php

$this->pageTitle = $game->title;


?>

<h4>Информация об игре</h4>
<div class="row">
    <div class="col-md-9">
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
    <div class="col-md-3">
        <?= CHtml::image('http://www.pacxon.net/artwork/pacxon-favicon.png', 'Картинка', array('width' => '100px')); ?>
    </div>
</div>

