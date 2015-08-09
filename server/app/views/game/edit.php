<?php

$uiHelper = $this->getViewHelper('UI');
$btnHelper = $uiHelper->getButtonHelper();

$this->pageTitle = $gameTitle;
$this->pageTitleIconClass = 'glyphicon glyphicon-pencil';


$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'type' => 'horizontal',
    )
);

echo CHtml::hiddenField('backUrl', $backUrl);

?>

<div class="game-card game-card_edit">
    <?php
    $this->renderPartial('_form', array(
        'form' => $form,
        'model' => $model,
    ));
    ?>

    <div class="game-card_section">
        <?= $btnHelper->submitButton(array('label' => 'Сохранить', 'fa-icon' => 'save', 'context' => 'success')); ?>
        <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
    </div>

</div>

<?php

$this->endWidget();

$this->renderPartial('_platform-info-params-template', array(
    'form' => $form,
    'model' => $model,
));

