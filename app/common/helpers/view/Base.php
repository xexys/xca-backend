<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 21:26
 */

namespace common\helpers\view;


abstract class Base extends \CComponent
{
    public $_owner;

    public function __construct($controller)
    {
        $this->_owner = $controller;
    }

} 