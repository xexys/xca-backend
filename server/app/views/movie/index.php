<?php

$this->pageTitle = 'Ролики';

$this->widget(
    '\app\components\grid\BaseView',
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
                'class'=> 'app\components\grid\DataColumn\Movie',
                'name'=>'title',
                'value'=> '$this->title($data)',
            ),
            array(
                'name'=>'game.title',
            ),
            array(
                'name' => 'issue_year',
            ),
            array(
                'class' => '\app\components\grid\ButtonColumn',
            )
        ),

    )
);