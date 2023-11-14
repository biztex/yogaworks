<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/05/12
 */

namespace Plugin\QuantityDiscount\Service\PurchaseFlow\Processor;


use Eccube\Entity\ItemHolderInterface;
use Eccube\Entity\Order;
use Eccube\Service\PurchaseFlow\ItemHolderPreprocessor;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Plugin\QuantityDiscount\Service\ConfigService;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;

class PriceResetShippingPreprocessor implements ItemHolderPreprocessor
{

    protected $configService;

    /** @var QuantityDiscountService  */
    protected $quantityDiscountService;

    public function __construct(
        ConfigService $configService,
        QuantityDiscountService $quantityDiscountService
    )
    {
        $this->configService = $configService;
        $this->quantityDiscountService = $quantityDiscountService;
    }

    /**
     * 受注データ調整処理。
     *
     * @param ItemHolderInterface $itemHolder
     * @param PurchaseContext $context
     */
    public function process(ItemHolderInterface $itemHolder, PurchaseContext $context)
    {

        if(ConfigService::DISCOUNT_MODE_DIRECT ==
            $this->configService->getKeyInteger(ConfigService::SETTING_KEY_MODE)) {

            // 直接値引+値引き前送料無料での判定の場合の送料無料判定後に値引く
            if(ConfigService::DISCOUNT_BEFORE_PRICE ==
                $this->configService->getKeyInteger(ConfigService::SETTING_KEY_DELIVERY_FEE_MODE)) {
                if ($itemHolder instanceof Order) {
                    $Order = $itemHolder;
                    foreach ($Order->getShippings() as $shipping) {
                        foreach ($shipping->getProductOrderItems() as $item) {
                            if($this->quantityDiscountService->isDiscount($item)) {
                                $discountPrice = $this->quantityDiscountService->getProductClassPrice($item);
                                $item->setPrice($discountPrice);
                            }
                        }
                    }
                }
            }

            return;
        }

        // 金額を元に戻す
        if($itemHolder instanceof Order) {
            $Order = $itemHolder;
            foreach ($Order->getShippings() as $shipping) {
                foreach ($shipping->getProductOrderItems() as $item) {
                    $realPrice = $item->getProductClass()->getPrice02();
                    $item->setPrice($realPrice);
                }
            }
        }
    }

}
