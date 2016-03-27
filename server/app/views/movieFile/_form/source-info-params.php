<?php

$cssHelper = $this->getViewUIHelper('Css');

foreach ($sourceInfoParams->getFormKeys() as $key) {
    $cssClass = 'movie-file-card_source-info-param_' . $cssHelper->fixCssName($key);

    if ($key === 'gamePlatformId') {
        $options = array('widgetOptions' => array(
            'data'=> $sourceInfoParams->getGamePlatformDictionary(),
            'htmlOptions'=>array(
                'class' => $cssClass
            )
        ));

        echo $formWidget->dropDownListGroup($sourceInfoParams, $key, $options);
    } else {
        $options = array('widgetOptions' => array(
            'htmlOptions'=>array(
                'data-label-width' => 10,
                'data-on-text' => 'Да',
                'data-off-text' => 'Нет',
                'data-size' => 'small',
                'autocomplete' => 'off',
                'class' => $cssClass
            )
        ));
        echo $formWidget->switchGroup($sourceInfoParams, $key, $options);
    }
}
