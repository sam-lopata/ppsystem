<?php

namespace PPSystem\SEParserBundle;

class DomainResult
{
    //Domain name
    private $_fqdn;
    
    //Google parsed results
    private $_google = array(
        'indexed' => null,
        'pr' => null,
        'mentions' => null,
        'related' => null
    );
    private $_yahoo = array(
        'indexed' => null,
        'backlinks' => null,
        'related' => null
    );
    private $_bing = array(
        'indexed' => null,
        'backlinks' => null,
        'related' => null
    );
    private $_yandex = array(
        'indexed' => null,
        'backlinks' => null,
        'related' => null,
        'yc' => null
    );
    private $_alexa = null;
    private $_dmoz = null;
    private $_whois = null;
    private $_dns = null;
        
    private function _assertArrayFields(array $fields, array $validator)
    {
        foreach ($fields as $name => $value)
            if (!array_key_exists($name, $validator)) 
                throw new \Exception(sprintf('Invalid option key \'%s\' passed', $name));
    }
    
    public function __construct($fqdn = "")
    {
        $this->_fqdn = $fqdn;
    }
    
    public function setFqdn($fqdn)
    {
        $this->_fqdn = $fqdn;
    }
    
    public function getFqdn()
    {
        return $this->_fqdn;
    }
    
    public function setGoogle(Array $google)
    {
        $this->_assertArrayFields($google, $this->_google);
        
        foreach ($google as $key=>$val) $this->_google[$key] = $val;
    }
    
    public function setYandex(Array $yandex)
    {
        $this->_assertArrayFields($yandex, $this->_yandex);
        
        foreach ($yandex as $key=>$val) $this->_yandex[$key] = $val;
    }
    
    public function setDmoz($dmoz)
    {
        $this->_dmoz = $dmoz;
    }
    
    public function getDmoz()
    {
        return $this->_dmoz;
    }
    
    public function setAlexa($alexa)
    {
        $this->_alexa = $alexa;
    }
    
    public function getAlexa()
    {
        return $this->_alexa;
    }
    
    public function toArray()
    {
        return array(
            'fqdn' => $this->_fqdn,
            'google' => $this->_google,
            'yahoo' => $this->_yahoo,
            'bing' => $this->_bing,
            'yandex' => $this->_yandex,
            'alexa' => $this->_alexa,
            'dmoz' => $this->_dmoz,
            'whois' => $this->_whois,
            'dns' => $this->_dns
        );
    }
    
}
