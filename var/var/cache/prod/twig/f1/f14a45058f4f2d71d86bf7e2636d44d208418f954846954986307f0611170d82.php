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

/* @admin/pager.twig */
class __TwigTemplate_66052a92fc29613b48f5aa48ef5b44d37be89e8261f1a306465a3252579316d9 extends \Eccube\Twig\Template
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
        if ((twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "pageCount", [], "any", false, false, false, 11) > 1)) {
            // line 12
            echo "    <ul class=\"pagination\">

        <!-- 最初へ -->
        ";
            // line 15
            if ((twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "firstPageInRange", [], "any", false, false, false, 15) != 1)) {
                // line 16
                echo "            <li class=\"page-item\">
                ";
                // line 18
                echo "                <a class=\"page-link\" href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getPath(((                // line 19
($context["routes"] ?? null)) ? (($context["routes"] ?? null)) : (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 19), "attributes", [], "any", false, false, false, 19), "get", [0 => "_route"], "method", false, false, false, 19))), twig_array_merge(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,                 // line 20
($context["app"] ?? null), "request", [], "any", false, false, false, 20), "query", [], "any", false, false, false, 20), "all", [], "any", false, false, false, 20), ["page_no" => twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "first", [], "any", false, false, false, 20)])), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.first"), "html", null, true);
                echo "</a></li>

        ";
            }
            // line 23
            echo "
        <!-- 前へ -->
        ";
            // line 25
            if (twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "previous", [], "any", true, true, false, 25)) {
                // line 26
                echo "            <li class=\"page-item\">
                ";
                // line 28
                echo "                <a class=\"page-link\"
                   href=\"";
                // line 29
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getPath(((($context["routes"] ?? null)) ? (($context["routes"] ?? null)) : (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 29), "attributes", [], "any", false, false, false, 29), "get", [0 => "_route"], "method", false, false, false, 29))), twig_array_merge(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 29), "query", [], "any", false, false, false, 29), "all", [], "any", false, false, false, 29), ["page_no" => twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "previous", [], "any", false, false, false, 29)])), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.prev"), "html", null, true);
                echo "</a>
            </li>
        ";
            }
            // line 32
            echo "
        <!-- 1ページリンクが表示されない場合、「...」を表示 -->
        ";
            // line 34
            if ((twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "firstPageInRange", [], "any", false, false, false, 34) != 1)) {
                // line 35
                echo "            <li class=\"page-item\">...</li>
        ";
            }
            // line 37
            echo "
        ";
            // line 38
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "pagesInRange", [], "any", false, false, false, 38));
            foreach ($context['_seq'] as $context["_key"] => $context["page"]) {
                // line 39
                echo "            <li class=\"page-item";
                if (($context["page"] == twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "current", [], "any", false, false, false, 39))) {
                    echo " active";
                }
                echo "\">
                ";
                // line 41
                echo "                <a class=\"page-link\"
                   href=\"";
                // line 42
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getPath(((($context["routes"] ?? null)) ? (($context["routes"] ?? null)) : (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 42), "attributes", [], "any", false, false, false, 42), "get", [0 => "_route"], "method", false, false, false, 42))), twig_array_merge(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 42), "query", [], "any", false, false, false, 42), "all", [], "any", false, false, false, 42), ["page_no" => $context["page"]])), "html", null, true);
                echo "\">
                    ";
                // line 43
                echo twig_escape_filter($this->env, $context["page"], "html", null, true);
                echo "
                </a>
            </li>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['page'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 47
            echo "
        <!-- 最終ページリンクが表示されない場合、「...」を表示 -->
        ";
            // line 49
            if ((twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "last", [], "any", false, false, false, 49) != twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "lastPageInRange", [], "any", false, false, false, 49))) {
                // line 50
                echo "            <li class=\"page-item\">...</li>
        ";
            }
            // line 52
            echo "
        <!-- 次へ -->
        ";
            // line 54
            if (twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "next", [], "any", true, true, false, 54)) {
                // line 55
                echo "            <li class=\"page-item\">
                ";
                // line 57
                echo "                <a class=\"page-link\"
                   href=\"";
                // line 58
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getPath(((($context["routes"] ?? null)) ? (($context["routes"] ?? null)) : (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 58), "attributes", [], "any", false, false, false, 58), "get", [0 => "_route"], "method", false, false, false, 58))), twig_array_merge(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 58), "query", [], "any", false, false, false, 58), "all", [], "any", false, false, false, 58), ["page_no" => twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "next", [], "any", false, false, false, 58)])), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.next"), "html", null, true);
                echo "</a>
            </li>
        ";
            }
            // line 61
            echo "
        <!-- 最後へ -->
        ";
            // line 63
            if ((twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "last", [], "any", false, false, false, 63) != twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "lastPageInRange", [], "any", false, false, false, 63))) {
                // line 64
                echo "            <li class=\"page-item\">
                ";
                // line 66
                echo "                <a class=\"page-link\" href=\"";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getPath(((                // line 67
($context["routes"] ?? null)) ? (($context["routes"] ?? null)) : (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 67), "attributes", [], "any", false, false, false, 67), "get", [0 => "_route"], "method", false, false, false, 67))), twig_array_merge(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,                 // line 68
($context["app"] ?? null), "request", [], "any", false, false, false, 68), "query", [], "any", false, false, false, 68), "all", [], "any", false, false, false, 68), ["page_no" => twig_get_attribute($this->env, $this->source, ($context["pages"] ?? null), "last", [], "any", false, false, false, 68)])), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.last"), "html", null, true);
                echo "</a></li>
        ";
            }
            // line 70
            echo "
    </ul>
";
        }
    }

    public function getTemplateName()
    {
        return "@admin/pager.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  170 => 70,  163 => 68,  162 => 67,  160 => 66,  157 => 64,  155 => 63,  151 => 61,  143 => 58,  140 => 57,  137 => 55,  135 => 54,  131 => 52,  127 => 50,  125 => 49,  121 => 47,  111 => 43,  107 => 42,  104 => 41,  97 => 39,  93 => 38,  90 => 37,  86 => 35,  84 => 34,  80 => 32,  72 => 29,  69 => 28,  66 => 26,  64 => 25,  60 => 23,  52 => 20,  51 => 19,  49 => 18,  46 => 16,  44 => 15,  39 => 12,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/pager.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/pager.twig");
    }
}
