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

/* Block/search_product.twig */
class __TwigTemplate_9cc3ed1622d7dcbfcd7fc8900b6f8667da90b22a1dd5ca6fb0808127c206d75b extends \Eccube\Twig\Template
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
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["form"] ?? null), [0 => "Form/form_div_layout.twig"], true);
        // line 12
        echo "
<div class=\"ec-headerSearch\">
    <form method=\"get\" class=\"searchform\" action=\"";
        // line 14
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getPath("product_list");
        echo "\">
        <div class=\"ec-headerSearch__category\">
            <div class=\"ec-select ec-select_search\">
                ";
        // line 17
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "category_id", [], "any", false, false, false, 17), 'widget', ["id" => null, "attr" => ["class" => "category_id"]]);
        echo "
            </div>
        </div>
        <div class=\"ec-headerSearch__keyword\">
            <div class=\"ec-input\">
                ";
        // line 22
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "name", [], "any", false, false, false, 22), 'widget', ["id" => null, "attr" => ["class" => "search-name", "placeholder" => "キーワードを入力"]]);
        echo "
                <button class=\"ec-headerSearch__keywordBtn\" type=\"submit\">
                    <div class=\"ec-icon\">
                        <img src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/icon/search-dark.svg"), "html", null, true);
        echo "\" alt=\"\">
                    </div>
                </button>
            </div>
        </div>
    </form>
</div>
";
    }

    public function getTemplateName()
    {
        return "Block/search_product.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 25,  57 => 22,  49 => 17,  43 => 14,  39 => 12,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "Block/search_product.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/Block/search_product.twig");
    }
}
