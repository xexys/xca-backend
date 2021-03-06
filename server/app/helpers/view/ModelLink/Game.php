<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 21:24
 */

namespace app\helpers\view\ModelLink;


class Game extends \app\helpers\view\ModelLink
{
    protected $_modelControllerId = 'game';

    public function getEditMainInfoUrl($model, $params = array())
    {
        $params['paramsKeys'] = 'mainInfo';
        return $this->getEditUrl($model, $params);
    }

    public function getEditIssuesInfoUrl($model, $params = array())
    {
        $params['paramsKeys'] = 'issuesInfo';
        return $this->getEditUrl($model, $params);
    }

}
