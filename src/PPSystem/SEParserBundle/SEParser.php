<?php 

namespace PPSystem\SEParserBundle;

use PPSystem\SEParserBundle\ParsersManager;
use PPSystem\SEParserBundle\DomainResult;
use PPSystem\SEParserBundle\Google\GooglePrChecker;

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
        'pages_indexed' => '_parseIndexedPages',
        'pr' => '_parseGooglePr',
        'alexa' => '_parse_alexa_rank',
        'related' => '_parse_related_results',
        'yc' => '_parse_yc',
        'dmoz' => '_parse_dmoz',
        'whois' => '_parse_whois',
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
        $parser->setDelays(array('min' =>5, 'max'=>10));
        
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
    
    
}
