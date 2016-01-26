<?php

$this->pageTitle = 'Файлы';

$this->widget(
    '\app\components\grid\BaseView',
    array(
        'dataProvider' => $movieFileDataProvider,
        'templateWidget'=>array(
            'params'=> array(
                'createItemButton'=>true,
            ),
        ),
        'columns' => array(
            array(
                'name'=>'id',
            ),
//            array(
//                'class'=> 'app\components\grid\DataColumn\Movie',
//                'name'=>'title',
//                'value'=> '$this->title($data)',
//            ),
            array(
                'name'=>'mainParams.name',
            ),
            array(
                'name'=>'type',
            ),
            array(
                'name'=>'movie.game.title',
            ),
            array(
                'name'=>'movie.title',
            ),
            array(
                'class' => '\app\components\grid\CrudButtonColumn',
            )
        ),

    )
);