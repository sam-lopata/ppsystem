<?php

namespace PPSystem\MainBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\TextField;

class SearchForm extends Form
{
    public $query;

    public function configure()
    {
        $this->add(new TextField('query'));
    }
}
