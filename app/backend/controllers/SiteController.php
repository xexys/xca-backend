<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 0:48
 * To change this template use File | Settings | File Templates.
 */

namespace backend\controllers;
use \Yii;
use \DateTime;
use \common\models\Game;
use \common\models\Movie;


class SiteController extends \backend\components\Controller
{
    public function actionIndex()
    {
        var_dump(Yii::getVersion());

        $game = Game::model()->with('movies')->findByTextId('wow');
        var_dump($game);

        $movie = Movie::model()->with('game')->findByPk(1);
        var_dump($movie->images);

        var_dump(new Movie\Image);

        var_dump(Yii::getPathOfAlias('ext'));

        echo date(DateTime::ATOM);

        echo '<hr>';

        $this->render('/dummy');
     }

 }