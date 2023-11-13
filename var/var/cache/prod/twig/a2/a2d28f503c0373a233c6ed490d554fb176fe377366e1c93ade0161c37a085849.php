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

/* @admin/Product/csv_category.twig */
class __TwigTemplate_fcdbf82c0ef87780f2bf75cd6d827cacb69432851d62ecd6e25b84972ff6ea36 extends \Eccube\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'sub_title' => [$this, 'block_sub_title'],
            'javascript' => [$this, 'block_javascript'],
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 11
        return "@admin/default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 13
        $context["menus"] = [0 => "product", 1 => "category_csv_import"];
        // line 18
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["form"] ?? null), [0 => "@admin/Form/bootstrap_4_horizontal_layout.html.twig"], true);
        // line 11
        $this->parent = $this->loadTemplate("@admin/default_frame.twig", "@admin/Product/csv_category.twig", 11);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 15
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.category_csv_upload"), "html", null, true);
    }

    // line 16
    public function block_sub_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.product_management"), "html", null, true);
    }

    // line 20
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 21
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/spin.min.js", "admin"), "html", null, true);
        echo "\"></script>
    <script>
        \$(function() {

            var opts = {
                lines: 13,
                length: 30,
                width: 2,
                radius: 12,
                corners: 1,
                rotate: 0,
                direction: 1,
                color: '#BBB',
                speed: 1,
                trail: 67,
                shadow: true,
                hwaccel: false,
                className: 'spinner',
                zIndex: 2e9,
                top: top
            };

            ImageSpinner = new Spinner(opts).spin(document.getElementById('spinner'));
            ImageSpinner.stop();

            \$('#upload-form').submit(function() {
                \$('#upload-button').attr('disabled', 'disabled');
                \$('#download-button').attr('disabled', 'disabled');
                ImageSpinner.spin(document.getElementById('spinner'));
            });

            \$('#file-select').click(function() {
                \$('#admin_csv_import_import_file').click();
                \$('#admin_csv_import_import_file').on('change', function() {
                    var files = \$(this).prop('files');
                    if (files.length) {
                        \$('#admin_csv_import_import_file_name').text(files[0].name);
                    }
                });
            });
        });
    </script>
";
    }

    // line 64
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 65
        echo "    <div class=\"c-contentsArea__cols\">
        <div class=\"c-contentsArea__primaryCol\">
            <div class=\"c-primaryCol\">
                <div class=\"card rounded border-0 mb-4\">
                    <div class=\"card-header\">
                        <div class=\"d-inline-block\" data-tooltip=\"true\" data-placement=\"top\" title=\"";
        // line 70
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("tooltip.category.csv_upload"), "html", null, true);
        echo "\"><span>";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.csv_upload"), "html", null, true);
        echo "</span><i class=\"fa fa-question-circle fa-lg fa-lg ml-1\"></i></div>
                    </div>
                    <div id=\"ex-csv_category-upload\" class=\"card-body\">
                        <div class=\"row\">
                            <div class=\"col-2\"><span>";
        // line 74
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.csv_select"), "html", null, true);
        echo "</span></div>
                            <div class=\"col\">
                                <form id=\"upload-form\" method=\"post\" action=\"";
        // line 76
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_csv_import");
        echo "\" enctype=\"multipart/form-data\">
                                    ";
        // line 77
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "_token", [], "any", false, false, false, 77), 'widget');
        echo "
                                    <div class=\"mb-2\">
                                        <span id=\"file-select\" class=\"btn btn-ec-regular mr-2\">";
        // line 79
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.file_select"), "html", null, true);
        echo "</span>
                                        <span id=\"admin_csv_import_import_file_name\">";
        // line 80
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.file_select_empty"), "html", null, true);
        echo "</span>
                                        ";
        // line 81
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "import_file", [], "any", false, false, false, 81), 'widget', ["attr" => ["accept" => "text/csv,text/tsv", "class" => "d-none"]]);
        echo "
                                        ";
        // line 82
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "import_file", [], "any", false, false, false, 82), 'errors');
        echo "
                                    </div>
                                    <button class=\"btn btn-ec-conversion\" id=\"upload-button\" type=\"submit\">";
        // line 84
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.bulk_registration"), "html", null, true);
        echo "</button>
                                    ";
        // line 85
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
            // line 86
            echo "                                        <div class=\"text-danger\">";
            echo twig_escape_filter($this->env, $context["error"], "html", null, true);
            echo "</div>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 88
        echo "                                </form>
                            </div>
                        </div>
                        <div id=\"spinner\"></div>
                    </div>
                </div>
                <div class=\"card rounded border-0 mb-4\">
                    <div class=\"card-header\">
                        <div class=\"row justify-content-between\">
                            <div class=\"col-6\">
                                <div class=\"d-inline-block\" data-tooltip=\"true\" data-placement=\"top\" title=\"";
        // line 98
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("tooltip.category.csv_format"), "html", null, true);
        echo "\"><span class=\"align-middle\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.csv_format"), "html", null, true);
        echo "</span><i class=\"fa fa-question-circle fa-lg fa-lg ml-1\"></i></div>
                            </div>
                            <div class=\"col-4 text-right\">
                                <a href=\"";
        // line 101
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_csv_template", ["type" => "category"]);
        echo "\" class=\"btn btn-ec-regular\" id=\"download-button\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.csv_skeleton_download"), "html", null, true);
        echo "</a>
                            </div>
                        </div>
                    </div>
                    <div id=\"ex-csv_category-format\" class=\"card-body\">
                        <table class=\"table table-striped table-bordered\">
                            <tbody>
                            ";
        // line 108
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["headers"] ?? null));
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
        foreach ($context['_seq'] as $context["header"] => $context["key"]) {
            // line 109
            echo "                                <tr>
                                    <th class=\"w-25 align-middle table-ec-lightGray\" id=\"file_format_box__header--";
            // line 110
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 110), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["header"], "html", null, true);
            echo "
                                        ";
            // line 111
            if (twig_get_attribute($this->env, $this->source, $context["key"], "required", [], "any", false, false, false, 111)) {
                // line 112
                echo "                                            <span class=\"badge badge-primary ml-1\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.required"), "html", null, true);
                echo "</span>
                                        ";
            }
            // line 114
            echo "                                    </th>
                                    <td class=\"align-middle\">
                                        ";
            // line 116
            if (twig_get_attribute($this->env, $this->source, $context["key"], "description", [], "any", false, false, false, 116)) {
                // line 117
                echo "                                            ";
                echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, $context["key"], "description", [], "any", false, false, false, 117));
                echo "
                                        ";
            }
            // line 119
            echo "                                    </td>
                                </tr>
                            ";
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
        unset($context['_seq'], $context['_iterated'], $context['header'], $context['key'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 122
        echo "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "@admin/Product/csv_category.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  282 => 122,  266 => 119,  260 => 117,  258 => 116,  254 => 114,  248 => 112,  246 => 111,  240 => 110,  237 => 109,  220 => 108,  208 => 101,  200 => 98,  188 => 88,  179 => 86,  175 => 85,  171 => 84,  166 => 82,  162 => 81,  158 => 80,  154 => 79,  149 => 77,  145 => 76,  140 => 74,  131 => 70,  124 => 65,  120 => 64,  72 => 21,  68 => 20,  61 => 16,  54 => 15,  49 => 11,  47 => 18,  45 => 13,  38 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/Product/csv_category.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/Product/csv_category.twig");
    }
}
