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
            'gameParams' => $gameParams,
        ));
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="section game-card_buttons-panel">
                <hr>
                <?= $btnHelper->submitButton(array('label' => 'Добавить', 'gl-icon' => 'plus', 'context' => 'success')); ?>
                <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
            </div>
        </div>
    </div>

</div>

<?php

$this->endWidget();
