<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 22:01
 */

namespace app\components;

use Yii;
use \app\helpers\Data as DataHelper;


class FormModel extends \CFormModel
{
    public function fixCssName($name)
    {
        return strtr(DataHelper::camelToSnake($name), '_', '-');
    }
}