<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 17:50
 */

namespace common\helpers;


class Data
{
    public static function trimRecursive($data)
    {
//        if (!is_array($data)) {
//            $data = trim($data);
//        } else {
//            $data = array_map('self::trimRecursive', $data);
//        }

        array_walk_recursive($data, function(&$item) {
            $item = trim($item);
        });

        return $data;
    }
}