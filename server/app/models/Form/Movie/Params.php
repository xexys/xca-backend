<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form\Movie;

use \app\components\FormModel;


abstract class Params extends FormModel
{
    protected $_movieModel;

    public function __construct($movie)
    {
        $scenario = $movie->getIsNewRecord() ? self::SCENARIO_CREATE : self::SCENARIO_UPDATE;
        $this->setScenario($scenario);
        $this->_movieModel = $movie;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        if ($this->getScenario() === self::SCENARIO_UPDATE) {
            $this->_setAttributesByMovieModel();
        }
    }

    public function getFormKeys()
    {
        return $this->getSafeAttributeNames();
    }

    abstract protected function _setAttributesByMovieModel();
}