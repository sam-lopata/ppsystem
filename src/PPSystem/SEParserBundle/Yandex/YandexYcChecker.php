<?php 

namespace PPSystem\SEParserBundle\Yandex;

use PPSystem\SEParserBundle\ParsersManager;
use PPSystem\SEParserBundle\DomainResult;

 /**
  * Class to get yandex YC.
  * Based on http://info.sectorit.net
  * 
  * @author Semen Bocharov <sam_lopata@gmail.com>
  */
class YandexYcChecker {

    public function getTcy($url) 
    {
        if ( ! preg_match('/^(http:\/\/)(.*)/i', $url)) $url = 'http://' . trim($url);
        $url = "http://bar-navig.yandex.ru/u?ver=2&show=32&url=" . $url;
        $result = file_get_contents($url);
        
        return $result ? (int) substr(strstr($result,'value="'), 7):false;
    }
}
    