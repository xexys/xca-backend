<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form\File;

use app\components\FormFacadeModel;


class Description extends FormFacadeModel
{
    public $movieId;
    public $movieTitle;
    public $type;
    public $description;

    protected $_movieFileModel;

    public function __construct($scenario, $movieFileModel)
    {
        $this->_movieFileModel = $movieFileModel;

        parent::__construct($scenario);
    }

    public function init()
    {
        parent::init();

        $this->_setAttributesByMovieFileModel();
    }

    public function rules()
    {
        return array(

        );
    }

    public function getFormKeys()
    {
        return $this->getSafeAttributeNames();
    }

    protected function _setAttributesByMovieFileModel()
    {
        $this->setAttributes($this->_movieFileModel->getAttributes());
    }

    protected function _create()
    {
        throw new \Exception(__METHOD__);
    }

    protected function _update()
    {
        throw new \Exception(__METHOD__);
    }
}
