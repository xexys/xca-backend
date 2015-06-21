<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08.06.15
 * Time: 0:40
 */

namespace backend\components\grid;


class DataColumn extends \CDataColumn
{
    private static $_crudLinkHelper;

    protected function _getCrudLinkHelper()
    {
        if (self::$_crudLinkHelper === null) {
            $modelClass = $this->grid->dataProvider->modelClass;
            self::$_crudLinkHelper = $this->grid->controller->getViewModelLinkHelper($modelClass);
        }
        return self::$_crudLinkHelper;

    }


} 