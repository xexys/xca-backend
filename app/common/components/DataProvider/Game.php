<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 12:44
 */

namespace common\components\DataProvider;


class Game extends \CActiveDataProvider
{
    public function __construct($config)
    {
        parent::__construct('\common\models\Game', $config);
    }

}
