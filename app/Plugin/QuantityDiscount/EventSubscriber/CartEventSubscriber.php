<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/27
 */

namespace Plugin\QuantityDiscount\EventSubscriber;


use Eccube\Entity\BaseInfo;
use Eccube\Entity\Cart;
use Eccube\Entity\CartItem;
use Eccube\Event\TemplateEvent;
use Eccube\Repository\BaseInfoRepository;
use Plugin\QuantityDiscount\Service\ConfigService;
use Plugin\QuantityDiscount\Service\TwigRenderService\TwigRenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CartEventSubscriber implements EventSubscriberInterface
{

    /** @var TwigRenderService  */
    protected $twigRenderService;

    /** @var ConfigService  */
    protected $configService;

    /** @var BaseInfo  */
    protected $baseInfo;

    public function __construct(
        TwigRenderService $twigRenderService,
        ConfigService $configService,
        BaseInfoRepository $baseInfoRepository
    )
    {
        $this->twigRenderService = $twigRenderService;
        $this->configService = $configService;
        $this->baseInfo = $baseInfoRepository->get();
    }

    /**
     * カート テンプレート
     *
     * @param TemplateEvent $event
     */
    public function onTemplateCartIndex(TemplateEvent $event)
    {

        if (ConfigService::DISCOUNT_BEFORE_PRICE
            == $this->configService->getKeyInteger(ConfigService::SETTING_KEY_DELIVERY_FEE_MODE)) {

            $Carts = $event->getParameter('Carts');
            $least = $event->getParameter('least');
            $isDeliveryFree = $event->getParameter('is_delivery_free');

            /** @var Cart $Cart */
            foreach ($Carts as $Cart) {

                if ($this->baseInfo->getDeliveryFreeAmount()) {

                    $subTotal = 0;
                    /** @var CartItem $cartItem */
                    foreach ($Cart->getCartItems() as $cartItem) {
                        $subTotal += $cartItem->getProductClass()->getPrice02IncTax() * $cartItem->getQuantity();
                    }

                    if (!$isDeliveryFree[$Cart->getCartKey()] && $this->baseInfo->getDeliveryFreeAmount() <= $subTotal) {
                        $isDeliveryFree[$Cart->getCartKey()] = true;
                    } else {
                        $least[$Cart->getCartKey()] = $this->baseInfo->getDeliveryFreeAmount() - $subTotal;
                    }
                }
            }

            $event->setParameter('least', $least);
            $event->setParameter('is_delivery_free', $isDeliveryFree);
        }

        if($this->configService->isKeyBool(ConfigService::SETTING_KEY_CART_VIEW)) {

            $this->twigRenderService->initRenderService($event);

            $eachChild = $this->twigRenderService
                ->eachChildBuilder()
                ->findThis()
                ->targetFindAndIndexKey('#quantity_discount_', 'qdIndex')
                ->setInsertModeAppend();

            $this->twigRenderService
                ->eachBuilder()
                ->find('.ec-cartRow')
                ->find('.ec-cartRow__summary')
                ->setEachIndexKey('qdIndex')
                ->each($eachChild->build());

            $this->twigRenderService->addSupportSnippet('@QuantityDiscount/default/Cart/index_ex.twig');
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
            'Cart/index.twig' => ['onTemplateCartIndex']
        ];
    }
}
