<?php

$btnHelper = $this->getViewHelper('UI\Button');

$this->pageTitle = $movie->game->title . ': ' . $movie->title;
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
        'movieParams' => $movieParams,
    ));
    ?>

    <div class="movie-card_section">
        <?= $btnHelper->submitButton(array('label' => 'Сохранить', 'fa-icon' => 'save', 'context' => 'success')); ?>
        <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
    </div>
</div>

<?php
$this->endWidget();

$this->renderPartial('_form/audio-params-template', array(
    'formWidget' => $formWidget,
    'movieParams' => $movieParams,
));


