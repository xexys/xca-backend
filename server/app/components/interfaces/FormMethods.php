<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.08.15
 * Time: 14:20
 */

namespace app\components\interfaces;


interface FormMethods
{
    public function setAttributesByPost($postData = array());

    public function getAjaxValidationResponseContent();

} 