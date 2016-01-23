<?php

$issuesInfoParamsKeys = $issuesInfoParams->getFormKeys();

// Важно сбросить ключи, чтобы номера начинались с 0
$issuesInfoParamsItems = array_values($issuesInfoParams->items->toArray());
$issuesInfoParamsItemsCount = count($issuesInfoParamsItems);

foreach ($issuesInfoParamsItems as $n => $issuesInfoParamsItem) {
    $this->renderPartial('_form/issues-info-params-item', array(
        'formWidget' => $formWidget,
        'params' => $issuesInfoParamsItem,
        'paramsKeys' => $issuesInfoParamsKeys,
        'paramsItemIndex' => $n,
        'isHideRemoveBtn' => $issuesInfoParamsItemsCount === 1,
    ));
}

$this->renderPartial('_form/issues-info-params-item-template', array(
    'formWidget' => $formWidget,
    'issuesInfoParams' => $issuesInfoParams,
));