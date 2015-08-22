<?php
/**
 * DAO (Database Access Object)
 *
 * Предоставляет объект для доступа к базе данных
 *
 * @author Васильев-Люлин А.В.
 *
 */

namespace app\components\behaviors;

use \Yii;
use \CDbConnection;
use \CDbException;


class DAO extends \CBehavior
{
    private static $_db;

    public function getDb()
    {
        if (self::$_db === null) {
            $db = Yii::app()->getDb();
            if (!$db instanceof CDbConnection) {
                throw new CDbException(Yii::t('yii', __CLASS__ . ' requires a "db" CDbConnection application component.'));
            }
            self::$_db = $db;
        }
        return self::$_db;
    }
}