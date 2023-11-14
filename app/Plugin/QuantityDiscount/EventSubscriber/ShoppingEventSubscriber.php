<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/28
 */

namespace Plugin\QuantityDiscount\EventSubscriber;


use Eccube\Event\TemplateEvent;
use Plugin\QuantityDiscount\Service\ConfigService;
use Plugin\QuantityDiscount\Service\TwigRenderService\TwigRenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ShoppingEventSubscriber implements EventSubscriberInterface
{

    /** @var TwigRenderService */
    protected $twigRenderService;

    /** @var ConfigService */
    protected $configService;

    public function __construct(
        TwigRenderService $twigRenderService,
        ConfigService $configService
    )
    {
        $this->twigRenderService = $twigRenderService;
        $this->configService = $configService;
    }

    public function onTemplateShopping(TemplateEvent $event)
    {
        if ($this->configService->isKeyBool(ConfigService::SETTING_KEY_SHOPPING_VIEW)) {
            $this->viewQuantityDiscount($event);
        }
    }

    public function onTemplateShoppingConfirm(TemplateEvent $event)
    {
        if ($this->configService->isKeyBool(ConfigService::SETTING_KEY_CONFIRM_VIEW)) {
            $this->viewQuantityDiscount($event);
        }
    }

    private function viewQuantityDiscount(TemplateEvent $event)
    {
        $this->twigRenderService->initRenderService($event);

        $child = $this->twigRenderService
            ->eachChildBuilder()
            ->findThis()
            ->targetFindAndIndexKey('#quantity_discount_', 'qdIndex')
            ->setInsertModeAppend();

        $this->twigRenderService
            ->eachBuilder()
            ->find('.ec-orderDelivery__item')
            ->find('.ec-imageGrid')
            ->find('.ec-imageGrid__content')
            ->setEachIndexKey('qdIndex')
            ->each($child->build());

        $this->twigRenderService->addSupportSnippet('@QuantityDiscount/default/Shopping/index_ex.twig');
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
            'Shopping/index.twig' => ['onTemplateShopping'],
            'Shopping/confirm.twig' => ['onTemplateShoppingConfirm'],
        ];
    }
}
