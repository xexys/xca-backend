<?php

$cssHelper = $this->getViewUIHelper('Css');

foreach ($videoParams->getFormKeys() as $key) {
    $cssClass = 'movie-file-card_video-param_' . $cssHelper->fixCssName($key);

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
