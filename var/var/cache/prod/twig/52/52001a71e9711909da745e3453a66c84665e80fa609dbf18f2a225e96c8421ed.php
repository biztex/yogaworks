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

/* Block/logo.twig */
class __TwigTemplate_0cdd22c369bb768185f848eec6779bfa9950ef7f9b854739e955d4d4be5ff86e extends \Eccube\Twig\Template
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
        echo "<div class=\"ec-headerRole\">
    <div class=\"ec-headerRole__title\">
        <div class=\"ec-headerTitle\">
            <div class=\"ec-headerTitle__title\">
                <h1>
                    <a href=\"";
        // line 16
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("homepage");
        echo "\">
                        ";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 17), "html", null, true);
        echo "
                    </a>
                </h1>
            </div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "Block/logo.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 17,  44 => 16,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "Block/logo.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/Block/logo.twig");
    }
}
