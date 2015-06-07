<?php

use \backend\helpers\Html;

$this->pageTitle = 'Новая игра';

$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'enableAjaxValidation'=>false,
        'type' => 'horizontal',
    )
);

?>

<div class="game-card game-card_edit">

    <div class="game-card_section">
        <div class="row">
            <div class="col-md-6">
                <h4 class="game-card_header">Информация об игре</h4>
                <div class="game-card_info">
                    <?= $form->textFieldGroup($game, 'text_id'); ?>
                    <?= $form->textFieldGroup($game, 'title'); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="game-card_picture">
                    <?= CHtml::image('?=' . PHP_EGG_LOGO_GUID); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="game-card_section">
        <?= Html::TbSubmitButton(array('label' => 'Добавить', 'fa-icon' => 'plus', 'context' => 'success')); ?>
        <?= Html::TbLinkButton(array('label' => 'Отмена', 'fa-icon' => 'ban', 'context' => 'primary', 'url' => '#')); ?>
    </div>

<?php

$this->endWidget();
