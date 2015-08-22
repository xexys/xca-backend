<?php

$platformInfoParams = $formSet->itemAt('platformInfoParams');

$item = $platformInfoParams->createItem();
$formKeys = $platformInfoParams->getFormKeys();
$itemIndex = md5(__FILE__);

//$formCssId = $form->htmlOptions['id'];

$content = $this->renderPartial('_form-platform-info-params-item', array(
    'formWidget' => $formWidget,
    'params' => $item,
    'paramsKeys' => $formKeys,
    'paramsItemIndex' => $itemIndex,
    'isHideRemoveBtn' => false
), true);


echo CHtml::tag('script', array(
    'id' => 'game-card_platform-info-template',
    'type' => 'text/x-template',
    'data-index-placeholder' => $itemIndex,
), $content);

