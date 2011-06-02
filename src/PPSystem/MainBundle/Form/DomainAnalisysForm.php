<?php

namespace PPSystem\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DomainAnalisysForm extends AbstractType
{
    private $parameters_choices = array(
        'google_indexed' => 'Google indexed',
        'google_pr' => 'Google PR',
        'google_backlinks' => 'Google Backlinks',
        'yahoo_indexed' => 'Yahoo indexed',
        'yahoo_backlinks' => 'Yahoo backlinks',
        'bing_indexed' => 'Bing indexed',
        'bing_backlinks' => 'Bing backlinks',
        'yandex_yc' => 'Yandex YC',
        'yandex_indexed' => 'Yandex indexed',
        'yandex_backlinks' => 'Yandex backlinks',
        'alexa' => 'Alexa Rank',
        'dmoz' => 'DMOZ',
        'whois' => 'Whois',
        'dns' => 'DNS',
        'google_trends' => 'Trends traff',
        'google_related' => 'Google related',
        'google_suggestions' => 'Google related',
    );
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('domains', 'textarea');
        $builder->add('parameters', 'choice', array(
            'choices'   => $this->parameters_choices,
            'required'  => true,
            'multiple'  => true,
            'expanded' =>true
        ));
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'PPSystem\MainBundle\Entity\DomainAnalisysCriteria',
        );
    } 
    
    public function getName()
    {
        return "DomainAnalisysForm";
    }
    
}
