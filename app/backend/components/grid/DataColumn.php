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
            $class = $this->_getModelClassShortName() . 'Link';
            self::$_crudLinkHelper = $this->grid->controller->getViewHelper($class);
        }
        return self::$_crudLinkHelper;

    }

    private function _getModelClassShortName()
    {
        return (new \ReflectionClass($this->grid->dataProvider->modelClass))->getShortName();
    }


} 