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

/* @admin/login_frame.twig */
class __TwigTemplate_2e3ba7e6aba95142b6b43579db33998895131cf1b5ebab36bf1ddc9120965aa3 extends \Eccube\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
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
        echo "<html lang=\"ja\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <title>";
        // line 16
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.login"), "html", null, true);
        echo " - ";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 16), "html", null, true);
        echo "</title>
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">
    <meta name=\"robots\" content=\"noindex,nofollow\"/>
    <link rel=\"icon\" href=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/img/favicon.ico", "admin"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/css/bootstrap.css", "admin"), "html", null, true);
        echo "\">
    <script src=\"https://code.jquery.com/jquery-3.5.1.min.js\" integrity=\"sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=\" crossorigin=\"anonymous\"></script>
</head>
<body id=\"login-page\" class=\"bg-light\">
<noscript>
    <p>";
        // line 26
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.login.enable_javascript"), "html", null, true);
        echo "</p>
</noscript>

<div class=\"c-container\">
    <div class=\"c-contentsArea\">
        ";
        // line 31
        echo twig_include($this->env, $context, "@admin/alert.twig");
        echo "

        ";
        // line 33
        $this->displayBlock('main', $context, $blocks);
        // line 34
        echo "
    </div>
</div>

<script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\" integrity=\"sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1\" crossorigin=\"anonymous\"></script>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js\" integrity=\"sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM\" crossorigin=\"anonymous\"></script>
<script src=\"";
        // line 40
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/function.js", "admin"), "html", null, true);
        echo "\"></script>
";
        // line 41
        $this->displayBlock('javascript', $context, $blocks);
        // line 42
        echo "</body>
</html>
";
    }

    // line 33
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 41
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "@admin/login_frame.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  110 => 41,  104 => 33,  98 => 42,  96 => 41,  92 => 40,  84 => 34,  82 => 33,  77 => 31,  69 => 26,  61 => 21,  57 => 20,  48 => 16,  42 => 12,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/login_frame.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/login_frame.twig");
    }
}
