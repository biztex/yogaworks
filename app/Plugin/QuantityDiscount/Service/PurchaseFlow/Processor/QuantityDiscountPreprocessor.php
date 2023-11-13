<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/23
 */

namespace Plugin\QuantityDiscount\Service\PurchaseFlow\Processor;


use Eccube\Annotation\CartFlow;
use Eccube\Annotation\ShoppingFlow;
use Eccube\Entity\ItemInterface;
use Eccube\Entity\OrderItem;
use Eccube\Service\PurchaseFlow\ItemPreprocessor;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Plugin\QuantityDiscount\Service\ConfigService;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;

/**
 * @CartFlow
 * @ShoppingFlow
 *
 * Class QuantityDiscountPreprocessor
 * @package Plugin\QuantityDiscount\Service\PurchaseFlow\Processor
 */
class QuantityDiscountPreprocessor implements ItemPreprocessor
{
    /** @var QuantityDiscountService */
    protected $quantityDiscountService;

    /** @var ConfigService  */
    protected $configService;

    public function __construct(
        QuantityDiscountService $quantityDiscountService,
        ConfigService $configService
    )
    {
        $this->quantityDiscountService = $quantityDiscountService;
        $this->configService = $configService;
    }

    /**
     * 受注データ調整処理。
     *
     * @param ItemInterface $item
     * @param PurchaseContext $context
     */
    public function process(ItemInterface $item, PurchaseContext $context)
    {
        if (!$item->isProduct()) {
            return;
        }

        if ($item instanceof OrderItem) {
            // OrderItem
            $incTax = false;

            if (ConfigService::DISCOUNT_BEFORE_PRICE
                == $this->configService->getKeyInteger(ConfigService::SETTING_KEY_DELIVERY_FEE_MODE)) {
                return;
            }

        } else {
            // CartItem
            $incTax = true;
        }

        // 直接値引
        if($incTax) {
            $discountPrice = $this->quantityDiscountService->getProductClassPriceIncTax($item);
        } else {
            $discountPrice = $this->quantityDiscountService->getProductClassPrice($item);
        }

        if ($discountPrice < 0) {
            return;
        }

        $item->setPrice($discountPrice);
    }
}
