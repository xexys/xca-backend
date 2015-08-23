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
