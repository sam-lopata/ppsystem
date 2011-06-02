<?php 

namespace PPSystem\SEParserBundle\Google\SerpScraper;

use PPSystem\SEParserBundle\Google\SerpScraper\GoogleSerpResult; 

/* -------------------------------------------------------------------------
 *
 * Google SERP Result Set
 *
 * - Purpose:	Implements a Seekable Iterator to loop through
 *				collected search results
 *
 * - Usage: 	Construct takes DOMDocument returned from SERP Scrape. Each
 *				result in this object can then be accessed via standard loop
 *				patterns e.g. while, foreach.
 *
 *				totalResults method returns number of results in object
 *
 * - Returns: 	Google_Serp_Result Object when iterated
 *
 * - Author:	gatecrasher1981@gmail.com
 *
 *				Any feedback welcome.
 *
 * --------------------------------------------------------------------------*/
//require_once('GoogleSerpResult.php ');

Class GoogleSerpResultSet implements \SeekableIterator
{

// ----------------
// Define Properties
// ----------------
	
    public $totalResultsAvailable;
    public $totalResultsReturned;
    
	protected $dom;
    protected $results;
    protected $currentIndex = 0;

// ------------------
// Public Methods
// ------------------

    // --------------------
    // Parse the search response and retrieve the results for iteration
    // --------------------
    public function __construct(\DOMDocument $dom)
    {  
		$this->dom = $dom;

		$xpath = new \DOMXPath($dom);
        $this->results = $xpath->query('//ResultSet//Result');
        
        $this->totalResultsAvailable 	= $dom->getElementsByTagName('EstimatedTotalResults')->item(0)->nodeValue;
        $this->totalResultsReturned 	= (int) $this->results->length;
    }

    // --------------------
    // Total Number of results returned
    // --------------------   
    public function totalResults()
    {
        return $this->totalResultsReturned;
    }

// --------------------
// Implement SeekableIterator
// --------------------

// --------------------
// Implement SeekableIterator::current()
// --------------------
    public function current()
    {
        // Return an instance of result Object
		return new GoogleSerpResult($this->results->item($this->currentIndex), $this->currentIndex);
    }


// --------------------
//Implement SeekableIterator::key()
// --------------------
    public function key()
    {
        return $this->currentIndex;
    }


// --------------------
// Implement SeekableIterator::next()
// --------------------
    public function next()
    {
        $this->currentIndex += 1;
    }

// --------------------
// Implement SeekableIterator::rewind()
// --------------------
    public function rewind()
    {
        $this->currentIndex = 0;
    }


// --------------------
// Implement SeekableIterator::seek()
// --------------------
    public function seek($index)
    {
        $indexInt = (int) $index;
        
        if ($indexInt >= 0 && $indexInt < $this->results->length) 
		{
            $this->currentIndex = $indexInt;
        } 
		else
		{
            throw new \OutOfBounds\Exception("Illegal index '$index'");
        }
    }

// --------------------
// Implement SeekableIterator::valid()
// --------------------
    public function valid()
    {
        return $this->currentIndex < $this->results->length;
    }
}