<?php 

namespace PPSystem\SEParserBundle\DMOZ;

 /**
  * Class to check is site in DMOZ
  * 
  * @author Semen Bocharov <sam_lopata@gmail.com>
  */
class DmozChecker {

    public function getDmoz($url) 
    {
        if ( ! preg_match('/^(http:\/\/)(.*)/i', $url)) $url = 'http://' . trim($url);
        $url = "http://www.dmoz.org/search/?q=" . $url;
        $result = file_get_contents($url);
        
        return (preg_match('#.*Open Directory Categories.*#Uis', $result)) ? true : false; 
    }
}
    