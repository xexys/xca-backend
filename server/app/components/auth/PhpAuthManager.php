<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.05.15
 * Time: 20:04
 */

namespace app\components\auth;
use \Yii;


class PhpAuthManager extends \CPhpAuthManager
{
    public function init()
    {
        parent::init();

        $webUser = Yii::app()->getUser();

        // Связываем роли заданные в БД если пользователь не гость и не заблокирован
        if (!$webUser->getIsGuest()) {

            // Связываем роль, заданную в БД с идентификатором пользователя,
            // возвращаемым UserIdentity::getId().
            $this->assign($webUser->getRole(), $webUser->getId());
        }
    }

} 