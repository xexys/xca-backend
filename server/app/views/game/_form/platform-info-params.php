<?php

$platformInfoParamsKeys = $platformInfoParams->getParamsKeys();

// Важно сбросить ключи, чтобы номера начинались с 0
$platformInfoParamsItems = array_values($platformInfoParams->items->toArray());
$platformInfoParamsItemsCount = count($platformInfoParamsItems);

foreach ($platformInfoParamsItems as $n => $platformInfoParamsItem) {
    $this->renderPartial('_form/platform-info-params-item', array(
        'formWidget' => $formWidget,
        'params' => $platformInfoParamsItem,
        'paramsKeys' => $platformInfoParamsKeys,
        'paramsItemIndex' => $n,
        'isHideRemoveBtn' => $platformInfoParamsItemsCount === 1,
    ));
}
