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

$mainParams = $model->mainParams;
$fileParams = $model->fileParams;
$videoParams = $model->videoParams;
$audioParamsArray = $model->audioParamsArray;

echo CHtml::hiddenField('backUrl', $backUrl);

?>

<div class="movie-card movie-card_edit">

    <div class="row">
        <div class="col-md-6">
            <div class="movie-card_section">
                <?php
                foreach ($model->getMainParamsKeys() as $key) {
                    $cssClass = 'movie-card_main-param_' . $model->fixCssName($key);
                    $options = array('widgetOptions' => array(
                        'htmlOptions'=>array(
                            'autocomplete' => 'off',
                            'class' => $cssClass
                        )
                    ));
                    echo $form->textFieldGroup($mainParams, $key, $options);
                }
                ?>
            </div>

            <div class="movie-card_section">
                <h4 class="movie-card_title">Параметры файла</h4>
                <div class="">
                    <?php
                    foreach ($model->getFileParamsKeys() as $key) {
                        $cssClass = 'movie-card_file-param_' . $model->fixCssName($key);

                        if ($key == 'formatId') {
                            $options = array('widgetOptions' => array(
                                'data'=> $fileParams->getFormatDictionary(),
                                'htmlOptions'=>array(
                                    'class' => $cssClass
                                )
                            ));
                            echo $form->dropDownListGroup($fileParams, $key, $options);
                        } else {
                            $options = array('widgetOptions' => array(
                                'htmlOptions'=>array(
                                    'autocomplete' => 'off',
                                    'class' => $cssClass
                                )
                            ));
                            echo $form->textFieldGroup($fileParams, $key, $options);
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="movie-card_section">
                <h4 class="movie-card_title">Параметры видео</h4>
                <div class="">
                    <?php
                    foreach ($model->getVideoParamsKeys() as $key) {
                        $cssClass = 'movie-card_video-param_' . $model->fixCssName($key);

                        if (in_array($key, array('formatId', 'frameRate', 'frameRateMode'))) {
                            $options = array('widgetOptions' => array(
                                'data'=> $videoParams->getDictionary($key),
                                'htmlOptions'=>array(
                                    'class' => $cssClass
                                )
                            ));
                            echo $form->dropDownListGroup($videoParams, $key, $options);
                        } else {
                            $options = array('widgetOptions' => array(
                                'htmlOptions'=>array(
                                    'autocomplete' => 'off',
                                    'class' => $cssClass
                                )
                            ));
                            echo $form->textFieldGroup($videoParams, $key, $options);
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="movie-card_section">
                <h4 class="movie-card_title">Параметры аудио</h4>
                <div class="">
                    <?php
                    $audioParamsKeys = $model->getAudioParamsKeys();
                    foreach ($audioParamsArray as $n => $audioParams) {
                        foreach ($audioParamsKeys as $key) {
                            $cssClass = 'movie-card_audio-param_' . $model->fixCssName($key);
                            $name = '[' . $n . ']' . $key;
                            $placeholder = $audioParams->getAttributeLabel($key);

                            if (in_array($key, array('formatId', 'bitRateMode', 'channels', 'languageId', 'sampleRate'))) {
                                $options = array('widgetOptions' => array(
                                    'data'=> $audioParams->getDictionary($key),
                                    'htmlOptions'=>array(
                                        'placeholder' => $placeholder,
                                        'class' => $cssClass,
                                    )
                                ));
                                echo $form->dropDownListGroup($audioParams, $name, $options);
                            } else {
                                $options = array('widgetOptions' => array(
                                    'htmlOptions'=>array(
                                        'autocomplete' => 'off',
                                        'placeholder' => $placeholder,
                                        'class' => $cssClass
                                    )
                                ));
                                echo $form->textFieldGroup($audioParams, $name, $options);
                            }
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

