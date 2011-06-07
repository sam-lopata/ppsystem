<?php

namespace PPSystem\MainBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class DomainAnalisysCriteria
{
    
    /**
     * @Assert\Type(type="PPSystem\MainBundle\Entity\GoogleDomainCriteria")
     */
    protected $google;
    
    /**
     * @Assert\Type(type="PPSystem\MainBundle\Entity\YandexDomainCriteria")
     */
    protected $yandex;
    
    
    public $domains;
    public $alexa;
    public $dmoz;
    public $whois;
    
    public function __construct(array $defaults = array())
    {
        // $this->domains = isset($defaults['query']) ? $defaults['query'] : array();
        // $this->domains = isset($defaults['query']) ? $defaults['query'] : array();
        // $this->google = isset($defaults['google']) ? $defaults['google'] : null;
        // $this->yandex = isset($defaults['yandex']) ? $defaults['yandex'] : null;
    }
    
    public function getGoogle()
    {
        return $this->google;
    }
    
    public function setGoogle(SEDomainCriteria $google)
    {
        $this->google = $google;
    }
    
    public function getYandex()
    {
        return $this->yandex;
    }
    
    public function setYandex(SEDomainCriteria $yandex)
    {
        $this->yandex = $yandex;
    }
   
}
