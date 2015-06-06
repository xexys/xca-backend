<?php

$this->pageTitle = 'Список роликов';

$this->widget(
    '\backend\components\GridView',
    array(
//        'fixedHeader' => true,
//        'headerOffset' => 40,
        // 40px is the height of the main navigation at bootstrap
//        'type' => 'bordered hover',
        'dataProvider' => $movieDataProvider,
//        'responsiveTable' => true,
        'templateWidget' => true,
        'columns' => array(
            array(
                'name'=>'id',
            ),
            array(
                'class'=> 'backend\components\DataColumn\Movie',
                'name'=>'title',
                'value'=> '$this->title($data)',
            ),
            array(
                'name'=>'game.title',
            ),
        ),

    )
);