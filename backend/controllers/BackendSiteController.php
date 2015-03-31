<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 0:48
 * To change this template use File | Settings | File Templates.
 */

class BackendSiteController extends BackendController
{
    public function actionIndex()
    {

        $game = GameList::model()->findByPk(1);
        var_dump($game->title);

        var_dump(Yii::getPathOfAlias('ext'));

        $this->render('/dummy');
    }

}