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

/* default_frame.twig */
class __TwigTemplate_2c00713e114074a4416a2c2729408de6e6000cf1c0ef27da45ac8fbd4535b4de extends \Eccube\Twig\Template
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
<head prefix=\"og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#\">
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <meta name=\"eccube-csrf-token\" content=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken(twig_constant("Eccube\\Common\\Constant::TOKEN_NAME")), "html", null, true);
        echo "\">
    <title>";
        // line 17
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "shop_name", [], "any", false, false, false, 17), "html", null, true);
        if ((array_key_exists("subtitle", $context) &&  !twig_test_empty(($context["subtitle"] ?? null)))) {
            echo " / ";
            echo twig_escape_filter($this->env, ($context["subtitle"] ?? null), "html", null, true);
        } elseif ((array_key_exists("title", $context) &&  !twig_test_empty(($context["title"] ?? null)))) {
            echo " / ";
            echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        }
        echo "</title>
    ";
        // line 18
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "meta_tags", [], "any", false, false, false, 18))) {
            // line 19
            echo "        ";
            echo twig_include($this->env, $context, twig_template_from_string($this->env, twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "meta_tags", [], "any", false, false, false, 19)));
            echo "
        ";
            // line 20
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "description", [], "any", false, false, false, 20))) {
                // line 21
                echo "            <meta name=\"description\" content=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "description", [], "any", false, false, false, 21), "html", null, true);
                echo "\">
        ";
            }
            // line 23
            echo "    ";
        } else {
            // line 24
            echo "        ";
            echo twig_include($this->env, $context, "meta.twig");
            echo "
    ";
        }
        // line 26
        echo "    ";
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "author", [], "any", false, false, false, 26))) {
            // line 27
            echo "        <meta name=\"author\" content=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "author", [], "any", false, false, false, 27), "html", null, true);
            echo "\">
    ";
        }
        // line 29
        echo "    ";
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "keyword", [], "any", false, false, false, 29))) {
            // line 30
            echo "        <meta name=\"keywords\" content=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "keyword", [], "any", false, false, false, 30), "html", null, true);
            echo "\">
    ";
        }
        // line 32
        echo "    ";
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "meta_robots", [], "any", false, false, false, 32))) {
            // line 33
            echo "        <meta name=\"robots\" content=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Page"] ?? null), "meta_robots", [], "any", false, false, false, 33), "html", null, true);
            echo "\">
    ";
        }
        // line 35
        echo "    <link rel=\"icon\" href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/img/common/favicon.ico", "user_data"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css\" integrity=\"sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu\" crossorigin=\"anonymous\">
    <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.3.1/css/all.css\" integrity=\"sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU\" crossorigin=\"anonymous\">
    <link rel=\"stylesheet\" href=\"//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css\">
    <link rel=\"stylesheet\" href=\"";
        // line 39
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/css/style.css"), "html", null, true);
        echo "\">
    ";
        // line 40
        $this->displayBlock('stylesheet', $context, $blocks);
        // line 41
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
        // line 52
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "Head", [], "any", false, false, false, 52)) {
            // line 53
            echo "        ";
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "Head", [], "any", false, false, false, 53)]);
            echo "
    ";
        }
        // line 55
        echo "    ";
        // line 56
        echo "    ";
        if (array_key_exists("plugin_assets", $context)) {
            echo twig_include($this->env, $context, "@admin/snippet.twig", ["snippets" => ($context["plugin_assets"] ?? null)]);
        }
        // line 57
        echo "    <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/css/customize.css", "user_data"), "html", null, true);
        echo "\">
</head>
<body id=\"page_";
        // line 59
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 59), "get", [0 => "_route"], "method", false, false, false, 59), "html", null, true);
        echo "\" class=\"";
        echo twig_escape_filter($this->env, ((array_key_exists("body_class", $context)) ? (_twig_default_filter(($context["body_class"] ?? null), "other_page")) : ("other_page")), "html", null, true);
        echo "\">
";
        // line 61
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "BodyAfter", [], "any", false, false, false, 61)) {
            // line 62
            echo "    ";
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "BodyAfter", [], "any", false, false, false, 62)]);
            echo "
";
        }
        // line 64
        echo "
<div class=\"ec-layoutRole\">
    ";
        // line 67
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "Header", [], "any", false, false, false, 67)) {
            // line 68
            echo "        <div class=\"ec-layoutRole__header\">
            ";
            // line 69
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "Header", [], "any", false, false, false, 69)]);
            echo "
        </div>
    ";
        }
        // line 72
        echo "
    ";
        // line 74
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "ContentsTop", [], "any", false, false, false, 74)) {
            // line 75
            echo "        <div class=\"ec-layoutRole__contentTop\">
            ";
            // line 76
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "ContentsTop", [], "any", false, false, false, 76)]);
            echo "
        </div>
    ";
        }
        // line 79
        echo "
    <div class=\"ec-layoutRole__contents\">
        ";
        // line 82
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "SideLeft", [], "any", false, false, false, 82)) {
            // line 83
            echo "            <div class=\"ec-layoutRole__left\">
                ";
            // line 84
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "SideLeft", [], "any", false, false, false, 84)]);
            echo "
            </div>
        ";
        }
        // line 87
        echo "
        ";
        // line 88
        $context["layoutRoleMain"] = "ec-layoutRole__main";
        // line 89
        echo "        ";
        if ((twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "ColumnNum", [], "any", false, false, false, 89) == 2)) {
            // line 90
            echo "            ";
            $context["layoutRoleMain"] = "ec-layoutRole__mainWithColumn";
            // line 91
            echo "        ";
        } elseif ((twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "ColumnNum", [], "any", false, false, false, 91) == 3)) {
            // line 92
            echo "            ";
            $context["layoutRoleMain"] = "ec-layoutRole__mainBetweenColumn";
            // line 93
            echo "        ";
        }
        // line 94
        echo "
        <div class=\"";
        // line 95
        echo twig_escape_filter($this->env, ($context["layoutRoleMain"] ?? null), "html", null, true);
        echo "\">
            ";
        // line 97
        echo "            ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "MainTop", [], "any", false, false, false, 97)) {
            // line 98
            echo "                <div class=\"ec-layoutRole__mainTop\">
                    ";
            // line 99
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "MainTop", [], "any", false, false, false, 99)]);
            echo "
                </div>
            ";
        }
        // line 102
        echo "
            ";
        // line 104
        echo "            ";
        $this->displayBlock('main', $context, $blocks);
        // line 105
        echo "
            ";
        // line 107
        echo "            ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "MainBottom", [], "any", false, false, false, 107)) {
            // line 108
            echo "                <div class=\"ec-layoutRole__mainBottom\">
                    ";
            // line 109
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "MainBottom", [], "any", false, false, false, 109)]);
            echo "
                </div>
            ";
        }
        // line 112
        echo "        </div>

        ";
        // line 115
        echo "        ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "SideRight", [], "any", false, false, false, 115)) {
            // line 116
            echo "            <div class=\"ec-layoutRole__right\">
                ";
            // line 117
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "SideRight", [], "any", false, false, false, 117)]);
            echo "
            </div>
        ";
        }
        // line 120
        echo "    </div>

    ";
        // line 123
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "ContentsBottom", [], "any", false, false, false, 123)) {
            // line 124
            echo "        <div class=\"ec-layoutRole__contentBottom\">
            ";
            // line 125
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "ContentsBottom", [], "any", false, false, false, 125)]);
            echo "
        </div>
    ";
        }
        // line 128
        echo "
    ";
        // line 130
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "Footer", [], "any", false, false, false, 130)) {
            // line 131
            echo "        <div class=\"ec-layoutRole__footer\">
            ";
            // line 132
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "Footer", [], "any", false, false, false, 132)]);
            echo "
        </div>
    ";
        }
        // line 135
        echo "</div><!-- ec-layoutRole -->

<div class=\"ec-overlayRole\"></div>
<div class=\"ec-drawerRoleClose\"><i class=\"fas fa-times\"></i></div>
<div class=\"ec-drawerRole\">
    ";
        // line 141
        echo "    ";
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "Drawer", [], "any", false, false, false, 141)) {
            // line 142
            echo "        ";
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "Drawer", [], "any", false, false, false, 142)]);
            echo "
    ";
        }
        // line 144
        echo "</div>
<div class=\"ec-blockTopBtn pagetop\">";
        // line 145
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("ページトップへ"), "html", null, true);
        echo "</div>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js\" integrity=\"sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd\" crossorigin=\"anonymous\"></script>
<script src=\"https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js\"></script>
";
        // line 148
        $this->loadTemplate("@common/lang.twig", "default_frame.twig", 148)->display($context);
        // line 149
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/function.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 150
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/eccube.js"), "html", null, true);
        echo "\"></script>
";
        // line 151
        $this->displayBlock('javascript', $context, $blocks);
        // line 153
        if (twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "CloseBodyBefore", [], "any", false, false, false, 153)) {
            // line 154
            echo "    ";
            echo twig_include($this->env, $context, "block.twig", ["Blocks" => twig_get_attribute($this->env, $this->source, ($context["Layout"] ?? null), "CloseBodyBefore", [], "any", false, false, false, 154)]);
            echo "
";
        }
        // line 157
        if (array_key_exists("plugin_snippets", $context)) {
            // line 158
            echo "    ";
            echo twig_include($this->env, $context, "snippet.twig", ["snippets" => ($context["plugin_snippets"] ?? null)]);
            echo "
";
        }
        // line 160
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/customize.js", "user_data"), "html", null, true);
        echo "\"></script>
</body>
</html>
";
    }

    // line 40
    public function block_stylesheet($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 104
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 151
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "default_frame.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  408 => 151,  402 => 104,  396 => 40,  387 => 160,  381 => 158,  379 => 157,  373 => 154,  371 => 153,  369 => 151,  365 => 150,  360 => 149,  358 => 148,  352 => 145,  349 => 144,  343 => 142,  340 => 141,  333 => 135,  327 => 132,  324 => 131,  321 => 130,  318 => 128,  312 => 125,  309 => 124,  306 => 123,  302 => 120,  296 => 117,  293 => 116,  290 => 115,  286 => 112,  280 => 109,  277 => 108,  274 => 107,  271 => 105,  268 => 104,  265 => 102,  259 => 99,  256 => 98,  253 => 97,  249 => 95,  246 => 94,  243 => 93,  240 => 92,  237 => 91,  234 => 90,  231 => 89,  229 => 88,  226 => 87,  220 => 84,  217 => 83,  214 => 82,  210 => 79,  204 => 76,  201 => 75,  198 => 74,  195 => 72,  189 => 69,  186 => 68,  183 => 67,  179 => 64,  173 => 62,  171 => 61,  165 => 59,  159 => 57,  154 => 56,  152 => 55,  146 => 53,  143 => 52,  131 => 41,  129 => 40,  125 => 39,  117 => 35,  111 => 33,  108 => 32,  102 => 30,  99 => 29,  93 => 27,  90 => 26,  84 => 24,  81 => 23,  75 => 21,  73 => 20,  68 => 19,  66 => 18,  55 => 17,  51 => 16,  43 => 12,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "default_frame.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/default_frame.twig");
    }
}
