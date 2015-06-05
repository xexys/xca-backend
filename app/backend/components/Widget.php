<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 0:50
 */

namespace backend\components;

class Widget extends \CWidget
{
    public function run()
    {
        $ref = new \ReflectionClass($this);
        $viewFile = lcfirst($ref->getShortName());
        $this->render($viewFile);
//        parent::run();
    }

}