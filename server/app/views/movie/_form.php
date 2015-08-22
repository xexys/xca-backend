<?php

$mainParams = $model->mainParams;
$fileParams = $model->fileParams;
$videoParams = $model->videoParams;
$audioParamsArray = array_values($model->audioParamsCollection->toArray());

?>

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
            <div>
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
                    // Важно сбросить ключи, чтобы номера начинались с 0
                    $audioParamsArray = array_values($model->audioParamsCollection->toArray());
                    $audioParamsArrayCount = count($audioParamsArray);

                    foreach ($audioParamsArray as $n => $audioParams) {
                        $this->renderPartial('_audio-params', array(
                            'form' => $form,
                            'params' => $audioParams,
                            'paramsKeys' => $audioParamsKeys,
                            'paramsItemIndex' => $n,
                            'isHideRemoveBtn' => $audioParamsArrayCount === 1,
                        ));
                    }
                ?>
            </div>
        </div>
    </div>
</div>
