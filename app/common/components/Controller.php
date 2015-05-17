<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17.05.15
 * Time: 17:09
 */

namespace common\components;
use \Yii;


class Controller extends \CController
{

    /**
     * Возвращает url по имени скрипта страницы
     *
     * @param $scriptBasePath string - базовый путь к скриптам страницы, который уже был опубликован
     * @param $scriptName string - имя скрипта
     * @return string | null
     */
    public function getPageScriptUrl($scriptBasePath, $scriptName) {

        $assetManager = Yii::app()->getAssetManager();
        $pubUrl = $assetManager->getPublishedUrl($scriptBasePath);
        $pubPath = $assetManager->getPublishedPath($scriptBasePath);

        $parts = array('', $this->id, $this->action->id);

        while($parts) {
            $path = implode('/', $parts) . '/' . $scriptName;
            $scriptPath = $pubPath . $path;
            $scriptUrl = $pubUrl . $path;
            if (is_file($scriptPath)) {
                return $scriptUrl;
            } else {
                array_pop($parts);
            }
        };

    }

} 