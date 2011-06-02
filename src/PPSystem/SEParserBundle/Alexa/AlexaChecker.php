<?php 

namespace PPSystem\SEParserBundle\Alexa;

use Symfony\Component\CssSelector\Parser;

 /**
  * Class to check domain Alexa.com rank
  * 
  * @author Semen Bocharov <sam_lopata@gmail.com>
  */
class AlexaChecker {

    public function getAlexa($url) 
    {
        if ( ! preg_match('/^(http:\/\/)(.*)/i', $url)) $url = 'http://' . trim($url);
        $url = "http://www.alexa.com/search?q=" . $url;
        $result = file_get_contents($url);
        
        $resultPage = new \DOMDocument();
        if (!@$resultPage->loadHTML($result))
            throw new \Exception('Failed to load HTML from result page into DOM object')    ;
        
        $xpath = new \DOMXpath($resultPage);
        
        $result = $xpath->query(Parser::cssToXpath('ul.traffic-stats'));
        
        return $result->item(0)->getElementsByTagName('a')->item(0)->nodeValue;
    }
    
}
    