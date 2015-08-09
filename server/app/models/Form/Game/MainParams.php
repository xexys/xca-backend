<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:01
 */

namespace app\models\Form\Game;


class MainParams extends \app\components\FormModel
{
    public $id;
    public $textId;
    public $title;

    public function rules()
    {
        return array(
            array('textId, title', 'required'),
            array('textId', 'length', 'max' => 10),
            array('textId', 'validateUniqueInDatabase', 'className' => '\app\models\Game', 'attributeName' => 'text_id'),
            array('title', 'validateUniqueInDatabase', 'className' => '\app\models\Game'),
            array('textId', 'match', 'pattern' => '/^\s*[a-z][a-z0-9_]+\s*$/',),
            array('title', 'length', 'max' => 50),
            array('id', 'required', 'safe' => false, 'on' => self::SCENARIO_UPDATE),
        );
    }

    protected function _prepareErrorMessage($attribute, $message, $params)
    {
        $params['{attribute}'] = $this->getAttributeLabel($attribute);
        return strtr($message, $params);
    }

} 