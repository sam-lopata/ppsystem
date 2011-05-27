<?php

/* PPSystemMainBundle:Main:index.html.twig */
class __TwigTemplate_f460060b1bcb461a2a00ccf2002fa12d extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("PPSystemMainBundle::layout.html.twig");
        }

        return $this->parent;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "PPSystem";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
Here will be more content. <br />
";
    }

    public function getTemplateName()
    {
        return "PPSystemMainBundle:Main:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
