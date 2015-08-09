<?php
$audioParams = $model->createAudioParams();
$audioParamsKeys = $model->getAudioParamsKeys();
$paramsArrayIndex = md5(__FILE__);

//$formCssId = $form->htmlOptions['id'];

$content = $this->renderPartial('_audio-params', array(
    'form' => $form,
    'params' => $audioParams,
    'paramsKeys' => $audioParamsKeys,
    'paramsArrayIndex' => $paramsArrayIndex,
    'isHideRemoveBtn' => false
), true);

echo CHtml::tag('script', array(
    'id' => 'movie-card_audio-template',
    'type' => 'text/x-template',
    'data-index-placeholder' => $paramsArrayIndex,
), $content);

