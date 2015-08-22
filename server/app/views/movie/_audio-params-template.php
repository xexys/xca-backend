<?php
$audioParams = $model->createAudioParams();
$audioParamsKeys = $model->getAudioParamsKeys();
$paramsItemIndex = md5(__FILE__);

//$formCssId = $form->htmlOptions['id'];

$content = $this->renderPartial('_audio-params', array(
    'form' => $form,
    'params' => $audioParams,
    'paramsKeys' => $audioParamsKeys,
    'paramsItemIndex' => $paramsItemIndex,
    'isHideRemoveBtn' => false
), true);

echo CHtml::tag('script', array(
    'id' => 'movie-card_audio-template',
    'type' => 'text/x-template',
    'data-index-placeholder' => $paramsItemIndex,
), $content);

