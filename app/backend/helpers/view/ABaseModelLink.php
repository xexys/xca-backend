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


abstract class ABaseModelLink extends \common\helpers\view\ABase
{
    protected $_modelControllerId;
    
    public function getCreateUrl($params = array())
    {
        return $this->_getActionUrl('create', $params);
    }

    public function getViewUrl($model, $params = array())
    {
        return $this->_getActionUrl('view', $params, $model);
    }

    public function getEditUrl($model, $params = array())
    {
        return $this->_getActionUrl('edit', $params, $model);
    }

    public function getDeleteUrl($model, $params = array())
    {
        return $this->_getActionUrl('delete', $params, $model);
    }

    protected function _getActionUrl($actionId, $params, $model = null)
    {
        $controllerId = $this->_modelControllerId;
        if (!$controllerId) {
            throw new \CHttpException('Не указан ID контроллера для модели');
        }
        
        $route = $controllerId . '/' . $actionId;

        if ($model) {
            $params = array_merge(array('id' => $model->id), $params);
            return Yii::app()->createUrl($route, $params);
        } else {
            return Yii::app()->createUrl($route, $params);
        }
    }
}
