<?php

namespace PPSystem\MainBundle\Entity;

class SearchCriteria
{
    
    private $_valid_params = array('query', 'results');
    
    protected $query;
    protected $results;
    
    private function _assert_valid_options(array $options)
    {
        foreach ($options as $name => $value)
            if (!in_array($name, $this->_valid_params)) 
                throw new Exception('Invalid option keys were passed');
    }
    
    public function __construct(array $defaults)
    {
        $this->_assert_valid_options($defaults);
        
        $this->query = isset($defaults['query']) ? $defaults['query'] : "";
        $this->results = isset($defaults['results']) ? (int) $defaults['results'] : 10;
        
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }
    
    public function getQuery()
    {
        return $this->query;
    } 
    
    public function setResults($results)
    {
        $this->results = $results;
    }
    
    public function getResults()
    {
        return $this->results;
    }
    
}
