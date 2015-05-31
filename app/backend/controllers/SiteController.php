<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 0:48
 * To change this template use File | Settings | File Templates.
 */

namespace backend\controllers;
use \backend\components\Controller;
use \Yii;
use \DateTime;
use \common\models\Game;
use \common\models\Movie;
use \common\models\Reference;

use \common\models\User;


class SiteController extends Controller
{
    public function actionIndex()
    {
        $game = Game::model()->with('movies')->findByTextId('wow');
        dump($game);

        dump(User\Role::model()->findByPk(1)->users);

        dump($_SESSION);

//        echo '<hr>';
//
//        $movie = Movie::model()->with('game')->findByPk(1);
//        d(simplexml_load_string(gzinflate($movie->mediaInfo->data)));
//        echo '<hr>';
//
//        d($movie->images);
//        echo '<hr>';
//
//        dump($movie->storage);
//        echo '<hr>';
//
//        dump(Yii::getPathOfAlias('ext'));
//        echo '<hr>';
//
//        echo date(DateTime::ATOM);
//        echo '<hr>';
//
//        $this->render('/dummy');

        $this->render('index');
    }

    function actionTest() {

        $this->render('test-css');
    }

 }