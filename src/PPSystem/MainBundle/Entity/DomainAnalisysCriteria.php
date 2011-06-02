<?php

namespace PPSystem\MainBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class DomainAnalisysCriteria
{
    
    private $_valid_params = array('pages_indexed', 'pr', 'backlinks', 'alexa', 'related', 'yc', 'dmoz', 'whois', 'dns', 'trends');

    public $domains;
    
    /**
     * @Assert\Choice(callback = "getParametersNames", multiply = true)
     */
    public $parameters;
    
    public function getParametersNames()
    {
        return $this->_valid_params;
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
