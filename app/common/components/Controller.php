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
     * @param $scriptBasePath string - базовый путь к скриптам страницы, который уже были опубликован
     * @param $scriptName string - имя скрипта
     * @return string | null
     */
    public function getPageScriptUrl($scriptBasePath, $scriptName) {

        $assetManager = Yii::app()->getAssetManager();
        $pubUrl = $assetManager->getPublishedUrl($scriptBasePath);
        $pubPath = $assetManager->getPublishedPath($scriptBasePath);

        $scriptPath = $pubPath . '/' . $this->id . '/' . $this->action->id . '/' . $scriptName;
        $scriptUrl = $pubUrl . '/' . $this->id . '/' . $this->action->id . '/' . $scriptName;

        if (!is_file($scriptPath)) {
            $scriptPath = $pubPath . '/' . $this->id . '/' . $scriptName;
            $scriptUrl = $pubUrl . '/' . $this->id . '/' . $scriptName;
            if (!is_file($scriptPath)) {
                $scriptPath = $pubPath . '/' . $scriptName;
                $scriptUrl = $pubUrl . '/' . $scriptName;
                if (!is_file($scriptPath)) {
                    $scriptUrl = null;
                }
            }
        }

        return $scriptUrl;
    }


} 