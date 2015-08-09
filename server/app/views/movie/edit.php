<?php

$btnHelper = $this->getViewHelper('UI\Button');

$this->pageTitle = $movie->game->title . ': ' . $movie->title;
$this->pageTitleIconClass = 'glyphicon glyphicon-pencil';

$form = $this->beginWidget(
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
        'form' => $form,
        'model' => $model,
    ));
    ?>

    <div class="movie-card_section">
        <?= $btnHelper->submitButton(array('label' => 'Сохранить', 'fa-icon' => 'save', 'context' => 'success')); ?>
        <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
    </div>
</div>

<?php
$this->endWidget();

$this->renderPartial('_audio-params-template', array(
    'form' => $form,
    'model' => $model,
));


