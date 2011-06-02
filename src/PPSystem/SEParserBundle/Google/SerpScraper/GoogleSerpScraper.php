<?php 

namespace PPSystem\SEParserBundle\Google\SerpScraper;

use PPSystem\SEParserBundle\Google\SerpScraper\GoogleSerpResultSet;
use Symfony\Component\CssSelector\Parser;

require_once('HTTP/Request2.php');

/* -------------------------------------------------------------------------
 *
 * Google SERP Scraper
 *
 * - Purpose:	Launches requests and collects responses
 *
 * - Usage: 	Create new object with google domain to scrape and 
 *		    any changes to valid search string paramaters.
 *
 *		    Pass query and any additional options to 'search' method.
 *
 * - Returns: 	Google_Serp_ResultSet Object
 *
 * - Author:	gatecrasher1981@gmail.com
 *
 *				Any feedback welcome.
 *
 * - Web site:  http://www.perkiset.org/best/blackhat/oo_google_serp_scraper.html
 * --------------------------------------------------------------------------*/

 /**
  * @todo: Implement caching of empty elements
  * 
  */
Class GoogleSerpScraper
{
	
// -----------------
// Properties
// -----------------

	// Public
	public $baseDomain;
	public $validOptions;
	
	// Protected
	protected $resultsTally  = 0;
	protected $results;
    
    // Private
    private $delays = array('min'=>10, 'max'=>45);
    
    public function setDelays(array $delays)
    {
        if (!$delays['min']) 
            throw new \Exception('Minimum delay value with key \'min\' must present!');
            
        if (!$delays['max'])
            throw new \Exception('Maximum delay value with key \'max\' must present!');
            
        $this->delays = $delays;
    }
    
// -----------------
// Constructor
// -----------------
	public function __construct($domain = "http://google.com/", array $options = array())
	{
		// Valid Search Paramaters :: Format: $key = search param; $value = friendly name 
		$validOptions 	= array(
						'hl' 		=> 'interfaceLanguage', 	// Validate
						'btnG'		=> 'btnG',
						'num'       => 'results',
						'oe'		=> 'outputEncoding', 		// Validate
						'ie'		=> 'inputEncoding', 		// Validate
						'qdr'		=> 'dateFilter',
						'lr'		=> 'language', 				// Validate
						'cr'		=> 'country', 				// Validate
						'safe'		=> 'safeFilter', 			// Validate
						'filter'	=> 'duplicateFilter', 		// Validate
						'start'		=> 'start'
						);						
						
		$this->validOptions = array_merge($validOptions, $options);
		
		$this->validateDomain($domain);
		
		$this->results = $this->createResultsContainer();
        $this->resultsTally = 0;
	}

// -----------------
// Methods
// -----------------

// -----------------
// Search Query
// -----------------
	public function search($query, $requestedResults = 100, $options = array())
	{
		// Set default options - minimum options required to get search to run
		$defaultOptions 	= array(
    		'interfaceLanguage' 	=> 'en',
    		'btnG'					=> 'Search',
    		'results'               => 10
		);

		$options = array_merge($defaultOptions, $options);
		
		if(empty($query))
			throw new \Exception('Query string must not be empty!');
		
		$this->validateOptions($options);
		
		$pagesRequired = (int) $this->getPagesRequired($requestedResults, $options);
        
		$pagesReceived = 0;
		$expectedResultsTally = 0;
	
		while($pagesReceived < $pagesRequired && $this->resultsTally >= $expectedResultsTally)
		{
			if ($pagesReceived > 0) $options['start'] = $requestedResults * $pagesReceived + 1;
					
			$queryString = $this->buildSearchString($query, $options);
            
     		$resultPage = $this->sendSearch($queryString);
            
			$this->processResultsPage($resultPage->getBody());
            
			sleep(rand($this->delays['min'], $this->delays['max']));
			
			$pagesReceived++;
			$expectedResultsTally = $pagesReceived * $options['results'];
		}

		return new GoogleSerpResultSet($this->results);
	}

// -----------------
// Get Number of Pages Required
// -----------------
	protected function getPagesRequired($requestedResults, array $options)
	{
		if(empty($options['results']))
		{
			return ceil($requestedResults / 10);
		}
		
		return ceil($requestedResults / $options['results']);
	}

// -----------------
// Validate Options
// -----------------
	protected function validateOptions(array $options)
	{
		// Check there are no invalid options passed
		$difference = array_diff(array_keys($options), $this->validOptions);
		
		if($difference)
		{
			throw new \Exception('Invalid option keys were passed');
		}
		
		// Validate number of results requested per page
		if( isset($options['results']) && ($options['results'] < 1 || $options['results'] > 100) )
		{
			throw new \Exception('Number of results per page must be between 1 - 100');
		}
		
		// Validate date option if set 
		if( isset($options['dateFilter']) && preg_match('/^(d|m|y)[0-9]+$/', $options['dateFilter']) == 0 )
		{
			throw new \Exception('Date Filter Option must be expressed as either d, m or y, followed by a number');
		}
	}

// -----------------
// Validate Domain
// -----------------
	protected function validateDomain($domain)
	{	
		// Sloppy link check, apply external link object validation where available
		if(empty($domain) || !stristr($domain, 'google'))
		{
			throw new \Exception('A valid google domain to search must be supplied.');
		}
		
		$this->baseDomain = $domain;
	}

// -----------------
// Process Results Page
// -----------------
	protected function processResultsPage($results)
	{
		$resultPage = new \DOMDocument();

		if (!@$resultPage->loadHTML($results))
			throw new \Exception('Failed to load HTML from result page into DOM object')	;
		
		$xpath = new \DOMXpath($resultPage);
		
		// Set estimated total results
		$total_results = $this->parseEstimatedTotalResults($xpath);
        
        if (preg_match("#.*about (.*) results#Uis", $total_results, $matches))
            $total_results = (int) str_replace(",", "", $matches[1]);
        else
            $total_results = 0;
            
		$this->results->getElementsByTagName('EstimatedTotalResults')->item(0)->nodeValue = $total_results;
        
		// Isolate results
		$results = $xpath->query(Parser::cssToXpath('div#ires > ol > li.g'));
		
		// Parse out each result
		foreach($results as $result)
		{
		    $check = $xpath->query(Parser::cssToXpath('h3.r'), $result);

		    if ($check->length == 0) continue;
            
			$resultNode = $this->results->createElement('Result');
					
			$resultNode->appendChild( $this->parseTitle($result) );	
			$resultNode->appendChild( $this->parseLink($result) );	
			$resultNode->appendChild( $this->parseSummaryText($result, $xpath) );	
			$resultNode->appendChild( $this->parseCacheLink($result, $xpath) );
			
			$this->results->getElementsByTagName('ResultSet')->item(0)->appendChild( $resultNode );
            
            $this->resultsTally++;
		}
        
	}

// -----------------
// Parse Estimated Total Results
// -----------------
	protected function parseEstimatedTotalResults(\DOMXPath $xpath)
	{
		$estimatedTotalResults = $xpath->query(Parser::cssToXpath('div#resultStats'));
        
		return ($estimatedTotalResults->length) ? $estimatedTotalResults->item(0)->nodeValue : 0;
	}

// -----------------
// Parse Title
// -----------------
	protected function parseTitle(\DOMNode $result)
	{
		$title = htmlentities($result->getElementsByTagName('h3')->item(0)->nodeValue);
		
		return new \DOMElement('Title', $title);
	}

// -----------------
// Parse Link
// -----------------
	protected function parseLink(\DOMNode $result)
	{
		$url = htmlentities($result->getElementsByTagName('h3')->item(0)->getElementsByTagName('a')->item(0)->attributes->getNamedItem('href')->nodeValue);
		
		return new \DOMElement('URL', $url);
	}

// -----------------
// Parse Summary
// -----------------
	protected function parseSummaryText(\DOMNode $result, \DOMXPath $xpath)
	{
        $summary = $xpath->query(Parser::cssToXpath('div.s'), $result);
        
        $replaceArray = array();
		foreach($xpath->query(Parser::cssToXpath('span.f'), $result) as $deletes)
			$replaceArray[] = $deletes->nodeValue;
        
        if (is_object($summary) && $summary->item(0) ) 
            $summary = htmlentities(str_replace($replaceArray, '', $summary->item(0)->nodeValue));
        else
            $summary = "No summary";
		
		return new \DOMElement('Summary', $summary);
	}

// -----------------
// Parse Cache Link
// -----------------
	protected function parseCacheLink(\DOMNode $result, \DOMXPath $xpath)
	{
        $cacheLinkResults = $xpath->query(Parser::cssToXpath('span.gl a'), $result);

        if ($cacheLinkResults && $cacheLinkResults->item(0))
            $cacheURL = htmlentities($cacheLinkResults->item(0)->getAttribute('href'));
        else 
            $cacheURL = 'No cache';          
		
		return new \DOMElement('CacheURL', $cacheURL);
	}

// -----------------
// Build Search String
// -----------------
	protected function buildSearchString($query, $options)
	{
		$params['q'] = (string) $query;
		
		foreach($options as $optionKey => $optionValue)
		{		
			$translateKey = array_search($optionKey, $this->validOptions);
			$params[$translateKey] = $optionValue;
		}
		
		// URL encodes and glues together $params array
		return http_build_query($params);
	}

// -----------------
// Send Query
// -----------------
	protected function sendSearch($queryString)
	{
		$url = $this->baseDomain . 'search?' . $queryString;
		
		$request = new \HTTP_Request2($url, \HTTP_Request2::METHOD_GET, array('follow_redirects'=>true));
        
		try {
		    $response = $request->send();
		    return $response;
		    
		    if (200 == $response->getStatus()) {
		        return $response->getBody();
		    } else {
		        //return 'Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase();
                throw new Exception('Unexpected HTTP status: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
		    }
		} catch (HTTP_Request2_Exception $e) {
		    //return 'Error: ' . $e->getMessage();
		    throw new Exception($e->getMessage(), $e->getCode());
		}
		
		return false;
	}
	
// -----------------
// Create Results Container
// -----------------	
	protected function createResultsContainer()
	{
		$dom = new \DOMDocument('1.0', 'UTF-8');
		$dom->appendChild( $dom->createElement('EstimatedTotalResults') );
		$dom->appendChild( $dom->createElement('ResultSet') );
		
		return $dom;
	}

}