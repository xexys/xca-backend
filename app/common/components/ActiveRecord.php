<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 1:58
 * To change this template use File | Settings | File Templates.
 */

namespace common\components;


class ActiveRecord extends \CActiveRecord
{
    /**
     * PHP 5.3 or above only
     * @param null $className
     * @return \CActiveRecord
     */
    public static function model($className = null)
    {
        return parent::model($className ?: get_called_class());
    }

}