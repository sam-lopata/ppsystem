<?php

namespace PPSystem\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SearchForm extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('query');
        $builder->add('tmp', 'text', array('required' => false));
        //$builder->add('price', 'money', array('currency' => 'USD'));
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
