<?php
require_once dirname(__FILE__).'/Browser.php';

class CBrowserComponent extends CApplicationComponent
{
    public $timezone; // Информация о временной зоне (часовом поясе)
    public $flashSupport; // Информация о поддержке flash
    
    private $_myBrowser;

    public function init()
    {
        if (isset($_SESSION['clientInfo'])) {
            
            $clientInfo = $_SESSION['clientInfo'];
            
            $timezone = $clientInfo['timezone'];
            // Смещение времнной зоны клиента от гринвича в секундах от -43200 до 50400
            // '+' - правее гринвича, '-' - левее гринвича
            $this->timezone['utc_offset'] = $timezone['utc_offset'];
            // Смещение временнной зоны клиента от заны сервера
            // '+' - правее, '-' - левее
            $this->timezone['server_offset'] = $timezone['utc_offset']-date("Z");
            
            // Поддержка flash
            if (!empty($clientInfo['flashSupport']['major']))
                $this->flashSupport = $clientInfo['flashSupport'];
        }
        
        $this->_myBrowser = new Browser();
        parent::init();
    }

    /**
    * Call a Browser function
    *
    * @return string
    */
    public function __call($method, $params)
    {
        if (is_object($this->_myBrowser) && get_class($this->_myBrowser)==='Browser')
            return call_user_func_array(array($this->_myBrowser, $method), $params);
        else
            throw new CException(Yii::t('Browser', 'Can not call a method of a non existent object'));
    }
}