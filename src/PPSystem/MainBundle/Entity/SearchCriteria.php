<?php

namespace PPSystem\MainBundle\Entity;

class SearchCriteria
{
    protected $query;
    public $tmp;

    public function setQuery($query)
    {
        $this->query = $query;
    }
    
    public function getQuery()
    {
        return $this->query;
    } 
    
}
