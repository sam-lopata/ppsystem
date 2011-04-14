<?php

namespace PPSystem\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PPSystem\MainBundle\Form\SearchForm;
use PPSystem\MainBundle\Parser\Google\GoogleSerpScraper;

class MainController extends Controller
{
    public function indexAction()
    {
    	
        $form = SearchForm::create($this->get('form.context'), 'search');

        $form->bind($this->container->get('request'), $form);
        
        $query = "";
        if ( $this->container->get('request')->getMethod() == "POST") {
        	$search = $this->container->get('request')->get('search');
            $query = $search['query'];
        	
	        if ($form->isValid()) {
	        	$google_serp_scraper = new GoogleSerpScraper('http://www.google.com/');
	        	$results = $google_serp_scraper->search($query, 100);
	        	
//	        	var_dump($results);
	        	
	            $this->get('session')->setFlash('notice', 'OK!');
	            
	            return $this->render('PPSystemMainBundle:Main:index.html.twig', array(
	            	'form' => $form, 
	            	'query'=>$query,
	            	'results_count'=>$results->totalResults(),
	            	'results' => $results
	            ));
	            
	        }
	        else
	           $this->get('session')->setFlash('notice', 'ERROR!');
        }                                           
            

        return $this->render('PPSystemMainBundle:Main:index.html.twig', array('form' => $form, 'query'=>$query));
        
//        return new Response('<html><body>Hello '.$name.'!</body></html>');
        
    }
    
    public function searchGoogleAction()
    {
    	
    }
}
