<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.07.15
 * Time: 22:04
 */

namespace common\components\interfaces\Form;


interface AjaxValidation
{
    public function setAttributesByPost();

    public function getAjaxValidationResponseContent();
}