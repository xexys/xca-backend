<?php

$platformsInfoParamsKeys = $platformsInfoParams->getFormKeys();

// Важно сбросить ключи, чтобы номера начинались с 0
$platformsInfoParamsItems = array_values($platformsInfoParams->items->toArray());
$platformsInfoParamsItemsCount = count($platformsInfoParamsItems);

foreach ($platformsInfoParamsItems as $n => $platformsInfoParamsItem) {
    $this->renderPartial('_form/platforms-info-params-item', array(
        'formWidget' => $formWidget,
        'params' => $platformsInfoParamsItem,
        'paramsKeys' => $platformsInfoParamsKeys,
        'paramsItemIndex' => $n,
        'isHideRemoveBtn' => $platformsInfoParamsItemsCount === 1,
    ));
}
