<?php 

namespace PPSystem\SEParserBundle;

use PPSystem\SEParserBundle\Google\SerpScraper\GoogleSerpScraper;

//implement other parsers here...

 /**
  * SE parsers manager
  * 
  * @author Semen Bocharov <sam_lopata@gmail.com>
  */
class ParsersManager {
    
    //Parsers types
    const GOOGLE = 1;
    const YAHOO = 2;
    const BING = 3;
    const YANDEX = 4;
    
    private $_mode;
    
    public function __construct( $mode )
    {
        $this->_mode = $mode;
    }
    
    public function getParser()
    {
        switch ($this->_mode) {
            case (self::GOOGLE) :
                return new GoogleSerpScraper();
                
            default:
                throw new Exception('No Parser class found');
        }
    }
    
    public function getSitePrefix()
    {
        switch ($this->_mode) {
            case (self::GOOGLE) :
                return "site:";
                
            default:
                throw new Exception('No Parser class found');
        }
    }
}
    