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

/* Form/form_div_layout.twig */
class __TwigTemplate_961b9f1c80efded6a557ad9838d4d53150d6b2134e67f1cc9235369b3a758ad6 extends \Eccube\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'form_errors' => [$this, 'block_form_errors'],
            'form_label' => [$this, 'block_form_label'],
            'choice_widget' => [$this, 'block_choice_widget'],
            'textarea_widget' => [$this, 'block_textarea_widget'],
            'radio_widget' => [$this, 'block_radio_widget'],
            'checkbox_widget' => [$this, 'block_checkbox_widget'],
            'widget_attributes' => [$this, 'block_widget_attributes'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 15
        return "form_div_layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("form_div_layout.html.twig", "Form/form_div_layout.twig", 15);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 17
    public function block_form_errors($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 18
        if ((twig_length_filter($this->env, ($context["errors"] ?? null)) > 0)) {
            // line 19
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 20
                echo "<p class=\"ec-errorMessage\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, $context["error"], "message", [], "any", false, false, false, 20), [], ($context["translation_domain"] ?? null)), "html", null, true);
                echo "</p>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    // line 25
    public function block_form_label($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 26
        $this->displayParentBlock("form_label", $context, $blocks);
        // line 27
        if (($context["required"] ?? null)) {
            // line 28
            echo "<span class=\"ec-required\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("必須"), "html", null, true);
            echo "</span>";
        }
    }

    // line 32
    public function block_choice_widget($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 33
        echo "    ";
        if ((array_key_exists("type", $context) && (($context["type"] ?? null) == "hidden"))) {
            // line 34
            echo "        ";
            $this->displayBlock("form_widget_simple", $context, $blocks);
            echo "
    ";
        } else {
            // line 36
            echo "        ";
            $this->displayParentBlock("choice_widget", $context, $blocks);
            echo "
    ";
        }
    }

    // line 40
    public function block_textarea_widget($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 41
        if ((array_key_exists("type", $context) && (($context["type"] ?? null) == "hidden"))) {
            // line 42
            echo "        ";
            $this->displayBlock("form_widget_simple", $context, $blocks);
            echo "
    ";
        } else {
            // line 44
            echo "        ";
            $this->displayParentBlock("textarea_widget", $context, $blocks);
            echo "
    ";
        }
    }

    // line 48
    public function block_radio_widget($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 49
        if ((array_key_exists("type", $context) && (($context["type"] ?? null) == "hidden"))) {
            // line 50
            echo "        ";
            $this->displayBlock("form_widget_simple", $context, $blocks);
            echo "
    ";
        } else {
            // line 52
            echo "        ";
            $this->displayParentBlock("radio_widget", $context, $blocks);
            echo "
        <label for=\"";
            // line 53
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\">
            <span>";
            // line 54
            (( !(($context["label"] ?? null) === false)) ? (print (twig_escape_filter($this->env, (((($context["translation_domain"] ?? null) === false)) ? (($context["label"] ?? null)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(($context["label"] ?? null), [], ($context["translation_domain"] ?? null)))), "html", null, true))) : (print ("")));
            echo "</span>
        </label>
    ";
        }
    }

    // line 60
    public function block_checkbox_widget($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 61
        if ((array_key_exists("type", $context) && (($context["type"] ?? null) == "hidden"))) {
            // line 62
            echo "        ";
            $this->displayBlock("form_widget_simple", $context, $blocks);
            echo "
    ";
        } else {
            // line 64
            echo "        ";
            $this->displayParentBlock("checkbox_widget", $context, $blocks);
            echo "
        ";
            // line 65
            if ( !(null === ($context["label"] ?? null))) {
                // line 66
                echo "            <label for=\"";
                echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
                echo "\">
                <span>";
                // line 67
                (( !(($context["label"] ?? null) === false)) ? (print (twig_escape_filter($this->env, (((($context["translation_domain"] ?? null) === false)) ? (($context["label"] ?? null)) : ($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(($context["label"] ?? null), [], ($context["translation_domain"] ?? null)))), "html", null, true))) : (print ("")));
                echo "</span>
            </label>
        ";
            }
            // line 70
            echo "    ";
        }
    }

    // line 73
    public function block_widget_attributes($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 74
        if (($context["id"] ?? null)) {
            echo " id=\"";
            echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
            echo "\" ";
        }
        // line 75
        echo "name=\"";
        echo twig_escape_filter($this->env, ($context["full_name"] ?? null), "html", null, true);
        echo "\"";
        // line 76
        if (($context["disabled"] ?? null)) {
            echo " disabled=\"disabled\"";
        }
        // line 77
        if (($context["required"] ?? null)) {
            echo " required=\"required\"";
        }
        // line 78
        $this->displayBlock("attributes", $context, $blocks);
    }

    public function getTemplateName()
    {
        return "Form/form_div_layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  215 => 78,  211 => 77,  207 => 76,  203 => 75,  197 => 74,  193 => 73,  188 => 70,  182 => 67,  177 => 66,  175 => 65,  170 => 64,  164 => 62,  162 => 61,  158 => 60,  150 => 54,  146 => 53,  141 => 52,  135 => 50,  133 => 49,  129 => 48,  121 => 44,  115 => 42,  113 => 41,  109 => 40,  101 => 36,  95 => 34,  92 => 33,  88 => 32,  81 => 28,  79 => 27,  77 => 26,  73 => 25,  62 => 20,  58 => 19,  56 => 18,  52 => 17,  41 => 15,);
    }

    public function getSourceContext()
    {
        return new Source("", "Form/form_div_layout.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/Form/form_div_layout.twig");
    }
}
