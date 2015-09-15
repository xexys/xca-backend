<?php

$this->pageTitle = $movie->game->title . ' &ndash; ' . $movie->title;

$uiHelper = $this->getViewHelper('UI');
$btnHelper = $uiHelper->getButtonHelper();
//$linkHelper = $uiHelper->getLinkHelper();

$viewDataHelper = $this->getViewHelper('Data');

$movieLinkHelper = $this->getViewModelLinkHelper('Movie');

$editMovieUrl = $movieLinkHelper->getEditUrl($movie);
$deleteGameUrl = $movieLinkHelper->getDeleteUrl($movie);

$deleteConfirmMessage = 'Вы уверены что хотите удалить ролик?';

?>

<div class="movie-card movie-card_view">
    <div class="row">
        <div class="col-md-12">
            <?php $this->renderPartial('_view/file', array(
                'file' => $movie->file,
                'viewDataHelper' => $viewDataHelper
            ));
            ?>
        </div>
        <div class="col-md-12">
            <?php $this->renderPartial('_view/video', array(
                'video' => $movie->video,
                'viewDataHelper' => $viewDataHelper
            ));
            ?>
        </div>
    </div>

    <div class="row">
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="section movie-card_buttons-panel">
                <hr>
                <?= $btnHelper->linkButton(array('label' => 'Редактировать', 'gl-icon' => 'pencil', 'context' => 'primary', 'url' => $editMovieUrl)); ?>
                <?= $btnHelper->linkButton(array('label' => 'Удалить', 'gl-icon' => 'trash', 'context' => 'danger', 'url' => $deleteGameUrl, 'confirm'=> $deleteConfirmMessage)); ?>
            </div>
        </div>
    </div>

</div>

