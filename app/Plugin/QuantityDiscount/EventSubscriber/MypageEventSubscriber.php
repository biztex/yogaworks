<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/24
 */

namespace Plugin\QuantityDiscount\EventSubscriber;


use Eccube\Entity\Order;
use Eccube\Entity\OrderItem;
use Eccube\Entity\ProductClass;
use Eccube\Entity\Shipping;
use Eccube\Event\TemplateEvent;
use Plugin\QuantityDiscount\Service\ConfigService;
use Plugin\QuantityDiscount\Service\PurchaseFlow\Processor\QuantityDiscountDiscountProcessor;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;
use Plugin\QuantityDiscount\Service\TwigRenderService\TwigRenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MypageEventSubscriber implements EventSubscriberInterface
{

    /** @var QuantityDiscountService */
    protected $quantityDiscountService;

    /** @var TwigRenderService */
    protected $twigRenderService;

    /** @var ConfigService */
    protected $configService;

    public function __construct(
        QuantityDiscountService $quantityDiscountService,
        TwigRenderService $twigRenderService,
        ConfigService $configService
    )
    {
        $this->quantityDiscountService = $quantityDiscountService;
        $this->twigRenderService = $twigRenderService;
        $this->configService = $configService;
    }

    /**
     * MYページ注文履歴　テンプレート
     *
     * @param TemplateEvent $event
     */
    public function onTemplateMypageHistory(TemplateEvent $event)
    {

        $this->twigRenderService->initRenderService($event);

        // 値引き額取得
        $quantityDiscounts = [];
        /** @var Order $Order */
        $Order = $event->getParameter('Order');
        /** @var OrderItem $orderItem */
        foreach ($Order->getItems() as $orderItem) {
            if ($orderItem->getProcessorName() == QuantityDiscountDiscountProcessor::class) {
                $shipping_id = $orderItem->getShipping()->getId();
                $product_class_id = $orderItem->getProductClass()->getId();
                $key = $shipping_id . '-' . $product_class_id;
                $quantityDiscounts[$key] = abs($orderItem->getPriceIncTax() * $orderItem->getQuantity());
            }
        }

        $event->setParameter('QuantityDiscounts', $quantityDiscounts);

        $childes = [];

        if ($this->configService->isKeyBool(ConfigService::SETTING_KEY_HISTORY_VIEW)) {


            $childes[] = $this->twigRenderService
                ->eachChildBuilder()
                ->findThis()
                ->find('.ec-imageGrid__content')
                ->targetFindAndIndexKey('#quantity_discount_history_', "qdIndex")
                ->setInsertModeAppend();

            $childes[] = $this->twigRenderService
                ->eachChildBuilder()
                ->findThis()
                ->find('.ec-imageGrid__content')
                ->targetFindAndIndexKey('#quantity_discount_', "qdIndex")
                ->setInsertModeAppend();

        }

        if (count($quantityDiscounts) == 0) {
            // 現在価格の調整
            $childes[] = $this->twigRenderService
                ->eachChildBuilder()
                ->findThis()
                ->find('.ec-imageGrid__content')
                ->find(".ec-color-accent:contains(\"現在価格\")")
                ->eq(0)
                ->targetFindAndIndexKey('#replace_quantity_discount_history_', "qdIndex")
                ->setInsertModeReplaceWith();
        } else {
            // まとめ買い現在価格の追加
            $childes[] = $this->twigRenderService
                ->eachChildBuilder()
                ->findThis()
                ->find('.ec-imageGrid__content')
                ->eq(0)
                ->targetFindAndIndexKey('#replace_quantity_discount_history_', "qdIndex")
                ->setInsertModeAppend();
        }

        $this->twigRenderService
            ->eachBuilder()
            ->find('.ec-orderDelivery__item')
            ->setEachIndexKey('qdIndex')
            ->each($childes);

        // 注意文言調整
        // 削除用
        $this->twigRenderService
            ->insertBuilder()
            ->find('.ec-orderRole__summary')
            ->find('.ec-color-accent')
            ->setTargetId('qd_no_diff')
            ->setInsertModeReplaceWith();

        // 追加用
        $this->twigRenderService
            ->insertBuilder()
            ->find('.ec-orderRole__summary')
            ->setTargetId('qd_in_diff')
            ->setInsertModeAppend();

        $this->twigRenderService->addSupportSnippet('@QuantityDiscount/default/Mypage/history_ex.twig');

    }

    public function onTemplateMypageHistoryChangePrice(TemplateEvent $event)
    {

        /** @var Order $Order */
        $Order = $event->getParameter('Order');

        /** @var Shipping $Shipping */
        foreach ($Order->getShippings() as $Shipping) {

            /** @var OrderItem $orderItem */
            foreach ($Shipping->getOrderItems() as $orderItem) {

                /** @var ProductClass $ProductClass */
                $ProductClass = $orderItem->getProductClass();
                if ($ProductClass) {

                    // まとめ買い値引額(税込み)
                    $discountPrice = $this->quantityDiscountService->getProductClassPriceIncTax($orderItem);

                    if ($discountPrice >= 0) {
                        $ProductClass->setPrice02IncTax($discountPrice);
                    }
                }
            }
        }

    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'Mypage/history.twig' => [
                ['onTemplateMypageHistory'],
//                ['onTemplateMypageHistoryChangePrice', -1024],
            ]
        ];
    }
}
