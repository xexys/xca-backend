<?php

$this->pageTitle = 'Ролики';

$this->widget(
    '\backend\components\grid\BaseView',
    array(
        'dataProvider' => $movieDataProvider,
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