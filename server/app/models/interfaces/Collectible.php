<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.08.15
 * Time: 0:55
 */

namespace app\models\interfaces;


interface Collectible
{
    public function getCollection();

    public function setCollection($collection);

}
