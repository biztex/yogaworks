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

/* Block/footer.twig */
class __TwigTemplate_25c3fe13e6f0530f572bfc814c4e196f11d491e399559a17471a6f7908acb033 extends \Eccube\Twig\Template
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
        echo "<div class=\"ec-footerRole\">
    <div class=\"ec-footerRole__inner\">
        <ul class=\"ec-footerNavi\">
            <li class=\"ec-footerNavi__link\">
                <a href=\"";
        // line 15
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("help_about");
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("当サイトについて"), "html", null, true);
        echo "</a>
            </li>
            <li class=\"ec-footerNavi__link\">
                <a href=\"";
        // line 18
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("help_privacy");
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("プライバシーポリシー"), "html", null, true);
        echo "</a>
            </li>
            <li class=\"ec-footerNavi__link\">
                <a href=\"";
        // line 21
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("help_tradelaw");
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("特定商取引法に基づく表記"), "html", null, true);
        echo "</a>
            </li>
            <li class=\"ec-footerNavi__link\">
                <a href=\"";
        // line 24
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("contact");
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("お問い合わせ"), "html", null, true);
        echo "</a>
            </li>
        </ul>
        <div class=\"ec-footerTitle\">
            <div class=\"ec-footerTitle__logo\">
                <a href=\"";
        // line 29
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("homepage");
        echo "\">";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 29), "html", null, true);
        echo "</a>
            </div>
            <div class=\"ec-footerTitle__copyright\">copyright (c) ";
        // line 31
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 31), "html", null, true);
        echo " all rights reserved.</div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "Block/footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 31,  77 => 29,  67 => 24,  59 => 21,  51 => 18,  43 => 15,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "Block/footer.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/Block/footer.twig");
    }
}
