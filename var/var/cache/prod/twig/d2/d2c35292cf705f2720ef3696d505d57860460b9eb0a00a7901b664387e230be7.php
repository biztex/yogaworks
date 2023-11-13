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

/* Block/login.twig */
class __TwigTemplate_003ba6a2d261317ccc0be867bf17a8b3e8d00eac124483ec21dfcdb340c1683a extends \Eccube\Twig\Template
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
<div class=\"ec-headerNav\">
    ";
        // line 13
        if ($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_USER")) {
            // line 14
            echo "        <div class=\"ec-headerNav__item\">
            <a href=\"";
            // line 15
            echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("mypage");
            echo "\">
                <i class=\"ec-headerNav__itemIcon fas fa-user fa-fw\"></i>
                <span class=\"ec-headerNav__itemLink\">";
            // line 17
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("マイページ"), "html", null, true);
            echo "</span>
            </a>
        </div>
        ";
            // line 20
            if (twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "option_favorite_product", [], "any", false, false, false, 20)) {
                // line 21
                echo "            <div class=\"ec-headerNav__item\">
                <a href=\"";
                // line 22
                echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("mypage_favorite");
                echo "\">
                    <i class=\"ec-headerNav__itemIcon fas fa-heart fa-fw\"></i>
                    <span class=\"ec-headerNav__itemLink\">";
                // line 24
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("お気に入り"), "html", null, true);
                echo "</span>
                </a>
            </div>
        ";
            }
            // line 28
            echo "        <div class=\"ec-headerNav__item\">
            <a href=\"";
            // line 29
            echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("logout");
            echo "\">
                <i class=\"ec-headerNav__itemIcon fas fa-lock fa-fw\"></i>
                <span class=\"ec-headerNav__itemLink\">";
            // line 31
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("ログアウト"), "html", null, true);
            echo "</span>
            </a>
        </div>
    ";
        } else {
            // line 35
            echo "        <div class=\"ec-headerNav__item\">
            <a href=\"";
            // line 36
            echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("entry");
            echo "\">
                <i class=\"ec-headerNav__itemIcon fas fa-user fa-fw\"></i>
                <span class=\"ec-headerNav__itemLink\">";
            // line 38
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("新規会員登録"), "html", null, true);
            echo "</span>
            </a>
        </div>
        ";
            // line 41
            if (twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "option_favorite_product", [], "any", false, false, false, 41)) {
                // line 42
                echo "            <div class=\"ec-headerNav__item\">
                <a href=\"";
                // line 43
                echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("mypage_favorite");
                echo "\">
                    <i class=\"ec-headerNav__itemIcon fas fa-heart fa-fw\"></i>
                    <span class=\"ec-headerNav__itemLink\">";
                // line 45
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("お気に入り"), "html", null, true);
                echo "</span>
                </a>
            </div>
        ";
            }
            // line 49
            echo "        <div class=\"ec-headerNav__item\">
            <a href=\"";
            // line 50
            echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("mypage_login");
            echo "\">
                <i class=\"ec-headerNav__itemIcon fas fa-lock fa-fw\"></i>
                <span class=\"ec-headerNav__itemLink\">";
            // line 52
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("ログイン"), "html", null, true);
            echo "</span>
            </a>
        </div>
    ";
        }
        // line 56
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "Block/login.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  135 => 56,  128 => 52,  123 => 50,  120 => 49,  113 => 45,  108 => 43,  105 => 42,  103 => 41,  97 => 38,  92 => 36,  89 => 35,  82 => 31,  77 => 29,  74 => 28,  67 => 24,  62 => 22,  59 => 21,  57 => 20,  51 => 17,  46 => 15,  43 => 14,  41 => 13,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "Block/login.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/Block/login.twig");
    }
}
