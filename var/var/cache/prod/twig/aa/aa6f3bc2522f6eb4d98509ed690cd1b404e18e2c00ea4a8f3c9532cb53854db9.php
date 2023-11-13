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

/* @admin/Product/category.twig */
class __TwigTemplate_de0df9203d21702308a68064a64ce035d6656989bcc3898e644022442c4fbd8d extends \Eccube\Twig\Template
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
            'stylesheet' => [$this, 'block_stylesheet'],
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
        $context["menus"] = [0 => "product", 1 => "class_category"];
        // line 18
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["form"] ?? null), [0 => "@admin/Form/bootstrap_4_horizontal_layout.html.twig"], true);
        // line 11
        $this->parent = $this->loadTemplate("@admin/default_frame.twig", "@admin/Product/category.twig", 11);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 15
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.category_management"), "html", null, true);
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
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/jquery.ui/jquery.ui.core.min.js", "admin"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/jquery.ui/jquery.ui.widget.min.js", "admin"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/jquery.ui/jquery.ui.mouse.min.js", "admin"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/jquery.ui/jquery.ui.sortable.min.js", "admin"), "html", null, true);
        echo "\"></script>
    <script>
        \$(function() {
            // 初期表示時のsort noを保持.
            var oldSortNos = [];
            \$('.sortable-item').each(function() {
                oldSortNos.push(this.dataset.sortNo);
            });
            oldSortNos.sort(function(a, b) {
                return a - b;
            }).reverse();
            // 並び替え後にsort noを更新
            var updateSortNo = function() {
                var newSortNos = {};
                var i = 0;
                \$('.sortable-item').each(function() {
                    newSortNos[this.dataset.id] = oldSortNos[i];
                    i++;
                });
                \$.ajax({
                    url: '";
        // line 44
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_sort_no_move");
        echo "',
                    type: 'POST',
                    data: newSortNos
                }).always(function() {
                    \$(\".modal-backdrop\").remove();
                });
            };
            // 最初と最後の↑↓を再描画
            var redrawDisableAllows = function() {
                var items = \$('.sortable-item');
                items.find('a.action-up').removeClass('disabled');
                items.find('a.action-down').removeClass('disabled');
                items.first().find('a.action-up').addClass('disabled');
                items.last().find('a.action-down').addClass('disabled');
            };
            // オーバレイ後, 表示順の更新を行う
            var moveSortNo = function() {
                \$('body').append(\$('<div class=\"modal-backdrop show\"></div>'));
                updateSortNo();
                redrawDisableAllows();
            };
            // Drag and Drop
            \$('.sortable-container').sortable({
                items: '> .sortable-item',
                cursor: 'move',
                update: function(e, ui) {
                    moveSortNo();
                }
            });
            // Up
            \$('.sortable-item').on('click', 'a.action-up', function(e) {
                e.preventDefault();
                var current = \$(this).parents(\"li\");
                if (current.prev().hasClass('sortable-item')) {
                    current.prev().before(current);
                    moveSortNo();
                }
            });
            // Down
            \$('.sortable-item').on('click', 'a.action-down', function(e) {
                e.preventDefault();
                var current = \$(this).parents(\"li\");
                if (current.next().hasClass('sortable-item')) {
                    current.next().after(current);
                    moveSortNo();
                }
            });

            var groupItem = \$('.list-group-item');
            groupItem.on('click', 'a.action-edit', function(e) {
                e.preventDefault();
                var current = \$(this).parents('li');
                current.find('.mode-view').addClass('d-none');
                current.find('.mode-edit').removeClass('d-none');
            });

            groupItem.on('click', 'button.action-edit-cancel', function(e) {
                e.preventDefault();
                var current = \$(this).parents('li');
                current.find('[data-origin-value]').each(function(e) {
                    \$(this).val(\$(this).attr('data-origin-value'));
                });
                current.find('.mode-view').removeClass('d-none');
                current.find('.mode-edit').addClass('d-none');
            });

            groupItem.find('.is-invalid').each(function(e) {
                e.preventDefault();
                var current = \$(this).parents(\"li\");
                current.find('.mode-view').addClass('d-none');
                current.find('.mode-edit').removeClass('d-none');
            });

            // 削除モーダルのhrefとmessageの変更
            \$('#DeleteModal').on('shown.bs.modal', function(event) {
                var target = \$(event.relatedTarget);
                // hrefの変更
                \$(this).find('[data-method=\"delete\"]').attr('href', target.data('url'));

                // messageの変更
                \$(this).find('p.modal-message').text(target.data('message'));
            });
        });
    </script>
";
    }

    // line 130
    public function block_stylesheet($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 131
        echo "    ";
        // line 132
        echo "    <style>
        .c-directoryTree ul > li > ul li:not(:last-of-type) > label:before,
        .c-directoryTree ul > li > ul li:last-of-type > label:before {
            margin-right: 1.6em;
        }
    </style>
";
    }

    // line 140
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 141
        echo "    <div class=\"c-outsideBlock\">
        <div class=\"c-outsideBlock__contents mb-2\">
            <div class=\"row\">
                <div class=\"col-6\">
                    <nav aria-label=\"breadcrumb\" role=\"navigation\">
                        <ol class=\"breadcrumb mb-2 p-0\">
                            <li class=\"breadcrumb-item\">
                                <a href=\"";
        // line 148
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category");
        echo "\">
                                    ";
        // line 149
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.category_all"), "html", null, true);
        echo "
                                </a>
                            </li>
                            ";
        // line 152
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["TargetCategory"] ?? null), "path", [], "any", false, false, false, 152));
        foreach ($context['_seq'] as $context["_key"] => $context["ParentCategory"]) {
            // line 153
            echo "                                ";
            if ( !(null === twig_get_attribute($this->env, $this->source, $context["ParentCategory"], "id", [], "any", false, false, false, 153))) {
                // line 154
                echo "                                    <li class=\"breadcrumb-item active\" aria-current=\"page\">
                                        <a href=\"";
                // line 155
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_show", ["parent_id" => twig_get_attribute($this->env, $this->source, $context["ParentCategory"], "id", [], "any", false, false, false, 155)]), "html", null, true);
                echo "\">
                                            ";
                // line 156
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["ParentCategory"], "name", [], "any", false, false, false, 156), "html", null, true);
                echo "
                                        </a>
                                    </li>
                                ";
            }
            // line 160
            echo "                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ParentCategory'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 161
        echo "                        </ol>
                    </nav>
                </div>
                <div class=\"col-6 text-right\">
                    <div class=\"btn-group\" role=\"group\">
                        <a class=\"btn btn-ec-regular\" href=\"";
        // line 166
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_export");
        echo "\">
                            <i class=\"fa fa-cloud-download mr-1 text-secondary\"></i>
                            <span>";
        // line 168
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.csv_download"), "html", null, true);
        echo "</span>
                        </a>
                        <a class=\"btn btn-ec-regular\" href=\"";
        // line 170
        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_setting_shop_csv", ["id" => twig_constant("\\Eccube\\Entity\\Master\\CsvType::CSV_TYPE_CATEGORY")]), "html", null, true);
        echo "\">
                            <i class=\"fa fa-cog mr-1 text-secondary\"></i>
                            <span>";
        // line 172
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.setting.shop.csv_setting"), "html", null, true);
        echo "</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=\"c-contentsArea__cols\">
        <div class=\"c-contentsArea__primaryCol\">
            <div id=\"ex-primaryCol\" class=\"c-primaryCol\">
                <div class=\"card rounded border-0 mb-4\">
                    <div class=\"card-body p-0\">
                        <div class=\"card rounded border-0\">
                            <ul class=\"list-group list-group-flush sortable-container\">
                                <li class=\"list-group-item\">
                                    <form role=\"form\" name=\"form1\" id=\"form1\" method=\"post\"
                                          action=\"";
        // line 188
        if (twig_get_attribute($this->env, $this->source, ($context["TargetCategory"] ?? null), "id", [], "any", false, false, false, 188)) {
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getPath("admin_product_category_edit", ["id" => twig_get_attribute($this->env, $this->source, ($context["TargetCategory"] ?? null), "id", [], "any", false, false, false, 188)]), "html", null, true);
        } elseif (($context["Parent"] ?? null)) {
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_show", ["parent_id" => twig_get_attribute($this->env, $this->source, ($context["Parent"] ?? null), "id", [], "any", false, false, false, 188)]), "html", null, true);
        } else {
            echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category");
        }
        echo "\"
                                          enctype=\"multipart/form-data\">
                                        ";
        // line 190
        if ((twig_get_attribute($this->env, $this->source, ($context["TargetCategory"] ?? null), "hierarchy", [], "any", false, false, false, 190) <= twig_get_attribute($this->env, $this->source, ($context["eccube_config"] ?? null), "eccube_category_nest_level", [], "any", false, false, false, 190))) {
            // line 191
            echo "                                            ";
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "_token", [], "any", false, false, false, 191), 'widget');
            echo "
                                            <div class=\"form-row mb-3\">
                                                <div class=\"col-auto\">
                                                    ";
            // line 194
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "name", [], "any", false, false, false, 194), 'widget');
            echo "
                                                    ";
            // line 195
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "name", [], "any", false, false, false, 195), 'errors');
            echo "
                                                </div>
                                                <div class=\"col-auto\">
                                                    <button class=\"btn btn-ec-regular\" type=\"submit\">
                                                        ";
            // line 199
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.create__new"), "html", null, true);
            echo "
                                                    </button>
                                                </div>
                                            </div>
                                            ";
            // line 204
            echo "                                            ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_array_filter($this->env, ($context["form"] ?? null), function ($__f__) use ($context, $macros) { $context["f"] = $__f__; return twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 204), "eccube_form_options", [], "any", false, false, false, 204), "auto_render", [], "any", false, false, false, 204); }));
            foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                // line 205
                echo "                                                ";
                if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 205), "eccube_form_options", [], "any", false, false, false, 205), "form_theme", [], "any", false, false, false, 205)) {
                    // line 206
                    echo "                                                    ";
                    $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme($context["f"], [0 => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 206), "eccube_form_options", [], "any", false, false, false, 206), "form_theme", [], "any", false, false, false, 206)], true);
                    // line 207
                    echo "                                                    ";
                    echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($context["f"], 'row');
                    echo "
                                                ";
                } else {
                    // line 209
                    echo "                                                    <div class=\"form-row mb-3\">
                                                        <div class=\"col-3\">
                                                            <span>";
                    // line 211
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 211), "label", [], "any", false, false, false, 211)), "html", null, true);
                    echo "</span>
                                                        </div>
                                                        <div class=\"col\">
                                                            ";
                    // line 214
                    echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($context["f"], 'widget');
                    echo "
                                                            ";
                    // line 215
                    echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($context["f"], 'errors');
                    echo "
                                                        </div>
                                                    </div>
                                                ";
                }
                // line 219
                echo "                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 220
            echo "                                        ";
        }
        // line 221
        echo "                                    </form>
                                </li>
                                <li class=\"list-group-item\">
                                    <div class=\"row\">
                                        <div class=\"col-auto\"><strong>&nbsp;</strong></div>
                                        <div class=\"col-auto\"><strong>";
        // line 226
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.id"), "html", null, true);
        echo "</strong></div>
                                        <div class=\"col-2\"><strong>";
        // line 227
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.category"), "html", null, true);
        echo "</strong></div>
                                    </div>
                                </li>
                                ";
        // line 230
        if ((twig_length_filter($this->env, ($context["Categories"] ?? null)) > 0)) {
            // line 231
            echo "                                    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["Categories"] ?? null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["Category"]) {
                // line 232
                echo "                                        <li id=\"ex-category-";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 232), "html", null, true);
                echo "\" class=\"list-group-item sortable-item\" data-id=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 232), "html", null, true);
                echo "\" data-sort-no=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Category"], "sort_no", [], "any", false, false, false, 232), "html", null, true);
                echo "\">
                                            ";
                // line 233
                if ((twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 233) != twig_get_attribute($this->env, $this->source, ($context["TargetCategory"] ?? null), "id", [], "any", false, false, false, 233))) {
                    // line 234
                    echo "                                                <div class=\"row justify-content-around mode-view\">
                                                    <div class=\"col-auto d-flex align-items-center\"><i class=\"fa fa-bars text-ec-gray\"></i></div>
                                                    <div class=\"col-auto d-flex align-items-center\">";
                    // line 236
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 236), "html", null, true);
                    echo "</div>
                                                    <div class=\"col d-flex align-items-center\">
                                                        <a href=\"";
                    // line 238
                    echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_show", ["parent_id" => twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 238)]), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Category"], "name", [], "any", false, false, false, 238), "html", null, true);
                    echo "</a>
                                                    </div>
                                                    <div class=\"col-auto text-right\">
                                                        <a class=\"btn btn-ec-actionIcon action-up mr-2 ";
                    // line 241
                    if (twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 241)) {
                        echo " disabled ";
                    }
                    echo "\" href=\"\"
                                                           data-tooltip=\"true\" data-placement=\"top\"
                                                           title=\"";
                    // line 243
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.up"), "html", null, true);
                    echo "\">
                                                            <i class=\"fa fa-arrow-up fa-lg text-secondary\"></i>
                                                        </a>
                                                        <a class=\"btn btn-ec-actionIcon action-down mr-2 ";
                    // line 246
                    if (twig_get_attribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 246)) {
                        echo " disabled ";
                    }
                    echo "\" href=\"\"
                                                           data-tooltip=\"true\" data-placement=\"top\"
                                                           title=\"";
                    // line 248
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.down"), "html", null, true);
                    echo "\">
                                                            <i class=\"fa fa-arrow-down fa-lg text-secondary\"></i>
                                                        </a>
                                                        <a class=\"btn btn-ec-actionIcon mr-2 action-edit\"
                                                           href=\"";
                    // line 252
                    echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_edit", ["id" => twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 252)]), "html", null, true);
                    echo "\"
                                                           data-tooltip=\"true\" data-placement=\"top\"
                                                           title=\"";
                    // line 254
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.edit"), "html", null, true);
                    echo "\">
                                                            <i class=\"fa fa-pencil fa-lg text-secondary\"></i>
                                                        </a>
                                                        <div class=\"d-inline-block mr-2\" data-tooltip=\"true\" data-placement=\"top\"
                                                             title=\"";
                    // line 258
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.delete"), "html", null, true);
                    echo "\">
                                                            <a class=\"btn btn-ec-actionIcon";
                    // line 259
                    if (((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Category"], "Children", [], "any", false, false, false, 259)) > 0) || twig_get_attribute($this->env, $this->source, $context["Category"], "hasProductCategories", [], "any", false, false, false, 259))) {
                        echo " disabled";
                    }
                    echo "\"
                                                               data-toggle=\"modal\" data-target=\"#DeleteModal\"
                                                               data-url=\"";
                    // line 261
                    echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_delete", ["id" => twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 261)]), "html", null, true);
                    echo "\"
                                                               data-message=\"";
                    // line 262
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.delete_modal__message", ["%name%" => twig_get_attribute($this->env, $this->source, $context["Category"], "name", [], "any", false, false, false, 262)]), "html", null, true);
                    echo "\">
                                                                <i class=\"fa fa-close fa-lg text-secondary\"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form class=\"form-row d-none mode-edit\" method=\"POST\" action=\"";
                    // line 268
                    (((($context["Parent"] ?? null) && twig_get_attribute($this->env, $this->source, ($context["Parent"] ?? null), "id", [], "any", false, false, false, 268))) ? (print (twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_show", ["parent_id" => twig_get_attribute($this->env, $this->source, ($context["Parent"] ?? null), "id", [], "any", false, false, false, 268)]), "html", null, true))) : (print ($this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category"))));
                    echo "\" enctype=\"multipart/form-data\">
                                                    ";
                    // line 269
                    echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 = ($context["forms"] ?? null)) && is_array($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4) || $__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4 instanceof ArrayAccess ? ($__internal_f607aeef2c31a95a7bf963452dff024ffaeb6aafbe4603f9ca3bec57be8633f4[twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 269)] ?? null) : null), "_token", [], "any", false, false, false, 269), 'widget');
                    echo "
                                                    <div class=\"col-auto align-items-center\">
                                                        ";
                    // line 271
                    echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 = ($context["forms"] ?? null)) && is_array($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144) || $__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144 instanceof ArrayAccess ? ($__internal_62824350bc4502ee19dbc2e99fc6bdd3bd90e7d8dd6e72f42c35efd048542144[twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 271)] ?? null) : null), "name", [], "any", false, false, false, 271), 'widget', ["attr" => ["data-origin-value" => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (($__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b = ($context["forms"] ?? null)) && is_array($__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b) || $__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b instanceof ArrayAccess ? ($__internal_1cfccaec8dd2e8578ccb026fbe7f2e7e29ac2ed5deb976639c5fc99a6ea8583b[twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 271)] ?? null) : null), "name", [], "any", false, false, false, 271), "vars", [], "any", false, false, false, 271), "value", [], "any", false, false, false, 271)]]);
                    echo "
                                                        ";
                    // line 272
                    echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, (($__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002 = ($context["forms"] ?? null)) && is_array($__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002) || $__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002 instanceof ArrayAccess ? ($__internal_68aa442c1d43d3410ea8f958ba9090f3eaa9a76f8de8fc9be4d6c7389ba28002[twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 272)] ?? null) : null), "name", [], "any", false, false, false, 272), 'errors');
                    echo "
                                                    </div>
                                                    <div class=\"col-auto align-items-center\">
                                                        <button class=\"btn btn-ec-conversion\" type=\"submit\">";
                    // line 275
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.decision"), "html", null, true);
                    echo "</button>
                                                    </div>
                                                    <div class=\"col-auto align-items-center\">
                                                        <button class=\"btn btn-ec-sub action-edit-cancel\" type=\"button\">";
                    // line 278
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.cancel"), "html", null, true);
                    echo "</button>
                                                    </div>
                                                    ";
                    // line 281
                    echo "                                                    ";
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_array_filter($this->env, (($__internal_d7fc55f1a54b629533d60b43063289db62e68921ee7a5f8de562bd9d4a2b7ad4 = ($context["forms"] ?? null)) && is_array($__internal_d7fc55f1a54b629533d60b43063289db62e68921ee7a5f8de562bd9d4a2b7ad4) || $__internal_d7fc55f1a54b629533d60b43063289db62e68921ee7a5f8de562bd9d4a2b7ad4 instanceof ArrayAccess ? ($__internal_d7fc55f1a54b629533d60b43063289db62e68921ee7a5f8de562bd9d4a2b7ad4[twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 281)] ?? null) : null), function ($__f__) use ($context, $macros) { $context["f"] = $__f__; return twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 281), "eccube_form_options", [], "any", false, false, false, 281), "auto_render", [], "any", false, false, false, 281); }));
                    foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
                        // line 282
                        echo "                                                    <div class=\"col-auto align-items-center\" style=\"width:90%; padding-top: 10px;\">
                                                        <div class=\"row\">
                                                            <div class=\"col-3\">
                                                                <span>";
                        // line 285
                        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 285), "label", [], "any", false, false, false, 285)), "html", null, true);
                        echo "</span>
                                                            </div>
                                                            <div class=\"col-9\">
                                                                ";
                        // line 288
                        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($context["f"], 'widget');
                        echo "
                                                                ";
                        // line 289
                        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($context["f"], 'errors');
                        echo "
                                                            </div>
                                                        </div>
                                                    </div>
                                                    ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 294
                    echo "                                                </form>
                                            ";
                }
                // line 296
                echo "                                        </li>
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Category'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 298
            echo "                                ";
        }
        // line 299
        echo "                            </ul>
                            <!-- 削除モーダル -->
                            <div class=\"modal fade\" id=\"DeleteModal\" tabindex=\"-1\" role=\"dialog\"
                                 aria-labelledby=\"DeleteModal\" aria-hidden=\"true\">
                                <div class=\"modal-dialog\" role=\"document\">
                                    <div class=\"modal-content\">
                                        <div class=\"modal-header\">
                                            <h5 class=\"modal-title font-weight-bold\">
                                                ";
        // line 307
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.delete_modal__title"), "html", null, true);
        echo "
                                            </h5>
                                            <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
                                                <span aria-hidden=\"true\">×</span>
                                            </button>
                                        </div>
                                        <div class=\"modal-body text-left\">
                                            <p class=\"text-left modal-message\"><!-- jsでメッセージを挿入 --></p>
                                        </div>
                                        <div class=\"modal-footer\">
                                            <button class=\"btn btn-ec-sub\" type=\"button\" data-dismiss=\"modal\">
                                                ";
        // line 318
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.cancel"), "html", null, true);
        echo "
                                            </button>
                                            <a class=\"btn btn-ec-delete\" href=\"#\" ";
        // line 320
        echo $this->extensions['Eccube\Twig\Extension\CsrfExtension']->getCsrfTokenForAnchor();
        echo "
                                               data-method=\"delete\" data-confirm=\"false\">
                                                ";
        // line 322
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.delete"), "html", null, true);
        echo "
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p>";
        // line 331
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.drag_and_drop_description"), "html", null, true);
        echo "</p>
            </div>
        </div>

        ";
        // line 357
        echo "
        <div class=\"c-contentsArea__secondaryCol\">
            <div id=\"ex-secondaryCol\" class=\"c-secondaryCol\">
                <div class=\"card rounded border-0 mb-4\">
                    <div class=\"card-header\">
                        <span class=\"card-title\"><a
                                    href=\"";
        // line 363
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category");
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.category_all"), "html", null, true);
        echo "</a></span>
                    </div>
                    <div class=\"card-body\">
                        <div class=\"c-directoryTree mb-3\">
                            ";
        // line 367
        $macros["renderMacro"] = $this;
        // line 368
        echo "                            ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["TopCategories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["TopCategory"]) {
            // line 369
            echo "                                <ul class=\"list-unstyled\">
                                    ";
            // line 370
            echo twig_call_macro($macros["renderMacro"], "macro_tree", [$context["TopCategory"], ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["TargetCategory"] ?? null), "Parent", [], "any", false, true, false, 370), "id", [], "any", true, true, false, 370)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["TargetCategory"] ?? null), "Parent", [], "any", false, true, false, 370), "id", [], "any", false, false, false, 370), null)) : (null)), 0, ($context["Ids"] ?? null)], 370, $context, $this->getSourceContext());
            echo "
                                </ul>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['TopCategory'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 373
        echo "                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
";
    }

    // line 335
    public function macro_tree($__Category__ = null, $__TargetId__ = null, $__level__ = null, $__Ids__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "Category" => $__Category__,
            "TargetId" => $__TargetId__,
            "level" => $__level__,
            "Ids" => $__Ids__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start(function () { return ''; });
        try {
            // line 336
            echo "            ";
            $macros["selfMacro"] = $this;
            // line 337
            echo "            ";
            $context["level"] = (($context["level"] ?? null) + 1);
            // line 338
            echo "            <li>
                <label ";
            // line 339
            if (((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "children", [], "any", false, false, false, 339)) > 0) && !twig_in_filter(twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 339), ($context["Ids"] ?? null)))) {
                echo "class=\"collapsed\"
                       ";
            }
            // line 340
            echo "data-toggle=\"collapse\"
                       href=\"#directory_category";
            // line 341
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 341), "html", null, true);
            echo "\"
                       aria-expanded=\"";
            // line 342
            if (twig_in_filter(twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 342), ($context["Ids"] ?? null))) {
                echo "true";
            }
            echo "\"
                       aria-controls=\"directory_category";
            // line 343
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 343), "html", null, true);
            echo "\"></label>
                <span>
                    <a href=\"";
            // line 345
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_category_show", ["parent_id" => twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 345)]), "html", null, true);
            echo "\"";
            if ((twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 345) == ($context["TargetId"] ?? null))) {
                echo " class=\"font-weight-bold\"";
            }
            echo ">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "name", [], "any", false, false, false, 345), "html", null, true);
            echo "
                        (";
            // line 346
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "children", [], "any", false, false, false, 346)), "html", null, true);
            echo ")</a></span>
                ";
            // line 347
            if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "children", [], "any", false, false, false, 347)) > 0)) {
                // line 348
                echo "                    <ul class=\"collapse list-unstyled ";
                if (twig_in_filter(twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 348), ($context["Ids"] ?? null))) {
                    echo "show";
                }
                echo "\"
                        id=\"directory_category";
                // line 349
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "id", [], "any", false, false, false, 349), "html", null, true);
                echo "\">
                        ";
                // line 350
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["Category"] ?? null), "children", [], "any", false, false, false, 350));
                foreach ($context['_seq'] as $context["_key"] => $context["ChildCategory"]) {
                    // line 351
                    echo "                            ";
                    echo twig_call_macro($macros["selfMacro"], "macro_tree", [$context["ChildCategory"], ($context["TargetId"] ?? null), ($context["level"] ?? null), ($context["Ids"] ?? null)], 351, $context, $this->getSourceContext());
                    echo "
                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ChildCategory'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 353
                echo "                    </ul>
                ";
            }
            // line 355
            echo "            </li>
        ";

            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "@admin/Product/category.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  792 => 355,  788 => 353,  779 => 351,  775 => 350,  771 => 349,  764 => 348,  762 => 347,  758 => 346,  748 => 345,  743 => 343,  737 => 342,  733 => 341,  730 => 340,  725 => 339,  722 => 338,  719 => 337,  716 => 336,  700 => 335,  690 => 373,  681 => 370,  678 => 369,  673 => 368,  671 => 367,  662 => 363,  654 => 357,  647 => 331,  635 => 322,  630 => 320,  625 => 318,  611 => 307,  601 => 299,  598 => 298,  583 => 296,  579 => 294,  568 => 289,  564 => 288,  558 => 285,  553 => 282,  548 => 281,  543 => 278,  537 => 275,  531 => 272,  527 => 271,  522 => 269,  518 => 268,  509 => 262,  505 => 261,  498 => 259,  494 => 258,  487 => 254,  482 => 252,  475 => 248,  468 => 246,  462 => 243,  455 => 241,  447 => 238,  442 => 236,  438 => 234,  436 => 233,  427 => 232,  409 => 231,  407 => 230,  401 => 227,  397 => 226,  390 => 221,  387 => 220,  381 => 219,  374 => 215,  370 => 214,  364 => 211,  360 => 209,  354 => 207,  351 => 206,  348 => 205,  343 => 204,  336 => 199,  329 => 195,  325 => 194,  318 => 191,  316 => 190,  305 => 188,  286 => 172,  281 => 170,  276 => 168,  271 => 166,  264 => 161,  258 => 160,  251 => 156,  247 => 155,  244 => 154,  241 => 153,  237 => 152,  231 => 149,  227 => 148,  218 => 141,  214 => 140,  204 => 132,  202 => 131,  198 => 130,  109 => 44,  86 => 24,  82 => 23,  78 => 22,  73 => 21,  69 => 20,  62 => 16,  55 => 15,  50 => 11,  48 => 18,  46 => 13,  39 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/Product/category.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/Product/category.twig");
    }
}
