<?php

echo __FILE__;

$this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => '{{label}}',
        'htmlOptions' => array(
            'data-key' => '{{data-key}}'
        )
    )
);