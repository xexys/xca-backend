<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.08.15
 * Time: 22:04
 *
 * Nested DB transactions
 * @link http://www.yiiframework.com/wiki/38/how-to-use-nested-db-transactions-mysql-5-postgresql/
 */

namespace app\components;


class PDO extends \PDO
{
    // The current transaction level.
    private $_transLevel = 0;
    
    // Is support SAVEPOINTs.
    private $_isSupportSavepoints;


    public function __construct ($dsn, $username = null, $password = null , $options = array())
    {
        parent::__construct($dsn, $username, $password, $options);

        // Database drivers that support SAVEPOINTs.
        $supportSavepointsDirvers = array('pgsql', 'mysql');
        $this->_isSupportSavepoints = in_array($this->getAttribute(PDO::ATTR_DRIVER_NAME), $supportSavepointsDirvers);
    }

    public function beginTransaction()
    {
        if ($this->_transLevel == 0 || !$this->_isSupportSavepoints) {
            parent::beginTransaction();
        } else {
            $this->exec('SAVEPOINT LEVEL_' . $this->_transLevel);
        }

        $this->_transLevel++;
    }

    public function commit()
    {
        $this->_transLevel--;

        if ($this->_transLevel == 0 || !$this->_isSupportSavepoints) {
            parent::commit();
        } else {
            $this->exec('RELEASE SAVEPOINT LEVEL_' . $this->_transLevel);
        }
    }

    public function rollBack()
    {
        $this->_transLevel--;

        if ($this->_transLevel == 0 || !$this->_isSupportSavepoints) {
            parent::rollBack();
        } else {
            $this->exec('ROLLBACK TO SAVEPOINT LEVEL_ ' . $this->_transLevel);
        }
    }
}
