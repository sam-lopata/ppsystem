<?php

/* WebProfilerBundle:Profiler:layout.html.twig */
class __TwigTemplate_6f98accaf2c2ce35db8e684acb4656a6 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'panel' => array($this, 'block_panel'),
            'body' => array($this, 'block_body'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("WebProfilerBundle:Profiler:base.html.twig");
        }

        return $this->parent;
    }

    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 45
    public function block_panel($context, array $blocks = array())
    {
        echo "";
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "
    ";
        // line 5
        echo $this->env->getExtension('templating')->renderAction("WebProfilerBundle:Profiler:toolbar", array("token" => $this->getContext($context, 'token', '5'), "position" => "normal"), array());
        // line 6
        echo "
    <div id=\"content\">
        ";
        // line 8
        $template = "WebProfilerBundle:Profiler:header.html.twig";
        if ($template instanceof Twig_Template) {
            $template->display(array());
        } else {
            echo $this->env->getExtension('templating')->getTemplating()->render($template, array());
        }
        // line 9
        echo "
        <div class=\"resume\">
            <p>
                <strong><a href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'profiler', '12'), "url", array(), "any", false, 12), "html");
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'profiler', '12'), "url", array(), "any", false, 12), "html");
        echo "</a></strong>
                <span class=\"date\">
                    <strong>by ";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'profiler', '14'), "ip", array(), "any", false, 14), "html");
        echo "</strong> at <strong>";
        echo twig_escape_filter($this->env, twig_date_format_filter($this->getAttribute($this->getContext($context, 'profiler', '14'), "time", array(), "any", false, 14), "r"), "html");
        echo "</strong>
                </span>
            </p>
        </div>

        <div class=\"main\">
    
            <div class=\"clear_fix\">

                <div class=\"navigation\">
            
                    ";
        // line 25
        if (twig_test_defined("templates", $context)) {
            // line 26
            echo "                        <ul class=\"menu_profiler\">
                            ";
            // line 27
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'templates', '27'));
            foreach ($context['_seq'] as $context['name'] => $context['template']) {
                // line 28
                echo "                                ";
                ob_start();
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'template', '28'), "renderBlock", array("menu", array("collector" => $this->getAttribute($this->getContext($context, 'profiler', '28'), "get", array($this->getContext($context, 'name', '28'), ), "method", false, 28)), ), "method", false, 28), "html");
                $context['menu'] = new Twig_Markup(ob_get_clean());
                // line 29
                echo "                                ";
                if (($this->getContext($context, 'menu', '29') != "")) {
                    // line 30
                    echo "                                    <li class=\"";
                    echo twig_escape_filter($this->env, $this->getContext($context, 'name', '30'), "html");
                    if (($this->getContext($context, 'name', '30') == $this->getContext($context, 'panel', '30'))) {
                        echo " selected";
                    }
                    echo "\">
                                        <a href=\"";
                    // line 31
                    echo twig_escape_filter($this->env, $this->env->getExtension('templating')->getPath("_profiler_panel", array("token" => $this->getContext($context, 'token', '31'), "panel" => $this->getContext($context, 'name', '31'))), "html");
                    echo "\">";
                    echo $this->getContext($context, 'menu', '31');
                    echo "</a>
                                    </li>
                                ";
                }
                // line 34
                echo "                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['name'], $context['template'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
            // line 35
            echo "                        </ul>
                    ";
        }
        // line 37
        echo "
                    ";
        // line 38
        echo $this->env->getExtension('templating')->renderAction("WebProfilerBundle:Profiler:searchBar", array("token" => $this->getContext($context, 'token', '38')), array());
        // line 39
        echo "                    
                    ";
        // line 40
        $template = "WebProfilerBundle:Profiler:admin.html.twig";
        if ($template instanceof Twig_Template) {
            $template->display(array("token" => $this->getContext($context, 'token', '40')));
        } else {
            echo $this->env->getExtension('templating')->getTemplating()->render($template, array("token" => $this->getContext($context, 'token', '40')));
        }
        // line 41
        echo "
                </div>

                <div class=\"collector_content\">
                    ";
        // line 45
        $this->displayBlock('panel', $context, $blocks);
        // line 46
        echo "                </div>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Profiler:layout.html.twig";
    }
}
