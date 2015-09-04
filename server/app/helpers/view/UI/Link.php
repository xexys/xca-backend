<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.06.15
 * Time: 22:04
 */

namespace app\helpers\view\UI;

use \CHtml;


class Link extends \app\helpers\view\Base
{
    const CRUD_ACTION_ADD = 'add';
    const CRUD_ACTION_REMOVE = 'remove';
    const CRUD_ACTION_EDIT = 'edit';

    private $_iconHelper;

    public function crudAddLink($params)
    {
        $params['action'] = self::CRUD_ACTION_ADD;
        return $this->crudLink($params);
    }

    public function crudEditLink($params)
    {
        $params['action'] = self::CRUD_ACTION_EDIT;
        return $this->crudLink($params);
    }

    public function crudRemoveLink($params)
    {
        $params['action'] = self::CRUD_ACTION_REMOVE;
        return $this->crudLink($params);
    }

    public function crudLink($params)
    {
        $action = $params['action'];
        unset($params['action']);

        switch ($action) {
            case self::CRUD_ACTION_ADD:
                $params['fa-icon'] = 'plus-circle';
                break;
            case self::CRUD_ACTION_REMOVE:
                $params['fa-icon'] = 'minus-circle';
                break;
            case self::CRUD_ACTION_EDIT:
                $params['gl-icon'] = 'pencil';
                break;
       }

        $params['class'] = 'link_crud-' . $action;

        return $this->link($params);
    }

    public function link($params)
    {
        $label = $params['label'];
        $url = isset($params['url']) ? $params['url'] : null;

        if (isset($params['fa-icon'])) {
            $icon = 'fa fa-' . $params['fa-icon'];
        } elseif (isset($params['gl-icon'])) {
            $icon = 'glyphicon glyphicon-' . $params['gl-icon'];
        } elseif (isset($params['icon']))  {
            $icon = $params['icon'];
        }
        $iconClass = 'link_icon ' . $icon;

        $linkClass = 'link';
        if (isset($params['class'])) {
            $linkClass .= ' ' . $params['class'];
        }

        $tag = $url ? 'a': 'span';

        $htmlOptions = array(
            'class' => $linkClass,
            'href' => $url,
        );

        $content = '';
        if ($iconClass) {
            $content .= $this->_getIconHelper()->icon($iconClass);
        }
        $content .= CHtml::tag('span', array('class'=>'link_text'), $label);

        return CHtml::tag($tag, $htmlOptions, $content);
    }

    private function _getIconHelper()
    {
        if ($this->_iconHelper === null) {
            $this->_iconHelper = new Icon($this->_controller);
        }
        return $this->_iconHelper;
    }

}
