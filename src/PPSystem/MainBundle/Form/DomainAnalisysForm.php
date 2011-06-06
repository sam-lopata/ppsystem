<?php

namespace PPSystem\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
//use PPSystem\MainBundle\Form\DomainAnalysisDataTransformer;

class DomainAnalisysForm extends AbstractType
{
    // private $parameters_choices = array(
        // 'google_indexed' => 'Google indexed',
        // 'google_pr' => 'Google PR',
        // 'google_backlinks' => 'Google Backlinks',   //intext:"brightonjewelry.biz"
        // 'yahoo_indexed' => 'Yahoo indexed',
        // 'yahoo_backlinks' => 'Yahoo backlinks',
        // 'bing_indexed' => 'Bing indexed',
        // 'bing_backlinks' => 'Bing backlinks',   //inbody:brightonjewelry.biz
        // 'yandex_yc' => 'Yandex YC',
        // 'yandex_indexed' => 'Yandex indexed',
        // 'yandex_backlinks' => 'Yandex backlinks',
        // 'alexa' => 'Alexa Rank',
        // 'dmoz' => 'DMOZ',
        // 'whois' => 'Whois',
        // 'dns' => 'DNS',
        // 'ip' => 'Ip address',
        // 'google_trends' => 'Trends traff',
        // 'google_related' => 'Google related',
        // 'google_suggestions' => 'Google related',
    // );
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('domains', 'textarea');
        
        $builder->add('google', new GoogleDomainForm());
        $builder->add('yandex', new YandexDomainForm());
        
        $builder->add('alexa', 'checkbox', array('required' => false));
        $builder->add('dmoz', 'checkbox', array('required' => false));
        $builder->add('whois', 'checkbox', array('required' => false));

        $builder->appendClientTransformer(new DomainAnalysisDataTransformer());        
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'PPSystem\MainBundle\Entity\DomainAnalisysCriteria',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
        );
    } 
    
    public function getName()
    {
        return "DomainAnalisysForm";
    }
    
}
