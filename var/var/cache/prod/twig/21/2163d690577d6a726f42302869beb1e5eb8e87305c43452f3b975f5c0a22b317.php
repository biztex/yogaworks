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

/* Block/nav_sp.twig */
class __TwigTemplate_0dc98b4e9e3c897958999cc16761e9fb186ca1e46bca2c5366409fc0032cd4b1 extends \Eccube\Twig\Template
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
<div class=\"ec-headerNavSP\">
    <i class=\"fas fa-bars\"></i>
</div>";
    }

    public function getTemplateName()
    {
        return "Block/nav_sp.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "Block/nav_sp.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/Block/nav_sp.twig");
    }
}
