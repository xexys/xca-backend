<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.08.15
 * Time: 19:02
 */

namespace app\models\Form\Game;

use \app\components\FormModel;
use \app\models\Dictionary;


class PlatformInfoParamsItem extends FormModel
{
    public $platformId = Dictionary\Platform::PLATFORM_ID_PC;
    public $issueStatusId = Dictionary\GameIssueStatus::STATUS_ID_RELEASED;
    public $comment;

    private static $_platformDictionary;
    private static $_issueDictionary;

    public function rules()
    {
        return array(
            array('platformId, issueStatusId', 'required'),
            array('comment', 'length', 'max' => 500),
            array('platformId', 'in', 'range' => array_keys($this->getPlatformDictionary())),
            array('platformId', 'validateUniqueInCollection'),
            array('issueStatusId', 'in', 'range' => array_keys($this->getGameIssueStatusDictionary())),
        );
    }

    public function getDictionary($key)
    {
        $data = array();

        switch ($key) {
            case 'platformId':
                $data = $this->getPlatformDictionary();
                break;
            case 'issueStatusId':
                $data = $this->getGameIssueStatusDictionary();
                break;
        }

        return $data;
    }

    public function getPlatformDictionary()
    {
        if (self::$_platformDictionary === null) {
            self::$_platformDictionary = array();

            $data = Dictionary\Platform::model()->findAll(array(
                'order'=>'full_name ASC'
            ));

            foreach ($data as $item) {
                self::$_platformDictionary[$item->id] = $item->full_name;
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