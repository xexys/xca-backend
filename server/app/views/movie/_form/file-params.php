<?php

$cssHelper = $this->getViewUIHelper('Css');

foreach ($fileParams->getFormKeys() as $key) {
    $cssClass = 'movie-card_file-param_' . $cssHelper->fixCssName($key);

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
