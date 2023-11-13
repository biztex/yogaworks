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

/* meta.twig */
class __TwigTemplate_99a5be046dae289043017fd4ed9189e1e67ed351d2ccddfb2fcc4388ccd35416 extends \Eccube\Twig\Template
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
        // line 1
        if ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 1), "get", [0 => "_route"], "method", false, false, false, 1) == "product_detail")) {
            // line 2
            echo "    ";
            $context["meta_og_type"] = "og:product";
            // line 3
            echo "    ";
            $context["meta_description"] = _twig_default_filter(((twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_list", [], "any", true, true, false, 3)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_list", [], "any", false, false, false, 3), twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_detail", [], "any", false, false, false, 3))) : (twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_detail", [], "any", false, false, false, 3))), twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "description", [], "any", false, false, false, 3));
            // line 4
            echo "    ";
            $context["meta_canonical"] = $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_detail", ["id" => twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "id", [], "any", false, false, false, 4)]);
            // line 5
            echo "    <meta property=\"og:title\" content=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "name", [], "any", false, false, false, 5), "html", null, true);
            echo "\" />
    <meta property=\"og:image\" content=\"";
            // line 6
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\HttpFoundationExtension']->generateAbsoluteUrl($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($this->extensions['Eccube\Twig\Extension\EccubeExtension']->getNoImageProduct(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "main_list_image", [], "any", false, false, false, 6)), "save_image")), "html", null, true);
            echo "\" />
    <meta property=\"product:price:amount\" content=\"";
            // line 7
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice02IncTaxMin", [], "any", false, false, false, 7), "html", null, true);
            echo "\"/>
    <meta property=\"product:price:currency\" content=\"";
            // line 8
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["eccube_config"] ?? null), "currency", [], "any", false, false, false, 8), "html", null, true);
            echo "\"/>
    <meta property=\"product:product_link\" content=\"";
            // line 9
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_detail", ["id" => twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "id", [], "any", false, false, false, 9)]), "html", null, true);
            echo "\"/>
    <meta property=\"product:retailer_title\" content=\"";
            // line 10
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 10), "html", null, true);
            echo "\"/>
    ";
            // line 11
            if ( !twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "stock_find", [], "any", false, false, false, 11)) {
                // line 12
                echo "        <meta name=\"robots\" content=\"noindex\">
    ";
            }
        } elseif ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 14
($context["app"] ?? null), "request", [], "any", false, false, false, 14), "get", [0 => "_route"], "method", false, false, false, 14) == "product_list")) {
            // line 15
            echo "    ";
            $context["meta_canonical"] = $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_list", ["category_id" => ((twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", true, true, false, 15)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 15), null)) : (null))]);
            // line 16
            echo "    ";
            if ((twig_length_filter($this->env, ($context["pagination"] ?? null)) == 0)) {
                // line 17
                echo "        <meta name=\"robots\" content=\"noindex\">
    ";
            }
        } elseif ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 19
($context["app"] ?? null), "request", [], "any", false, false, false, 19), "get", [0 => "_route"], "method", false, false, false, 19) == "homepage")) {
            // line 20
            echo "    ";
            $context["meta_og_type"] = "website";
            // line 21
            echo "    ";
            $context["meta_canonical"] = $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("homepage");
        }
        // line 23
        echo "
<meta property=\"og:type\" content=\"";
        // line 24
        echo twig_escape_filter($this->env, ((array_key_exists("meta_og_type", $context)) ? (_twig_default_filter(($context["meta_og_type"] ?? null), "article")) : ("article")), "html", null, true);
        echo "\"/>
<meta property=\"og:site_name\" content=\"";
        // line 25
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 25), "html", null, true);
        echo "\"/>
";
        // line 26
        $context["meta_description"] = ((array_key_exists("meta_description", $context)) ? (_twig_default_filter(($context["meta_description"] ?? null), twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "description", [], "any", false, false, false, 26))) : (twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "description", [], "any", false, false, false, 26)));
        // line 27
        if (($context["meta_description"] ?? null)) {
            // line 28
            echo "    <meta name=\"description\" content=\"";
            echo twig_escape_filter($this->env, twig_slice($this->env, strip_tags(($context["meta_description"] ?? null)), 0, 120), "html", null, true);
            echo "\">
    <meta property=\"og:description\" content=\"";
            // line 29
            echo twig_escape_filter($this->env, twig_slice($this->env, strip_tags(($context["meta_description"] ?? null)), 0, 120), "html", null, true);
            echo "\"/>
";
        }
        // line 31
        if (((array_key_exists("meta_canonical", $context)) ? (_twig_default_filter(($context["meta_canonical"] ?? null))) : (""))) {
            // line 32
            echo "    <meta property=\"og:url\" content=\"";
            echo twig_escape_filter($this->env, ($context["meta_canonical"] ?? null), "html", null, true);
            echo "\"/>
    <link rel=\"canonical\" href=\"";
            // line 33
            echo twig_escape_filter($this->env, ($context["meta_canonical"] ?? null), "html", null, true);
            echo "\"/>
";
        }
    }

    public function getTemplateName()
    {
        return "meta.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  132 => 33,  127 => 32,  125 => 31,  120 => 29,  115 => 28,  113 => 27,  111 => 26,  107 => 25,  103 => 24,  100 => 23,  96 => 21,  93 => 20,  91 => 19,  87 => 17,  84 => 16,  81 => 15,  79 => 14,  75 => 12,  73 => 11,  69 => 10,  65 => 9,  61 => 8,  57 => 7,  53 => 6,  48 => 5,  45 => 4,  42 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "meta.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/meta.twig");
    }
}
