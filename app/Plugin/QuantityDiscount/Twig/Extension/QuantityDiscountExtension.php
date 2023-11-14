<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/26
 */

namespace Plugin\QuantityDiscount\Twig\Extension;


use Eccube\Entity\ItemInterface;
use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;
use Plugin\QuantityDiscount\Service\ConfigService;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class QuantityDiscountExtension extends AbstractExtension
{

    /** @var QuantityDiscountService */
    protected $quantityDiscountService;

    /** @var ConfigService */
    protected $configService;

    public function __construct(
        QuantityDiscountService $quantityDiscountService,
        ConfigService $configService
    )
    {
        $this->quantityDiscountService = $quantityDiscountService;
        $this->configService = $configService;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('is_quantity_discount', [$this, 'isQuantityDiscount']),
            new TwigFunction('qd_discount_price', [$this, 'getDiscount']),
            new TwigFunction('qd_discount_price_one', [$this, 'getDiscountOne']),
            new TwigFunction('qd_discount_price_inc_tax', [$this, 'getDiscountIncTax']),
            new TwigFunction('qd_discount_price_one_inc_tax', [$this, 'getDiscountOneIncTax']),
            new TwigFunction('is_qd_mode_normal', [$this, 'isQdModeNormal']),
            new TwigFunction('qd_product_price_inc_tax', [$this, 'getProductClassPriceIncTax']),
            new TwigFunction('qd_product_list', [$this, 'getQuantityDiscountList']),
        ];
    }

    /**
     * まとめ買い判定
     *
     * @param ItemInterface $item
     * @return bool true:まとめ買い値引対象
     */
    public function isQuantityDiscount(ItemInterface $item)
    {
        return $this->quantityDiscountService->isDiscount($item);
    }

    /**
     * まとめ買い値引き額(税抜き)取得
     *
     * @param ItemInterface $orderItem
     * @param bool $numberFormat
     * @return int|string
     */
    public function getDiscount(ItemInterface $orderItem, $numberFormat = true)
    {
        $price = $this->quantityDiscountService->getDiscountPrice($orderItem);

        if ($numberFormat) {
            $price = number_format($price);
        }

        return $price;
    }

    /**
     * まとめ買い値引き額(税抜き１個分)取得
     *
     * @param ItemInterface $cartItem
     * @param bool $numberFormat
     * @return int|string
     */
    public function getDiscountOne(ItemInterface $cartItem, $numberFormat = true)
    {
        $price = $this->quantityDiscountService->getDiscountPriceOne($cartItem);

        if ($numberFormat) {
            $price = number_format($price);
        }

        return $price;
    }

    /**
     * まとめ買い値引き額(税込み１個分)取得
     *
     * @param ItemInterface $cartItem
     * @param bool $numberFormat
     * @return int|string
     */
    public function getDiscountOneIncTax(ItemInterface $cartItem, $numberFormat = true)
    {
        $price = $this->quantityDiscountService->getDiscountPriceOneIncTax($cartItem);

        if ($numberFormat) {
            $price = number_format($price);
        }

        return $price;
    }

    /**
     * まとめ買い値引き額(税込み)取得
     *
     * @param ItemInterface $orderItem
     * @param bool $numberFormat true:3桁区切り表示
     * @return int|string
     */
    public function getDiscountIncTax(ItemInterface $orderItem, $numberFormat = true)
    {
        $price = $this->quantityDiscountService->getDiscountPriceIncTax($orderItem);

        if ($numberFormat) {
            $price = number_format($price);
        }

        return $price;
    }

    /**
     * まとめ買い値引き後 商品価格(税込み)取得
     *
     * @param ItemInterface $orderItem
     * @param bool $numberFormat
     * @return float|int|string|null
     */
    public function getProductClassPriceIncTax(ItemInterface $orderItem, $numberFormat = true)
    {
        $price = $this->quantityDiscountService->getProductClassPriceIncTax($orderItem);

        if ($numberFormat) {
            $price = number_format($price);
        }

        return $price;
    }

    /**
     * 値引き方式判定
     *
     * @return bool true:通常, false:直接
     */
    public function isQdModeNormal()
    {
        if (ConfigService::DISCOUNT_MODE_NORMAL
            == $this->configService->getKeyInteger(ConfigService::SETTING_KEY_MODE)) {
            return true;
        }

        return false;
    }

    /**
     * 商品のまとめ買い値引情報
     *
     * @param Product $product
     * @return array
     */
    public function getQuantityDiscountList(Product $product)
    {
        $quantityDiscountList = [];

        /** @var ProductClass $productClass */
        foreach ($product->getProductClasses() as $productClass) {

            if (!$productClass->isVisible()) continue;

            $ClassCategory1 = $productClass->getClassCategory1();
            $ClassCategory2 = $productClass->getClassCategory2();

            if ($ClassCategory2 && !$ClassCategory2->isVisible()) {
                continue;
            }

            if (!$this->quantityDiscountService->isDiscountByProductClass($productClass)) {
                continue;
            }

            $classCategoryId1 = $ClassCategory1 ? $ClassCategory1->getId() : 0;
            $classCategoryId2 = $ClassCategory2 ? $ClassCategory2->getId() : 0;

            $quantityDiscounts = $this->quantityDiscountService->getQuantityDiscountList($productClass);

            // 規格ID, 商品コード, 規格名1, 企画名2, {数量, 金額*2, 値引き額*2}
            $quantityDiscountList[$classCategoryId1][$classCategoryId2] = [
                'product_class_id' => $productClass->getId(),
                'product_code' => $productClass->getCode(),
                'class_name1' => $ClassCategory1 ? $ClassCategory1->getName() : null,
                'class_name2' => $ClassCategory2 ? $ClassCategory2->getName() : null,
                'quantity_discounts' => $quantityDiscounts,
            ];

            $quantityDiscountList['has_class'] = $product->hasProductClass();
        }

        return $quantityDiscountList;
    }
}
