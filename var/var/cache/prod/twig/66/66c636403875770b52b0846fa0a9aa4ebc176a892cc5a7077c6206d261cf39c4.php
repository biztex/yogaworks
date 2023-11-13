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

/* @admin/default_frame.twig */
class __TwigTemplate_5b4e9cb27e0ee755170c5cfebe8620ad009d1471020619d463c8e53e1ff1a140 extends \Eccube\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'stylesheet' => [$this, 'block_stylesheet'],
            'main' => [$this, 'block_main'],
            'javascript' => [$this, 'block_javascript'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!doctype html>
";
        // line 12
        echo "<html lang=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["eccube_config"] ?? null), "locale", [], "any", false, false, false, 12), "html", null, true);
        echo "\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <meta name=\"eccube-csrf-token\" content=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(twig_constant("Eccube\\Common\\Constant::TOKEN_NAME")), "html", null, true);
        echo "\">
    <title>";
        // line 17
        $this->displayBlock("sub_title", $context, $blocks);
        echo " ";
        $this->displayBlock("title", $context, $blocks);
        echo " - ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 17), "html", null, true);
        echo "</title>
    <link rel=\"icon\" href=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/img/favicon.ico", "admin"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/css/bootstrap.css", "admin"), "html", null, true);
        echo "\">
    <link href=\"https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\" rel=\"stylesheet\" integrity=\"sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN\" crossorigin=\"anonymous\">
    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.3.1/css/all.css\">
    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.3.1/css/v4-shims.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/css/ladda-themeless.min.css", "admin"), "html", null, true);
        echo "\"></link>
    <link rel=\"stylesheet\" href=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/css/app.css", "admin"), "html", null, true);
        echo "\">
    ";
        // line 25
        $this->displayBlock('stylesheet', $context, $blocks);
        // line 26
        echo "    <script src=\"https://code.jquery.com/jquery-3.5.1.min.js\" integrity=\"sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=\" crossorigin=\"anonymous\"></script>
    <script>
        \$(function() {
            \$.ajaxSetup({
                'headers': {
                    'ECCUBE-CSRF-TOKEN': \$('meta[name=\"eccube-csrf-token\"]').attr('content')
                }
            });
        });
    </script>
    ";
        // line 37
        echo "    ";
        if (array_key_exists("plugin_assets", $context)) {
            echo twig_include($this->env, $context, "@admin/snippet.twig", ["snippets" => ($context["plugin_assets"] ?? null)]);
        }
        // line 38
        echo "</head>
<body id=\"page_";
        // line 39
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 39), "get", [0 => "_route"], "method", false, false, false, 39), "html", null, true);
        echo "\">
<header class=\"c-headerBar\">
    <div class=\"c-headerBar__container\">
        <div class=\"c-headerBar__logo\">
            <h1><img src=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/img/logo@2x.png", "admin"), "html", null, true);
        echo "\"></h1>
        </div>
        <a class=\"c-headerBar__toggleBtn\"><i class=\"fa fa-bars\" aria-hidden=\"true\"></i></a>
        <a class=\"c-headerBar__shopTitle\" href=\"";
        // line 46
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("homepage");
        echo "\" target=\"_blank\"><span>";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 46), "html", null, true);
        echo "</span><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></a>
        <a class=\"c-headerBar__userMenu\"
           data-container=\"body\"
           data-toggle=\"popover\"
           data-placement=\"bottom\"
           title=\"";
        // line 51
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.header.last_login"), "html", null, true);
        echo "\"
           data-content=\"&lt;p&gt;";
        // line 52
        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IntlExtension']->date_min($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "user", [], "any", false, false, false, 52), "login_date", [], "any", false, false, false, 52)), "html", null, true);
        echo "&lt;/p&gt;&lt;a href='";
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_change_password");
        echo "' class='btn btn-ec-regular btn-block'&gt;";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.header.change_password"), "html", null, true);
        echo "&lt;/a&gt;";
        if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "user", [], "any", false, false, false, 52), "two_factor_auth_enabled", [], "any", false, false, false, 52)) {
            echo "&lt;a href='";
            echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_setting_system_two_factor_auth_edit");
            echo "' class='btn btn-ec-regular btn-block'&gt;";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.header.two_factor_auth"), "html", null, true);
            echo "&lt;/a&gt;";
        }
        echo "&lt;a href='";
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_logout");
        echo "' class='btn btn-ec-sub btn-block'&gt;";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.header.logout"), "html", null, true);
        echo "&lt;/a&gt;\"
           data-html=\"true\"><i class=\"fa fa-user-circle\" aria-hidden=\"true\"></i><span>";
        // line 53
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.header.user_name", ["%name%" => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "user", [], "any", false, false, false, 53), "name", [], "any", false, false, false, 53)]), "html", null, true);
        echo "</span><i class=\"fa fa-angle-down\" aria-hidden=\"true\"></i></a>
    </div>
</header>
<div class=\"c-container\">
    <div class=\"c-mainNavArea\">
        ";
        // line 58
        echo twig_include($this->env, $context, "@admin/nav.twig");
        echo "
    </div>
    <div class=\"c-curtain\"></div>
    <div class=\"c-contentsArea\">
        <div class=\"c-pageTitle\">
            <div class=\"c-pageTitle__titles\">
                <h2 class=\"c-pageTitle__title\">";
        // line 64
        $this->displayBlock("title", $context, $blocks);
        echo "</h2><span class=\"c-pageTitle__subTitle\">";
        $this->displayBlock("sub_title", $context, $blocks);
        echo "</span>
            </div>
        </div>

        ";
        // line 68
        echo twig_include($this->env, $context, "@admin/alert.twig");
        echo "

        ";
        // line 70
        $this->displayBlock('main', $context, $blocks);
        // line 71
        echo "
    </div>
</div>
<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\" integrity=\"sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1\" crossorigin=\"anonymous\"></script>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\" integrity=\"sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM\" crossorigin=\"anonymous\"></script>
<script src=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/spin.min.js", "admin"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 77
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/ladda.min.js", "admin"), "html", null, true);
        echo "\"></script>
";
        // line 78
        $this->loadTemplate("@common/lang.twig", "@admin/default_frame.twig", 78)->display($context);
        // line 79
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/function.js", "admin"), "html", null, true);
        echo "\"></script>
";
        // line 80
        $this->displayBlock('javascript', $context, $blocks);
        // line 82
        if (array_key_exists("plugin_snippets", $context)) {
            // line 83
            echo "    ";
            echo twig_include($this->env, $context, "@admin/snippet.twig", ["snippets" => ($context["plugin_snippets"] ?? null)]);
            echo "
";
        }
        // line 85
        echo "</body>
</html>
";
    }

    // line 25
    public function block_stylesheet($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 70
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 80
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "@admin/default_frame.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  234 => 80,  228 => 70,  222 => 25,  216 => 85,  210 => 83,  208 => 82,  206 => 80,  201 => 79,  199 => 78,  195 => 77,  191 => 76,  184 => 71,  182 => 70,  177 => 68,  168 => 64,  159 => 58,  151 => 53,  131 => 52,  127 => 51,  117 => 46,  111 => 43,  104 => 39,  101 => 38,  96 => 37,  84 => 26,  82 => 25,  78 => 24,  74 => 23,  67 => 19,  63 => 18,  55 => 17,  51 => 16,  43 => 12,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/default_frame.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/default_frame.twig");
    }
}
