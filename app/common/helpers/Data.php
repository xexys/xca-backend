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
    public static function trimRecursive(&$data)
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
    
    public static function snakeToCamel($str)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }
    
    public static function camelToSnake($str)
    {
        $str = preg_replace_callback('/[A-Z]/', function($match) {
            return '_' . strtolower($match[0]);
        }, $str);
        return $str;
    }

    public static function arrayKeysSnakeToCamel($arrayIn)
    {
        $arrayOut = array();
        foreach ($arrayIn as $key => $val) {
            $arrayOut[self::snakeToCamel($key)] = $val;
        }
        return $arrayOut;
    }

    public static function arrayKeysCamelToSnake($arrayIn)
    {
        $arrayOut = array();
        foreach ($arrayIn as $key => $val) {
            $arrayOut[self::camelToSnake($key)] = $val;
        }
        return $arrayOut;
    }

}