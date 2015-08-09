<?php

$this->pageTitle = $game->title;

$btnHelper = $this->getViewHelper('UI\Button');
$gameLinkHelper = $this->getViewHelper('ModelLink\Game');
$movieLinkHelper = $this->getViewHelper('ModelLink\Movie');

$createMovieUrl = $movieLinkHelper->getBelongsToGameCreateUrl($game);
$editGameUrl = $gameLinkHelper->getEditUrl($game);
$deleteGameUrl = $gameLinkHelper->getDeleteUrl($game);

$deleteConfirmMessage = 'Вы уверены что хотите удалить игру?';

?>

<div class="game-card game-card_view">
    <div class="game-card_section">
        <div class="row">
            <div class="col-md-6">
                <h4 class="game-card_title">Информация об игре</h4>
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
        <h4 class="game-card_title">Ролики</h4>
        <div class="game-card_movies">
<?php
$this->widget(
    '\app\components\grid\BaseView',
    array(
        'dataProvider' => $gameMovieDataProvider,
        'templateWidget' => true,
        'columns' => array(
            array(
                'name' => 'id',
            ),
            array(
                'class' => 'app\components\grid\DataColumn\Movie',
                'name' => 'title',
                'value' => '$this->title($data)',
            ),
            array(
                'class' => '\app\components\grid\ButtonColumn',
            )

        ),

    )
);
?>
        </div>
    </div>

    <div class="game-card_section">
        <?= $btnHelper->linkButton(array('label' => 'Добавить ролик', 'gl-icon' => 'plus', 'context' => 'success', 'url' => $createMovieUrl)); ?>
        <?= $btnHelper->linkButton(array('label' => 'Редактировать', 'gl-icon' => 'pencil', 'context' => 'primary', 'url' => $editGameUrl)); ?>
        <?= $btnHelper->linkButton(array('label' => 'Удалить', 'gl-icon' => 'trash', 'context' => 'danger', 'url' => $deleteGameUrl, 'confirm'=> $deleteConfirmMessage)); ?>
    </div>
</div>

