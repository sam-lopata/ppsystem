<?php 

use PPSystem\SEParserBundle\Whois\Whois;

namespace PPSystem\SEParserBundle\Whois;

 /**
  * Class to check domain whois information
  * 
  * @author Semen Bocharov <sam_lopata@gmail.com>
  */
class WhoisChecker {

    public function checkWhois($domain) 
    {
         $whois = new Whois();
         
         return $whois->checkDomain($domain);
    }
}
    