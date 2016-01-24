<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20.06.15
 * Time: 23:39
 */

namespace app\components;

use \Yii;
use \CHtml;


abstract class CrudController extends HtmlController
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function init()
    {
        // Инициализация конвертера префикса используемого в формах для редактирования и создания модели
        if (PROD_MODE) {
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

    protected function _tryAjaxValidation($form, $postData = array())
    {
        if ($this->_isAjaxValidationRequest()) {
            header('Content-Type: application/json');
            $form->setAttributesByPost($postData);
            echo $form->getAjaxValidationResponseContent();
            Yii::app()->end();
        }
    }
}
