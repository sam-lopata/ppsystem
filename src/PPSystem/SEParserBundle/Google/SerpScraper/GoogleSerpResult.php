<?php 

namespace PPSystem\SEParserBundle\Google\SerpScraper;

/* -------------------------------------------------------------------------
 *
 * Google SERP Result Object
 *
 * - Purpose:	Models a result object.
 *
 * - Usage: 	Takes DOMElement representing result on construct
 *
 *		    Access properties to get result values
 *
 * - Returns: 	N/A
 *
 * - Author:	gatecrasher1981@gmail.com
 *
 *				Any feedback welcome.
 *
 * --------------------------------------------------------------------------*/

Class GoogleSerpResult
{

// -----------------
// Define Properties
// -----------------

    public $position;
    public $type;
	public $title;
	public $summary;
	public $cacheUrl;
	public $url;
	
    protected $resultElement;

// -----------------
// Constructor
// -----------------
    public function __construct(\DOMElement $result, $position)
    {
        // Assign properties
        $this->position		      = $position + 1;
        $this->title			= $result->getElementsByTagName('Title')->item(0)->nodeValue;
        $this->url 			= $result->getElementsByTagName('URL')->item(0)->nodeValue;
        $this->summary		    = $result->getElementsByTagName('Summary')->item(0)->nodeValue;
        $this->cacheUrl		     = $result->getElementsByTagName('CacheURL')->item(0)->nodeValue;

		$this->resultElement = $result;
    }
}