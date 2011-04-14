<?php

/* WebProfilerBundle:Profiler:header.html.twig */
class __TwigTemplate_2e1f21d08be3a4245c34344252e091e1 extends Twig_Template
{
    public function display(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<div class=\"header clear_fix\">
    <h1>
        <img src=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->env->getExtension('templating')->getAssetUrl("bundles/webprofiler/images/profiler/logo_symfony_profiler.gif"), "html");
        echo "\" alt=\"Symfony profiler\"/>
    </h1>

    <div class=\"search\">
        <form method=\"get\" action=\"http://symfony.com/search\">
            <div class=\"form_row\">
                <label for=\"search_id\">
                    <img src=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('templating')->getAssetUrl("bundles/webprofiler/images/profiler/grey_magnifier.png"), "html");
        echo "\" alt=\"Search on Symfony website\"/>
                </label>

                <input name=\"q\" id=\"search_id\" type=\"search\" placeholder=\"Search on Symfony website\"/>

                <button type=\"submit\">
                    <span class=\"border_l\">
                        <span class=\"border_r\">
                            <span class=\"btn_bg\">OK</span>
                        </span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "WebProfilerBundle:Profiler:header.html.twig";
    }
}
