<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:01
 */

namespace app\models\Form\Game;


class MainParams extends Params
{
    public $id;
    public $textId;
    public $title;

    public function rules()
    {
        return array(
            array('textId, title', 'required'),
            array('textId', 'length', 'max' => 10),
            array('textId', 'validateUniqueInDatabase', 'className' => '\app\models\AR\Game', 'attributeName' => 'text_id'),
            array('title', 'validateUniqueInDatabase', 'className' => '\app\models\AR\Game'),
            array('textId', 'match', 'pattern' => '/^\s*[a-z][a-z0-9_]+\s*$/',),
            array('title', 'length', 'max' => 50),
            array('id', 'required', 'safe' => false, 'on' => self::SCENARIO_UPDATE),
        );
    }

    protected function _setAttributesByGameModel()
    {
        // safeOnly = false - чтобы установить значение id
        $this->setAttributes($this->_gameModel->getAttributes(), false);
    }

    protected function _create()
    {
        $this->_gameModel->setAttributes($this->getAttributes());

        if (!$this->_gameModel->save()) {
            throw new CException($this->_gameModel->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $this->_create();
    }

    protected function _delete()
    {
        $this->_gameModel->delete();
    }
}
