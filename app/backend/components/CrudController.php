<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20.06.15
 * Time: 23:39
 */

namespace backend\components;

use \Yii;
use \CHtml;
use \CActiveForm;


abstract class CrudController extends Controller
{
    public function init()
    {
        // Инициализация конвертера префикса используемого в формах для редактирования модели
        if (!YII_DEBUG) {
            CHtml::setModelNameConverter(array($this, '_friendGetFormElementsNamePrefix'));
        }

        parent::init();
    }

    abstract public function actionIndex();

    abstract public function actionCreate();

    abstract public function actionView($id);

    abstract public function actionEdit($id);

    abstract public function actionDelete($id);

    public function _friendGetFormElementsNamePrefix($model)
    {
        return md5(get_class($model));
    }

    protected function _setModelAttributesByPost($model)
    {
        $model->setAttributes(array_map('trim', $_POST[CHtml::modelName($model)]));
    }

    /**
     * @param string $defaultBackAction - Куда переходить если нет urlReferrer
     * @return mixed|string
     */
    protected function _getBackUrl($defaultBackAction = 'index')
    {
        $request = Yii::app()->getRequest();
        $backUrl = $request->getUrlReferrer() ?: $this->createUrl($defaultBackAction);

        if ($request->getIsPostRequest() && ($postBackUrl = $request->getPost('backUrl'))) {
            $backUrl = $postBackUrl;
        }

        return $backUrl;
    }

    protected function _tryAjaxValidation($model)
    {
        if ($this->_isAjaxValidationRequest()) {
            header('Content-Type: application/json');
            echo $this->_getAjaxValidationResponseContent($model);
            Yii::app()->end();
        }
    }

    protected function _isAjaxValidationRequest()
    {
        $request = Yii::app()->getRequest();
        return $request->getIsPostRequest() && $request->getIsAjaxRequest() && $request->getPost('ajax');
    }

    protected function _getAjaxValidationResponseContent($model)
    {
        return CActiveForm::validate($model);
    }
}