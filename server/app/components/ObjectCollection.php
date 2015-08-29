<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.08.15
 * Time: 0:59
 */

namespace app\components;

use \CMap;
use \app\components\interfaces\Collectible;


class ObjectCollection extends CMap
{
    public function add($key, $item)
    {
        $this->_checkItemInstanceof($item);
        parent::add($key, $item);
        $item->setCollection($this);
    }

    public function remove($key)
    {
        $item = parent::remove($key);
        if ($item) {
            $item->setCollection(null);
        }
        return $item;
    }

    public function mergeWith($data, $recursive = true)
    {
        parent::mergeWith($data, $recursive);
        if ($recursive) {
            foreach ($this as $item) {
                $this->_checkItemInstanceof($item);
                $item->setCollection($this);
            }
        }
    }

    public function getFirstItem()
    {
        $keys = $this->getKeys();
        if ($keys) {
            return $this->itemAt(reset($keys));
        }
    }

    protected function _checkItemInstanceof($item)
    {
        if (!$item instanceof Collectible) {
            throw new \CException('Item must be instanceof Collectible');
        }
    }
}