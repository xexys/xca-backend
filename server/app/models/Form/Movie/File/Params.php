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

    protected function _initByParams($params)
    {
        $this->_movieFile = $params['movieFile'];
    }

}