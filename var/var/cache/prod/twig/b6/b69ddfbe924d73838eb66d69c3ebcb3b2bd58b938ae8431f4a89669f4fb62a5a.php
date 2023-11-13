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

/* @admin/Store/plugin_detail_info.twig */
class __TwigTemplate_6dba3f4a166e3d7afc873e79ff25e21b50fd5ecaef50d7b407477fa2646067d0 extends \Eccube\Twig\Template
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
        echo "
<ul class=\"plugin-ver col-12\">
    ";
        // line 13
        if ( !twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "price", [], "any", false, false, false, 13)) {
            // line 14
            echo "    <li class=\"row\"><span class=\"font-weight-bold col-7 col-sm-6 pl-0\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.detail.download"), "html", null, true);
            echo "</span>";
            echo twig_escape_filter($this->env, twig_number_format_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "downloads", [], "any", false, false, false, 14)), "html", null, true);
            echo "</li>
    ";
        }
        // line 16
        echo "    <li class=\"row\"><span class=\"font-weight-bold col-7 col-sm-6 pl-0\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.detail.version"), "html", null, true);
        echo "</span>";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "version", [], "any", false, false, false, 16), "html", null, true);
        echo "</li>
    <li class=\"row\"><span class=\"font-weight-bold col-7 col-sm-6 pl-0\">";
        // line 17
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.detail.support"), "html", null, true);
        echo "</span>";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "supported_versions", [], "any", false, false, false, 17));
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
        foreach ($context['_seq'] as $context["_key"] => $context["version"]) {
            echo twig_escape_filter($this->env, $context["version"], "html", null, true);
            if ((twig_get_attribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 17) == false)) {
                echo ", ";
            }
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['version'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo "</li>
    <li class=\"row\"><span class=\"font-weight-bold col-7 col-sm-6 pl-0\">";
        // line 18
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.detail.public_date"), "html", null, true);
        echo "</span>";
        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IntlExtension']->date_day($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "publish_date", [], "any", false, false, false, 18)), "html", null, true);
        echo "</li>
    <li class=\"row\"><span class=\"font-weight-bold col-7 col-sm-6 pl-0\">";
        // line 19
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.detail.update_date"), "html", null, true);
        echo "</span>";
        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IntlExtension']->date_day($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "update_date", [], "any", false, false, false, 19)), "html", null, true);
        echo "</li>
    <li class=\"row\"><span class=\"font-weight-bold col-7 col-sm-6 pl-0\">";
        // line 20
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.detail.license"), "html", null, true);
        echo "</span>";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "license", [], "any", false, false, false, 20), "html", null, true);
        echo "</li>
    <li class=\"row\"><span class=\"font-weight-bold col-7 col-sm-6 pl-0\">";
        // line 21
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.detail.develop"), "html", null, true);
        echo "</span>
        ";
        // line 22
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "author", [], "any", false, false, false, 22))) {
            // line 23
            echo "            ";
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "author", [], "any", false, false, false, 23), "url", [], "any", false, false, false, 23))) {
                // line 24
                echo "                <a href=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "author", [], "any", false, false, false, 24), "url", [], "any", false, false, false, 24), "html", null, true);
                echo "\" target=\"_blank\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "author", [], "any", false, false, false, 24), "name", [], "any", false, false, false, 24), "html", null, true);
                echo "</a>";
            } else {
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "author", [], "any", false, false, false, 24), "name", [], "any", false, false, false, 24), "html", null, true);
                echo "
            ";
            }
            // line 26
            echo "        ";
        }
        // line 27
        echo "    </li>
</ul>";
    }

    public function getTemplateName()
    {
        return "@admin/Store/plugin_detail_info.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  136 => 27,  133 => 26,  122 => 24,  119 => 23,  117 => 22,  113 => 21,  107 => 20,  101 => 19,  95 => 18,  58 => 17,  51 => 16,  43 => 14,  41 => 13,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/Store/plugin_detail_info.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/Store/plugin_detail_info.twig");
    }
}
