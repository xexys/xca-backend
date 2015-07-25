<?php
/**
 * Базовый класс для вью хелперов
 *
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 21:26
 */

namespace common\helpers\view;


abstract class Base
{
    /**
     * @var \CController
     */
    protected $_controller;

    public function __construct($controller)
    {
        $this->_controller = $controller;
    }

} 