<?php

return CMap::mergeArray(
    require Yii::getPathOfAlias('common.config.main') . '.php',
    require __DIR__ . '/overrides/base.php',
    require __DIR__ . '/overrides/' . (PROD_MODE ? 'prod' : 'dev') . '.php'
);
