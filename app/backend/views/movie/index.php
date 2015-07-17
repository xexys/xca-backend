<?php

$this->pageTitle = 'Ролики';

$this->widget(
    '\backend\components\grid\BaseView',
    array(
        'dataProvider' => $movieDataProvider,
        'templateWidget'=>array(
            'params'=> array(
                'createItemButton'=>true,
            ),
        ),
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
            array(
                'class' => '\backend\components\grid\ButtonColumn',
            )
        ),

    )
);