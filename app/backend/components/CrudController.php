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
use \common\helpers\Data as DataHelper;


abstract class CrudController extends HtmlController
{
    public function init()
    {
        // Инициализация конвертера префикса используемого в формах для редактирования модели
        if (!PROD_MODE) {
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

    /**
     * @param string $defaultBackAction - Куда переходить если нет urlReferrer
     * @return mixed|string
     */
    protected function _getBackUrl($defaultBackAction = 'index')
    {
        $request = $this->_getRequest();
        $backUrl = $request->getUrlReferrer() ?: $this->createUrl($defaultBackAction);

        if ($request->getIsPostRequest() && ($postBackUrl = $request->getPost('backUrl'))) {
            $backUrl = $postBackUrl;
        }

        return $backUrl;
    }

    protected function _isAjaxValidationRequest()
    {
        $request = $this->_getRequest();
        return $request->getIsPostRequest() && $request->getIsAjaxRequest() && $request->getPost('ajax');
    }

    protected function _tryAjaxValidation($model)
    {
        if ($this->_isAjaxValidationRequest()) {
            header('Content-Type: application/json');
            $this->_setAttributesByPost($model);
            echo $this->_getAjaxValidationResponseContent($model);
            Yii::app()->end();
        }
    }

    protected function _setAttributesByPost($model)
    {
        if ($model instanceof \common\components\interfaces\Form\AjaxValidation) {
            $model->setAttributesByPost();
        } else {
            $postData = Yii::app()->getRequest()->getPost(CHtml::modelName($model));
            $model->setAttributes(DataHelper::trimRecursive($postData));
        }
    }

    private function _getAjaxValidationResponseContent($model)
    {
        if ($model instanceof \common\components\interfaces\Form\AjaxValidation) {
            return $model->getAjaxValidationResponseContent();
        } else {
            return CActiveForm::validate($model, null, false);
        }
    }

}
