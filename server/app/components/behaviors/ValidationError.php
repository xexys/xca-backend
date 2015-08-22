<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08.08.15
 * Time: 17:09
 */

namespace app\components\behaviors;


class ValidationError extends \CBehavior
{
    public function getFirstErrorMessage()
    {
        $errors = $this->getOwner()->getErrors();
        if ($errors) {
            return reset($errors)[0];
        }
    }
}
