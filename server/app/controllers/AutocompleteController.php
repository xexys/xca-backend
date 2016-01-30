<?php

namespace app\controllers;

use \Yii;
use \CDbCriteria;
use \CHttpException;
use \app\models\AR\Game;
use \app\models\AR\Movie;


class AutocompleteController extends \app\components\JsonController
{
    /**
     * @param string $search Поисковая строка
     * @param bool $expand Возвращать расширенные данные
     */
    public function actionGetGameList($search = '', $expand = false)
    {
        $search = $this->_prepareSearchString($search);

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

    /**
     * @param string $search Поисковая строка
     */
    public function actionGetMovieList($search = '')
    {
        $criteria = new CDbCriteria();

        if (strpos($search, '-') !== false) {
            list($gameSearch, $movieSearch) = explode('-', $search);
            $gameSearch = $search = $this->_prepareSearchString($gameSearch);
            $movieSearch = $search = $this->_prepareSearchString($movieSearch);

            $criteria->addSearchCondition('t.title', $movieSearch);
            $criteria->addSearchCondition('game.title', $gameSearch);
        } else {
            $search = $this->_prepareSearchString($search);

            $criteria->addSearchCondition('t.title', $search);
            $criteria->addSearchCondition('game.title', $search, true, 'OR');
        }

        $criteria->order = 't.title ASC';
        $movies = Movie::model()->with('game')->findAll($criteria);

        $data = array();

        foreach ($movies as $movie) {
            $data[] = array(
                'id' => $movie->id,
                'title' => $movie->title,
                'game' => array(
                    'id' => $movie->game->id,
                    'title' => $movie->game->title,
                )
            );
        }

        $this->_sendAnswer($data);
    }

    protected function _sendAnswer($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        Yii::app()->end();
    }

    protected function _sendError($statusCode, $message)
    {
        // X-TODO: Сделать нормальный josn ответ c http статусом
        throw new CHttpException($statusCode, $message);
    }

    private function _prepareSearchString($search, $minLength = 1)
    {
        $search = trim($search);

        if (mb_strlen($search) < $minLength) {
            $this->_sendError(400, 'Длинна поисковой строки должна быть больше ' . $minLength);
        }

        return $search;
    }
}