<?php

$cssHelper = $this->getViewUIHelper('Css');

foreach ($infoParams->getFormKeys() as $key) {
    $cssClass = 'movie-file-card_info-param_' . $cssHelper->fixCssName($key);

    if ($key === 'movieId') {
        $options = array(
            'class' => $cssClass,
        );

        echo $formWidget->hiddenField($infoParams, $key, $options);
    } elseif ($key === 'type') {
        $options = array('widgetOptions' => array(
            'data' => $infoParams->getTypeDictionary(),
            'htmlOptions'=>array(
                'class' => $cssClass,
            )
        ));

        echo $formWidget->dropDownListGroup($infoParams, $key, $options);
    } elseif ($key === 'comment') {
        $options = array('widgetOptions' => array(
            'htmlOptions'=>array(
                'class' => $cssClass,
                'rows' => 3,
            )
        ));

        echo $formWidget->textAreaGroup($infoParams, $key, $options);
    } else {
        $options = array('widgetOptions' => array(
            'htmlOptions'=>array(
                'autocomplete' => 'off',
                'class' => $cssClass,
            )
        ));

        echo $formWidget->textFieldGroup($infoParams, $key, $options);
    }


}
