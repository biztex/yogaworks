<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\Coupon4\Service\PurchaseFlow\Processor;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\DeliveryFee;
use Eccube\Entity\ItemHolderInterface;
use Eccube\Entity\Master\OrderItemType;
use Eccube\Entity\Master\TaxDisplayType;
use Eccube\Entity\Master\TaxType;
use Eccube\Entity\Order;
use Eccube\Entity\OrderItem;
use Eccube\Entity\Shipping;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\DeliveryFeeRepository;
use Eccube\Repository\TaxRuleRepository;
use Eccube\Service\PurchaseFlow\ItemHolderPreprocessor;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\Processor\DeliveryFeePreprocessor;

use Plugin\Coupon4\Repository\CouponOrderRepository;
use Plugin\Coupon4\Repository\CouponRepository;
/**
 * 送料明細追加.
 */
class CouponFreeFeeProcessor implements ItemHolderPreprocessor
{
    /**
     * @var DeliveryFeeRepository
     */
    protected $deliveryFeeRepository;

    /**
     * DeliveryFeePreprocessor constructor.
     *
     * @param DeliveryFeeRepository $deliveryFeeRepository
     * @param BaseInfoRepository $baseInfoRepository
     */
    public function __construct(
        DeliveryFeeRepository $deliveryFeeRepository,
        CouponOrderRepository $couponOrderRepository,
        CouponRepository $couponRepository,
        BaseInfoRepository $baseInfoRepository
    ) {

        $this->deliveryFeeRepository = $deliveryFeeRepository;
        $this->couponOrderRepository = $couponOrderRepository;
        $this->couponRepository = $couponRepository;
        $this->baseInfoRepository = $baseInfoRepository;
    }

    /**
     * @param ItemHolderInterface $itemHolder
     * @param PurchaseContext $context
     */
    public function process(ItemHolderInterface $itemHolder, PurchaseContext $context)
    {
        $this->updateDeliveryFeeItem($itemHolder);
    }

    /**
     * @param ItemHolderInterface $itemHolder
     */
    private function updateDeliveryFeeItem(ItemHolderInterface $itemHolder)
    {

        /** @var Order $Order */
        $Order = $itemHolder;
		$CouponOrder = $this->couponOrderRepository->getCouponOrder($Order->getPreOrderId());
		if ($CouponOrder!=null){
			$Coupon = $this->couponRepository->find($CouponOrder->getCouponId());
			if($Coupon!=null){
				$isFreeShipping = $Coupon->getFreeShipping() == null ? 2 : $Coupon->getFreeShipping();
				if ($isFreeShipping==1){
					/* @var Shipping $Shipping */
					foreach ($Order->getShippings() as $Shipping) {
						/** @var OrderItem $item */
						foreach ($Shipping->getOrderItems() as $item) {
							if ($item->isDeliveryFee()) {
								$item->setQuantity(0);
							}
						}
					}
				}
				
				$isFreeFee = $Coupon->getFreeFee() == null ? 2 : $Coupon->getFreeFee();
				if ($isFreeFee==1 && $Order->getPaymentMethod()=='代金引換'){
					/* @var Shipping $Shipping */
					foreach ($Order->getOrderItems() as $item) {				
						
							if ($item->isCharge()) {
								$item->setPrice(0);
							}
					}
				}
			}
		}
    }
}
