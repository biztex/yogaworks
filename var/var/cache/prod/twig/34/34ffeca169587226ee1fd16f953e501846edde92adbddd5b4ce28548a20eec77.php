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

/* @admin/Store/plugin_detail_modal.twig */
class __TwigTemplate_b7d17e292f3ef96e5bcf715eeee6335abf60063f73ae503b62a4c3773e73aa5c extends \Eccube\Twig\Template
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
        echo "<div class=\"modal fade\" id=\"searchPluginModal-";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "id", [], "any", false, false, false, 1), "html", null, true);
        echo "\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"searchPluginModal\" aria-hidden=\"true\">
    <div class=\"modal-dialog modal-lg\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title font-weight-bold\" id=\"exampleModalLabel\">";
        // line 5
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin_owners_search.modal.header"), "html", null, true);
        echo "</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>
            </div>
            <div class=\"modal-body\">
                <div class=\"row mb-5\">
                    <div class=\"col-6\">
                        <img class=\"w-100 img-responsive\"
                             src=\"";
        // line 14
        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "image", [], "any", true, true, false, 14)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "image", [], "any", false, false, false, 14), $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("noimage_plugin_list.png", "save_image"))) : ($this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("noimage_plugin_list.png", "save_image"))), "html", null, true);
        echo "\" alt=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "name", [], "any", false, false, false, 14), "html", null, true);
        echo "\">
                    </div>
                    <div class=\"col-6\">
                        <h5 class=\"font-weight-bold mb-3\">";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "name", [], "any", false, false, false, 17), "html", null, true);
        echo "</h5>
                        <p>";
        // line 18
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "short_description", [], "any", false, false, false, 18), "html", null, true);
        echo "</p>
                        <p class=\"plg-prices text-danger\"><span class=\"font-weight-bold text-dark\">";
        // line 19
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.price"), "html", null, true);
        echo " </span> ";
        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "price", [], "any", false, false, false, 19)), "html", null, true);
        echo "<small> (";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.tax_include"), "html", null, true);
        echo ")</small></p>
                    </div>
                </div>
                <div class=\"row mb-4\">
                    <div class=\"col-7\">
                        ";
        // line 24
        echo twig_include($this->env, $context, "@admin/Store/plugin_detail_info.twig");
        echo "
                    </div>
                    <div class=\"col-5 text-right\">
                        ";
        // line 27
        if (twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "contact_url", [], "any", false, false, false, 27)) {
            // line 28
            echo "                        <a class=\"btn btn-ec-regular btn-lg mb-3\" href=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "contact_url", [], "any", false, false, false, 28), "html", null, true);
            echo "\" target=\"_blank\"><i class=\"fa fa-image fa-lg text-secondary\"></i> ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin_owners_search.modal.contact"), "html", null, true);
            echo "</a>{ }}
                        ";
        }
        // line 30
        echo "                        ";
        if (twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "manual_url", [], "any", false, false, false, 30)) {
            // line 31
            echo "                        <a class=\"btn btn-ec-regular btn-lg\" href=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "manual_url", [], "any", false, false, false, 31), "html", null, true);
            echo "\" target=\"_blank\"><i class=\"fa fa-image fa-lg text-secondary\"></i> ";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin_owners_search.modal.manual"), "html", null, true);
            echo "</a>
                        ";
        }
        // line 33
        echo "                    </div>
                </div>
                <div class=\"row\">
                    <div class=\"col-12\">
                        ";
        // line 37
        $context["version_check"] = twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "version_check", [], "any", false, false, false, 37);
        // line 38
        echo "                        ";
        if ((($context["version_check"] ?? null) == 0)) {
            // line 39
            echo "                        <div class=\"alert alert-danger border border-danger\">
                                <p class=\"text-danger mb-1\">";
            // line 40
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin_owners_search.modal.note", ["%version%" => twig_constant("Eccube\\Common\\Constant::VERSION")]), "html", null, true);
            echo "</p>
                        </div>
                        ";
        }
        // line 43
        echo "                    </div>
                </div>
                <hr>
                <div class=\"row mt-4\">
                    <div class=\"col-12\">
                        ";
        // line 48
        echo twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "long_description", [], "any", false, false, false, 48);
        echo "
                    </div>
                </div>
            </div>
            <div class=\"modal-footer\">
                <form action=\"";
        // line 53
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["eccube_config"] ?? null), "eccube_owners_store_url", [], "any", false, false, false, 53), "html", null, true);
        echo "/gateway/purchase/?product_id=";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "id", [], "any", false, false, false, 53), "html", null, true);
        echo "\" method=\"post\" target=\"_blank\">
                <button type=\"button\" class=\"btn btn-ec-sub\" data-dismiss=\"modal\">";
        // line 54
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin_owners_search.modal.cancel"), "html", null, true);
        echo "</button>
                ";
        // line 55
        if ((twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "update_status", [], "any", false, false, false, 55) == 1)) {
            // line 56
            echo "                    <a href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_store_plugin_install_confirm", ["id" => twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "id", [], "any", false, false, false, 56)]), "html", null, true);
            echo "\" class=\"btn btn-primary\">
                        ";
            // line 57
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin_owners_search.install.free"), "html", null, true);
            echo "
                    </a>
                ";
        } elseif ((twig_get_attribute($this->env, $this->source,         // line 59
($context["item"] ?? null), "update_status", [], "any", false, false, false, 59) == 2)) {
            // line 60
            echo "                    <a href=\"#\" class=\"btn btn-ec-regular\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.installed"), "html", null, true);
            echo "</a>
                ";
        } elseif ((twig_get_attribute($this->env, $this->source,         // line 61
($context["item"] ?? null), "update_status", [], "any", false, false, false, 61) == 3)) {
            // line 62
            echo "                    <a href=\"";
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_store_plugin_install_confirm", ["id" => twig_get_attribute($this->env, $this->source, ($context["item"] ?? null), "id", [], "any", false, false, false, 62)]), "html", null, true);
            echo "\" class=\"btn btn-primary\">
                        ";
            // line 63
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin.update"), "html", null, true);
            echo "
                    </a>
                ";
        } elseif ((twig_get_attribute($this->env, $this->source,         // line 65
($context["item"] ?? null), "update_status", [], "any", false, false, false, 65) == 4)) {
            // line 66
            echo "                    <input type=\"hidden\" name=\"mode\" value=\"link_site\" />
                    <input type=\"hidden\" name=\"public_key\" value=\"";
            // line 67
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "authentication_key", [], "any", false, false, false, 67), "html", null, true);
            echo "\" />
                    <input type=\"submit\" class=\"btn btn-primary\" value=\"";
            // line 68
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.store.plugin_owners_search.install.fee"), "html", null, true);
            echo "\" />
                ";
        }
        // line 70
        echo "                </form>
            </div>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "@admin/Store/plugin_detail_modal.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  202 => 70,  197 => 68,  193 => 67,  190 => 66,  188 => 65,  183 => 63,  178 => 62,  176 => 61,  171 => 60,  169 => 59,  164 => 57,  159 => 56,  157 => 55,  153 => 54,  147 => 53,  139 => 48,  132 => 43,  126 => 40,  123 => 39,  120 => 38,  118 => 37,  112 => 33,  104 => 31,  101 => 30,  93 => 28,  91 => 27,  85 => 24,  73 => 19,  69 => 18,  65 => 17,  57 => 14,  45 => 5,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/Store/plugin_detail_modal.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/Store/plugin_detail_modal.twig");
    }
}
