<?php
$audioParams = $movieFileForm->itemAt('audioParams');
$paramsItemIndex = md5(__FILE__);

//$formWidgetCssId = $formWidget->htmlOptions['id'];

$content = $this->renderPartial('_form/audio-params', array(
    'formWidget' => $formWidget,
    'paramsItem' => $audioParams->createItem(),
    'paramsItemIndex' => $paramsItemIndex,
    'hideRemoveBtn' => false
), true);

echo CHtml::tag('script', array(
    'id' => 'movie-file-card_audio-template',
    'type' => 'text/x-template',
    'data-index-placeholder' => $paramsItemIndex,
), $content);

