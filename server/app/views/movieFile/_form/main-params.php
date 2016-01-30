<?php

$cssHelper = $this->getViewUIHelper('Css');

foreach ($mainParams->getFormKeys() as $key) {
    $cssClass = 'movie-file-card_main-param_' . $cssHelper->fixCssName($key);

    if ($key == 'formatId') {
        $options = array('widgetOptions' => array(
            'data'=> $mainParams->getFormatDictionary(),
            'htmlOptions'=>array(
                'class' => $cssClass
            )
        ));
        echo $formWidget->dropDownListGroup($mainParams, $key, $options);
    } else {
        $options = array('widgetOptions' => array(
            'htmlOptions'=>array(
                'autocomplete' => 'off',
                'class' => $cssClass
            )
        ));
        echo $formWidget->textFieldGroup($mainParams, $key, $options);
    }
}
