<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.06.15
 * Time: 22:04
 */

namespace app\helpers\view\UI;


class Button extends \app\helpers\view\Base
{
    /**
     * @param array $params
     * @return string
     */
    private function button($params)
    {
        // Алиас для Font-Awesome
        if (isset($params['fa-icon'])) {
            $params['icon'] = 'fa fa-' . $params['fa-icon'];
            unset($params['fa-icon']);
        }

        // Алиас для Glyphicons
        if (isset($params['gl-icon'])) {
            $params['icon'] = $params['gl-icon'];
            unset($params['gl-icon']);
        }

        return $this->_controller->widget('booster.widgets.TbButton', $params, true);
    }

    /**
     * @param array $params
     * @return string
     */
    public function linkButton($params)
    {
        $params['buttonType'] = 'link';
        return $this->button($params);
    }

    /**
     * @param array $params
     * @return string
     */
    public function submitButton($params)
    {
        $params['buttonType'] = 'submit';
        return $this->button($params);
    }
}
