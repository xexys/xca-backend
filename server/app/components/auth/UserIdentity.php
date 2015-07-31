<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.05.15
 * Time: 20:04
 */

namespace app\components\auth;

use \app\models\User;

class UserIdentity extends \CUserIdentity
{
    public $email;

    private $_id;

    const ERROR_EMAIL_INVALID = 3;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticate()
    {

        //$user = User::model()->notDeleted()->findByAttributes(array('email'=>$this->email));
        $user = User::model()->find(array(
            'condition' => "email=:email",
            'params' => array(':email' => $this->email)
        ));

        if ($user === null) {
            $this->errorCode = self::ERROR_EMAIL_INVALID;
        } elseif ($user->password !== $this->password) {
            // TODO: Сделать проверку по хешу
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->id;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}