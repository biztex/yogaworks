<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/09
 */

namespace Plugin\QuantityDiscount\EventSubscriber;


use Eccube\Entity\Product;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;
use Plugin\QuantityDiscount\Service\TwigRenderService\TwigRenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminProductEventSubscriber implements EventSubscriberInterface
{

    /** @var TwigRenderService */
    protected $twigRenderService;

    /** @var QuantityDiscountService */
    protected $quantityDiscountService;

    public function __construct(
        TwigRenderService $twigRenderService,
        QuantityDiscountService $quantityDiscountService
    )
    {
        $this->twigRenderService = $twigRenderService;
        $this->quantityDiscountService = $quantityDiscountService;
    }

    /**
     * 商品詳細テンプレート
     *
     * @param TemplateEvent $event
     */
    public function onTemplateProductProduct(TemplateEvent $event)
    {

        $this->twigRenderService->initRenderService($event);

        /** @var Product $Product */
        $Product = $event->getParameter('Product');

        if ($Product->hasProductClass()) {
            // 規格あり商品
        } else {
            // 規格なし商品
            $this->twigRenderService
                ->insertBuilder()
                ->find('.c-primaryCol > div')
                ->eq(0)
                ->setTemplate('@QuantityDiscount/admin/Product/qd_area.twig')
                ->setTargetId('plugin_qd_block')
                ->setInsertModeAfter()
                ->setScript('@QuantityDiscount/admin/Product/qd_area_js.twig');

            $this->twigRenderService->addSupportSnippet();
        }

    }

    /**
     * 商品コピー完了
     *
     * @param EventArgs $event
     */
    public function onAdminProductCopyComplete(EventArgs $event)
    {
        // 商品コピー完了時
        $CopyProductClasses = $event->getArgument('CopyProductClasses');
        $this->quantityDiscountService->copyQdProductClasses($CopyProductClasses);
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     * * The method name to call (priority defaults to 0)
     * * An array composed of the method name to call and the priority
     * * An array of arrays composed of the method names to call and respective
     *   priorities, or 0 if unset
     *
     * For instance:
     *
     * * array('eventName' => 'methodName')
     * * array('eventName' => array('methodName', $priority))
     * * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            // 商品詳細
            '@admin/Product/product.twig' => ['onTemplateProductProduct'],
            // 商品コピー完了
            EccubeEvents::ADMIN_PRODUCT_COPY_COMPLETE => ['onAdminProductCopyComplete'],
        ];
    }
}
