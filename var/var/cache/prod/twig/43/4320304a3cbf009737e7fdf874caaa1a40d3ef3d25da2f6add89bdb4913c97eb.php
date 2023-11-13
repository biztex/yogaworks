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

/* Product/detail.twig */
class __TwigTemplate_ac3845f1b3c33c180c74c179e9a61e44e88694c249843ae3c0762a9af82a618d extends \Eccube\Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'stylesheet' => [$this, 'block_stylesheet'],
            'javascript' => [$this, 'block_javascript'],
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 11
        return "default_frame.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 13
        $context["body_class"] = "product_page";
        // line 11
        $this->parent = $this->loadTemplate("default_frame.twig", "Product/detail.twig", 11);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 15
    public function block_stylesheet($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 16
        echo "    <style>

        .slick-slider {
            margin-bottom: 30px;
        }

        .slick-dots {
            position: absolute;
            bottom: -45px;
            display: block;
            width: 100%;
            padding: 0;
            list-style: none;
            text-align: center;
        }

        .slick-dots li {
            position: relative;
            display: inline-block;
            width: 20px;
            height: 20px;
            margin: 0 5px;
            padding: 0;

            cursor: pointer;
        }

        .slick-dots li button {
            font-size: 0;
            line-height: 0;
            display: block;
            width: 20px;
            height: 20px;
            padding: 5px;
            cursor: pointer;
            color: transparent;
            border: 0;
            outline: none;
            background: transparent;
        }

        .slick-dots li button:hover,
        .slick-dots li button:focus {
            outline: none;
        }

        .slick-dots li button:hover:before,
        .slick-dots li button:focus:before {
            opacity: 1;
        }

        .slick-dots li button:before {
            content: \" \";
            line-height: 20px;
            position: absolute;
            top: 0;
            left: 0;
            width: 12px;
            height: 12px;
            text-align: center;
            opacity: .25;
            background-color: black;
            border-radius: 50%;

        }

        .slick-dots li.slick-active button:before {
            opacity: .75;
            background-color: black;
        }

        .slick-dots li button.thumbnail img {
            width: 0;
            height: 0;
        }

    </style>
";
    }

    // line 95
    public function block_javascript($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 96
        echo "    <script>
        eccube.classCategories = ";
        // line 97
        echo $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getClassCategoriesAsJson(($context["Product"] ?? null));
        echo ";

        // 規格2に選択肢を割り当てる。
        function fnSetClassCategories(form, classcat_id2_selected) {
            var \$form = \$(form);
            var product_id = \$form.find('input[name=product_id]').val();
            var \$sele1 = \$form.find('select[name=classcategory_id1]');
            var \$sele2 = \$form.find('select[name=classcategory_id2]');
            eccube.setClassCategories(\$form, product_id, \$sele1, \$sele2, classcat_id2_selected);
        }

        ";
        // line 108
        if (twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id2", [], "any", true, true, false, 108)) {
            // line 109
            echo "        fnSetClassCategories(
            \$('#form1'), ";
            // line 110
            echo json_encode(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id2", [], "any", false, false, false, 110), "vars", [], "any", false, false, false, 110), "value", [], "any", false, false, false, 110));
            echo "
        );
        ";
        } elseif (twig_get_attribute($this->env, $this->source,         // line 112
($context["form"] ?? null), "classcategory_id1", [], "any", true, true, false, 112)) {
            // line 113
            echo "        eccube.checkStock(\$('#form1'), ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "id", [], "any", false, false, false, 113), "html", null, true);
            echo ", ";
            echo json_encode(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id1", [], "any", false, false, false, 113), "vars", [], "any", false, false, false, 113), "value", [], "any", false, false, false, 113));
            echo ", null);
        ";
        }
        // line 115
        echo "    </script>
    <script>
        \$(function() {
            // bfcache無効化
            \$(window).bind('pageshow', function(event) {
                if (event.originalEvent.persisted) {
                    location.reload(true);
                }
            });

            \$('.item_visual').slick({
                dots: false,
                arrows: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        dots: true
                    }
                }]
            });

            \$('.slideThumb').on('click', function() {
                var index = \$(this).attr('data-index');
                \$('.item_visual').slick('slickGoTo', index, false);
            })
        });
    </script>
    <script>
        \$(function() {
            \$('.add-cart').on('click', function(event) {
                ";
        // line 145
        if (twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id1", [], "any", true, true, false, 145)) {
            // line 146
            echo "                // 規格1フォームの必須チェック
                if (\$('#classcategory_id1').val() == '__unselected' || \$('#classcategory_id1').val() == '') {
                    \$('#classcategory_id1')[0].setCustomValidity('";
            // line 148
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("項目が選択されていません"), "html", null, true);
            echo "');
                    return true;
                } else {
                    \$('#classcategory_id1')[0].setCustomValidity('');
                }
                ";
        }
        // line 154
        echo "
                ";
        // line 155
        if (twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id2", [], "any", true, true, false, 155)) {
            // line 156
            echo "                // 規格2フォームの必須チェック
                if (\$('#classcategory_id2').val() == '__unselected' || \$('#classcategory_id2').val() == '') {
                    \$('#classcategory_id2')[0].setCustomValidity('";
            // line 158
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("項目が選択されていません"), "html", null, true);
            echo "');
                    return true;
                } else {
                    \$('#classcategory_id2')[0].setCustomValidity('');
                }
                ";
        }
        // line 164
        echo "
                // 個数フォームのチェック
                if (\$('#quantity').val() < 1) {
                    \$('#quantity')[0].setCustomValidity('";
        // line 167
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("1以上で入力してください。"), "html", null, true);
        echo "');
                    return true;
                } else {
                    \$('#quantity')[0].setCustomValidity('');
                }

                event.preventDefault();
                \$form = \$('#form1');
                \$.ajax({
                    url: \$form.attr('action'),
                    type: \$form.attr('method'),
                    data: \$form.serialize(),
                    dataType: 'json',
                    beforeSend: function(xhr, settings) {
                        // Buttonを無効にする
                        \$('.add-cart').prop('disabled', true);
                    }
                }).done(function(data) {
                    // レスポンス内のメッセージをalertで表示
                    \$.each(data.messages, function() {
                        \$('#ec-modal-header').html(this);
                    });

                    \$('.ec-modal').show()

                    // カートブロックを更新する
                    \$.ajax({
                        url: \"";
        // line 194
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("block_cart");
        echo "\",
                        type: 'GET',
                        dataType: 'html'
                    }).done(function(html) {
                        \$('.ec-headerRole__cart').html(html);
                    });
                }).fail(function(data) {
                    alert('";
        // line 201
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("カートへの追加に失敗しました。"), "html", null, true);
        echo "');
                }).always(function(data) {
                    // Buttonを有効にする
                    \$('.add-cart').prop('disabled', false);
                });
            });
        });

        \$('.ec-modal-wrap').on('click', function(e) {
            // モーダル内の処理は外側にバブリングさせない
            e.stopPropagation();
        });
        \$('.ec-modal-overlay, .ec-modal, .ec-modal-close, .ec-inlineBtn--cancel').on('click', function() {
            \$('.ec-modal').hide()
        });
    </script>
    <script type=\"application/ld+json\">
    {
        \"@context\": \"https://schema.org/\",
        \"@type\": \"Product\",
        \"name\": \"";
        // line 221
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "name", [], "any", false, false, false, 221), "html", null, true);
        echo "\",
        \"image\": [
            ";
        // line 223
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "ProductImage", [], "any", false, false, false, 223));
        $context['_iterated'] = false;
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
        foreach ($context['_seq'] as $context["_key"] => $context["img"]) {
            // line 224
            echo "                \"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 224), "schemeAndHttpHost", [], "any", false, false, false, 224), "html", null, true);
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($context["img"], "save_image"), "html", null, true);
            echo "\"";
            if ( !twig_get_attribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 224)) {
                echo ",";
            }
            // line 225
            echo "
            ";
            $context['_iterated'] = true;
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        if (!$context['_iterated']) {
            // line 227
            echo "                \"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 227), "schemeAndHttpHost", [], "any", false, false, false, 227), "html", null, true);
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($this->extensions['Eccube\Twig\Extension\EccubeExtension']->getNoImageProduct(""), "save_image"), "html", null, true);
            echo "\"
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['img'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 229
        echo "        ],
        \"description\": \"";
        // line 230
        echo twig_escape_filter($this->env, twig_slice($this->env, twig_replace_filter(((twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_list", [], "any", true, true, false, 230)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_list", [], "any", false, false, false, 230), twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_detail", [], "any", false, false, false, 230))) : (twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_detail", [], "any", false, false, false, 230))), ["
" => "", "" => ""]), 0, 300), "html", null, true);
        echo "\",
        ";
        // line 231
        if (twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "code_min", [], "any", false, false, false, 231)) {
            // line 232
            echo "        \"sku\": \"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "code_min", [], "any", false, false, false, 232), "html", null, true);
            echo "\",
        ";
        }
        // line 234
        echo "        \"offers\": {
            \"@type\": \"Offer\",
            \"url\": \"";
        // line 236
        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_detail", ["id" => twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "id", [], "any", false, false, false, 236)]), "html", null, true);
        echo "\",
            \"priceCurrency\": \"";
        // line 237
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["eccube_config"] ?? null), "currency", [], "any", false, false, false, 237), "html", null, true);
        echo "\",
            \"price\": ";
        // line 238
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice02IncTaxMin", [], "any", false, false, false, 238), "html", null, true);
        echo ",
            \"availability\": \"";
        // line 239
        echo ((twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "stock_find", [], "any", false, false, false, 239)) ? ("InStock") : ("OutOfStock"));
        echo "\"
        }
    }
    </script>
";
    }

    // line 245
    public function block_main($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 246
        echo "    <div class=\"ec-productRole\">
        <div class=\"ec-grid2\">
            <div class=\"ec-grid2__cell\">
                <div class=\"ec-sliderItemRole\">

                    <div class=\"item_visual\">
                        ";
        // line 252
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "ProductImage", [], "any", false, false, false, 252));
        $context['_iterated'] = false;
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
        foreach ($context['_seq'] as $context["_key"] => $context["ProductImage"]) {
            // line 253
            echo "                            <div class=\"slide-item\"><img src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($context["ProductImage"], "save_image"), "html", null, true);
            echo "\" alt=\"";
            ((twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 253)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "name", [], "any", false, false, false, 253), "html", null, true))) : (print ("")));
            echo "\"></div>
                        ";
            $context['_iterated'] = true;
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        if (!$context['_iterated']) {
            // line 255
            echo "                            <div class=\"slide-item\"><img src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($this->extensions['Eccube\Twig\Extension\EccubeExtension']->getNoImageProduct(""), "save_image"), "html", null, true);
            echo "\" alt=\"";
            ((twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 255)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "name", [], "any", false, false, false, 255), "html", null, true))) : (print ("")));
            echo "\" /></div>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ProductImage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 257
        echo "                    </div>
                    <div class=\"item_nav\">
                        ";
        // line 259
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "ProductImage", [], "any", false, false, false, 259));
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
        foreach ($context['_seq'] as $context["_key"] => $context["ProductImage"]) {
            // line 260
            echo "                            <div class=\"slideThumb\" data-index=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 260), "html", null, true);
            echo "\"><img src=\"";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl($context["ProductImage"], "save_image"), "html", null, true);
            echo "\" alt=\"\"></div>
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ProductImage'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 262
        echo "                    </div>
                </div>
            </div>
            <div class=\"ec-grid2__cell\">
                <div class=\"ec-productRole__profile\">
                    ";
        // line 268
        echo "                    <div class=\"ec-productRole__title\">
                        <h2 class=\"ec-headingTitle\">";
        // line 269
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "name", [], "any", false, false, false, 269), "html", null, true);
        echo "</h2>
                    </div>
                    ";
        // line 272
        echo "                    <ul class=\"ec-productRole__tags\">
                        ";
        // line 273
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "Tags", [], "any", false, false, false, 273));
        foreach ($context['_seq'] as $context["_key"] => $context["Tag"]) {
            // line 274
            echo "                            <li class=\"ec-productRole__tag tag_";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Tag"], "id", [], "any", false, false, false, 274), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $context["Tag"], "html", null, true);
            echo "</li>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['Tag'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 276
        echo "                    </ul>
                    ";
        // line 278
        echo "                    ";
        if (twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "hasProductClass", [], "any", false, false, false, 278)) {
            // line 279
            echo "<div class=\"ec-productRole__priceRegular\">
                            ";
            // line 280
            if (( !(null === twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01Min", [], "any", false, false, false, 280)) && (twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01IncTaxMin", [], "any", false, false, false, 280) == twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01IncTaxMax", [], "any", false, false, false, 280)))) {
                // line 281
                echo "                                <span class=\"ec-productRole__priceRegularPrice\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("通常価格"), "html", null, true);
                echo "：<span class=\"price01-default\">";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01IncTaxMin", [], "any", false, false, false, 281)), "html", null, true);
                echo "</span></span>
                                <span class=\"ec-productRole__priceRegularTax\">";
                // line 282
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("税込"), "html", null, true);
                echo "</span>
                            ";
            } elseif (( !(null === twig_get_attribute($this->env, $this->source,             // line 283
($context["Product"] ?? null), "getPrice01Min", [], "any", false, false, false, 283)) &&  !(null === twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01Max", [], "any", false, false, false, 283)))) {
                // line 284
                echo "                                <span class=\"ec-productRole__priceRegularPrice\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("通常価格"), "html", null, true);
                echo "：<span class=\"price01-default\">";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01IncTaxMin", [], "any", false, false, false, 284)), "html", null, true);
                echo "～ ";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01IncTaxMax", [], "any", false, false, false, 284)), "html", null, true);
                echo "</span></span>
                                <span class=\"ec-productRole__priceRegularTax\">";
                // line 285
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("税込"), "html", null, true);
                echo "</span>
                            ";
            }
            // line 287
            echo "                        </div>
                    ";
        } else {
            // line 289
            echo "                        ";
            if ( !(null === twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01Max", [], "any", false, false, false, 289))) {
                // line 290
                echo "                            <span class=\"ec-productRole__priceRegularPrice\">";
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("通常価格"), "html", null, true);
                echo "：";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice01IncTaxMin", [], "any", false, false, false, 290)), "html", null, true);
                echo "</span>
                            <span class=\"ec-productRole__priceRegularTax\">";
                // line 291
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("税込"), "html", null, true);
                echo "</span>
                        ";
            }
            // line 293
            echo "                    ";
        }
        // line 294
        echo "                    ";
        // line 295
        echo "                    <div class=\"ec-productRole__price\">
                        ";
        // line 296
        if (twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "hasProductClass", [], "any", false, false, false, 296)) {
            // line 297
            if ((twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice02IncTaxMin", [], "any", false, false, false, 297) == twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice02IncTaxMax", [], "any", false, false, false, 297))) {
                // line 298
                echo "                                <div class=\"ec-price\">
                                    <span class=\"ec-price__price price02-default\">";
                // line 299
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice02IncTaxMin", [], "any", false, false, false, 299)), "html", null, true);
                echo "</span>
                                    <span class=\"ec-price__tax\">";
                // line 300
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("税込"), "html", null, true);
                echo "</span>
                                </div>
                            ";
            } else {
                // line 303
                echo "                                <div class=\"ec-price\">
                                    <span class=\"ec-price__price price02-default\">";
                // line 304
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice02IncTaxMin", [], "any", false, false, false, 304)), "html", null, true);
                echo " ～ ";
                echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice02IncTaxMax", [], "any", false, false, false, 304)), "html", null, true);
                echo "</span>
                                    <span class=\"ec-price__tax\">";
                // line 305
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("税込"), "html", null, true);
                echo "</span>
                                </div>
                            ";
            }
            // line 308
            echo "                        ";
        } else {
            // line 309
            echo "                            <div class=\"ec-price\">
                                <span class=\"ec-price__price\">";
            // line 310
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\EccubeExtension']->getPriceFilter(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "getPrice02IncTaxMin", [], "any", false, false, false, 310)), "html", null, true);
            echo "</span>
                                <span class=\"ec-price__tax\">";
            // line 311
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("税込"), "html", null, true);
            echo "</span>
                            </div>
                        ";
        }
        // line 314
        echo "                    </div>
                    ";
        // line 316
        echo "                    ";
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "code_min", [], "any", false, false, false, 316))) {
            // line 317
            echo "                        <div class=\"ec-productRole__code\">
                            ";
            // line 318
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("商品コード"), "html", null, true);
            echo "： <span class=\"product-code-default\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "code_min", [], "any", false, false, false, 318), "html", null, true);
            if ((twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "code_min", [], "any", false, false, false, 318) != twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "code_max", [], "any", false, false, false, 318))) {
                echo " ～ ";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "code_max", [], "any", false, false, false, 318), "html", null, true);
            }
            echo "</span>
                        </div>
                    ";
        }
        // line 321
        echo "                    ";
        // line 322
        echo "                    ";
        if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "ProductCategories", [], "any", false, false, false, 322))) {
            // line 323
            echo "                        <div class=\"ec-productRole__category\">
                            <div>";
            // line 324
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("関連カテゴリ"), "html", null, true);
            echo "</div>
                            ";
            // line 325
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "ProductCategories", [], "any", false, false, false, 325));
            foreach ($context['_seq'] as $context["_key"] => $context["ProductCategory"]) {
                // line 326
                echo "                                <ul>
                                    <li>
                                        ";
                // line 328
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["ProductCategory"], "Category", [], "any", false, false, false, 328), "path", [], "any", false, false, false, 328));
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
                    // line 329
                    echo "                                            <a href=\"";
                    echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_list");
                    echo "?category_id=";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Category"], "id", [], "any", false, false, false, 329), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["Category"], "name", [], "any", false, false, false, 329), "html", null, true);
                    echo "</a>";
                    if ((twig_get_attribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 329) == false)) {
                        // line 330
                        echo "                                            <span>＞</span>";
                    }
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
                // line 332
                echo "                                    </li>
                                </ul>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ProductCategory'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 335
            echo "                        </div>
                    ";
        }
        // line 337
        echo "                    <form action=\"";
        echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_add_cart", ["id" => twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "id", [], "any", false, false, false, 337)]), "html", null, true);
        echo "\" method=\"post\" id=\"form1\" name=\"form1\">
                        ";
        // line 338
        if (twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "stock_find", [], "any", false, false, false, 338)) {
            // line 339
            echo "                            <div class=\"ec-productRole__actions\">
                                ";
            // line 340
            if (twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id1", [], "any", true, true, false, 340)) {
                // line 341
                echo "                                    <div class=\"ec-select\">
                                        ";
                // line 342
                echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id1", [], "any", false, false, false, 342), 'widget');
                echo "
                                        ";
                // line 343
                echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id1", [], "any", false, false, false, 343), 'errors');
                echo "
                                    </div>
                                    ";
                // line 345
                if (twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id2", [], "any", true, true, false, 345)) {
                    // line 346
                    echo "                                        <div class=\"ec-select\">
                                            ";
                    // line 347
                    echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id2", [], "any", false, false, false, 347), 'widget');
                    echo "
                                            ";
                    // line 348
                    echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "classcategory_id2", [], "any", false, false, false, 348), 'errors');
                    echo "
                                        </div>
                                    ";
                }
                // line 351
                echo "                                ";
            }
            // line 352
            echo "                                <div class=\"ec-numberInput\"><span>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("数量"), "html", null, true);
            echo "</span>
                                    ";
            // line 353
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "quantity", [], "any", false, false, false, 353), 'widget');
            echo "
                                    ";
            // line 354
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "quantity", [], "any", false, false, false, 354), 'errors');
            echo "
                                </div>
                            </div>
                            <div class=\"ec-productRole__btn\">
                                <button type=\"submit\" class=\"ec-blockBtn--action add-cart\">
                                    ";
            // line 359
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("カートに入れる"), "html", null, true);
            echo "
                                </button>
                            </div>
                        ";
        } else {
            // line 363
            echo "                            <div class=\"ec-productRole__btn\">
                                <button type=\"button\" class=\"ec-blockBtn--action\" disabled=\"disabled\">
                                    ";
            // line 365
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("ただいま品切れ中です。"), "html", null, true);
            echo "
                                </button>
                            </div>
                        ";
        }
        // line 369
        echo "
                        ";
        // line 370
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["form"] ?? null), 'rest');
        echo "
                    </form>
                    <div class=\"ec-modal\">
                        <div class=\"ec-modal-overlay\">
                            <div class=\"ec-modal-wrap\">
                                <span class=\"ec-modal-close\"><span class=\"ec-icon\"><img src=\"";
        // line 375
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("assets/icon/cross-dark.svg"), "html", null, true);
        echo "\" alt=\"\"/></span></span>
                                <div id=\"ec-modal-header\" class=\"text-center\">";
        // line 376
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("カートに追加しました。"), "html", null, true);
        echo "</div>
                                <div class=\"ec-modal-box\">
                                    <div class=\"ec-role\">
                                        <span class=\"ec-inlineBtn--cancel\">";
        // line 379
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("お買い物を続ける"), "html", null, true);
        echo "</span>
                                        <a href=\"";
        // line 380
        echo $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("cart");
        echo "\" class=\"ec-inlineBtn--action\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("カートへ進む"), "html", null, true);
        echo "</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
        // line 386
        if (twig_get_attribute($this->env, $this->source, ($context["BaseInfo"] ?? null), "option_favorite_product", [], "any", false, false, false, 386)) {
            // line 387
            echo "                        <form action=\"";
            echo twig_escape_filter($this->env, $this->extensions['Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension']->getUrl("product_add_favorite", ["id" => twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "id", [], "any", false, false, false, 387)]), "html", null, true);
            echo "\" method=\"post\">
                            <div class=\"ec-productRole__btn\">
                                ";
            // line 389
            if ((($context["is_favorite"] ?? null) == false)) {
                // line 390
                echo "                                    <button type=\"submit\" id=\"favorite\" class=\"ec-blockBtn--cancel\">
                                        ";
                // line 391
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("お気に入りに追加"), "html", null, true);
                echo "
                                    </button>
                                ";
            } else {
                // line 394
                echo "                                    <button type=\"submit\" id=\"favorite\" class=\"ec-blockBtn--cancel\"
                                            disabled=\"disabled\">";
                // line 395
                echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("お気に入りに追加済です。"), "html", null, true);
                echo "
                                    </button>
                                ";
            }
            // line 398
            echo "                            </div>
                        </form>
                    ";
        }
        // line 401
        echo "                    <div class=\"ec-productRole__description\">";
        echo nl2br(twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "description_detail", [], "any", false, false, false, 401));
        echo "
                    </div>
                </div>
            </div>
        </div>
        ";
        // line 406
        if (twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "freearea", [], "any", false, false, false, 406)) {
            // line 407
            echo "             <div class=\"ec-productRole__description\">
                 ";
            // line 408
            echo twig_include($this->env, $context, twig_template_from_string($this->env, twig_get_attribute($this->env, $this->source, ($context["Product"] ?? null), "freearea", [], "any", false, false, false, 408)));
            echo "
            </div>
        ";
        }
        // line 411
        echo "    </div>
";
    }

    public function getTemplateName()
    {
        return "Product/detail.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  911 => 411,  905 => 408,  902 => 407,  900 => 406,  891 => 401,  886 => 398,  880 => 395,  877 => 394,  871 => 391,  868 => 390,  866 => 389,  860 => 387,  858 => 386,  847 => 380,  843 => 379,  837 => 376,  833 => 375,  825 => 370,  822 => 369,  815 => 365,  811 => 363,  804 => 359,  796 => 354,  792 => 353,  787 => 352,  784 => 351,  778 => 348,  774 => 347,  771 => 346,  769 => 345,  764 => 343,  760 => 342,  757 => 341,  755 => 340,  752 => 339,  750 => 338,  745 => 337,  741 => 335,  733 => 332,  718 => 330,  709 => 329,  692 => 328,  688 => 326,  684 => 325,  680 => 324,  677 => 323,  674 => 322,  672 => 321,  660 => 318,  657 => 317,  654 => 316,  651 => 314,  645 => 311,  641 => 310,  638 => 309,  635 => 308,  629 => 305,  623 => 304,  620 => 303,  614 => 300,  610 => 299,  607 => 298,  605 => 297,  603 => 296,  600 => 295,  598 => 294,  595 => 293,  590 => 291,  583 => 290,  580 => 289,  576 => 287,  571 => 285,  562 => 284,  560 => 283,  556 => 282,  549 => 281,  547 => 280,  544 => 279,  541 => 278,  538 => 276,  527 => 274,  523 => 273,  520 => 272,  515 => 269,  512 => 268,  505 => 262,  486 => 260,  469 => 259,  465 => 257,  454 => 255,  436 => 253,  418 => 252,  410 => 246,  406 => 245,  397 => 239,  393 => 238,  389 => 237,  385 => 236,  381 => 234,  375 => 232,  373 => 231,  368 => 230,  365 => 229,  355 => 227,  341 => 225,  333 => 224,  315 => 223,  310 => 221,  287 => 201,  277 => 194,  247 => 167,  242 => 164,  233 => 158,  229 => 156,  227 => 155,  224 => 154,  215 => 148,  211 => 146,  209 => 145,  177 => 115,  169 => 113,  167 => 112,  162 => 110,  159 => 109,  157 => 108,  143 => 97,  140 => 96,  136 => 95,  55 => 16,  51 => 15,  46 => 11,  44 => 13,  37 => 11,);
    }

    public function getSourceContext()
    {
        return new Source("", "Product/detail.twig", "/var/www/html/yogaworks.jp/web/src/Eccube/Resource/template/default/Product/detail.twig");
    }
}
