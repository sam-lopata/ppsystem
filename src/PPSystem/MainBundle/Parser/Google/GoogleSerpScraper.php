<?php 

namespace PPSystem\MainBundle\Parser\Google;

use PPSystem\MainBundle\Parser\Google\GoogleSerpResultSet;
use Symfony\Component\CssSelector\Parser;
//use PPSystem\MainBundle\Parser\Google\Crawler;
//use Symfony\Component\BrowserKit\Response;
//use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

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

Class GoogleSerpScraper
{
	
// -----------------
// Properties
// -----------------

	// Public
	public $baseDomain;
	public $validOptions;
	
	// Protected
	protected $resultsTally;
	protected $results;

// -----------------
// Constructor
// -----------------
	public function __construct($domain, array $options = array())
	{
		// Valid Search Paramaters :: Format: $key = search param; $value = friendly name 
		$validOptions 	= array(
						'hl' 		=> 'interfaceLanguage', 	// Validate
						'btnG'		=> 'btnG',
						'num'		=> 'results',
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
//							'sclient'				=> 'psy',
//							'source'				=> 'hp'
							);

		$options = array_merge($defaultOptions, $options);
		
		if(empty($query))
		{
			throw new \Exception('Query string must not be empty!');
		}
		
		$this->validateOptions($options);
		
		$pagesRequired = $this->getPagesRequired($requestedResults, $options);
		
		$pagesReceived = 0;
		$expectedResultsTally = 0;
	
		$options['results'] = 1;
		while($pagesReceived < $pagesRequired && $this->resultsTally >= $expectedResultsTally)
		{
			if($pagesReceived > 0)
			{
				$options['start'] = $requestedResults * $pagesReceived + 1;
			}
					
			$queryString = $this->buildSearchString($query, $options);
			
			$resultPage = $this->sendSearch($queryString);
			
			var_dump($resultPage);
			die;
			
			$this->processResultsPage($resultPage);
			
			sleep(rand(5,15));
			
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
		
		$html = '<html>
		<head>
		</head>
		<body>
			<div id="res">
				<span class="tests"></span>
				<span class="tests"></span>
				<span class="tests"></span>
			</div>
		</body>
		</html>';

		$resultPage = new \DOMDocument();
		
		$resultPage->loadHTML($html);
		
		$xpath = new \DOMXpath($resultPage);
		
		foreach ($xpath->query(Parser::cssToXpath('div.res > span.tests')) as $node)
		{
		  printf("%s\n", $node->nodeValue);
		}
		
		echo $resultPage->saveHTML();
		die();
		
//		if(!$resultPage->loadHTML($results))
		if(!$resultPage->loadHTML($html))
		{
			throw new \Exception('Failed to load HTML from result page into DOM object')	;
		}
		
		echo $resultPage->saveHTML();
		die();
		
		$xpath = new \DOMXpath($resultPage);
		
		// Set estimated total results
//		$this->results->getElementsByTagName('EstimatedTotalResults')->item(0)->nodeValue = $this->parseEstimatedTotalResults($xpath);
		
		$results = $xpath->query(Parser::cssToXpath(''));
		var_dump($results);
		
		die;
		// Isolate results
		//$results = $xpath->query('//div[@id="res"]//div[@class="g"]');
		$results = $xpath->query('//div[@id="ires"]');
		
		var_dump($results);
		
		// Parse out each result
		foreach($results as $result)
		{
			$resultNode = $this->results->createElement('Result');
					
			$resultNode->appendChild( $this->parseTitle($result) );	
			$resultNode->appendChild( $this->parseLink($result) );	
			$resultNode->appendChild( $this->parseSummaryText($result, $xpath) );	
			$resultNode->appendChild( $this->parseCacheLink($result, $xpath) );
			
			$this->results->getElementsByTagName('ResultSet')->item(0)->appendChild( $resultNode );
		}
		
		$this->resultsTally = $this->results->getElementsByTagName('ResultSet')->length;
	}

// -----------------
// Parse Estimated Total Results
// -----------------
	protected function parseEstimatedTotalResults(\DOMXPath $xpath)
	{
		//$estimatedTotalResults = $xpath->query('//table[@class="t bt"]//font//b[3]');
		$estimatedTotalResults = $xpath->query('//div[@id="resultStats"]');
		
		return $estimatedTotalResults->item(0)->nodeValue;
	}

// -----------------
// Parse Title
// -----------------
	protected function parseTitle(\DOMNode $result)
	{
		$title = htmlentities($result->getElementsByTagName('h2')->item(0)->nodeValue);
		
		return new \DOMElement('Title', $title);
	}

// -----------------
// Parse Link
// -----------------
	protected function parseLink(\DOMNode $result)
	{
		$url = htmlentities($result->getElementsByTagName('h2')->item(0)->getElementsByTagName('a')->item(0)->attributes->getNamedItem('href')->nodeValue);
		
		return new \DOMElement('URL', $url);
	}

// -----------------
// Parse Summary
// -----------------
	protected function parseSummaryText(\DOMNode $result, DOMXPath $xpath)
	{
		$summary = $xpath->query('.//font[@size = "-1"]', $result);
		
		foreach($xpath->query('.//font[@size = "-1"]//a | //span', $result) as $deletes)
		{
			$replaceArray[] = $deletes->nodeValue;
		}	
		
		$summary = htmlentities(str_replace( $replaceArray, '', $summary->item(0)->nodeValue ));
		
		return new \DOMElement('Summary', $summary);
	}

// -----------------
// Parse Cache Link
// -----------------
	protected function parseCacheLink(\DOMNode $result, DOMXPath $xpath)
	{
		$cacheLinkResults = $xpath->query('table//nobr/a[. = "Cached"]/@href', $result);
		
		$cacheURL = htmlentities($cacheLinkResults->item(0)->nodeValue);
		
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
		
		$request = new \HTTP_Request2($url, \HTTP_Request2::METHOD_GET);
		
		try {
		    $response = $request->send();
		    return $response;
		    
		    if (200 == $response->getStatus()) {
		        return $response->getBody();
		    } else {
		        return 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
		             $response->getReasonPhrase();
		    }
		} catch (HTTP_Request2_Exception $e) {
		    return 'Error: ' . $e->getMessage();
		}
		
		
		// --------------------------!
		// INSERT WEB REQUEST TO $url HERE
		// --------------------------!
		
		// --------------------------!
		// Check if the Web request was successful
		// --------------------------!
//		if(! )
//		{
//			throw new \Exception('Web request to' . $url . 'failed.');	
//		}
		
		// --------------------------!
		// Return string containing HTML received
		// --------------------------!
		return true;
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