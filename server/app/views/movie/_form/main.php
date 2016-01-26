<?php

$cssHelper = $this->getViewUIHelper('Css');

foreach ($movieForm->getFormKeys() as $key) {
    $cssClass = 'movie-card_main-param_' . $cssHelper->fixCssName($key);
    $placeholder = $movieForm->getAttributeLabel($key);
    $htmlOptions = array(
        'autocomplete' => 'off',
        'placeholder' => $placeholder,
        'class' => $cssClass,
    );

    if ($key === 'issueYear') {
        $options = array(
            'widgetOptions' => array(
                'options' => array(
                    'minViewMode' => 'years',
                    'format' => APP_DATEPICKER_YEAR_FORMAT

                ),
                'htmlOptions' => $htmlOptions
            )
        );

        echo $formWidget->datePickerGroup($movieForm, $key, $options);

    } else {
        $options = array('widgetOptions' => array(
            'htmlOptions' => $htmlOptions
        ));

        echo $formWidget->textFieldGroup($movieForm, $key, $options);
    }

}
