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
