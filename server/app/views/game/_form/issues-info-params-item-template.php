<?php

$item = $issuesInfoParams->createItem();
$formKeys = $issuesInfoParams->getFormKeys();
$itemIndex = md5(__FILE__);

//$formCssId = $form->htmlOptions['id'];

$content = $this->renderPartial('_form/issues-info-params-item', array(
    'formWidget' => $formWidget,
    'params' => $item,
    'paramsKeys' => $formKeys,
    'paramsItemIndex' => $itemIndex,
    'isHideRemoveBtn' => false
), true);


echo CHtml::tag('script', array(
    'id' => 'game-card_issue-info-template',
    'type' => 'text/x-template',
    'data-index-placeholder' => $itemIndex,
), $content);

