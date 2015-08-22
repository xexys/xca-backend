<?php

namespace app\controllers;

use \Yii;
use \CDbCriteria;
use \app\models\AR\Game;


class AutocompleteController extends \app\components\JsonController
{
    /**
     * @param string $search Поисковая строка
     * @param bool $expand Возвращать расширенные данные
     */
    public function actionGetGameList($search = '', $expand = false)
    {
        $search = trim($search);
        $minLength = 1;
        if (mb_strlen($search) < $minLength) {
            $this->_sendError('Длинна поисковой строки должна быть больше ' . $minLength);
        }

        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.title', $search); // %search%
        $criteria->order = 't.title ASC';
        $games = Game::model()->findAll($criteria);

        $data = array();

        if ($expand) {
            foreach ($games as $game) {
                $data[] = array('title' => $game->title, 'id' => $game->id);
            }
        } else {
            foreach ($games as $game) {
                $data[] = $game->title;
            }
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