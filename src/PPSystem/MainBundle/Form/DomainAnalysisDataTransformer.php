<?php

namespace PPSystem\MainBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;

class DomainAnalysisDataTransformer implements DataTransformerInterface
{
    /**
     * @var Array $result
     */
    private $_result = array();
    
    /**
     * Checks whether value passed and pushes it into result array
     * 
     * @param String $value Value to search for
     * @param Array $options Where to search the value
     * @param String $result_value_name The name of the value to put in result array
     */
    private function _pushValueFromArrayToResult($value, $options, $result_value_name)
    {
        if (array_search($value, $options) !== FALSE){
            array_push($this->_result, $result_value_name);
            return true;            
        }
            
        return false;
    }
    
    function transform($value)
    {
        if ($value === null) return '';
        
        //Google section
        $this->_pushValueFromArrayToResult('indexed', $value->getGoogle()->options, 'google_indexed');
        $this->_pushValueFromArrayToResult('backlinks', $value->getGoogle()->options, 'google_backlinks');
        $this->_pushValueFromArrayToResult('pr', $value->getGoogle()->options, 'google_pr');

        //Yandex section
        $this->_pushValueFromArrayToResult('indexed', $value->getYandex()->options, 'yandex_indexed');
        $this->_pushValueFromArrayToResult('backlinks', $value->getYandex()->options, 'yandex_backlinks');
        $this->_pushValueFromArrayToResult('yc', $value->getYandex()->options, 'yandex_yc');
        
        //Others
        if ($value->alexa) array_push($this->_result, 'alexa');
        if ($value->dmoz) array_push($this->_result, 'dmoz');
        if ($value->whois) array_push($this->_result, 'whois');
        
        return $this->_result;
    }
    
    
    function reverseTransform($value)
    {
        if ($value === '') return null;
        
        return $value;
    }
}
