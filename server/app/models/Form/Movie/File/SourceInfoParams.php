<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25.07.15
 * Time: 15:56
 */

namespace app\models\Form\Movie\File;

use \app\models\AR\Movie;
use \app\models\AR\Dictionary;


class SourceInfoParams extends Params
{
    public $gamePlatformId;
    public $isBest;

    private static $_gamePlatformDictionary;

    public function rules()
    {
        return array(
            array('gamePlatformId', 'required'),
            array('gamePlatformId', 'in', 'range' => array_keys($this->getGamePlatformDictionary())),
            array('isBest', 'boolean'),
        );
    }

    public function getGamePlatformDictionary()
    {
        if (self::$_gamePlatformDictionary === null) {
            self::$_gamePlatformDictionary = array();

            $data = Dictionary\GamePlatform::model()->findAll(array(
                'order'=>'name ASC'
            ));

            foreach ($data as $item) {
                self::$_gamePlatformDictionary[$item->id] = $item->name;
            }
        }
        return self::$_gamePlatformDictionary;
    }

    protected function _create()
    {
        $attrs = $this->getAttributes();
        $attrs['movieFileId'] = $this->_movieFile->id;

        $model = new Movie\File\SourceInfo();
        $model->setAttributes($attrs);

        if (!$model->save()) {
            throw new CException($model->getFirstErrorMessage());
        }
    }

    protected function _update()
    {
        $attrs = $this->getAttributes();

        $model = $this->_movieFile->sourceInfo;
        $model->setAttributes($attrs);

        if (!$model->save()) {
            throw new CException($model->getFirstErrorMessage());
        }
    }
}
