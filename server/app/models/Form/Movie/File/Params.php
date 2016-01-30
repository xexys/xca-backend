<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 12:39
 */

namespace app\models\Form\Movie\File;

use \CException;
use \app\components\FormFacadeModel;


abstract class Params extends FormFacadeModel
{
    protected $_movieFile;

    public function getFormKeys()
    {
        return $this->getSafeAttributeNames();
    }

    protected function _checkMovieFileIsNewRecord()
    {
        if ($this->_movieFile->getIsNewRecord()) {
            throw new CException('The game must not be a new.');
        }
    }

    protected function _initByParams($params)
    {
        $this->_movieFile = $params['movieFile'];

        $this->setAttributes($this->_movieFile->getAttributes());
    }
}