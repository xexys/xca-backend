<?php
/**
 * Форма для создания и редактировния ролика
 *
 * Фасадный объект для работы с несколькими формами и моделями AR
 *
 * User: Alex
 * Date: 21.06.15
 * Time: 1:22
 */

namespace app\models;

use \Yii;
use \app\components\FacadeModel;
use \app\models\MovieFacade\ParamsCrudHelper;


class MovieFacade extends FacadeModel
{
    public $mainParams;
    public $fileParams;
    public $videoParams;
    public $audioParams;

    private $_movie;

    public function __construct($movie)
    {
        $scenario = $movie->getIsNewRecord() ? self::SCENARIO_CREATE : self::SCENARIO_UPDATE;
        $this->setScenario($scenario);
        $this->_movie = $movie;

        parent::__construct($scenario);
    }

    public function rules()
    {
        return array(
            array('mainParams, fileParams, videoParams, audioParams', '\app\components\validators\ModelsValidator'),
        );
    }

// ----- PROTECTED ----------------------------------------------------------------------------------------------------

    protected function _create()
    {
        $this->_getParamsCrudHelper()->create();
    }

    protected function _update()
    {
        $this->_getParamsCrudHelper()->update();
    }

    protected function _delete()
    {
        $this->_getParamsCrudHelper()->delete();
    }

// ----- PRIVATE ------------------------------------------------------------------------------------------------------

    private function _getParamsCrudHelper()
    {
        return new ParamsCrudHelper($this->_movie, $this->getAttributes());
    }

}