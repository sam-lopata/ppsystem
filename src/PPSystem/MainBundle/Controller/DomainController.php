<?php

namespace PPSystem\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PPSystem\MainBundle\Entity\SearchCriteria;
use PPSystem\MainBundle\Form\SearchForm;
use PPSystem\MainBundle\Parser\Google\GoogleSerpScraper;

class DomainController extends Controller
{
    public function indexAction()
    {
        $searchCriteria = new SearchCriteria();
        
        $form = $this->get('form.factory')->create(new SearchForm($searchCriteria));
        
        $query = "";
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $formData= $form->getData();
                $google_serp_scraper = new GoogleSerpScraper('http://www.google.com/');
                $results = $google_serp_scraper->search($formData->getQuery(), 3);
                
                $this->get('session')->setFlash('notice', 'OK!');
             
                return $this->render('PPSystemMainBundle:Domain:index.html.twig', array(
                    'form' => $form->createView(), 
                    'query'=>$query,
                    'results_count'=>$results->totalResults(),
                    'results' => $results
                ));    
            }
            
            $this->get('session')->setFlash('notice', 'ERROR!');
        }
    
        return $this->render('PPSystemMainBundle:Domain:index.html.twig', array('form' => $form->createView(), 'query'=>$query));
        
    }

}
