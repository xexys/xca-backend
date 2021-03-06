<div class="page_movie-card">

<?php

$this->pageTitle = 'Новый ролик';

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

<div class="movie-card movie-card_edit">
    <?php
    $this->renderPartial('_form', array(
        'formWidget' => $formWidget,
        'movieForm' => $movieForm,
    ));
    ?>

    <div class="section">
        <?= $btnHelper->submitButton(array('label' => 'Добавить', 'gl-icon' => 'plus', 'context' => 'success')); ?>
        <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
    </div>
</div>

<?php
$this->endWidget();

?>

</div>
