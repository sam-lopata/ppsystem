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

    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Symfony - Welcome";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "You searched for: ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'query', '6'), "html");
        echo "
<br>
<form action=\"#\" method=\"post\">
    ";
        // line 9
        echo $this->env->getExtension('form')->renderField($this->getContext($context, 'form', '9'));
        echo "

    <input type=\"submit\" value=\"Send!\" />
</form>

";
        // line 14
        if (twig_test_defined("results", $context)) {
            // line 15
            echo "<div id=\"results\">
\t";
            // line 16
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'results', '16'));
            $context['_iterated'] = false;
            foreach ($context['_seq'] as $context['_key'] => $context['item']) {
                // line 17
                echo "\t\t";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'item', '17'), "url", array(), "any", false, 17), "html");
                echo "
\t";
                $context['_iterated'] = true;
            }
            if (!$context['_iterated']) {
                // line 19
                echo "\t\tNo results
\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 21
            echo "</div>
";
        }
        // line 23
        echo "
";
    }

    public function getTemplateName()
    {
        return "PPSystemMainBundle:Main:index.html.twig";
    }
}
