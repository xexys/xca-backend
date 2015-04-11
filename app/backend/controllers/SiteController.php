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
use \common\models\Reference;


class SiteController extends \backend\components\Controller
{
    public function actionIndex()
    {
        var_dump(Yii::getVersion());

        $game = Game::model()->with('movies')->findByTextId('wow');
        var_dump($game);

        echo '<hr>';
        $movie = Movie::model()->with('game')->findByPk(1);

        var_dump(simplexml_load_string(gzinflate($movie->mediaInfo->data)));

        echo '<hr>';
        var_dump(new Movie\Image);

        echo '<hr>';
        var_dump(new Movie\Storage);

        echo '<hr>';

        var_dump(Yii::getPathOfAlias('ext'));

        echo '<hr>';

        echo date(DateTime::ATOM);

        echo '<hr>';

        echo '<hr>';

        $this->render('/dummy');
     }

 }