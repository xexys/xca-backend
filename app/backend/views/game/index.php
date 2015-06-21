<?php

/**
 * @var $this \CController
 */

$this->pageTitle = 'Игры';

$this->widget(
    '\backend\components\grid\BaseView',
    array(
        'dataProvider' => $gameDataProvider,
        'templateWidget'=>array(
            'params'=> array(
                'createItemButton'=>true,
            ),
        ),
        'columns' => array(
            array(
                'name' => 'id',
            ),
            array(
                'class' => '\backend\components\grid\DataColumn\Game',
                'name' => 'title',
                'value' => '$this->title($data)',
            ),
            array(
                'name' => 'text_id',
            ),
            array(
                'class' => '\backend\components\grid\ButtonColumn',
            )
        ),
    )
);