<?php 

namespace PPSystem\SEParserBundle\Google;

use PPSystem\SEParserBundle\ParsersManager;
use PPSystem\SEParserBundle\DomainResult;

 /**
  * Class to get google PR.
  * Based on http://info.sectorit.net
  * 
  * @author Semen Bocharov <sam_lopata@gmail.com>
  */
class GooglePrChecker {

    /**
     * Конвертируем строку в 32-bit
     * @param   string  $str
     * @param   hex     $check
     * @param   hex     $magic
     * @return  integer
     */
    private function _strToNum($str, $check, $magic)
    {
        $int32Unit = 4294967296;  // 2^32
    
        $length = strlen($str);
        for ($i = 0; $i < $length; $i++) {
            $check *= $magic;
            /**
             * Если выпадаем за граници инта (обычно +/- 2.15e+9 = 2^31), то
             * получим undefined, читать ниже по ссылке:
             * http://www.php.net/manual/en/language.types.integer.php
             * потому танцуем с бубном
             */
            if ($check >= $int32Unit) {
                $check = ($check - $int32Unit * (int) ($check / $int32Unit));
                //if the check less than -2^31
                $check = ($check < -2147483648) ? ($check + $int32Unit) : $check;
            }
            $check += ord($str{$i});
        }
        return $check;
    }
    
    /**
     * Получаем хеш URL-а
     * @param   string  $string
     * @return  integer
     */
    private function _hashUrl($string)
    {
        $check1 = $this->_strToNum($string, 0x1505, 0x21);
        $check2 = $this->_strToNum($string, 0, 0x1003F);
    
        $check1 >>= 2;
        $check1 = (($check1 >> 4) & 0x3FFFFC0 ) | ($check1 & 0x3F);
        $check1 = (($check1 >> 4) & 0x3FFC00 ) | ($check1 & 0x3FF);
        $check1 = (($check1 >> 4) & 0x3C000 ) | ($check1 & 0x3FFF);
    
        $T1 = (((($check1 & 0x3C0) << 4) | ($check1 & 0x3C)) <<2 ) | ($check2 & 0xF0F );
        $T2 = (((($check1 & 0xFFFFC000) << 4) | ($check1 & 0x3C00)) << 0xA) | ($check2 & 0xF0F0000 );
    
        return ($T1 | $T2);
    }
    
    /**
     * Получаем чексум URL-а
     * @param   integer $Hashnum    хеш URL-а
     * @return  integer
     */
    private function _checkHash($hashNum)
    {
        $checkByte = 0;
        $flag = 0;
    
        $hashStr = sprintf('%u', $hashNum) ;
        $length = strlen($hashStr);
    
        for ($i = $length - 1;  $i >= 0;  $i --) {
            $re = $hashStr{$i};
            if (1 === ($flag % 2)) {
                $re += $re;
                $re = (int)($re / 10) + ($re % 10);
            }
            $checkByte += $re;
            $flag ++;
        }
    
        $checkByte %= 10;
        if (0 !== $checkByte) {
            $checkByte = 10 - $checkByte;
            if (1 === ($flag % 2) ) {
                if (1 === ($checkByte % 2)) {
                    $checkByte += 9;
                }
                $checkByte >>= 1;
            }
        }
    
        return '7' . $checkByte . $hashStr;
    }
    
    /**
     * Получаем PR с одного из сайтов гугла "закосив" под мозиллу
     * @param   string  $url    URL страницы
     */
    public function getPR($url)
    {
        if ( ! preg_match('/^(http:\/\/)(.*)/i', $url)) {
            $url = 'http://' . $url;
        }
        $googlehost = 'toolbarqueries.google.com';
        $googleua = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.6) Gecko/20060728 Firefox/1.5';
    
        $ch = $this->_checkHash($this->_hashUrl($url));
        /**
         * Используя сокеты, вероятность бана снижается до 0,
         * темболее что едим только 30 первых символов ;)
         */
        $fp = fsockopen($googlehost, 80, $errno, $errstr, 30);
        if ($fp) {
            $out = "GET /search?client=navclient-auto&ch=$ch&features=Rank&q=info:$url HTTP/1.1\r\n";
            $out .= "User-Agent: $googleua\r\n";
            $out .= "Host: $googlehost\r\n";
            $out .= "Connection: Close\r\n\r\n";
    
            fwrite($fp, $out);
    
            while ( ! feof($fp)) {
                $data = fgets($fp, 128);
                // ПР идёт в строке Rank_1:1:Х где Х наш ПР
                $pos = strpos($data, "Rank_");
                if($pos === false){} else{
                    fclose($fp);
                    $pr=substr($data, $pos + 9);
                    $pr=trim($pr);
                    $pr=str_replace("\n",'',$pr);
                    return $pr ? $pr : '0';
                }
            }
            fclose($fp);
        }
    }

}
    