<?php

$this->pageTitle = $game->title;

$gameLinkHelper = $this->getViewHelper('GameLink');
$createUrl = $gameLinkHelper->getCreateUrl();
$editUrl = $gameLinkHelper->getEditUrl($game);
$deleteUrl = $gameLinkHelper->getDeleteUrl($game);

?>

<div class="game-card_section">
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
</div>

<div class="game-card_section">
    <h4>Ролики</h4>
<?php
    $this->widget(
        '\backend\components\GridView',
        array(
            'dataProvider' => $gameMovieDataProvider,
            'templateWidget'=>array(
                'params'=> array(
                    'createItemButton'=>false,
                ),
            ),
            'columns' => array(
                array(
                    'name' => 'id',
                ),
                array(
                    'class' => 'backend\components\DataColumn\Movie',
                    'name' => 'title',
                    'value' => '$this->title($data)',
                ),
            ),

        )
    );
?>
</div>

<div class="game-card_section game-card_section-buttons">
    <?= CHtml::link('Добавить ролик', $createUrl, array(
        'class'=>'btn btn-success'
    )); ?>
    <?= CHtml::link('Редактировать', $editUrl, array(
        'class'=>'btn btn-primary'
    )); ?>
    <?= CHtml::link('Удалить', $deleteUrl, array(
        'class'=>'btn btn-danger'
    )); ?>
</div>