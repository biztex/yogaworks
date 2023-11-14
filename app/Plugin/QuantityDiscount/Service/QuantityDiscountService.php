<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/24
 */

namespace Plugin\QuantityDiscount\Service;


use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\ItemInterface;
use Eccube\Entity\Master\RoundingType;
use Eccube\Entity\OrderItem;
use Eccube\Entity\ProductClass;
use Eccube\Service\TaxRuleService;
use Plugin\QuantityDiscount\Entity\QdProductClass;
use Plugin\QuantityDiscount\Repository\QdProductClassRepository;
use Psr\Container\ContainerInterface;

class QuantityDiscountService
{

    /** @var QdProductClassRepository */
    protected $qdProductClassRepository;

    /** @var TaxRuleService */
    protected $taxRuleService;

    /** @var ConfigService */
    protected $configService;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var ContainerInterface  */
    protected $container;

    /**
     * QuantityDiscountService constructor.
     * @param QdProductClassRepository $qdProductClassRepository
     * @param TaxRuleService $taxRuleService
     * @param ConfigService $configService
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     */
    public function __construct(
        QdProductClassRepository $qdProductClassRepository,
        TaxRuleService $taxRuleService,
        ConfigService $configService,
        EntityManagerInterface $entityManager,
        ContainerInterface $container
    )
    {
        $this->qdProductClassRepository = $qdProductClassRepository;
        $this->taxRuleService = $taxRuleService;
        $this->configService = $configService;
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    /**
     * まとめ買い適用判定
     *
     * @param ItemInterface $item
     * @param null $quantity
     * @return bool
     */
    public function isDiscount(ItemInterface $item, $quantity = null)
    {
        $ProductClass = $item->getProductClass();

        if (is_null($quantity)) {
            // Orderから対象商品の数量計を算出
            $quantity = $this->getOrderItemTotalQuantity($item);
        }

        $QdProductClasses = $this->qdProductClassRepository
            ->findProductClassPrice($ProductClass, $quantity);

        if (empty($QdProductClasses)) {
            // 対象なし
            return false;
        }

        return true;
    }

    /**
     * まとめ買い適用判定
     *
     * @param ProductClass $productClass
     * @return bool
     */
    public function isDiscountByProductClass(ProductClass $productClass)
    {

        $QdProductClasses = $this->qdProductClassRepository
            ->findProductClassPrice($productClass);

        if (empty($QdProductClasses)) {
            // 対象なし
            return false;
        }

        return true;
    }

    /**
     * 対象商品の合計購入数取得
     *
     * @param ItemInterface $targetItem
     * @return int
     */
    public function getOrderItemTotalQuantity(ItemInterface $targetItem)
    {
        if ($targetItem instanceof OrderItem) {

            $Order = $targetItem->getOrder();
            $subTotal = 0;

            /** @var OrderItem $item */
            foreach ($Order->getItems() as $item) {
                if ($item->isProduct()) {
                    if ($targetItem->getProductClass()->getId() == $item->getProductClass()->getId()) {
                        $subTotal += $item->getQuantity();
                    }
                }
            }

            return $subTotal;

        } else {
            return $targetItem->getQuantity();
        }
    }

    /**
     * まとめ買い値引後の価格(税抜き)取得
     *
     * @param ItemInterface $targetItem
     * @param null|int $orderItemTotalQuantity
     * @return float|int|string|null
     */
    public function getProductClassPrice(ItemInterface $targetItem, $orderItemTotalQuantity = null)
    {
        $ProductClass = $targetItem->getProductClass();

        if (is_null($orderItemTotalQuantity)) {
            $orderItemTotalQuantity = $this->getOrderItemTotalQuantity($targetItem);
        }

        $price = $this->calcProductClassPrice($ProductClass, $orderItemTotalQuantity);

        return $price;
    }

    /**
     * まとめ買い値引き後の価格(税込み)取得
     *
     * @param ItemInterface $targetItem
     * @param null|int $orderItemTotalQuantity
     * @return float|int|string|null
     */
    public function getProductClassPriceIncTax(ItemInterface $targetItem, $orderItemTotalQuantity = null)
    {
        $ProductClass = $targetItem->getProductClass();

        if (is_null($orderItemTotalQuantity)) {
            $orderItemTotalQuantity = $this->getOrderItemTotalQuantity($targetItem);
        }

        $price = $this->calcProductClassPrice($ProductClass, $orderItemTotalQuantity, true);

        return $price;
    }

    /**
     * まとめ買い値引き後の価格取得
     *
     * @param ProductClass $productClass
     * @param $quantity
     * @param bool $incTax
     * @return float|int|string|null
     */
    private function calcProductClassPrice(ProductClass $productClass, $quantity, $incTax = false)
    {
        $discountPrice = -1;

        $QdProductClasses = $this->qdProductClassRepository
            ->findProductClassPrice($productClass, $quantity);

        if (empty($QdProductClasses)) {
            // 対象なし
            return $discountPrice;
        }

        // 1件目を利用する
        /** @var QdProductClass $QdProductClass */
        $QdProductClass = $QdProductClasses[0];

        // 値引後価格を取得
        $discountPrice = $this->calcQuantityDiscountPrice($QdProductClass);

        if ($incTax) {
            // 税額計算
            if (ConfigService::DISCOUNT_MODE_DIRECT ==
                $this->configService->getKeyInteger(ConfigService::SETTING_KEY_MODE)) {

                $discountPrice = $this->taxRuleService->getPriceIncTax(
                    $discountPrice,
                    $productClass->getProduct(),
                    $productClass
                );

            } else {
                $discountPrice = $this->calcDiscountPriceIncTax($productClass, $discountPrice);
            }
        }

        return $discountPrice;
    }

    /**
     * 値引タイプを判別し値引後価格を計算
     *
     * @param QdProductClass $qdProductClass
     * @return float|int|string|null
     */
    private function calcQuantityDiscountPrice(QdProductClass $qdProductClass)
    {
        if ($qdProductClass->isQdTypePrice()) {
            // Price
            $discountPrice = $qdProductClass->getPrice();

            // 価格チェック
            if($qdProductClass->getProductClass()->getPrice02() < $discountPrice) {
                $discountPrice = $qdProductClass->getProductClass()->getPrice02();
            }

        } else {
            // Rate
            $price = $this->getProductPrice02($qdProductClass->getProductClass());
            $rate = $qdProductClass->getRate();

            $roundingType = $this->configService->getKeyInteger(ConfigService::SETTING_KEY_RATE_TYPE);
            $discountPrice = $this->calcDiscountPrice($price, $rate, $roundingType);
        }

        return $discountPrice;
    }

    /**
     * まとめ買い値引き額*数量を取得
     *
     * @param ItemInterface $orderItem
     * @return int
     */
    public function getDiscountPrice(ItemInterface $orderItem)
    {

        $ProductClass = $orderItem->getProductClass();
        $quantity = $this->getOrderItemTotalQuantity($orderItem);

        return $this->getProductDiscountPrice($ProductClass, $quantity, $quantity);
    }

    /**
     * まとめ買い値引き額(税抜き１個分)を取得
     *
     * @param ItemInterface $item
     * @return float|int
     */
    public function getDiscountPriceOne(ItemInterface $item)
    {
        $ProductClass = $item->getProductClass();
        $quantity = $this->getOrderItemTotalQuantity($item);

        return $this->getProductDiscountPrice($ProductClass, $quantity);
    }

    /**
     * まとめ買い値引額(税込み１個分)取得
     *
     * @param ItemInterface $item
     * @return float|int
     */
    public function getDiscountPriceOneIncTax(ItemInterface $item)
    {
        $ProductClass = $item->getProductClass();
        $quantity = $this->getOrderItemTotalQuantity($item);

        return $this->getProductDiscountPrice($ProductClass, $quantity, 1, true);
    }

    /**
     * まとめ買い値引き額取得
     *
     * @param ProductClass $productClass
     * @param integer $totalQuantity 購入予定の数量
     * @param int $quantity 数量
     * @param bool $incTax true:税込 false:税抜き
     * @return float|int
     */
    private function getProductDiscountPrice(ProductClass $productClass, $totalQuantity, $quantity = 1, $incTax = false)
    {

        if ($incTax) {
            $realPrice = $this->getProductPrice02IncTax($productClass);
            $discountPrice = $this->calcProductClassPrice($productClass, $totalQuantity, true);

            // まとめ買い値引き税込み額
            $resultPrice = $realPrice - $discountPrice;

        } else {
            $realPrice = $this->getProductPrice02($productClass);
            $discountPrice = $this->calcProductClassPrice($productClass, $totalQuantity);

            $resultPrice = ($realPrice - $discountPrice);
        }

        return $resultPrice * $quantity;
    }

    /**
     * まとめ買い値引き額（税込み）*数量を取得
     *
     * @param ItemInterface $orderItem
     * @return int
     */
    public function getDiscountPriceIncTax(ItemInterface $orderItem)
    {
        $ProductClass = $orderItem->getProductClass();
        $realPrice = $this->getProductPrice02IncTax($ProductClass);

        $discountPrice = $this->getProductClassPrice($orderItem);
        $discountPriceIncTax = $this->calcDiscountPriceIncTax($ProductClass, $discountPrice);

        $quantity = $orderItem->getQuantity();

        // まとめ買い値引き税込み額
        $resultPrice = $realPrice - $discountPriceIncTax;

        return $resultPrice * $quantity;
    }

    /**
     * @param ProductClass $productClass
     * @return mixed
     */
    public function getQuantityDiscountList(ProductClass $productClass)
    {

        $QdProductClasses = $this->qdProductClassRepository
            ->findProductClassPrice($productClass, null, 'asc');

        if (empty($QdProductClasses)) {
            // まとめ買い値引対象外
            return false;
        }

        $realPrice = $this->getProductPrice02($productClass);
        $realPriceIncTax = $this->getProductPrice02IncTax($productClass);

        $result = [];

        /** @var QdProductClass $qdProductClass */
        foreach ($QdProductClasses as $qdProductClass) {

            $productClassPrice = $this->calcQuantityDiscountPrice($qdProductClass);

            // 税額計算
            $productClassPriceIncTax = $this->calcDiscountPriceIncTax($productClass, $productClassPrice);

            $discountPrice = $realPrice - $productClassPrice;
            $discountPriceIncTax = $realPriceIncTax - $productClassPriceIncTax;

            if($discountPriceIncTax < 0) {
                // 値引き額がマイナスの場合リスト表示しない
                continue;
            }

            // 数量, 金額,
            $result[] = [
                'quantity' => $qdProductClass->getQuantity(),
                'max_quantity' => '',
                'price' => $productClassPrice,
                'price_inc_tax' => $productClassPriceIncTax,
                'discount_price' => $discountPrice,
                'discount_price_inc_tax' => $discountPriceIncTax
            ];
        }

        // 数量範囲を設定
        for ($i = count($result) - 1; $i > 0; $i--) {

            $result[$i - 1]['max_quantity'] = ($result[$i]['quantity'] - 1);
        }

        return $result;
    }

    /**
     * 値引き後税込み価格計算
     *
     * @param ProductClass $productClass
     * @param $productClassPrice
     * @return float|string
     */
    private function calcDiscountPriceIncTax(ProductClass $productClass, $productClassPrice)
    {
        // 税額計算
        $discount = $productClass->getPrice02() - $productClassPrice;
        $discountIncTax = $this->taxRuleService->getPriceIncTax(
            $discount,
            $productClass->getProduct(),
            $productClass
        );

        $productClassPriceIncTax = $productClass->getPrice02IncTax() - $discountIncTax;

        return $productClassPriceIncTax;
    }

    /**
     * @param $price
     * @param $rate
     * @param int $roundingType
     * @return float|int
     */
    private function calcDiscountPrice($price, $rate, $roundingType = 1)
    {
        $value = $price * $rate / 100;

        switch ($roundingType) {
            // 四捨五入
            case RoundingType::ROUND:
                $roundResult = round($value);
                break;
            // 切り捨て
            case RoundingType::FLOOR:
                $roundResult = floor($value);
                break;
            // 切り上げ
            case RoundingType::CEIL:
                $roundResult = ceil($value);
                break;
            // デフォルト:切り上げ
            default:
                $roundResult = ceil($value);
                break;
        }

        $discountPrice = $price - $roundResult;

        return ($discountPrice > 0 ? $discountPrice : 0);
    }

    /**
     * まとめ買い値引コピー
     *
     * @param $CopyProductClasses
     */
    public function copyQdProductClasses($CopyProductClasses)
    {
        /** @var ProductClass $productClass */
        foreach ($CopyProductClasses as $productClass) {
            // Copy
            $productClass->copyQdProductClasses();
            $this->entityManager->persist($productClass);
        }

        $this->entityManager->flush();
    }

    /**
     * 商品価格取得
     *
     * @param ProductClass $productClass
     * @return string
     */
    private function getProductPrice02(ProductClass $productClass)
    {

        if($this->isPinpointSale()) {
            // タイムセール併用時
            if($productClass->getPinpointSaleItem()) {
                $pinpointSaleItem = $productClass->getPinpointSaleItem();
                return $pinpointSaleItem->getPrice();
            }
        }

        return $productClass->getPrice02();
    }

    /**
     * 商品価格（税込み）取得
     *
     * @param ProductClass $productClass
     * @return string
     */
    private function getProductPrice02IncTax(ProductClass $productClass)
    {
        if($this->isPinpointSale()) {
            // タイムセール併用時
            if ($productClass->getPinpointSaleItem()) {
                $pinpointSaleItem = $productClass->getPinpointSaleItem();
                return $pinpointSaleItem->getPriceIncTax();
            }
        }

        return $productClass->getPrice02IncTax();
    }

    /**
     * タイムセールプラグイン併用チェック
     *
     * @return bool true:利用
     */
    private function isPinpointSale()
    {
        $plugins = $this->container->getParameter('eccube.plugins.enabled');
        if (empty($plugins)) {
            return false;
        }

        $pluginsCheck = array_flip($plugins);
        return isset($pluginsCheck['PinpointSale']);
    }
}
