<?php
/**
 * Базовый хелпер для генирации CRUD урлов для модели
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 23:24
 */

namespace backend\helpers\view;

use \Yii;


abstract class ModelLink extends \common\helpers\view\Base
{
    protected $_modelControllerId;
    
    public function getCreateUrl()
    {
        return $this->_getActionUrl('create');
    }

    public function getViewUrl($model)
    {
        return $this->_getActionUrl('view', $model);
    }

    public function getEditUrl($model)
    {
        return $this->_getActionUrl('edit', $model);
    }

    public function getDeleteUrl($model)
    {
        return $this->_getActionUrl('delete', $model);
    }

    public function _getActionUrl($actionId, $model = null)
    {
        $controllerId = $this->_modelControllerId;
        if (!$controllerId) {
            throw new \CHttpException('Не указан ID контроллера для модели');
        }
        
        $route = $controllerId . '/' . $actionId;

        if ($model) {
            return Yii::app()->createUrl($route, array('id' => $model->id));
        } else {
            return Yii::app()->createUrl($route);
        }
    }
} 