<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 12:44
 */

namespace app\components\DataProvider\Movie;


class File extends \CActiveDataProvider
{
    public function __construct($config)
    {
        parent::__construct('\app\models\AR\Movie\File', $config);
    }

}
