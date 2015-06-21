<?php

$this->pageTitle = 'Новый ролик';

$btnHelper = $this->getViewHelper('UI\Button');

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

<div class="game-card game-card_edit">

    <div class="row">
        <div class="col-md-6">
            <div class="movie-card_section">
                <h4 class="movie-card_title">Основные параметры</h4>
                <div class="">
                    <?php
                    foreach ($model->getMainInputKeys() as $key) {
                        echo $form->textFieldGroup($model->mainParams, $key);
                    }
                    ?>
                </div>
            </div>

            <div class="movie-card_section">
                <h4 class="movie-card_title">Видео параметры</h4>
                <div class="">
                    <?php
                    foreach ($model->getVideoInputKeys() as $key) {
                        echo $form->textFieldGroup($model->videoParams, $key);
                    } ?>
                </div>
            </div>

            <div class="movie-card_section">
                <h4 class="movie-card_title">Аудио параметры</h4>
                <div class="">
                    <?php
                    $audioParamsKeys = $model->getAudioInputKeys();
                    foreach ($model->audioParams as $n => $audioParams) {
                        foreach ($audioParamsKeys as $key) {
                            $name = '[' . $n . ']' . $key;
                            echo $form->textFieldGroup($audioParams, $name);
                        }
                        echo '<hr>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="movie-card_section">
        <?= $btnHelper->submitButton(array('label' => 'Добавить', 'gl-icon' => 'plus', 'context' => 'success')); ?>
        <?= $btnHelper->linkButton(array('label' => 'Отмена', 'gl-icon' => 'ban-circle', 'context' => 'primary', 'url' => $backUrl)); ?>
    </div>

</div>

<?php
$this->endWidget();

