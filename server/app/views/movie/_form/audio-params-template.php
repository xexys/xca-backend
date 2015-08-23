<?php
$audioParams = $movieParams->itemAt('audioParams');
$audioParamsKeys = $audioParams->getFormKeys();
$paramsItemIndex = md5(__FILE__);

//$formWidgetCssId = $formWidget->htmlOptions['id'];

$content = $this->renderPartial('_form/audio-params', array(
    'formWidget' => $formWidget,
    'params' => $audioParams->createItem(),
    'paramsKeys' => $audioParamsKeys,
    'paramsItemIndex' => $paramsItemIndex,
    'isHideRemoveBtn' => false
), true);

echo CHtml::tag('script', array(
    'id' => 'movie-card_audio-template',
    'type' => 'text/x-template',
    'data-index-placeholder' => $paramsItemIndex,
), $content);

