<?php

namespace PPSystem\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GoogleDomainForm extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('options', 'choice' , array(
           'choices' => array('indexed' => 'indexed', 'backlinks' => 'backlinks', 'pr' => 'pr' ),
           'multiple' => true,
           'expanded' => true 
        ));
        
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'PPSystem\MainBundle\Entity\SEDomainCriteria',
        );
    } 
}
