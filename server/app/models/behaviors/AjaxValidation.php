<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.07.15
 * Time: 22:04
 */

namespace app\models\behaviors;

use \Yii;
use \CHtml;
use \CActiveForm;
use \app\helpers\Data as DataHelper;


class AjaxValidation extends \CBehavior
{
    public function setAttributesByPost()
    {
        $owner = $this->getOwner();
        $postData = Yii::app()->getRequest()->getPost(CHtml::modelName($owner));
        $owner->setAttributes(DataHelper::trimRecursive($postData));
    }

    public function getAjaxValidationResponseContent()
    {
        return CActiveForm::validate($this->getOwner(), null, false);
    }
}