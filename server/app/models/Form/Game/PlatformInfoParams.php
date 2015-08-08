<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:02
 */

namespace app\models\Form\Game;

use \app\models\Game\PlatformInfo as GamePlatformInfoModel;


class PlatformInfoParams extends \app\components\FormModel
{
    private static $_platformDictionary;

    public $platformId;
    public $status;
    public $comment;

    public function rules()
    {
        return array(
            array('platformId, status', 'required'),
            array('comment', 'length', 'max' => 500),
            array('platformId', 'in', 'range' => array_keys($this->getPlatformDictionary())),
            array('status', 'in', 'range' => array_keys($this->getStatusDictionary())),
        );
    }

    public function getDictionary($key)
    {
        $data = array();

        switch ($key) {
            case 'platformId':
                $data = $this->getPlatformDictionary();
                break;
            case 'status':
                $data = $this->getStatusDictionary();
                break;
        }

        return $data;
    }

    public function getPlatformDictionary()
    {
        if (self::$_platformDictionary === null) {
            self::$_platformDictionary = array();

            $data = \app\models\Dictionary\Platform::model()->findAll(array(
                'order'=>'t.full_name ASC'
            ));

            foreach ($data as $item) {
                self::$_platformDictionary[$item->id] = $item->full_name;
            }
        }
        return self::$_platformDictionary;
    }

    public function getStatusDictionary()
    {
        return array(
            GamePlatformInfoModel::STATUS_AWAITING => 'Ожидается выход',
            GamePlatformInfoModel::STATUS_RELEASED => 'Вышла',
            GamePlatformInfoModel::STATUS_FROZEN => 'Проект заморожена',
            GamePlatformInfoModel::STATUS_RIP => 'Проект закрыт',
        );
    }


} 