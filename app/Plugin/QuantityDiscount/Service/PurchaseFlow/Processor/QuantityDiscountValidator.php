<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/24
 */

namespace Plugin\QuantityDiscount\Service\PurchaseFlow\Processor;


use Eccube\Annotation\ShoppingFlow;
use Eccube\Entity\ItemInterface;
use Eccube\Entity\OrderItem;
use Eccube\Service\PurchaseFlow\InvalidItemException;
use Eccube\Service\PurchaseFlow\ItemValidator;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;

/**
 * @ShoppingFlow
 *
 * Class QuantityDiscountValidator
 * @package Plugin\QuantityDiscount\Service\PurchaseFlow\Processor
 */
class QuantityDiscountValidator extends ItemValidator
{

    /** @var QuantityDiscountService */
    protected $quantityDiscountService;

    /**
     * PriceResetValidator constructor.
     * @param QuantityDiscountService $quantityDiscountService
     */
    public function __construct(QuantityDiscountService $quantityDiscountService)
    {
        $this->quantityDiscountService = $quantityDiscountService;
    }

    /**
     * 妥当性検証を行う.
     *
     * @param ItemInterface $item
     * @param PurchaseContext $context
     * @throws InvalidItemException
     */
    protected function validate(ItemInterface $item, PurchaseContext $context)
    {

        if (!$item->isDiscount()) {
            return;
        }

        if ($item instanceof OrderItem) {

            if ($item->getProcessorName() == QuantityDiscountDiscountProcessor::class) {

                // 注文上のまとめ買い値引額
                $orderDiscount = $item->getPriceIncTax();

                // 最新のまとめ買い値引き額
                $nowDiscountIncTax = $this->quantityDiscountService->getDiscountPriceOneIncTax($item);

                if (abs($orderDiscount) != abs($nowDiscountIncTax)) {
                    // 値引き額が変更されている
                    $this->throwInvalidItemException('quantity_discount.front.quantity_discount_change', $item->getProductClass());
                }
            }
        }
    }
}
