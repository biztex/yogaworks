<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/23
 */

namespace Plugin\QuantityDiscount\Service\PurchaseFlow\Processor;


use Eccube\Entity\CartItem;
use Eccube\Entity\ItemInterface;
use Eccube\Entity\OrderItem;
use Eccube\Service\PurchaseFlow\ItemValidator;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;
use Psr\Container\ContainerInterface;

class PriceResetValidator extends ItemValidator
{

    protected $quantityDiscountService;

    protected $container;

    public function __construct(QuantityDiscountService $quantityDiscountService, ContainerInterface $container)
    {
        $this->quantityDiscountService = $quantityDiscountService;
        $this->container = $container;
    }

    /**
     * 妥当性検証を行う.
     *
     * @param ItemInterface|CartItem|OrderItem $item
     * @param PurchaseContext $context
     */
    protected function validate(ItemInterface $item, PurchaseContext $context)
    {

        log_info("PriceResetValidator Start");

        if (!$item->isProduct()) {
            return;
        }

        $discountPriceCheck = true;

        if ($item instanceof OrderItem) {
            $realPrice = $item->getProductClass()->getPrice02();

            if (!$this->quantityDiscountService->isDiscount($item)) {
                // まとめ買いでない場合は戻さない
                return;
            }
            $discountPrice = $this->quantityDiscountService->getProductClassPrice($item);

        } else {
            $realPrice = $item->getProductClass()->getPrice02IncTax();
            $discountPrice = $this->quantityDiscountService->getProductClassPriceIncTax($item);

            // カート判定
            $request = $this->container->get('request_stack')->getCurrentRequest();
            $productClassId = $request->get('productClassId');

            // 数量が変更された商品のチェック制御
            if (!is_null($productClassId)
                && $productClassId == $item->getProductClass()->getId()) {

                // up or down
                $operation = $request->get('operation');

                if ($operation == "down") {
                    $checkQuantity = (int)$item->getQuantity() + 1;

                    if ($this->quantityDiscountService->isDiscount($item)) {
                        // まとめ買い
                        // まとめ買い→まとめ買いは金額チェックなし
                        $discountPriceCheck = false;

                    } else {
                        // まとめ買い→通常チェック
                        // 数量を減らした場合 +1 がまとめ買いの場合に元へ戻す
                        if ($this->quantityDiscountService->isDiscount($item, $checkQuantity)) {
                            $discountPrice = $this->quantityDiscountService->getProductClassPriceIncTax($item, $checkQuantity);
                        } else {
                            // 数量 +1 した場合もまとめ買いに該当しない場合
                            return;
                        }
                    }
                } elseif ($operation == "up") {
                    // 金額チェックなし
                    if ($this->quantityDiscountService->isDiscount($item)) {
                        // まとめ買い→まとめ買いは金額チェックなし
                        $discountPriceCheck = false;
                    } else {
                        // まとめ買い値引でない場合は、価格を戻さない
                        return;
                    }
                }
            } else {
                $discountPrice = $this->quantityDiscountService->getProductClassPriceIncTax($item);
            }
        }

        // 割引後価格の変更についてチェックを実施
        if($discountPriceCheck
            && $item->getPrice() != $discountPrice) {
            // 価格が変わっている場合通知する
            return;
        }

        // 商品価格を元に戻す
        $item->setPrice($realPrice);

        log_info("PriceResetValidator end");
    }
}
