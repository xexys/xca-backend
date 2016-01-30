<?php

$btnHelper = $this->getViewHelper('UI\Button');

$this->pageTitle = $movie->game->title . ' &ndash; ' . $movie->title;
$this->pageTitleIconClass = 'glyphicon glyphicon-pencil';

$formWidget = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'type' => 'horizontal',
    )
);

echo CHtml::hiddenField('backUrl', $backUrl);

?>

<div class="movie-card movie-card_edit">
    <?php
    $this->renderPartial('_form', array(
        'formWidget' => $formWidget,
        'movieForm' => $movieForm,
    ));
    ?>

    <div class="section">
        <?= $btnHelper->submitButton(array('label' => 'Сохранить', 'fa-icon' => 'save', 'context' => 'success')); ?>
        <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
    </div>
</div>

<?php
$this->endWidget();
