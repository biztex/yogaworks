<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/28
 */

namespace Plugin\QuantityDiscount\Service\PurchaseFlow\Processor;


use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\ItemHolderInterface;
use Eccube\Entity\Master\OrderItemType;
use Eccube\Entity\Master\TaxDisplayType;
use Eccube\Entity\Master\TaxType;
use Eccube\Entity\Order;
use Eccube\Entity\OrderItem;
use Eccube\Entity\Shipping;
use Eccube\Repository\TaxRuleRepository;
use Eccube\Service\PurchaseFlow\DiscountProcessor;
use Eccube\Service\PurchaseFlow\ProcessResult;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\TaxRuleService;
use Plugin\QuantityDiscount\Service\ConfigService;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;

/**
 * ShoppingFlow
 *
 * Class QuantityDiscountHolderPreprocessor
 * @package Plugin\QuantityDiscount\Service\PurchaseFlow\Processor
 */
class QuantityDiscountDiscountProcessor implements DiscountProcessor
{

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var QuantityDiscountService */
    protected $quantityDiscountService;

    /** @var TaxRuleRepository */
    protected $taxRuleRepository;

    /** @var TaxRuleService */
    protected $taxRuleService;

    /** @var ConfigService */
    protected $configService;

    public function __construct(
        EntityManagerInterface $entityManager,
        QuantityDiscountService $quantityDiscountService,
        TaxRuleRepository $taxRuleRepository,
        TaxRuleService $taxRuleService,
        ConfigService $configService
    )
    {
        $this->entityManager = $entityManager;
        $this->quantityDiscountService = $quantityDiscountService;
        $this->configService = $configService;
        $this->taxRuleRepository = $taxRuleRepository;
        $this->taxRuleService = $taxRuleService;
    }

    /**
     * 値引き明細の削除処理を実装します.
     *
     * @param ItemHolderInterface $itemHolder
     * @param PurchaseContext $context
     */
    public function removeDiscountItem(ItemHolderInterface $itemHolder, PurchaseContext $context)
    {
        // 途中切り替えを考慮
        // 直接値引の場合も実施
        if ($itemHolder instanceof Order) {

            /** @var OrderItem $orderItem */
            foreach ($itemHolder->getItems() as $orderItem) {

                if ($orderItem->getProcessorName() == QuantityDiscountDiscountProcessor::class) {
                    $itemHolder->removeOrderItem($orderItem);
                    $this->entityManager->remove($orderItem);
                }
            }
        }
    }

    /**
     * 値引き明細の追加処理を実装します.
     *
     * かならず合計金額等のチェックを行い, 超える場合は利用できる金額まで丸めるか、もしくは明細の追加処理をスキップしてください.
     * 正常に追加できない場合は, ProcessResult::warnを返却してください.
     *
     * @param ItemHolderInterface $itemHolder
     * @param PurchaseContext $context
     *
     * @return ProcessResult|null
     * @throws \Doctrine\ORM\NoResultException
     */
    public function addDiscountItem(ItemHolderInterface $itemHolder, PurchaseContext $context)
    {

        if (ConfigService::DISCOUNT_MODE_DIRECT ==
            $this->configService->getKeyInteger(ConfigService::SETTING_KEY_MODE)) {
            // 直接値引の場合は値引レコード作成なし
            return null;
        }

        $DiscountType = $this->entityManager
            ->find(OrderItemType::class, OrderItemType::DISCOUNT);

        $TaxExcluded = $this->entityManager
            ->find(TaxDisplayType::class, TaxDisplayType::EXCLUDED);

        $TaxIncluded = $this->entityManager
            ->find(TaxDisplayType::class, TaxDisplayType::INCLUDED);

        $totalDiscount = 0;

        // 割引レコード用の設定取得
        $qdSettingTaxType = $this->configService->getKeyInteger(ConfigService::SETTING_KEY_DISCOUNT_TAX);
        $discountTaxType = $this->entityManager->find(TaxType::class, $qdSettingTaxType);

        if ($itemHolder instanceof Order) {
            /** @var Shipping $shipping */
            foreach ($itemHolder->getShippings() as $shipping) {
                /** @var OrderItem $orderItem */
                foreach ($shipping->getOrderItems() as $orderItem) {

                    if (!$orderItem->isProduct()) continue;

                    // まとめ買い値引きの設定
                    if ($this->quantityDiscountService->isDiscount($orderItem)) {

                        // 値引き額取得
                        if ($discountTaxType->getId() == TaxType::TAXATION) {
                            // 税抜き価格取得
                            $discount = $this->quantityDiscountService->getDiscountPriceOne($orderItem);
                        } else {
                            // 税込み価格取得
                            $discount = $this->quantityDiscountService->getDiscountPriceOneIncTax($orderItem);
                        }

                        if ($discount <= 0) {
                            // マイナスの場合（値上がりする場合）は値引レコードを作成しない
                            // 直接値引の動作にて金額をプラス
                            continue;
                        }

                        $quantity = $orderItem->getQuantity();
                        $calcDiscount = -1 * $discount;

                        // 合計金額チェック
                        if ($itemHolder->getSubtotal() <= ($totalDiscount + abs($calcDiscount) * $quantity)) {
                            // NG状態
                            // 金額を減らし数量１にする
                            $calcDiscount = $itemHolder->getSubtotal() - $totalDiscount;
                            $calcDiscount = $calcDiscount * -1;
                            $quantity = 1;
                        }

                        $totalDiscount += abs($calcDiscount);

                        $ProductClass = $orderItem->getProductClass();

                        $discountName = trans('quantity_discount.admin.discount_title', [
                            '%product_name%' => $ProductClass->getProduct()->getName()
                        ]);

                        $newOrderItem = new OrderItem();
                        $newOrderItem->setProductName($discountName)
                            ->setOrderItemType($DiscountType)
                            ->setPrice($calcDiscount)
                            ->setQuantity($quantity)
                            ->setTaxType($discountTaxType)
                            ->setProductClass($ProductClass)
                            ->setShipping($shipping)
                            ->setOrder($itemHolder)
                            ->setProcessorName(QuantityDiscountDiscountProcessor::class);

                        if ($orderItem->getTaxRuleId()) {
                            $TaxRule = $this->taxRuleRepository->find($orderItem->getTaxRuleId());
                        } else {
                            $TaxRule = $this->taxRuleRepository->getByRule($orderItem->getProduct(), $ProductClass);
                        }

                        // 税区分: 非課税, 不課税
                        if ($discountTaxType->getId() != TaxType::TAXATION) {
                            $newOrderItem->setTax(0);
                            $newOrderItem->setTaxRate(0);
                            $newOrderItem->setRoundingType(null);
                            $newOrderItem->setTaxRuleId(null);
                            $newOrderItem->setTaxDisplayType($TaxIncluded);

                            // 税込表示の場合は, priceが税込金額のため割り戻す.
                            $tax = $this->taxRuleService->calcTaxIncluded(
                                abs($calcDiscount), $TaxRule->getTaxRate(), $TaxRule->getRoundingType()->getId(),
                                $TaxRule->getTaxAdjust());

                        } else {

                            $tax = $this->taxRuleService->calcTax(
                                abs($calcDiscount), $TaxRule->getTaxRate(), $TaxRule->getRoundingType()->getId(),
                                $TaxRule->getTaxAdjust());

                            $newOrderItem->setTaxRate($TaxRule->getTaxRate());
                            $newOrderItem->setRoundingType($TaxRule->getRoundingType());
                            $newOrderItem->setTaxRuleId($TaxRule->getId());
                            $newOrderItem->setTaxDisplayType($TaxExcluded);
                        }

                        if ($calcDiscount < 0) {
                            $tax = -1 * $tax;
                        }

                        $newOrderItem->setTax($tax);

                        $itemHolder->addItem($newOrderItem);
                    }
                }
            }
        }

        return null;
    }
}
