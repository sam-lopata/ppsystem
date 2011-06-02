<?php

namespace PPSystem\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SearchForm extends AbstractType
{
    
    private $results_choices = array(10,20,30,40,50,100,200,500, 1000); 
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('query', 'text');
        $builder->add('results', 'choice', array(
            'choices'   => array_combine(array_values($this->results_choices), $this->results_choices),
            'required'  => true,
        ));
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'PPSystem\MainBundle\Entity\SearchCriteria',
        );
    } 
    
    public function getName()
    {
        return "SearchForm";
    }
    
}
