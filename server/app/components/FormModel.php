<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.08.15
 * Time: 23:39
 */

namespace app\components;

use \CFormModel;


class FormModel extends CFormModel
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
}
