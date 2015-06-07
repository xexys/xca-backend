<?php

use \backend\helpers\Html;

$this->pageTitle = $game->title;

$createMovieUrl = $movieLinkHelper->getBelongsToGameCreateUrl($game);
$editGameUrl = $gameLinkHelper->getEditUrl($game);
$deleteGameUrl = $gameLinkHelper->getDeleteUrl($game);

?>

<div class="game-card game-card_view">
    <div class="game-card_section">
        <div class="row">
            <div class="col-md-6">
                <h4 class="game-card_header">Информация об игре</h4>
                <div class="game-card_info">
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
            <div class="col-md-6">
                <div class="game-card_picture">
                    <?= CHtml::image('?=' . PHP_EGG_LOGO_GUID); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="game-card_section">
        <h4 class="game-card_header">Ролики</h4>
        <div class="game-card_movies">
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
    </div>

    <div class="game-card_section">
        <?= Html::TbLinkButton(array('label' => 'Добавить ролик', 'fa-icon' => 'plus', 'context' => 'success', 'url' => $createMovieUrl)); ?>
        <?= Html::TbLinkButton(array('label' => 'Редактировать', 'fa-icon' => 'edit', 'context' => 'primary', 'url' => $editGameUrl)); ?>
        <?= Html::TbLinkButton(array('label' => 'Удалить', 'fa-icon' => 'trash-o', 'context' => 'danger', 'url' => $deleteGameUrl)); ?>
    </div>
</div>
