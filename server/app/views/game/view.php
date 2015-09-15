<?php

$this->pageTitle = $game->title;

$uiHelper = $this->getViewHelper('UI');

$btnHelper = $uiHelper->getButtonHelper();
$linkHelper = $uiHelper->getLinkHelper();

$gameLinkHelper = $this->getViewModelLinkHelper('Game');
$movieLinkHelper = $this->getViewModelLinkHelper('Movie');

$createMovieUrl = $movieLinkHelper->getBelongsToGameCreateUrl($game);

$editGameUrl = $gameLinkHelper->getEditUrl($game);
$deleteGameUrl = $gameLinkHelper->getDeleteUrl($game);

$deleteConfirmMessage = 'Вы уверены что хотите удалить игру?';

?>

<div class="game-card game-card_view">
    <div class="row">
        <div class="col-md-7">
            <?php require '_view/main.php'; ?>
            <?php $this->renderPartial('_view/platforms', array(
                'game' => $game
            ));
            ?>
        </div>

        <div class="col-md-5">
            <?php require '_view/pictures.php'; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php require '_view/movies.php'; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="section game-card_buttons-panel">
                <hr>
                <?= $btnHelper->linkButton(array('label' => 'Редактировать', 'gl-icon' => 'pencil', 'context' => 'primary', 'url' => $editGameUrl)); ?>
                <?= $btnHelper->linkButton(array('label' => 'Удалить', 'gl-icon' => 'trash', 'context' => 'danger', 'url' => $deleteGameUrl, 'confirm'=> $deleteConfirmMessage)); ?>
            </div>
        </div>
    </div>

</div>

