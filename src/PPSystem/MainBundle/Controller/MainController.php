<?php

namespace PPSystem\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PPSystem\MainBundle\Entity\SearchCriteria;
use PPSystem\MainBundle\Form\SearchForm;
use PPSystem\MainBundle\Parser\Google\GoogleSerpScraper;

class MainController extends Controller
{
    public function indexAction()
    {
        $searchCriteria = new SearchCriteria();
        
        $form = $this->get('form.factory')->create(new SearchForm($searchCriteria));
        //$form->setData($searchCriteria);             
        // $form->bind($this->container->get('request'), $form);
        
        $query = "";
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $formData= $form->getData();
                $google_serp_scraper = new GoogleSerpScraper('http://www.google.com/');
                $results = $google_serp_scraper->search($formData->getQuery(), 3);
                
                // foreach ($results as $result){
                    // echo var_dump($result);
                // }
                
            
                $this->get('session')->setFlash('notice', 'OK!');
             
                return $this->render('PPSystemMainBundle:Main:index.html.twig', array(
                    'form' => $form->createView(), 
                    'query'=>$query,
                    'results_count'=>$results->totalResults(),
                    'results' => $results
                ));    
            }
            
            $this->get('session')->setFlash('notice', 'ERROR!');
        }
    
    
        // if ( $this->container->get('request')->getMethod() == "POST") {
        	// $search = $this->container->get('request')->get('search');
            // $query = $search['query'];
//         	
	        // if ($form->isValid()) {
	        	// $google_serp_scraper = new GoogleSerpScraper('http://www.google.com/');
	        	// $results = $google_serp_scraper->search($query, 100);
// 	        	
	            // $this->get('session')->setFlash('notice', 'OK!');
// 	            
	            // return $this->render('PPSystemMainBundle:Main:index.html.twig', array(
	            	// 'form' => $form, 
	            	// 'query'=>$query,
	            	// 'results_count'=>$results->totalResults(),
	            	// 'results' => $results
	            // ));
// 	            
	        // }
	        // else
	           // $this->get('session')->setFlash('notice', 'ERROR!');
        // }                                           
//             
        // $jade = $this->container->get('jade');
//         
        // $engine = $this->container->get('templating');
        // $content = $engine->render('PPSystemMainBundle:Main:index.html.jade');
//         
        // var_dump($content);
        // die();

//        return $this->render('PPSystemMainBundle:Main:index.html.jade', array('name' => 'Sam'));
        
        return $this->render('PPSystemMainBundle:Main:index.html.twig', array('form' => $form->createView(), 'query'=>$query));
        
//        return new Response('<html><body>Hello '.$name.'!</body></html>');
        
    }
    
    public function searchGoogleAction()
    {
    	
    }
}
