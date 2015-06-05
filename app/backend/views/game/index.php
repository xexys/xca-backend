<?php

$this->pageTitle = 'Список игр';
$this->breadcrumbs = array(
    'Игры'=> $this->createUrl('index')
);

$this->widget(
    '\backend\components\grids\GridView',
    array(
//        'fixedHeader' => true,
//        'headerOffset' => 40,
        // 40px is the height of the main navigation at bootstrap
//        'type' => 'bordered hover',
        'dataProvider' => $gameDataProvider,
//        'responsiveTable' => true,
//        'columns' => $gridColumns,
    )
);