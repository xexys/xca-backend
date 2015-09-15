<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 15.09.2015
 * Time: 11:24
 */

namespace app\helpers\view;

use app\models\Form\Movie\VideoParams;


class Data extends \app\helpers\view\Base
{
    function formatBytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('', 'Кб', 'Мб', 'Гб', 'Тб');

        return round(pow(1024, $base - floor($base)), $precision) . ' '. $suffixes[floor($base)];
    }

    function formatDuration($duration) {
        $minutes = floor($duration / 60);
        $seconds = $duration % 60;

        $str = '';

        if ($minutes) {
            $str .= $minutes . ' мин ';
        }
        $str .= $seconds . ' сек';

        return $str;
    }

    function getVideoFormatStr($formatId) {
        $formats = VideoParams::getFormatDictionary();
        return $formats[$formatId];
    }

    function getVideoFrameRateModeStr($mode) {
        $modes = VideoParams::getFrameRateModeDictionary();
        return $modes[$mode];
    }
}