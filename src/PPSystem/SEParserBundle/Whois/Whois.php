<?php

use PPSystem\SEParserBundle\Whois\WhoisException;

namespace PPSystem\SEParserBundle\Whois;

require_once('Net/IDNA2.php');

class Whois {

    private static $_REQUEST_ZONES = array(
        ".ru"=>"ns.ripn.net",
        ".com"=>"k.gtld-servers.net",
        ".net"=>"k.gtld-servers.net",
        ".org"=>"tld2.ultradns.net",
        ".su"=>"ns.ripn.net",
        ".biz"=>"c.gtld.biz",
        ".info"=>"c9.info.afilias-nst.info",
        ".mobi"=>"tld2.ultradns.net",
    );

    private static $_WHOIS_SERVERS = array(
        ".ru"=>"whois.ripn.net",
        ".su"=>"whois.ripn.net",
        ".com"=>"whois.verisign-grs.com",
        ".net"=>"whois.verisign-grs.com",
        ".org"=>"whois.pir.org",
        ".info"=>"whois.afilias.info",
        ".biz"=>"whois.biz",
        ".me"=>"whois.meregistry.net",
        ".us"=>"whois.nic.us",
        ".mobi"=>"whois.dotmobiregistry.net",
        ".la"=>"whois.nic.la",
        ".cn"=>"whois.cnnic.cn",
        ".eu"=>"whois.eu",
        ".name"=>"whois.nic.name",
        ".cc"=>"ccwhois.verisign-grs.com",
        ".tv"=>"tvwhois.verisign-grs.com",
        ".bz"=>"whois.belizenic.bz",
        ".nu"=>"whois.nic.nu",
        ".ws"=>"whois.website.ws",
        ".de"=>"whois.denic.de",
        ".tc"=>"whois.adamsnames.tc",
        ".vg"=>"whois.adamsnames.tc",
        ".ms"=>"whois.adamsnames.tc",
        ".uk.com"=>"whois.centralnic.net",
        ".in"=>"whois.inregistry.net",
        ".am"=>"whois.amnic.net",
        ".ch"=>"whois.nic.ch",
        ".cz"=>"whois.nic.cz",
        ".li"=>"whois.nic.li",
        ".pl"=>"whois.dns.pl",
        ".re"=>"whois.nic.re",
        ".tw"=>"whois.twnic.net.tw",
        ".asia"=>"whois.nic.asia",
        ".xn--p1ai"=>"whois.ripn.net",
    	".fm"=>"whois.nic.fm",
    );

    private static $_WHOIS_WORDS = array(
        ".ru"=>"No entries",
        ".su"=>"No entries",
        ".com"=>"No match",
        ".net"=>"No match",
        ".org"=>"NOT FOUND",
        ".info"=>"NOT FOUND",
        ".biz"=>"Not found",
        ".me"=>"NOT FOUND",
        ".us"=>"Not found",
        ".mobi"=>"NOT FOUND",
        ".la"=>"NOT FOUND",
        ".cn"=>"no matching record",
        ".eu"=>"AVAILABLE",
        ".name"=>"No match",
        ".cc"=>"No match",
        ".tv"=>"No match",
        ".bz"=>"Your IP address is",
        ".nu"=>"NO MATCH",
        ".ws"=>"No match",
        ".de"=>"not found",
        ".tc"=>"not registered",
        ".vg"=>"not registered",
        ".ms"=>"not registered",
        ".uk.com"=>"No match",
        ".in"=>"NOT FOUND",
        ".am"=>"No match",
        ".fm"=>"Not Registered",
        ".ch"=>"do not have",
        ".cz"=>"No entries",
        ".li"=>"do not have",
        ".pl"=>"No information",
        ".re"=>"No entries",
        ".tw"=>"No Found",
        ".asia"=>"NOT FOUND",
        ".xn--p1ai"=>"No entries",
    );

    private static $_VARIANTS = array(
        "-info",
        "-net",
        "-company",
    );


	/* Обработчик классических ошибок, перенаправляет ошибки обработчику исключений */
	static function error_handler($errno, $errstr, $errfile, $errline)
	{
		if (error_reporting() != 0)
			throw new WhoisException($errstr, 0, $errno, $errfile, $errline);
	}

    /**
     * Checks domain whois
     * @param string $domain any domain name
     *
     * @return stdClass object with boolean <success> property, may contain boolean <free> and string <whois> properties or string <error> property
     *
     * @todo: Check domain name by regular expression
     */
    public function checkDomain($domain, $server = "")
    {
    	set_error_handler(array("self", "error_handler"), E_ALL);

        $result = new \stdClass();
        $result->success = false;

    	if ( trim($domain) == "" ) {
    		$result->error = "Empty domain name";
    		return $result;
    	}

        $output = "";

        try {
           	//encodes domain name to punicode
	    	$idn = new \Net_IDNA2();

	    	if ( !preg_match("/^[\\x20-\\x7F]*$/u", $domain) )
	    		$domain = $idn->encode($domain);

	        //get domain name and zone
	        list($domain_name, $zone) = self::_cutDomainName($domain);

	        if ( !isset(self::$_WHOIS_SERVERS[$zone]) ) {
	        	$result->error = sprintf("Wrong domain zone: %s", $zone);
	            return $result;
	        }

        	$server = ( trim($server) == "" ) ? self::$_WHOIS_SERVERS[$zone] : $server;

	        //open connection to whois server
	        $connection = fsockopen($server, 43, $errno, $errstr, 30);

	        //put data
        	fputs($connection, $domain_name . $zone . "\r\n");

	        //read whois data
	        while( !feof($connection) )
	            $output .= fgets($connection, 4096);

        	fclose($connection);

	        //error
	        if ( strlen($output) == 0 ) {
	        	$result->error = "Empty response from server";
				return $result;
	        }

	        $pos = mb_strpos($output, self::$_WHOIS_WORDS[$zone]);

            //domain is free
	        if ( $pos !== false )
	            $result->free = true;
	        //domain is busy
	        else {
	        	$result->free = false;
	        	$result->whois = $output;
	        }

	        $result->success = true;
        }
        catch ( Exception $e ) {
        	$result->error = $e->getMessage();
        	$result->errorTrace = $e->getTraceAsString();

        }

        restore_error_handler();

        return $result;
    }

    /*
     * Formats domain name and zone for different level domains
     *
     * @param String $domain "Raw" domain name
     *
     * @return Array[domain_name, zone] array with domain name and zone separated
     */
    private function _cutDomainName($domain)
    {
        //2-d level domains like domain.ru...
        if ( mb_substr_count($domain, ".") == 1 ){
            list($domain_name, $zone) = explode(".", $domain);
            $zone = ".".$zone;
        }
        //regional domains spb.ru...
        elseif ( in_array(mb_substr($domain, -7), array(".spb.ru", ".msk.ru", ".spb.su", ".msk.su")) ) {
            return array('domain'=>$domain, 'result'=>-1);
        }
        //all other domains like some.domain.ru, some.other.some.domain.ru...
        else {
            $last_comma = mb_strripos($domain, ".");
            $zone = mb_substr($domain, $last_comma);
            $domain_name = mb_substr($domain, 0, $last_comma);
            $domain_name = mb_substr($domain_name, mb_strripos($domain_name, ".")+1);
        }

        return array($domain_name, $zone);
    }
}

