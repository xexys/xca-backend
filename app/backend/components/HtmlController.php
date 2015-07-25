<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alex
 * Date: 08.06.14
 * Time: 12:57
 * To change this template use File | Settings | File Templates.
 */

namespace backend\components;

use \Yii;

abstract class HtmlController extends Controller
{
    public $layout = '/layouts/main';
    public $breadcrumbs;
    public $pageTitleIconClass;

    private $_viewHelpers = array();
    private $_viewHelpersNamespace = '\backend\helpers\view';

    public function getViewHelper($name)
    {
        if (strpos($name, '.') !== false) {
            $className = Yii::import($name, true);
        } else {
            $className = $this->_viewHelpersNamespace . '\\' . $name;
        }

        if (!isset($this->_viewHelpers[$className])) {
            $this->_viewHelpers[$className] = new $className($this);
        }

        return $this->_viewHelpers[$className];
    }

    public function getViewUIHelper($name)
    {
        return $this->getViewHelper('UI\\' . $name);
    }

    /**
     * Возвращает хелпер для модели
     * @param mixed $model - Модель, полное или короткое имя класса
     * @return mixed
     */
    public function getViewModelLinkHelper($model)
    {
        if ($model instanceof \CActiveRecord) {
            $name = (new \ReflectionClass($model))->getShortName();
        } elseif (is_string($model) && strpos($model, '\\') !== false) {
            $name = (new \ReflectionClass($model))->getShortName();
        } else {
            $name = $model;
        }


        return $this->getViewHelper('ModelLink\\' . $name);
    }

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

    public function _correctCssName($name)
    {
        $name = strtr($name, '_', '-');
        $name = preg_replace_callback('/[A-Z]/', function($match) {
            return '-' . strtolower($match[0]);
        }, $name);
        return $name;
    }

}