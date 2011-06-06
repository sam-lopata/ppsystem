<?php

namespace PPSystem\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

//Forms
use PPSystem\MainBundle\Entity\SearchCriteria;
use PPSystem\MainBundle\Form\SearchForm;
use PPSystem\MainBundle\Entity\DomainAnalisysCriteria;
use PPSystem\MainBundle\Form\DomainAnalisysForm;

//Parser
use PPSystem\SEParserBundle\SEParser;

class DomainController extends Controller
{
    public function indexAction()
    {
        $searchCriteria = new SearchCriteria(array('query'=>'Enter query here', 'results'=>10));
        
        $form = $this->get('form.factory')->create(new SearchForm());
        $form->setData($searchCriteria);
        
        return $this->render('PPSystemMainBundle:Domain:index.html.twig', array('form' => $form->createView()));
    }

    public function serpOutputAction()
    {
        $searchCriteria = new SearchCriteria(array('query'=>'Enter query here', 'results'=>10));
        
        $form = $this->get('form.factory')->create(new SearchForm());
        $form->setData($searchCriteria);
        
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $formData = $form->getData();
                $google_parser = new SeParser();
                $results = $google_parser->getSEOutput($formData->getQuery(), $formData->getResults());
                
                return $this->render('PPSystemMainBundle:Domain:serpOutput.html.twig', array(
                    'form' => $form->createView(), 
                    'query'=> $formData->getQuery(),
                    'results_count' => $results->totalResults(),
                    'results_total' => $results->totalResultsAvailable,
                    'results' => $results
                ));    
            }
        }
    
        return $this->render('PPSystemMainBundle:Domain:serpOutput.html.twig', array('form' => $form->createView()));
    } 

    public function domainAnalysisAction()
    {
        $DomainAnalisysCriteria = new DomainAnalisysCriteria();
        
        $form = $this->get('form.factory')->create(new DomainAnalisysForm());
        
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST') {
            
            $form->bindRequest($request);
                       
            if ($form->isValid()) {
                $formData = $form->getData();
                
                $google_parser = new SEParser();

                $domains = explode("\r\n", $formData->domains);
                foreach ($domains as $domain) {
                    $result = $google_parser->analizeDomain($domain, $form->getClientData());
                    $results[$domain] = $result->toArray();
                }

                return $this->render('PPSystemMainBundle:Domain:domainAnalysis.html.twig', array(
                    'form' => $form->createView(), 
                    'results' => $results
                ));    
            }
        }
    
        return $this->render('PPSystemMainBundle:Domain:domainAnalysis.html.twig', array('form' => $form->createView()));
    }

}
