<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 30.08.2015
 * Time: 8:51
 */

namespace app\helpers\view\UI;

use \app\helpers\Data as DataHelper;


class Css extends \app\helpers\view\Base
{
    public function fixCssName($name)
    {
        return strtr(DataHelper::camelToSnake($name), '_', '-');
    }
}
