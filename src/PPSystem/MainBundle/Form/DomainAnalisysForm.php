<?php

namespace PPSystem\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DomainAnalisysForm extends AbstractType
{
    private $parameters_choices = array(
        'pages_indexed' => 'Total pages',
        'pr' => 'PR',
        'backlinks' => 'Backlinks',
        'alexa' => 'Alexa Rank',
        'related' => 'Related results',
        'yc' => 'YC',
        'dmoz' => 'DMOZ',
        'whois' => 'Whois',
        'dns' => 'DNS',
        'trends' => 'Trends traff'         
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
