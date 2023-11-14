<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/16
 */

namespace Plugin\QuantityDiscount\EventSubscriber;


use Eccube\Event\TemplateEvent;
use Plugin\QuantityDiscount\Service\TwigRenderService\builder\EachChildContentBlockBuilder;
use Plugin\QuantityDiscount\Service\TwigRenderService\TwigRenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminProductClassEventSubscriber implements EventSubscriberInterface
{

    /** @var TwigRenderService */
    protected $twigRenderService;

    public function __construct(
        TwigRenderService $twigRenderService
    )
    {
        $this->twigRenderService = $twigRenderService;
    }

    /**
     * 規格画面　テンプレート
     *
     * @param TemplateEvent $event
     */
    public function onTemplateProductProductClass(TemplateEvent $event)
    {

        $this->twigRenderService->initRenderService($event);

        $insertPositionCol = 7;

        $this->twigRenderService
            ->insertBuilder()
            ->find('#ex-product_class')
            ->find('th')->eq($insertPositionCol)
            ->setTargetId('plugin_qd_area_title')
            ->setInsertModeAfter();

        // リスト
        $eachChild = $this->twigRenderService->eachChildBuilder();
        $eachChild
            ->findAndDataKey('#ex-product_class-', 'product_class_name')
            ->find('td')
            ->eq($insertPositionCol)
            ->targetFindThis()
            ->targetFind('td')
            ->setInsertModeAfter();

        $this->twigRenderService
            ->eachBuilder()
            ->find('.product_class_qd_area_target')
            ->each($eachChild->build());

        $this->twigRenderService->addSupportSnippet(
            '@QuantityDiscount/admin/Product/product_class_qd_area.twig',
            '@QuantityDiscount/admin/Product/product_class_qd_area_js.twig'
        );
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
            '@admin/Product/product_class.twig' => ['onTemplateProductProductClass']
        ];
    }
}
