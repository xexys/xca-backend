<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06.06.15
 * Time: 19:48
 */

namespace backend\widgets;


class GridViewTemplateBuilder extends \CWidget
{
    /**
     * Могут быть значения true | false | 'top bottom'
     * @var bool | string
     */
    public $createItemButton = true;
    public $createItemButtonLabel;

    private $_normalizedParams;

    public function run()
    {
        $params = $this->_getNormalizedParams();
        $this->render('gridViewTemplateBuilder', array('params' => $params));
    }

    private function _getNormalizedParams()
    {
        if ($this->_normalizedParams === null) {
            $this->_normalizedParams = $this->_normalizeParams();
        }
        return $this->_normalizedParams;
    }

    private function _normalizeParams()
    {
        $normalizedParams = array(
            'createItemButtonTop' => null,
            'createItemButtonBottom' => null,
            'createItemButtonLabel' => null,
        );

        if ($this->createItemButton) {
            $createItemButton = $this->createItemButton;

            if ($createItemButton === true) {
                $normalizedParams['createItemButtonTop'] = true;
                $normalizedParams['createItemButtonBottom'] = true;
            } else {
                if (is_string($createItemButton)) {
                    $createItemButton = array_filter(explode(' ', $createItemButton));
                }
                $normalizedParams['createItemButtonTop'] = in_array('top', $createItemButton, true);
                $normalizedParams['createItemButtonBottom'] = in_array('bottom', $createItemButton, true);
            }
        }

        $normalizedParams['createItemButtonLabel'] = $this->createItemButtonLabel ?: null;

        return $normalizedParams;
    }
} 