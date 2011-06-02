<?php

namespace PPSystem\MainBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class DomainAnalisysCriteria
{
    
    private $_valid_params = array(
        'google_indexed' => 'Google indexed',
        'google_pr' => 'Google PR',
        'google_backlinks' => 'Google Backlinks',
        'yahoo_indexed' => 'Yahoo indexed',
        'yahoo_backlinks' => 'Yahoo backlinks',
        'bing_indexed' => 'Bing indexed',
        'bing_backlinks' => 'Bing backlinks',
        'yandex_yc' => 'Yandex YC',
        'yandex_indexed' => 'Yandex indexed',
        'yandex_backlinks' => 'Yandex backlinks',
        'alexa' => 'Alexa Rank',
        'dmoz' => 'DMOZ',
        'whois' => 'Whois',
        'dns' => 'DNS',
        'google_trends' => 'Trends traff',
        'google_related' => 'Google related',
        'google_suggestions' => 'Google related',
    );
    
    public $domains;
    
    /**
     * @Assert\Choice(callback = "getParametersNames", multiply = true)
     */
    public $parameters;
    
    public function getParametersNames()
    {
        return array_keys($this->_valid_params);
    }
    
    private function _assertValidOptions(array $options)
    {
        foreach ($options as $name => $value)
            if (!in_array($name, $this->_valid_params)) 
                throw new \Exception(sprintf('Invalid option key \'%s\' passed', $name));
    }
    
    public function __construct(array $defaults = array())
    {
        $this->_assertValidOptions($defaults);
        
        $this->domains = isset($defaults['query']) ? $defaults['query'] : array();
        $this->parameters = isset($defaults['parameters']) ? (int) $defaults['parameters'] : array();
    }
    
}
