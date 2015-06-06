<?php

/**
 * @var $this \CController
 */

$this->pageTitle = 'Список игр';

$this->widget(
    '\backend\components\GridView',
    array(
//        'fixedHeader' => true,
//        'headerOffset' => 40,
        // 40px is the height of the main navigation at bootstrap
//        'type' => 'bordered hover',
        'dataProvider' => $gameDataProvider,
//        'responsiveTable' => true,
        'templateWidget' => true,
        'columns' => array(
            array(
                'name'=>'id',
            ),
            array(
                'class'=> '\backend\components\DataColumn\Game',
                'name'=>'title',
                'value'=> '$this->title($data)',
            ),
            array(
                'name'=>'text_id',
            ),
        ),
    )
);