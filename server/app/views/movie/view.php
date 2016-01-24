<?php

$this->pageTitle = $movie->game->title . ' &ndash; ' . $movie->title;

$uiHelper = $this->getViewHelper('UI');
$btnHelper = $uiHelper->getButtonHelper();
$linkHelper = $uiHelper->getLinkHelper();

$movieLinkHelper = $this->getViewModelLinkHelper('Movie');

$editMovieUrl = $movieLinkHelper->getEditUrl($movie);
$deleteMovieUrl = $movieLinkHelper->getDeleteUrl($movie);

$deleteConfirmMessage = 'Вы уверены что хотите удалить ролик?';

?>

<div class="movie-card movie-card_view">
    <div class="row">
        <div class="col-md-7">
            <?php $this->renderPartial('_view/main', array(
                'movie' => $movie
            ));
            ?>

            <?php $this->renderPartial('_view/main-file', array(
                'movie' => $movie,
                'linkHelper' => $linkHelper
            ));
            ?>
        </div>

        <div class="col-md-5">
            <?php $this->renderPartial('_view/pictures', array(
                'movie' => $movie
            ));
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php $this->renderPartial('_view/sources', array(
                'movie' => $movie,
                'linkHelper' => $linkHelper
            ));
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="section movie-card_buttons-panel">
                <hr>
                <?= $btnHelper->linkButton(array('label' => 'Редактировать', 'gl-icon' => 'pencil', 'context' => 'primary', 'url' => $editMovieUrl)); ?>
                <?= $btnHelper->linkButton(array('label' => 'Удалить', 'gl-icon' => 'trash', 'context' => 'danger', 'url' => $deleteMovieUrl, 'confirm'=> $deleteConfirmMessage)); ?>
            </div>
        </div>
    </div>

</div>

