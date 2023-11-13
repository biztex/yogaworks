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

/* @admin/search_items.twig */
class __TwigTemplate_bf1e66f2b58c22e80ed8f137c14ea2b95a45729e1a7c51f52f40fc52b0979162 extends \Eccube\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 11
        echo "<ul class=\"list-inline\">
    ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "children", [], "any", false, false, false, 12));
        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
            if (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 12), "name", [], "any", false, false, false, 12) != "_token") &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 12), "data", [], "any", false, false, false, 12)))) {
                // line 13
                echo "        <li class=\"list-inline-item\"><span class=\"font-weight-bold\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 13), "label", [], "any", false, false, false, 13)), "html", null, true);
                echo ":&nbsp;</span>";
                // line 14
                if (twig_test_iterable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 14), "data", [], "any", false, false, false, 14))) {
                    // line 15
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 15), "value", [], "any", false, false, false, 15));
                    $context['loop'] = [
                      'parent' => $context['_parent'],
                      'index0' => 0,
                      'index'  => 1,
                      'first'  => true,
                    ];
                    if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                        $length = count($context['_seq']);
                        $context['loop']['revindex0'] = $length - 1;
                        $context['loop']['revindex'] = $length;
                        $context['loop']['length'] = $length;
                        $context['loop']['last'] = 1 === $length;
                    }
                    foreach ($context['_seq'] as $context["_key"] => $context["value"]) {
                        // line 17
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 17), "choices", [], "any", false, false, false, 17));
                        foreach ($context['_seq'] as $context["_key"] => $context["choice"]) {
                            // line 18
                            if (Symfony\Bridge\Twig\Extension\twig_is_selected_choice($context["choice"], $context["value"])) {
                                // line 19
                                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, $context["choice"], "label", [], "any", false, false, false, 19)), "html", null, true);
                            }
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['choice'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 22
                        echo (( !twig_get_attribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 22)) ? (",&nbsp;") : (""));
                        ++$context['loop']['index0'];
                        ++$context['loop']['index'];
                        $context['loop']['first'] = false;
                        if (isset($context['loop']['length'])) {
                            --$context['loop']['revindex0'];
                            --$context['loop']['revindex'];
                            $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                        }
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                } elseif ($this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPhpFunctions("is_a", twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,                 // line 24
$context["child"], "vars", [], "any", false, false, false, 24), "data", [], "any", false, false, false, 24), "DateTime")) {
                    // line 26
                    echo "                ";
                    if (twig_in_filter("datetime", twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 26), "id", [], "any", false, false, false, 26))) {
                        // line 27
                        echo "                    ";
                        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IntlExtension']->date_sec($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 27), "data", [], "any", false, false, false, 27)), "html", null, true);
                        echo "
                ";
                    } else {
                        // line 29
                        echo "                    ";
                        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IntlExtension']->date_day($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 29), "data", [], "any", false, false, false, 29)), "html", null, true);
                        echo "
                ";
                    }
                } else {
                    // line 33
                    if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, true, false, 33), "choices", [], "any", true, true, false, 33) &&  !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 33), "choices", [], "any", false, false, false, 33)))) {
                        // line 34
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 34), "choices", [], "any", false, false, false, 34));
                        foreach ($context['_seq'] as $context["_key"] => $context["choice"]) {
                            // line 35
                            if (Symfony\Bridge\Twig\Extension\twig_is_selected_choice($context["choice"], twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 35), "value", [], "any", false, false, false, 35))) {
                                // line 36
                                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, $context["choice"], "label", [], "any", false, false, false, 36)), "html", null, true);
                            }
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['choice'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                    } else {
                        // line 40
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["child"], "vars", [], "any", false, false, false, 40), "data", [], "any", false, false, false, 40), "html", null, true);
                    }
                }
                // line 43
                echo "</li>
    ";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 45
        echo "</ul>
";
    }

    public function getTemplateName()
    {
        return "@admin/search_items.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  141 => 45,  133 => 43,  129 => 40,  121 => 36,  119 => 35,  115 => 34,  113 => 33,  106 => 29,  100 => 27,  97 => 26,  95 => 24,  81 => 22,  74 => 19,  72 => 18,  68 => 17,  51 => 15,  49 => 14,  45 => 13,  40 => 12,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/search_items.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/search_items.twig");
    }
}
