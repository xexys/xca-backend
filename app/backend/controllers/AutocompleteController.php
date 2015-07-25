<?php

namespace backend\controllers;

use \Yii;
use \CDbCriteria;
use \common\models\Game;


class AutocompleteController extends \backend\components\JsonController
{
    public function actionGetGameList($search = '')
    {
        $search = trim($search);
        $minLength = 1;
        if (mb_strlen($search) < $minLength) {
            $this->_sendError('Длинна поисковой строки должна быть больше ' . $minLength);
        }

        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.title', $search); // %search%
        $games = Game::model()->findAll($criteria);

        $data = array();
        foreach ($games as $game) {
            $data[] = array('name' => $game->title, 'id' => $game->id);
        }

        $this->_sendAnswer($data);
    }

    protected function _sendAnswer($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        Yii::app()->end();
    }

    protected function _sendError($message)
    {
        $this->_sendAnswer(array('error' => $message));
    }
}