<?php

/* PPSystemMainBundle::layout.html.twig */
class __TwigTemplate_c67770bb64181d229ba10bf56a1c18f7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'sidebar' => array($this, 'block_sidebar'),
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
        $this->displayBlock('sidebar', $context, $blocks);
        // line 22
        echo "        </div>    
        
        ";
        // line 24
        if ($this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "session", array(), "any", false), "flash", array("notice", ), "method", false)) {
            // line 25
            echo "            <div class=\"flash-message\">
                <em>Notice</em>: ";
            // line 26
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "session", array(), "any", false), "flash", array("notice", ), "method", false), "html");
            echo "
            </div>
        ";
        }
        // line 29
        echo "
        <div id=\"content\">
            ";
        // line 31
        $this->displayBlock('content', $context, $blocks);
        // line 33
        echo "        </div>

        ";
        // line 35
        if (twig_test_defined("code", $context)) {
            // line 36
            echo "            <h2>Code behind this page</h2>
            <div class=\"symfony-content\">";
            // line 37
            echo $this->getContext($context, 'code');
            echo "</div>
        ";
        }
        // line 39
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

    // line 11
    public function block_sidebar($context, array $blocks = array())
    {
        // line 12
        echo "            <dl>
                <dt><a href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("main"), "html");
        echo "\">Home</a></dt>
                <dt><a href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("domain"), "html");
        echo "\">Domain utilites</a></dt>
                <dd><a href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("domain"), "html");
        echo "\">Pages in SERP</a></dd>
                <dd><a href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("domain"), "html");
        echo "\">Backlinks</a></dd>
                <dd><a href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("domain"), "html");
        echo "\">Google PR</a></dd>
                <dd><a href=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("domain"), "html");
        echo "\">Alexa Rank</a></dd>
                
            </dl>
            ";
    }

    // line 31
    public function block_content($context, array $blocks = array())
    {
        // line 32
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
