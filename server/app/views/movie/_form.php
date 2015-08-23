<?php

$mainParams = $movieParams->itemAt('mainParams');
$fileParams = $movieParams->itemAt('fileParams');
$videoParams = $movieParams->itemAt('videoParams');
$audioParams = $movieParams->itemAt('audioParams');

?>

<div class="row">
    <div class="col-md-6">
        <div class="movie-card_section">
            <?php
            foreach ($mainParams->getFormKeys() as $key) {
                $cssClass = 'movie-card_main-param_' . $mainParams->fixCssName($key);
                $options = array('widgetOptions' => array(
                    'htmlOptions'=>array(
                        'autocomplete' => 'off',
                        'class' => $cssClass
                    )
                ));
                echo $formWidget->textFieldGroup($mainParams, $key, $options);
            }
            ?>
        </div>

        <div class="movie-card_section">
            <h4 class="movie-card_title">Параметры файла</h4>
            <div>
                <?php
                foreach ($fileParams->getFormKeys() as $key) {
                    $cssClass = 'movie-card_file-param_' . $fileParams->fixCssName($key);

                    if ($key == 'formatId') {
                        $options = array('widgetOptions' => array(
                            'data'=> $fileParams->getFormatDictionary(),
                            'htmlOptions'=>array(
                                'class' => $cssClass
                            )
                        ));
                        echo $formWidget->dropDownListGroup($fileParams, $key, $options);
                    } else {
                        $options = array('widgetOptions' => array(
                            'htmlOptions'=>array(
                                'autocomplete' => 'off',
                                'class' => $cssClass
                            )
                        ));
                        echo $formWidget->textFieldGroup($fileParams, $key, $options);
                    }
                }
                ?>
            </div>
        </div>

        <div class="movie-card_section">
            <h4 class="movie-card_title">Параметры видео</h4>
            <div class="">
                <?php
                foreach ($videoParams->getFormKeys() as $key) {
                    $cssClass = 'movie-card_video-param_' . $videoParams->fixCssName($key);

                    if (in_array($key, array('formatId', 'frameRate', 'frameRateMode'))) {
                        $options = array('widgetOptions' => array(
                            'data'=> $videoParams->getDictionary($key),
                            'htmlOptions'=>array(
                                'class' => $cssClass
                            )
                        ));
                        echo $formWidget->dropDownListGroup($videoParams, $key, $options);
                    } else {
                        $options = array('widgetOptions' => array(
                            'htmlOptions'=>array(
                                'autocomplete' => 'off',
                                'class' => $cssClass
                            )
                        ));
                        echo $formWidget->textFieldGroup($videoParams, $key, $options);
                    }
                }
                ?>
            </div>
        </div>

        <div class="movie-card_section">
            <h4 class="movie-card_title">Параметры аудио</h4>
            <div class="">
                <?php
                    $audioParamsKeys = $audioParams->getFormKeys();
                    // Важно сбросить ключи, чтобы номера начинались с 0
                    $audioParamsItems = array_values($audioParams->items->toArray());
                    $audioParamsItemsCount = count($audioParamsItems);

                    foreach ($audioParamsItems as $n => $audioParamsItem) {
                        $this->renderPartial('_form/audio-params', array(
                            'formWidget' => $formWidget,
                            'params' => $audioParamsItem,
                            'paramsKeys' => $audioParamsKeys,
                            'paramsItemIndex' => $n,
                            'isHideRemoveBtn' => $audioParamsItemsCount === 1,
                        ));
                    }
                ?>
            </div>
        </div>
    </div>
</div>
