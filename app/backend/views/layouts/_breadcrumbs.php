<?php

$this->widget('booster.widgets.TbBreadcrumbs', array(
    'homeLink' => CHtml::link('Главная', Yii::app()->homeUrl),
    'links' => $this->breadcrumbs,
));