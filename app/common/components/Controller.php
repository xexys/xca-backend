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
     * Публикует каталог со скриптами страницы.
     *
     * @param $scriptBasePath string - базовый путь к скриптам страницы
     * @param $scriptName string - имя скрипта который публикуем
     * @return string | null - ulr к опубликованному скрипту
     */
    public function publishPageScript($scriptBasePath, $scriptName) {

        $assetManager = Yii::app()->getAssetManager();
        $pubUrl = $assetManager->publish($scriptBasePath, false, -1, YII_DEBUG);
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