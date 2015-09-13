<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.06.15
 * Time: 22:40
 */

namespace app\helpers\view\UI;

use \CHtml;
use \app\models\AR\Dictionary;


class Icon extends \app\helpers\view\Base
{
    public function icon($params)
    {
        $iconClass = '';
        $htmlOptions = isset($params['htmlOptions']) ? $params['htmlOptions'] : array();

        if (isset($params['fa-icon'])) {
            $iconClass = 'fa fa-' . $params['fa-icon'];
        }

        if (isset($params['gl-icon'])) {
            $iconClass = $params['gl-icon'];
        }

        if ($iconClass) {
            if (isset($htmlOptions['class'])) {
                $htmlOptions['class'] .= ' ' . $iconClass;
            } else {
                $htmlOptions['class'] = $iconClass;
            }
        }

        return CHtml::tag('i', $htmlOptions, '', true);
    }

    public function gameIssueStatusIcon($statusId, $htmlOptions)
    {
        $statusIconMap = array(
            Dictionary\GameIssueStatus::STATUS_ID_UNKNOWN => 'fa fa-question',
            Dictionary\GameIssueStatus::STATUS_ID_RELEASED => 'glyphicon glyphicon-ok',
            Dictionary\GameIssueStatus::STATUS_ID_AWAIT => 'fa fa-hourglass-half',
            Dictionary\GameIssueStatus::STATUS_ID_FROZEN => 'fa fa-asterisk',
            Dictionary\GameIssueStatus::STATUS_ID_CLOSED => 'glyphicon glyphicon-remove',
        );

        $iconClass = $statusIconMap[$statusId];
        if (isset($htmlOptions['class'])) {
            $htmlOptions['class'] .= ' ' . $iconClass;
        } else {
            $htmlOptions['class'] = $iconClass;
        }

        return $this->icon(array('htmlOptions' => $htmlOptions));
    }

} 