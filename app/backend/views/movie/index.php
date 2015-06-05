<?php

$this->pageTitle = 'Список роликов';
$this->breadcrumbs = array(
    'Ролики'=> $this->createUrl('index')
);

$this->widget(
    '\backend\components\grids\GridView',
    array(
//        'fixedHeader' => true,
//        'headerOffset' => 40,
        // 40px is the height of the main navigation at bootstrap
//        'type' => 'bordered hover',
        'dataProvider' => $movieDataProvider,
//        'responsiveTable' => true,
//        'columns' => $gridColumns,
    )
);