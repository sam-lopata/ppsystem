<?php

/* PPSystemMainBundle::layout.html.twig */
class __TwigTemplate_c67770bb64181d229ba10bf56a1c18f7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <link href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('templating')->getAssetUrl("css/reset.css"), "html");
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
        <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('templating')->getAssetUrl("css/style.css"), "html");
        echo "\" rel=\"stylesheet\" type=\"text/css\" />
    </head>
    <body>
        <div id=\"sidebar\">
            ";
        // line 11
        echo $this->env->getExtension('menu')->render("main");
        echo "
        </div>    
        
        ";
        // line 14
        if ($this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "session", array(), "any", false), "flash", array("notice", ), "method", false)) {
            // line 15
            echo "            <div class=\"flash-message\">
                <em>Notice</em>: ";
            // line 16
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "session", array(), "any", false), "flash", array("notice", ), "method", false), "html");
            echo "
            </div>
        ";
        }
        // line 19
        echo "
        <div id=\"content\">
            ";
        // line 21
        $this->displayBlock('content', $context, $blocks);
        // line 23
        echo "        </div>

        ";
        // line 25
        if (twig_test_defined("code", $context)) {
            // line 26
            echo "            <h2>Code behind this page</h2>
            <div class=\"symfony-content\">";
            // line 27
            echo $this->getContext($context, 'code');
            echo "</div>
        ";
        }
        // line 29
        echo "            
    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "PPSystem";
    }

    // line 21
    public function block_content($context, array $blocks = array())
    {
        // line 22
        echo "            ";
    }

    public function getTemplateName()
    {
        return "PPSystemMainBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
