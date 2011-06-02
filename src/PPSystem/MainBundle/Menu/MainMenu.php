<?php // src/PPSystem/MainBundle/Menu/MainMenu.php

namespace PPSystem\MainBundle\Menu;

use Knplabs\MenuBundle\Menu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class MainMenu extends Menu
{
    /**
     * @param Request $request
     * @param Router $router
     */
    public function __construct(Request $request, Router $router)
    {
        parent::__construct(array('id'=>'main_menu'), 'PPSystem\MainBundle\Menu\CustomMenuItem');

        $this->setCurrentUri($request->getRequestUri());

        $this->addChild('Home', $router->generate('main'));
        
        $domains_section = $this->addChild('Domains utilities', $router->generate('domain'));
        $domains_section->addChild('SERP analisys', $router->generate('domain_serp'), array('class'=>'child-level-1'));
        $domains_section->addChild('Domain analysis', $router->generate('domain_analysis'), array('class'=>'child-level-1'));
        $domains_section->addChild('Backlinks', null, array('class'=>'child-level-1'));
        $domains_section->addChild('Google PR', null, array('class'=>'child-level-1'));
        $domains_section->addChild('Alexa Rank', $router->generate('domain'), array('class'=>'child-level-1'));
        
        // ... add more children
    }
}