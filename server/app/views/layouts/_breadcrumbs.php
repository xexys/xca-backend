<?php

$breadcrumbs = array(
    $this->id => Yii::app()->createUrl($this->id),
    $this->action->id
);

$this->widget('booster.widgets.TbBreadcrumbs', array(
    'homeLink' => CHtml::link('Главная', Yii::app()->homeUrl),
    'links' => $breadcrumbs,
));