<?php

$this->pageTitle = 'Ролики';

$this->widget(
    '\backend\components\grid\BaseView',
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
                'class'=> 'backend\components\grid\DataColumn\Movie',
                'name'=>'title',
                'value'=> '$this->title($data)',
            ),
            array(
                'name'=>'game.title',
            ),
        ),

    )
);