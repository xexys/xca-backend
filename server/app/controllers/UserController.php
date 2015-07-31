<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.05.15
 * Time: 19:44
 */

namespace app\controllers;

use \Yii;
use \app\components\auth\UserIdentity;
use \app\models\User;

class UserController extends \app\components\HtmlController
{
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('login', 'logout', 'signup'),
                'users' => array('*'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    // Авторизация пользователя
    public function actionLogin()
    {
        $webUser = Yii::app()->getUser();

        if ($webUser->getIsGuest()) {

            // TODO: Нарисовать форму регистрации

            $model = new User();
            $model->email = 'admin@test.ru';
            $model->password = '123';

            $this->_login($model);

            d($webUser->getIsGuest());

//            $this->_logout();

            $this->render('login', array('webUser' => $webUser));

        } else {
            // Переход на домашнюю страницу если метод login вызвал авторизованный пользователь
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    // Выход пользователя
    public function actionLogout()
    {
        $this->_logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    // Регистрация нового пользователя
    public function actionSignup()
    {
        // TODO: Реализовать
    }

    private function _login($user)
    {
        $identity = new UserIdentity($user->email, $user->password);
        $identity->authenticate();

        if ($identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = Yii::app()->params['autoLoginDuration'];
            Yii::app()->getUser()->login($identity, $duration);
            return true;
        }
    }

    private function _logout()
    {
        Yii::app()->getUser()->logout();
    }

} 