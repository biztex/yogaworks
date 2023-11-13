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

/* @admin/Product/index.twig */
class __TwigTemplate_de9333bb60f3b12266c08b24d8d717f56a3415c713adb2fc36f1fb4b587f710e extends \Eccube\Twig\Template
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
            'stylesheet' => [$this, 'block_stylesheet'],
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
        $context["menus"] = [0 => "product", 1 => "product_master"];
        // line 18
        $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme(($context["searchForm"] ?? null), [0 => "@admin/Form/bootstrap_4_layout.html.twig"], true);
        // line 11
        $this->parent = $this->loadTemplate("@admin/default_frame.twig", "@admin/Product/index.twig", 11);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 15
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.product_list"), "html", null, true);
    }

    // line 16
    public function block_sub_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.product_management"), "html", null, true);
    }

    // line 20
    public function block_stylesheet($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 21
        echo "    <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/css/tempusdominus-bootstrap-4.min.css", "admin"), "html", null, true);
        echo "\">
    <style type=\"text/css\">
        .datepicker-days th.dow:first-child,
        .datepicker-days td:first-child {
            color: #f00;
        }

        .datepicker-days th.dow:last-child,
        .datepicker-days td:last-child {
            color: #00f;
        }
    </style>
";
    }

    // line 35
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 36
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/moment.min.js", "admin"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 37
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/moment-with-locales.min.js", "admin"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 38
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/js/vendor/tempusdominus-bootstrap-4.min.js", "admin"), "html", null, true);
        echo "\"></script>

    <script>
        \$(function() {
            // datetimepicker で value が消えてしまうので data-value に保持しておく
            \$('input.datetimepicker-input').each(function() {
                \$(this).data('value', \$(this).val());
            });

            \$('input.datetimepicker-input').datetimepicker({
                locale: '";
        // line 48
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["eccube_config"] ?? null), "locale", [], "any", false, false, false, 48), "html", null, true);
        echo "',
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: false,
                buttons: {
                    showToday: true,
                    showClose: true
                },
            });

            // datetimepicker で value が消えてしまうので更新
            \$('input.datetimepicker-input').each(function() {
                \$(this).val(\$(this).data('value'));
            });

            \$('#bulkDelete').on('click', function() {

                var modal = \$('#bulkDeleteModal');

                // 削除中のUI変更処理
                modal.find('button').attr('disabled', 'disabled');
                \$('.modal-body p', modal).text(\"";
        // line 68
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.permanently_delete__in_progress"), "html", null, true);
        echo "\");
                \$('.progress', modal).show();

                var checkedList = \$('input[type=checkbox][data-delete-url]:checked');
                var totalCount = checkedList.length;
                var currentCount = 0;

                var promises = checkedList.map(function() {
                    return \$.ajax({
                        'url': \$(this).data('delete-url'),
                        'type': 'delete',
                        'data': {'_token': \$(this).attr('token-for-anchor')}
                    }).always(function() {
                        \$('.progress-bar', modal).css('width', (++currentCount / totalCount * 100) + '%');
                    });
                });

                var addError = function(errorMessage) {
                    \$('<li><span class=\"badge badge-danger\">ERROR</span> </li>')
                        .append(\$('<span></span>').text(errorMessage))
                        .appendTo('#bulkErrors');
                };

                \$.when.apply(\$, promises)
                    .done(function() {
                        // 削除できなかった場合はエラーメッセージを表示
                        var args = promises.length === 1 ? [arguments[0]] : [].slice.call(arguments).map(function(result) {
                            return result[0];
                        });
                        args.filter(function(result) {
                            return result.success === false;
                        }).forEach(function(result) {
                            addError(result.message);
                        });
                    })
                    .fail(function() {
                        // システムエラー
                        addError(\"";
        // line 105
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.permanently_delete__system_error"), "html", null, true);
        echo "\");
                    })
                    .always(function() {
                        \$('.progress', modal).hide();
                        \$('.modal-body p', modal).text(\"";
        // line 109
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.permanently_delete__complete_message"), "html", null, true);
        echo "\");
                        modal.find('button').removeAttr('disabled').toggle();
                    })
            });

            \$('#bulkDeleteDone').on('click', function() {
                location.reload(true);
            });

            toggleBtnBulk('input[id^=\"check_\"]', '#btn_bulk');
            \$('input[id^=\"check_\"]').on('change', function() {
                \$('#trigger_check_all').prop('checked', false);
                toggleBtnBulk('input[id^=\"check_\"]', '#btn_bulk');
            });

            \$('#trigger_check_all').on('change', function() {
                var checked = \$(this).prop('checked');
                if (checked) {
                    \$('input[id^=\"check_\"]').prop('checked', true);
                } else {
                    \$('input[id^=\"check_\"]').prop('checked', false);
                }
                toggleBtnBulk('input[id^=\"check_\"]', '#btn_bulk');
            });

            \$('#form_bulk').find('.action-submit').on('click', function(event) {
                event.preventDefault();
                var form = \$(this).closest('form');
                if (!form.find('input:checkbox[name^=\"ids\"]:checked').length) {
                    ";
        // line 139
        echo "                    alert('please check');
                    return false;
                }

                \$('<input />').attr('type', 'hidden').attr('name', '";
        // line 143
        echo twig_escape_filter($this->env, twig_constant("Eccube\\Common\\Constant::TOKEN_NAME"), "html", null, true);
        echo "')
                    .val(\$(this).attr('token-for-anchor'))
                    .appendTo(form);
                form.attr('action', \$(this).data('action')).submit();
                return false;
            });

            var dataClass = [];
            var modalClass = \$('#productClassesModal');
            \$('form#form_bulk').on('click', 'table.table button[data-class-url]', function() {
                var btnClass = \$(this);
                btnClass.attr('disabled', true);
                var productId = btnClass.data('product-id');

                if (dataClass[productId] != undefined) {
                    renderClass(dataClass[productId], btnClass);
                    return;
                }

                \$.ajax({
                    url: btnClass.data('class-load'),
                    type: 'GET',
                }).done(function(data) {
                    dataClass[productId] = data;
                    renderClass(dataClass[productId], btnClass);
                }).fail(function() {
                    alert('Failed');
                });
            });

            // Append html and show popup
            function renderClass(data, btnClass) {
                \$('div.modal-body', modalClass).html(data);
                \$('h5.modal-title', modalClass).text(btnClass.data('message'));
                \$('a.btn-ec-conversion', modalClass).attr('href', btnClass.data('class-url'));
                modalClass.modal('show');
                btnClass.attr('disabled', false);
            }
        });
    </script>
";
    }

    // line 185
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 186
        echo "    <div class=\"c-outsideBlock\">
        <form id='search_form' method=\"post\" action=\"";
        // line 187
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product");
        echo "\">
            ";
        // line 188
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "_token", [], "any", false, false, false, 188), 'widget');
        echo "
            <div class=\"c-outsideBlock__contents\">
                <div class=\"row justify-content-start\">

                    <div class=\"col-6\">
                        <div class=\"mb-2\">
                            <label class=\"col-form-label\" data-tooltip=\"true\" data-placement=\"top\" title=\"";
        // line 194
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("tooltip.product.multi_search_label"), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.multi_search_label"), "html", null, true);
        echo "<i class=\"fa fa-question-circle fa-lg ml-1\"></i></label>
                            ";
        // line 195
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "id", [], "any", false, false, false, 195), 'widget');
        echo "
                            ";
        // line 196
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "id", [], "any", false, false, false, 196), 'errors');
        echo "
                        </div>
                        <div class=\"d-inline-block mb-3\" data-toggle=\"collapse\" href=\"#searchDetail\"
                             aria-expanded=\"false\" aria-controls=\"searchDetail\"><a><i
                                        class=\"fa fa-plus-square-o font-weight-bold mr-1\"></i><span
                                        class=\"font-weight-bold\">";
        // line 201
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.search_detail"), "html", null, true);
        echo "</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class=\"c-subContents collapse ec-collapse";
        // line 206
        echo ((($context["has_errors"] ?? null)) ? (" show") : (""));
        echo "\" id=\"searchDetail\">
                <div class=\"row mb-2\">
                    <div class=\"col-6\">
                        <div class=\"form-row mb-2\">
                            <div class=\"col-6\">
                                <label class=\"col-form-label\">";
        // line 211
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.category"), "html", null, true);
        echo "</label>
                                ";
        // line 212
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "category_id", [], "any", false, false, false, 212), 'widget');
        echo "
                                ";
        // line 213
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "category_id", [], "any", false, false, false, 213), 'errors');
        echo "
                            </div>
                        </div>
                        <div class=\"form-row mb-2\">
                            <div class=\"col-12\">
                                <p class=\"col-form-label\">";
        // line 218
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.display_status"), "html", null, true);
        echo "</p>
                                ";
        // line 219
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "status", [], "any", false, false, false, 219), 'widget', ["label_attr" => ["class" => "checkbox-inline"]]);
        echo "
                                ";
        // line 220
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "status", [], "any", false, false, false, 220), 'errors', ["label_attr" => ["class" => "checkbox-inline"]]);
        echo "
                            </div>
                        </div>
                        <div class=\"form-row mb-2\">
                            <div class=\"col-12\">
                                <p class=\"col-form-label\">";
        // line 225
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.stock__short"), "html", null, true);
        echo "</p>
                                ";
        // line 226
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "stock", [], "any", false, false, false, 226), 'widget', ["label_attr" => ["class" => "checkbox-inline"]]);
        echo "
                                ";
        // line 227
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "stock", [], "any", false, false, false, 227), 'errors');
        echo "
                            </div>
                        </div>
                    </div>
                    <div class=\"col-6\">
                        <div class=\"mb-2\">
                            <label class=\"col-form-label\">
                                ";
        // line 234
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.create_date"), "html", null, true);
        echo "
                            </label>
                            <div class=\"form-row align-items-center\">
                                <div class=\"col\">
                                    ";
        // line 239
        echo "                                    ";
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "create_datetime_start", [], "any", false, false, false, 239), 'widget');
        echo "
                                    ";
        // line 240
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "create_datetime_start", [], "any", false, false, false, 240), 'errors');
        echo "
                                </div>
                                <div class=\"col-auto text-center\"><span>";
        // line 242
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.separator__range"), "html", null, true);
        echo "</span>
                                </div>
                                <div class=\"col\">
                                    ";
        // line 245
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "create_datetime_end", [], "any", false, false, false, 245), 'widget');
        echo "
                                    ";
        // line 246
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "create_datetime_end", [], "any", false, false, false, 246), 'errors');
        echo "
                                </div>
                            </div>
                        </div>
                        <div class=\"mb-2\">
                            <label class=\"col-form-label\">";
        // line 251
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.update_date"), "html", null, true);
        echo "</label>
                            <div class=\"form-row align-items-center\">
                                <div class=\"col\">
                                    ";
        // line 255
        echo "                                    ";
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "update_datetime_start", [], "any", false, false, false, 255), 'widget');
        echo "
                                    ";
        // line 256
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "update_datetime_start", [], "any", false, false, false, 256), 'errors');
        echo "
                                </div>
                                <div class=\"col-auto\"><span>";
        // line 258
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.separator__range"), "html", null, true);
        echo "</span></div>
                                <div class=\"col\">
                                    ";
        // line 260
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "update_datetime_end", [], "any", false, false, false, 260), 'widget');
        echo "
                                    ";
        // line 261
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["searchForm"] ?? null), "update_datetime_end", [], "any", false, false, false, 261), 'errors');
        echo "
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
        // line 268
        echo "                ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_array_filter($this->env, ($context["searchForm"] ?? null), function ($__f__) use ($context, $macros) { $context["f"] = $__f__; return twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 268), "eccube_form_options", [], "any", false, false, false, 268), "auto_render", [], "any", false, false, false, 268); }));
        foreach ($context['_seq'] as $context["_key"] => $context["f"]) {
            // line 269
            echo "                    ";
            // line 270
            echo "                    <div class=\"row mb-2\">
                        ";
            // line 271
            if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 271), "eccube_form_options", [], "any", false, false, false, 271), "form_theme", [], "any", false, false, false, 271)) {
                // line 272
                echo "                            ";
                $this->env->getRuntime("Symfony\\Component\\Form\\FormRenderer")->setTheme($context["f"], [0 => twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 272), "eccube_form_options", [], "any", false, false, false, 272), "form_theme", [], "any", false, false, false, 272)], true);
                // line 273
                echo "                            ";
                echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($context["f"], 'row');
                echo "
                        ";
            } else {
                // line 275
                echo "                            <div class=\"col\">
                                <div class=\"mb-3\">
                                    <label>";
                // line 277
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["f"], "vars", [], "any", false, false, false, 277), "label", [], "any", false, false, false, 277)), "html", null, true);
                echo "</label>
                                    ";
                // line 278
                echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($context["f"], 'widget');
                echo "
                                    ";
                // line 279
                echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($context["f"], 'errors');
                echo "
                                </div>
                            </div>
                        ";
            }
            // line 283
            echo "                    </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['f'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 285
        echo "            </div>
            <div class=\"c-outsideBlock__contents mb-5\">
                <button class=\"btn btn-ec-conversion px-5\" type=\"submit\">";
        // line 287
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.search"), "html", null, true);
        echo "</button>
                ";
        // line 288
        if (($context["pagination"] ?? null)) {
            // line 289
            echo "                    <span class=\"font-weight-bold ml-2\">";
            echo $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.search_result", ["%count%" => twig_get_attribute($this->env, $this->source, ($context["pagination"] ?? null), "totalItemCount", [], "any", false, false, false, 289)]);
            echo "</span>
                ";
        }
        // line 291
        echo "            </div>
            <div class=\"c-outsideBlock__contents mb-5\">
                ";
        // line 293
        echo twig_include($this->env, $context, "@admin/search_items.twig", ["form" => ($context["searchForm"] ?? null)], true, true);
        echo "
            </div>
        </form>
    </div>
    <div class=\"c-contentsArea__cols\">
        <div class=\"c-contentsArea__primaryCol\">
            <div class=\"c-primaryCol\">
                ";
        // line 300
        if ((($context["pagination"] ?? null) && twig_get_attribute($this->env, $this->source, ($context["pagination"] ?? null), "totalItemCount", [], "any", false, false, false, 300))) {
            // line 301
            echo "                    <form id=\"form_bulk\" method=\"POST\" action=\"\">
                        <div class=\"row justify-content-between mb-2\">
                            <div class=\"col-6\">
                                <div id=\"btn_bulk\" class=\"d-none\">
                                    <label class=\"mr-2\">";
            // line 305
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.bulk_actions"), "html", null, true);
            echo "</label>
                                    <div class=\"btn-group mr-2\" role=\"group\">
                                        <button ";
            // line 307
            echo $this->extensions['Eccube\Twig\Extension\CsrfExtension']->getCsrfTokenForAnchor();
            echo " data-action=\"";
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_bulk_product_status", ["id" => twig_constant("Eccube\\Entity\\Master\\ProductStatus::DISPLAY_SHOW")]), "html", null, true);
            echo "\" class=\"btn btn-ec-regular action-submit\" type=\"button\">
                                            <span>";
            // line 308
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.display_status__show"), "html", null, true);
            echo "</span>
                                        </button>
                                        <button ";
            // line 310
            echo $this->extensions['Eccube\Twig\Extension\CsrfExtension']->getCsrfTokenForAnchor();
            echo " data-action=\"";
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_bulk_product_status", ["id" => twig_constant("Eccube\\Entity\\Master\\ProductStatus::DISPLAY_HIDE")]), "html", null, true);
            echo "\" class=\"btn btn-ec-regular action-submit\" type=\"button\">
                                            <span>";
            // line 311
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.display_status__hide"), "html", null, true);
            echo "</span>
                                        </button>
                                    </div>
                                    <button ";
            // line 314
            echo $this->extensions['Eccube\Twig\Extension\CsrfExtension']->getCsrfTokenForAnchor();
            echo " data-action=\"";
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_bulk_product_status", ["id" => twig_constant("Eccube\\Entity\\Master\\ProductStatus::DISPLAY_ABOLISHED")]), "html", null, true);
            echo "\" class=\"btn btn-ec-regular mr-2 action-submit\">
                                        ";
            // line 315
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.display_status__abolished"), "html", null, true);
            echo "
                                    </button>
                                    <button type=\"button\" data-toggle=\"modal\" data-target=\"#bulkDeleteModal\" class=\"btn btn-ec-delete\">";
            // line 317
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.permanently_delete"), "html", null, true);
            echo "</button>
                                </div>
                            </div>
                            <div class=\"col-5 text-right\">
                                <div class=\"d-inline-block mr-2\">
                                    <div>
                                        <select class=\"custom-select\" onchange=\"location = this.value;\">
                                            ";
            // line 324
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["pageMaxis"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["pageMax"]) {
                // line 325
                echo "                                                <option ";
                if ((twig_get_attribute($this->env, $this->source, $context["pageMax"], "name", [], "any", false, false, false, 325) == ($context["page_count"] ?? null))) {
                    echo "selected=\"\"";
                }
                echo " value=\"";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getPath("admin_product_page", ["page_no" => 1, "page_count" => twig_get_attribute($this->env, $this->source, $context["pageMax"], "name", [], "any", false, false, false, 325)]), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.count", ["%count%" => twig_get_attribute($this->env, $this->source, $context["pageMax"], "name", [], "any", false, false, false, 325)]), "html", null, true);
                echo "</option>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['pageMax'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 327
            echo "                                        </select>
                                    </div>
                                </div>
                                <div class=\"d-inline-block\">
                                    <div class=\"btn-group\" role=\"group\">
                                        <a class=\"btn btn-ec-regular\" href=\"";
            // line 332
            echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_export");
            echo "\">
                                            <i class=\"fa fa-cloud-download mr-1 text-secondary\"></i><span>";
            // line 333
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.csv_download"), "html", null, true);
            echo "</span>
                                        </a>
                                        <a class=\"btn btn-ec-regular\" href=\"";
            // line 335
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_setting_shop_csv", ["id" => twig_constant("\\Eccube\\Entity\\Master\\CsvType::CSV_TYPE_PRODUCT")]), "html", null, true);
            echo "\">
                                            <i class=\"fa fa-cog mr-1 text-secondary\"></i><span>";
            // line 336
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.setting.shop.csv_setting"), "html", null, true);
            echo "</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=\"card rounded border-0 mb-4 d-block\">
                            <div class=\"card-body p-0\">
                                <table class=\"table table-sm\">
                                    <thead>
                                    <tr>
                                        <th class=\"border-top-0 pl-3 pt-2 pb-2\">
                                            <input type=\"checkbox\" name=\"filter\" value=\"open\" id=\"trigger_check_all\">
                                        </th>
                                        <th class=\"border-top-0 pt-2 pb-2\">";
            // line 350
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.product_id__short"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2\">";
            // line 351
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.image__short"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2\">";
            // line 352
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.name"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2\">";
            // line 353
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.product_code__short"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2\">";
            // line 354
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.price"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2\">";
            // line 355
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.stock"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2 text-nowrap\">";
            // line 356
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.display_status__short"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2\">";
            // line 357
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.create_date"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2\">";
            // line 358
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.update_date"), "html", null, true);
            echo "</th>
                                        <th class=\"border-top-0 pt-2 pb-2 pr-3\" colspan=\"3\"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    ";
            // line 363
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["pagination"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["Product"]) {
                // line 364
                echo "                                        <tr id=\"ex-product-";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 364), "html", null, true);
                echo "\">
                                            <td class=\"align-middle pl-3\">
                                                <input type=\"checkbox\" name=\"ids[]\" value=\"";
                // line 366
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 366), "html", null, true);
                echo "\" id=\"check_";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 366), "html", null, true);
                echo "\" data-delete-url=\"";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_product_delete", ["id" => twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 366)]), "html", null, true);
                echo "\">
                                            </td>
                                            <td class=\"align-middle\">";
                // line 368
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 368), "html", null, true);
                echo "</td>
                                            ";
                // line 370
                echo "                                            <td class=\"align-middle\">
                                                <a href=\"";
                // line 371
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_product_edit", ["id" => twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 371)]), "html", null, true);
                echo "\">
                                                    <img src=\"";
                // line 372
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($this->extensions['Eccube\Twig\Extension\EccubeExtension']->getNoImageProduct(twig_get_attribute($this->env, $this->source, $context["Product"], "mainFileName", [], "any", false, false, false, 372)), "save_image"), "html", null, true);
                echo "\"
                                                         style=\"max-width: 50px\">
                                                </a>
                                            </td>
                                            <td class=\"align-middle\"><a
                                                        href=\"";
                // line 377
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_product_edit", ["id" => twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 377)]), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "name", [], "any", false, false, false, 377), "html", null, true);
                echo "</a>
                                            </td>
                                            <td class=\"align-middle\">
                                                ";
                // line 380
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "code_min", [], "any", false, false, false, 380), "html", null, true);
                echo "
                                                ";
                // line 381
                if ((twig_get_attribute($this->env, $this->source, $context["Product"], "code_min", [], "any", false, false, false, 381) != twig_get_attribute($this->env, $this->source, $context["Product"], "code_max", [], "any", false, false, false, 381))) {
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.separator__range"), "html", null, true);
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "code_max", [], "any", false, false, false, 381), "html", null, true);
                    echo "
                                                ";
                }
                // line 383
                echo "                                            </td>
                                            <td class=\"align-middle\">
                                                ";
                // line 385
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, $context["Product"], "price02_min", [], "any", false, false, false, 385)), "html", null, true);
                echo "
                                                ";
                // line 386
                if ((twig_get_attribute($this->env, $this->source, $context["Product"], "price02_min", [], "any", false, false, false, 386) != twig_get_attribute($this->env, $this->source, $context["Product"], "price02_max", [], "any", false, false, false, 386))) {
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.separator__range"), "html", null, true);
                    echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, $context["Product"], "price02_max", [], "any", false, false, false, 386)), "html", null, true);
                    echo "
                                                ";
                }
                // line 388
                echo "                                            </td>
                                            <td class=\"align-middle\">
                                                ";
                // line 390
                if (twig_get_attribute($this->env, $this->source, $context["Product"], "hasProductClass", [], "any", false, false, false, 390)) {
                    // line 391
                    echo "                                                    <button type=\"button\" class=\"btn page-link text-dark d-inline-block\"
                                                            data-product-id=\"";
                    // line 392
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 392), "html", null, true);
                    echo "\"
                                                            data-message=\"";
                    // line 393
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.move_to_product_class__confirm_title", ["%name%" => twig_get_attribute($this->env, $this->source, $context["Product"], "name", [], "any", false, false, false, 393)]), "html", null, true);
                    echo "\"
                                                            data-class-load=\"";
                    // line 394
                    echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_classes_load", ["id" => twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 394)]), "html", null, true);
                    echo "\"
                                                            data-class-url=\"";
                    // line 395
                    echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_product_class", ["id" => twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 395), "return_product_list" => true]), "html", null, true);
                    echo "\">
                                                        ";
                    // line 396
                    echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.product_class__confirm"), "html", null, true);
                    echo "
                                                    </button>
                                                ";
                } else {
                    // line 399
                    echo "                                                    ";
                    // line 400
                    echo "                                                    ";
                    if (twig_get_attribute($this->env, $this->source, $context["Product"], "stockunlimited_min", [], "any", false, false, false, 400)) {
                        // line 401
                        echo "                                                        ";
                        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.stock_unlimited__short"), "html", null, true);
                        echo "
                                                    ";
                    } else {
                        // line 403
                        echo "                                                        ";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "stock_min", [], "any", false, false, false, 403), "html", null, true);
                        echo "
                                                    ";
                    }
                    // line 405
                    echo "                                                ";
                }
                // line 406
                echo "                                            </td>
                                            <td class=\"align-middle\">
                                                ";
                // line 408
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["Product"], "status", [], "any", false, false, false, 408), "name", [], "any", false, false, false, 408), "html", null, true);
                echo "
                                            </td>
                                            <td class=\"align-middle\">
                                                ";
                // line 411
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IntlExtension']->date_min($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "create_date", [], "any", false, false, false, 411)), "html", null, true);
                echo "
                                            </td>
                                            <td class=\"align-middle\">
                                                ";
                // line 414
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IntlExtension']->date_min($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "update_date", [], "any", false, false, false, 414)), "html", null, true);
                echo "
                                            </td>
                                            <td class=\"align-middle pr-3\" colspan=\"3\">
                                                <div class=\"text-right\">
                                                    <div class=\"px-1 d-inline-block text-center\" data-tooltip=\"true\"
                                                         data-placement=\"top\"
                                                         title=\"";
                // line 420
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.display"), "html", null, true);
                echo "\"><a class=\"btn btn-ec-actionIcon\"
                                                                                                       href=\"";
                // line 421
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_detail", ["id" => twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 421)]), "html", null, true);
                echo "\"
                                                                                                       target=\"_blank\"><i
                                                                    class=\"fa fa-eye fa-lg text-secondary\"
                                                                    aria-hidden=\"true\"></i></a></div>
                                                    <div class=\"px-1 d-inline-block text-center\" data-tooltip=\"true\"
                                                         data-placement=\"top\"
                                                         title=\"";
                // line 427
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.copy"), "html", null, true);
                echo "\">
                                                        <a href=\"#\" class=\"btn btn-ec-actionIcon\"
                                                           data-toggle=\"modal\"
                                                           data-target=\"#confirmModal-";
                // line 430
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 430), "html", null, true);
                echo "\">
                                                            <i class=\"fa fa-files-o fa-lg text-secondary\"
                                                               aria-hidden=\"true\"></i></a>
                                                        <div class=\"modal fade\" id=\"confirmModal-";
                // line 433
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 433), "html", null, true);
                echo "\" tabindex=\"-1\"
                                                             role=\"dialog\"
                                                             aria-labelledby=\"confirmModal-";
                // line 435
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 435), "html", null, true);
                echo "\" aria-hidden=\"true\">
                                                            <div class=\"modal-dialog\" role=\"document\">
                                                                <div class=\"modal-content\">
                                                                    <div class=\"modal-header\">
                                                                        <h5 class=\"modal-title font-weight-bold\">
                                                                            ";
                // line 440
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.copy__confirm_title"), "html", null, true);
                echo "</h5>
                                                                        <button class=\"close\" type=\"button\"
                                                                                data-dismiss=\"modal\"
                                                                                aria-label=\"Close\"><span
                                                                                    aria-hidden=\"true\">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class=\"modal-body text-left\">
                                                                        <p class=\"text-left\">
                                                                            ";
                // line 449
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.copy__confirm_message"), "html", null, true);
                echo "</p>
                                                                    </div>
                                                                    <div class=\"modal-footer\">
                                                                        <button class=\"btn btn-ec-sub\" type=\"button\"
                                                                                data-dismiss=\"modal\">";
                // line 453
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.cancel"), "html", null, true);
                echo "
                                                                        </button>
                                                                        <a
                                                                                href=\"";
                // line 456
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("admin_product_product_copy", ["id" => twig_get_attribute($this->env, $this->source, $context["Product"], "id", [], "any", false, false, false, 456)]), "html", null, true);
                echo "\"
                                                                                class=\"btn btn-ec-conversion\"
                                                                                data-confirm=\"false\"
                                                                                ";
                // line 459
                echo $this->extensions['Eccube\Twig\Extension\CsrfExtension']->getCsrfTokenForAnchor();
                echo "
                                                                                data-method=\"post\">
                                                                            ";
                // line 461
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.copy"), "html", null, true);
                echo "
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Product'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 472
            echo "
                                    </tbody>
                                </table>
                            </div>
                            ";
            // line 476
            if ((twig_get_attribute($this->env, $this->source, ($context["pagination"] ?? null), "totalItemCount", [], "any", false, false, false, 476) > 0)) {
                // line 477
                echo "                                <div class=\"row justify-content-md-center mb-4 pb-4\">
                                    ";
                // line 478
                $this->loadTemplate("@admin/pager.twig", "@admin/Product/index.twig", 478)->display(twig_array_merge($context, ["pages" => twig_get_attribute($this->env, $this->source, ($context["pagination"] ?? null), "paginationData", [], "any", false, false, false, 478), "routes" => "admin_product_page"]));
                // line 479
                echo "                                </div>
                            ";
            }
            // line 481
            echo "                        </div>
                    </form>
                ";
        } elseif (        // line 483
($context["has_errors"] ?? null)) {
            // line 484
            echo "                    <div class=\"card rounded border-0\">
                        <div class=\"card-body p-4\">
                            <div class=\"text-center text-muted mb-4 h5\">";
            // line 486
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.search_invalid_condition"), "html", null, true);
            echo "</div>
                            <div class=\"text-center text-muted\">";
            // line 487
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.search_try_change_condition"), "html", null, true);
            echo "</div>
                        </div>
                    </div>
                ";
        } else {
            // line 491
            echo "                    <div class=\"card rounded border-0\">
                        <div class=\"card-body p-4\">
                            <div class=\"text-center text-muted mb-4 h5\">";
            // line 493
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.search_no_result"), "html", null, true);
            echo "</div>
                            <div class=\"text-center text-muted\">";
            // line 494
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.search_try_change_condition"), "html", null, true);
            echo "</div>
                            <div class=\"text-center text-muted\">";
            // line 495
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.search_try_advanced_search"), "html", null, true);
            echo "</div>
                        </div>
                    </div>
                ";
        }
        // line 499
        echo "            </div>

            <!-- 完全に削除の確認モーダル-->
            <div class=\"modal fade\" id=\"bulkDeleteModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"discontinuance\" aria-hidden=\"true\" data-keyboard=\"false\" data-backdrop=\"static\">
                <div class=\"modal-dialog\" role=\"document\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title font-weight-bold\">";
        // line 506
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.permanently_delete__confirm_title"), "html", null, true);
        echo "</h5>
                            <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                        </div>
                        <div class=\"modal-body text-left\">
                            <p class=\"text-left\">";
        // line 510
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.permanently_delete__confirm_message"), "html", null, true);
        echo "</p>
                            <ul id=\"bulkErrors\"></ul>
                            <div class=\"progress\" style=\"display: none\">
                                <div class=\"progress-bar progress-bar-striped progress-bar-animated\" role=\"progressbar\" style=\"width: 0%\" aria-valuenow=\"0\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div>
                            </div>
                        </div>
                        <div class=\"modal-footer\">
                            <button class=\"btn btn-ec-sub\" type=\"button\" data-dismiss=\"modal\">";
        // line 517
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.cancel"), "html", null, true);
        echo "</button>
                            <button class=\"btn btn-ec-delete\" type=\"button\" id=\"bulkDelete\">";
        // line 518
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.permanently_delete"), "html", null, true);
        echo "</button>
                            <button class=\"btn btn-ec-regular\" id=\"bulkDeleteDone\" style=\"display: none\" type=\"button\" data-dismiss=\"modal\">";
        // line 519
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.permanently_delete__complete"), "html", null, true);
        echo "</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class=\"modal fade\" id=\"productClassesModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"productClassesModal\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title font-weight-bold\">";
        // line 532
        echo "</h5>
                    <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span>
                    </button>
                </div>
                <div class=\"modal-body\">
                    ";
        // line 538
        echo "                </div>
                <div class=\"modal-footer\">
                    <button class=\"btn btn-v-sub\" type=\"button\" data-dismiss=\"modal\">
                        ";
        // line 541
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.common.cancel"), "html", null, true);
        echo "
                    </button>
                    <a class=\"btn btn-ec-conversion\"
                       href=\"#\">
                        ";
        // line 545
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.product.move_to_product_class"), "html", null, true);
        echo "
                    </a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /#productClassesModal -->
";
    }

    public function getTemplateName()
    {
        return "@admin/Product/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1038 => 545,  1031 => 541,  1026 => 538,  1019 => 532,  1003 => 519,  999 => 518,  995 => 517,  985 => 510,  978 => 506,  969 => 499,  962 => 495,  958 => 494,  954 => 493,  950 => 491,  943 => 487,  939 => 486,  935 => 484,  933 => 483,  929 => 481,  925 => 479,  923 => 478,  920 => 477,  918 => 476,  912 => 472,  895 => 461,  890 => 459,  884 => 456,  878 => 453,  871 => 449,  859 => 440,  851 => 435,  846 => 433,  840 => 430,  834 => 427,  825 => 421,  821 => 420,  812 => 414,  806 => 411,  800 => 408,  796 => 406,  793 => 405,  787 => 403,  781 => 401,  778 => 400,  776 => 399,  770 => 396,  766 => 395,  762 => 394,  758 => 393,  754 => 392,  751 => 391,  749 => 390,  745 => 388,  738 => 386,  734 => 385,  730 => 383,  723 => 381,  719 => 380,  711 => 377,  703 => 372,  699 => 371,  696 => 370,  692 => 368,  683 => 366,  677 => 364,  673 => 363,  665 => 358,  661 => 357,  657 => 356,  653 => 355,  649 => 354,  645 => 353,  641 => 352,  637 => 351,  633 => 350,  616 => 336,  612 => 335,  607 => 333,  603 => 332,  596 => 327,  581 => 325,  577 => 324,  567 => 317,  562 => 315,  556 => 314,  550 => 311,  544 => 310,  539 => 308,  533 => 307,  528 => 305,  522 => 301,  520 => 300,  510 => 293,  506 => 291,  500 => 289,  498 => 288,  494 => 287,  490 => 285,  483 => 283,  476 => 279,  472 => 278,  468 => 277,  464 => 275,  458 => 273,  455 => 272,  453 => 271,  450 => 270,  448 => 269,  443 => 268,  434 => 261,  430 => 260,  425 => 258,  420 => 256,  415 => 255,  409 => 251,  401 => 246,  397 => 245,  391 => 242,  386 => 240,  381 => 239,  374 => 234,  364 => 227,  360 => 226,  356 => 225,  348 => 220,  344 => 219,  340 => 218,  332 => 213,  328 => 212,  324 => 211,  316 => 206,  308 => 201,  300 => 196,  296 => 195,  290 => 194,  281 => 188,  277 => 187,  274 => 186,  270 => 185,  225 => 143,  219 => 139,  187 => 109,  180 => 105,  140 => 68,  117 => 48,  104 => 38,  100 => 37,  95 => 36,  91 => 35,  73 => 21,  69 => 20,  62 => 16,  55 => 15,  50 => 11,  48 => 18,  46 => 13,  39 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "@admin/Product/index.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/admin/Product/index.twig");
    }
}
