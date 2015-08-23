<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.08.15
 * Time: 16:41
 */

namespace app\components\interfaces;


interface FacadeModelCrudHelper
{
    public function create();

    public function update();

    public function delete();

} 