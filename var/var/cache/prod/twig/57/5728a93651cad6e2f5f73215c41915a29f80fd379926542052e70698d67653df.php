<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @admin/Form/bootstrap_4_horizontal_layout.html.twig */
class __TwigTemplate_f0c35b67161cf357840d66a105e6ca956015fac775588e6009be4b1919b9867c extends \Eccube\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'toggle_switch_widget' => [$this, 'block_toggle_switch_widget'],
            'choice_widget' => [$this, 'block_choice_widget'],
            'file_widget' => [$this, 'block_file_widget'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 11
        return "bootstrap_4_horizontal_layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("bootstrap_4_horizontal_layout.html.twig", "@admin/Form/bootstrap_4_horizontal_layout.html.twig", 11);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 13
    public function block_toggle_switch_widget($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 14
        echo "<div class=\"c-toggleSwitch\">
        <div class=\"c-toggleSwitch__btn\">
            <input type=\"checkbox\"
                   id=\"";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 17), "id", [], "any", false, false, false, 17), "html", null, true);
        echo "\"
                   name=\"";
        // line 18
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 18), "full_name", [], "any", false, false, false, 18), "html", null, true);
        echo "\"
                   value=\"";
        // line 19
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 19), "value", [], "any", false, false, false, 19), "html", null, true);
        echo "\"";
        echo ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 19), "data", [], "any", false, false, false, 19)) ? (" checked") : (""));
        echo ">
            <label for=\"";
        // line 20
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 20), "id", [], "any", false, false, false, 20), "html", null, true);
        echo "\"></label>
        </div>
        <div class=\"c-toggleSwitch__label\">
            <span class=\"";
        // line 23
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 23), "id", [], "any", false, false, false, 23), "html", null, true);
        echo "-on text-dark ";
        echo ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 23), "data", [], "any", false, false, false, 23)) ? ("") : ("d-none"));
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 23), "label_on", [], "any", false, false, false, 23)), "html", null, true);
        echo "</span>
            <span class=\"";
        // line 24
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 24), "id", [], "any", false, false, false, 24), "html", null, true);
        echo "-off text-dark ";
        echo ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 24), "data", [], "any", false, false, false, 24)) ? ("d-none") : (""));
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 24), "label_off", [], "any", false, false, false, 24)), "html", null, true);
        echo "</span>
        </div>
        <script>
            \$('#";
        // line 27
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 27), "id", [], "any", false, false, false, 27), "html", null, true);
        echo "').on('change', function (e) {
                if (\$(this).prop('checked')) {
                    \$('.";
        // line 29
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 29), "id", [], "any", false, false, false, 29), "html", null, true);
        echo "-on').removeClass('d-none');
                    \$('.";
        // line 30
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 30), "id", [], "any", false, false, false, 30), "html", null, true);
        echo "-off').addClass('d-none');
                } else {
                    \$('.";
        // line 32
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 32), "id", [], "any", false, false, false, 32), "html", null, true);
        echo "-on').addClass('d-none');
                    \$('.";
        // line 33
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "vars", [], "any", false, false, false, 33), "id", [], "any", false, false, false, 33), "html", null, true);
        echo "-off').removeClass('d-none');
                }
            });
        </script>
    </div>";
    }

    // line 40
    public function block_choice_widget($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 41
        echo "    ";
        if ((array_key_exists("type", $context) && (($context["type"] ?? null) == "hidden"))) {
            // line 42
            echo "        ";
            $this->displayBlock("form_widget_simple", $context, $blocks);
            echo "
    ";
        } else {
            // line 44
            echo "        ";
            $this->displayParentBlock("choice_widget", $context, $blocks);
            echo "
    ";
        }
    }

    // line 48
    public function block_file_widget($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 49
        $context["attr"] = twig_array_merge(($context["attr"] ?? null), ["class" => twig_trim_filter((((twig_get_attribute($this->env, $this->source, ($context["attr"] ?? null), "class", [], "any", true, true, false, 49)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["attr"] ?? null), "class", [], "any", false, false, false, 49), "")) : ("")) . " form-control-file"))]);
        // line 50
        echo "<input type=\"file\" ";
        $this->displayBlock("widget_attributes", $context, $blocks);
        echo " ";
        if ( !twig_test_empty(($context["value"] ?? null))) {
            echo "value=\"";
            echo twig_escape_filter($this->env, ($context["value"] ?? null), "html", null, true);
            echo "\" ";
        }
        echo "/>";
    }

    public function getTemplateName()
    {
        return "@admin/Form/bootstrap_4_horizontal_layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  149 => 50,  147 => 49,  143 => 48,  135 => 44,  129 => 42,  126 => 41,  122 => 40,  113 => 33,  109 => 32,  104 => 30,  100 => 29,  95 => 27,  85 => 24,  77 => 23,  71 => 20,  65 => 19,  61 => 18,  57 => 17,  52 => 14,  48 => 13,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/Form/bootstrap_4_horizontal_layout.html.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/Form/bootstrap_4_horizontal_layout.html.twig");
    }
}
