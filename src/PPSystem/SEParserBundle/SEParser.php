<?php 

namespace PPSystem\SEParserBundle;

use PPSystem\SEParserBundle\ParsersManager;
use PPSystem\SEParserBundle\DomainResult;
use PPSystem\SEParserBundle\Google\GooglePrChecker;
use PPSystem\SEParserBundle\Yandex\YandexYcChecker;
use PPSystem\SEParserBundle\DMOZ\DmozChecker;
use PPSystem\SEParserBundle\Alexa\AlexaChecker;
use PPSystem\SEParserBundle\Whois\WhoisChecker;

/**
 * @todo: implement config loading and saving
 */

 /**
  * Class to process searches
  * 
  * @author Semen Bocharov <sam_lopata@gmail.com>
  */
class SEParser {
    
    //Options actions lookup
    private $_options_actions = array(
        'google_indexed' => '_parseIndexedPages',
        'google_pr' => '_parseGooglePr',
        'yandex_yc' => '_parseYandexYc',
        'dmoz' => '_parseDmoz',
        'alexa' => '_parseAlexaRank',
        'whois' => '_parseWhois',
        'related' => '_parse_related_results',
        'dns' => '_parse_dns',
        'backlinks' => '_parse_backlinks',
        'trends' => '_parse_trends'         
    );
    
    //Variable to put domain analyze results 
    private $_results;
    
    private function _getParser($se)
    {
        $pm = new ParsersManager($se);
        
        return $pm->getParser();
    }
    
    /**
     * Constructor
     * 
     * @param String $url Url to send requests to
     */
    public function __construct( ) { }
    
    /**
     * Parses goole output
     * 
     * @param String $query The query
     * @param Integer $results Number of results to return
     * @param Integer $se SE identificator, @see ParsersManager  
     * 
     * @return GoogleSerpResultSet Parsed results
     */
    public function getSEOutput($query, $results, $se = 1)
    {
        $parser = $this->_getParser($se);
        
        return $parser->search($query, $results);
    }

    /**
     * Domain properties lookup
     * 
     * @param String $fqdn Domain name
     * @param Array $options What to analize
     * 
     * @return Array Domain properties
     */
    public function analizeDomain($fqdn, Array $options)
    {
        $this->_results = new DomainResult($fqdn);
        
        foreach ($options as $option) {
            $action = $this->_options_actions[$option];
            $this->$action();
        }
        
        return $this->_results;
    }
    
    /**
     * Returns number of pages in se output
     * 
     * @param Integer $se SE identificator, @see ParsersManager  
     */
    private function _parseIndexedPages($se = 1)
    {
        $pm = new ParsersManager($se);
        $parser = $pm->getParser();
        $parser->setDelays(array('min' =>5, 'max'=>45));
        
        $result = $parser->search($pm->getSitePrefix().$this->_results->getFqdn(), 1, array('results'=>1));
        
        $this->_results->setGoogle(array('indexed'=>$result->totalResultsAvailable));
    }
    
    /**
     * Returns google pagerank
     * 
     */
    private function _parseGooglePr()
    {
        $prchecker = new GooglePrChecker();
        $pr = $prchecker->getPR($this->_results->getFqdn()); 
        
        $this->_results->setGoogle(array('pr'=>$pr));
    }
    
    /**
     * Returns yandex YC
     */
    private function _parseYandexYc()
    {
        $ycchecker = new YandexYcChecker();
        $yc = $ycchecker->getTcy($this->_results->getFqdn()); 
        
        $this->_results->setYandex(array('yc'=>$yc));
    }
    
    private function _parseDmoz()
    {
        $dmozchecker = new DmozChecker();
        $dmoz= $dmozchecker->getDmoz($this->_results->getFqdn()); 
        
        $this->_results->setDmoz($dmoz);
    }
    
    private function _parseAlexaRank()
    {
        $alexachecker = new AlexaChecker();
        $alexa = $alexachecker->getAlexa($this->_results->getFqdn()); 
        
        $this->_results->setAlexa($alexa);
        
    }
    
    private function _parseWhois()
    {
        $whoischecker = new WhoisChecker();
        $whois = $whoischecker->checkWhois($this->_results->getFqdn()); 
        
        $this->_results->setWhois(array('busy' => !$whois->free, 'data' => (!$whois->free) ? $whois->whois : null));
    }
}
