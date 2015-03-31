<?php
/**
 * Описание класса WebApplication
 *
 * @author Васильев-Люлин А.В.
 */
class WebApplication extends CWebApplication
{
    private $_jsUrl;
    private $_cssUrl;
    
    public function getJsUrl()
    {
        if ($this->_jsUrl === null) {
            $this->_jsUrl = $this->getBaseUrl().'/js';
        }
        return $this->_jsUrl;
    }
    
    public function getCssUrl()
    {
        if ($this->_cssUrl === null) {
            $this->_cssUrl = $this->getBaseUrl().'/css';
        }
        return $this->_cssUrl;
    }
    
}