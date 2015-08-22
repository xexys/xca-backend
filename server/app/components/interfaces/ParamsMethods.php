<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.08.15
 * Time: 14:20
 */

namespace app\components\interfaces;


interface ParamsMethods
{
    public function setAttributesByPost($postData = array());

    public function getAjaxValidationResponseContent();

    public function validate($attributes = null, $clearErrors = true);

}