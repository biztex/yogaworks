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

/* Block/category_nav_sp.twig */
class __TwigTemplate_f4f4585c5513949f9783e3498b1cb6de35c33c9b941ea322bb15f46f1dff30c0 extends \Eccube\Twig\Template
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
        $context["Categories"] = twig_get_attribute($this->env, $this->source, call_user_func_array($this->env->getFunction('repository')->getCallable(), ["Eccube\\Entity\\Category"]), "getList", [], "method", false, false, false, 11);
        // line 12
        echo "
";
        // line 28
        echo "
";
        // line 30
        $macros["__internal_83bee557d923903ceac8c5f45bc4cf84cf71c86132a8852ea3a3616e41b77917"] = $this->macros["__internal_83bee557d923903ceac8c5f45bc4cf84cf71c86132a8852ea3a3616e41b77917"] = $this;
        // line 31
        echo "
<div class=\"ec-headerCategoryArea\">
    <div class=\"ec-headerCategoryArea__heading\">
        <p>";
        // line 34
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("カテゴリ一覧"), "html", null, true);
        echo "</p>
    </div>
    <div class=\"ec-itemNav\">
        <ul class=\"ec-itemNav__nav\">
            ";
        // line 38
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["Categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["Category"]) {
            // line 39
            echo "                <li>
                    ";
            // line 40
            echo twig_call_macro($macros["__internal_83bee557d923903ceac8c5f45bc4cf84cf71c86132a8852ea3a3616e41b77917"], "macro_tree", [$context["Category"]], 40, $context, $this->getSourceContext());
            echo "
                </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 43
        echo "        </ul>
    </div>
</div>
";
    }

    // line 13
    public function macro_tree($__Category__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "Category" => $__Category__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 14
            echo "    ";
            $macros["__internal_ec9c7adf070ee47ea6126764727565ab8d6ec9810196852ad13c4dde109b9fbd"] = $this;
            // line 15
            echo "    <a href=\"";
            echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_list");
            echo "?category_id=";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 15), "html", null, true);
            echo "\">
        ";
            // line 16
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "name", [], "any", false, false, false, 16), "html", null, true);
            echo "
    </a>
    ";
            // line 18
            if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "children", [], "any", false, false, false, 18)) > 0)) {
                // line 19
                echo "        <ul>
            ";
                // line 20
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "children", [], "any", false, false, false, 20));
                foreach ($context['_seq'] as $context["_key"] => $context["ChildCategory"]) {
                    // line 21
                    echo "                <li>
                    ";
                    // line 22
                    echo twig_call_macro($macros["__internal_ec9c7adf070ee47ea6126764727565ab8d6ec9810196852ad13c4dde109b9fbd"], "macro_tree", [$context["ChildCategory"]], 22, $context, $this->getSourceContext());
                    echo "
                </li>
            ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ChildCategory'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 25
                echo "        </ul>
    ";
            }

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "Block/category_nav_sp.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  131 => 25,  122 => 22,  119 => 21,  115 => 20,  112 => 19,  110 => 18,  105 => 16,  98 => 15,  95 => 14,  82 => 13,  75 => 43,  66 => 40,  63 => 39,  59 => 38,  52 => 34,  47 => 31,  45 => 30,  42 => 28,  39 => 12,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "Block/category_nav_sp.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/Block/category_nav_sp.twig");
    }
}
