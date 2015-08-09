<?php
$platformInfoParams = $model->createPlatformInfoParams();
$platformInfoParamsKeys = $model->getPlatformInfoParamsKeys();
$paramsArrayIndex = md5(__FILE__);

//$formCssId = $form->htmlOptions['id'];

$content = $this->renderPartial('_platform-info-params', array(
    'form' => $form,
    'params' => $platformInfoParams,
    'paramsKeys' => $platformInfoParamsKeys,
    'paramsArrayIndex' => $paramsArrayIndex,
    'isHideRemoveBtn' => false
), true);


echo CHtml::tag('script', array(
    'id' => 'game-card_platform-info-template',
    'type' => 'text/x-template',
    'data-index-placeholder' => $paramsArrayIndex,
), $content);

