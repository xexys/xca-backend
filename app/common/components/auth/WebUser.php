<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.05.15
 * Time: 20:04
 */

namespace common\components\auth;
use common\models\User;

class WebUser extends \CWebUser
{

    private $_name;
    private $_role;
    private $_model;

    public function getRole()
    {
        if ($this->_role === null) {
            if ($user = $this->getModel()) {
                $this->_role = $user->role->name;
            }
        }
        return $this->_role;
    }

    public function getName()
    {
        if ($this->_name === null) {
            if ($user = $this->getModel()) {
                $this->_name = $user->name;
            } else {
                $this->_name = $this->guestName;
            }
        }
        return $this->_name;
    }

    public function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = User::model()->with('role')->findByPk($this->id);
        }
        return $this->_model;
    }

} 