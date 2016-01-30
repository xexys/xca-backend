<div class="page_movie-file-card">

<?php

$this->pageTitle = 'Новый файл для ролика';

$btnHelper = $this->getViewHelper('UI\Button');

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

<div class="movie-file-card movie-file-card_edit">
    <?php
    $this->renderPartial('_form', array(
        'formWidget' => $formWidget,
        'movieFileForm' => $movieFileForm,
    ));
    ?>

    <div class="section">
        <?= $btnHelper->submitButton(array('label' => 'Добавить', 'gl-icon' => 'plus', 'context' => 'success')); ?>
        <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
    </div>
</div>

<?php
$this->endWidget();

$this->renderPartial('_form/audio-params-template', array(
    'formWidget' => $formWidget,
    'movieFileForm' => $movieFileForm,
));

?>

</div>
