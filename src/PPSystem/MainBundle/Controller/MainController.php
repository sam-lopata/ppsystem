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
        return $this->render('PPSystemMainBundle:Main:index.html.twig', array());
        
    }
    
    public function analyzeDomainAction()
    {
    	
    }
}
