<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.06.15
 * Time: 23:47
 */

namespace app\components\grid;

use \Yii;

Yii::import('booster.widgets.TbButtonColumn');


class ButtonColumn extends \TbButtonColumn
{
    const BUTTON_VIEW_LABEL = 'Просмотреть';

    const BUTTON_EDIT_LABEL = 'Редактировать';

    const BUTTON_DELETE_LABEL = 'Удалить';

    public $template = '{edit} {delete}';

    public $buttons = array(
        'view' => array(
            'label' => self::BUTTON_VIEW_LABEL,
            'icon' => 'eye-open',
            'url' => '$this->getViewUrl($data)'
        ),
        'edit' => array(
            'label' => self::BUTTON_EDIT_LABEL,
            'icon' => 'pencil',
            'url' => '$this->getEditUrl($data)'
        ),
        'delete' => array(
            'label' => self::BUTTON_DELETE_LABEL,
            'icon' => 'trash',
            'url' => '$this->getDeleteUrl($data)'
        )
    );

    private static $_crudLinkHelper;

    public function getViewUrl($game)
    {
        return $this->_getCrudLinkHelper()->getViewUrl($game);
    }

    public function getEditUrl($game)
    {
        return $this->_getCrudLinkHelper()->getEditUrl($game);
    }

    public function getDeleteUrl($game)
    {
        return $this->_getCrudLinkHelper()->getDeleteUrl($game);
    }

    protected function _getCrudLinkHelper()
    {
        if (self::$_crudLinkHelper === null) {
            $name = 'ModelLink\\' . $this->_getModelClassShortName();
            self::$_crudLinkHelper = $this->grid->controller->getViewHelper($name);
        }
        return self::$_crudLinkHelper;

    }

    private function _getModelClassShortName()
    {
        return (new \ReflectionClass($this->grid->dataProvider->modelClass))->getShortName();
    }


} 