<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:02
 */

namespace app\models\Form\Game;

use \Yii;
use \app\components\FormModel;
use \app\models\AR\Dictionary;


class IssuesInfoParamsItem extends FormModel
{
    public $platformId = Dictionary\GamePlatform::PLATFORM_ID_PC;
    public $statusId = Dictionary\GameIssueStatus::STATUS_ID_RELEASED;
    public $statusDate;
    public $comment;

    private static $_platformDictionary;
    private static $_issueDictionary;

    public function rules()
    {
        return array(
            array('platformId, statusId', 'required'),
            array('platformId', 'in', 'range' => array_keys($this->getPlatformDictionary())),
            array('platformId', 'validateUniqueInCollection'),
            array('statusId', 'in', 'range' => array_keys($this->getGameIssueStatusDictionary())),
            array('statusDate', 'date', 'format' => APP_VALIDATION_DATE_FORMAT, 'allowEmpty' => true),
            array('comment', 'length', 'max' => 500),
        );
    }

    public function getDictionary($key)
    {
        $data = array();

        switch ($key) {
            case 'platformId':
                $data = $this->getPlatformDictionary();
                break;
            case 'statusId':
                $data = $this->getGameIssueStatusDictionary();
                break;
        }

        return $data;
    }

    public function getPlatformDictionary()
    {
        if (self::$_platformDictionary === null) {
            self::$_platformDictionary = array();

            $data = Dictionary\GamePlatform::model()->findAll(array(
                'order'=>'name ASC'
            ));

            foreach ($data as $item) {
                self::$_platformDictionary[$item->id] = $item->name;
            }
        }
        return self::$_platformDictionary;
    }

    public function getGameIssueStatusDictionary()
    {
        if (self::$_issueDictionary === null) {
            self::$_issueDictionary = array();

            $data = Dictionary\GameIssueStatus::model()->findAll(array(
                'order'=>'id ASC'
            ));

            foreach ($data as $item) {
                self::$_issueDictionary[$item->id] = $item->name;
            }
        }
        return self::$_issueDictionary;
    }
}