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

    public function display(array $context, array $blocks = array())
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
    </head>
    <body>

            ";
        // line 9
        if ($this->getAttribute($this->getAttribute($this->getContext($context, 'app', '9'), "session", array(), "any", false, 9), "flash", array("notice", ), "method", false, 9)) {
            // line 10
            echo "                <div class=\"flash-message\">
                    <em>Notice</em>: ";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, 'app', '11'), "session", array(), "any", false, 11), "flash", array("notice", ), "method", false, 11), "html");
            echo "
                </div>
            ";
        }
        // line 14
        echo "
            <div class=\"symfony-content\">
                ";
        // line 16
        $this->displayBlock('content', $context, $blocks);
        // line 18
        echo "            </div>

            ";
        // line 20
        if (twig_test_defined("code", $context)) {
            // line 21
            echo "                <h2>Code behind this page</h2>
                <div class=\"symfony-content\">";
            // line 22
            echo $this->getContext($context, 'code', '22');
            echo "</div>
            ";
        }
        // line 24
        echo "        </div>
    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "PPSystem";
    }

    // line 16
    public function block_content($context, array $blocks = array())
    {
        // line 17
        echo "                ";
    }

    public function getTemplateName()
    {
        return "PPSystemMainBundle::layout.html.twig";
    }
}
