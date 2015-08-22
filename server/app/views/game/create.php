<?php

$this->pageTitle = 'Новая игра';

$btnHelper = $this->getViewHelper('UI\Button');

$formWidget = $this->beginWidget(
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
            'formWidget' => $formWidget,
            'formSet' => $formSet,
        ));
    ?>

    <div class="game-card_section">
        <?= $btnHelper->submitButton(array('label' => 'Добавить', 'gl-icon' => 'plus', 'context' => 'success')); ?>
        <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
    </div>

</div>

<?php

$this->endWidget();

$this->renderPartial('_form/platform-info-params-item-template', array(
    'formWidget' => $formWidget,
    'formSet' => $formSet,
));
