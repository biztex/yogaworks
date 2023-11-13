<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/04/02
 */

namespace Plugin\QuantityDiscount\EventSubscriber;


use Eccube\Entity\Product;
use Eccube\Event\TemplateEvent;
use Plugin\QuantityDiscount\Service\ConfigService;
use Plugin\QuantityDiscount\Service\QuantityDiscountService;
use Plugin\QuantityDiscount\Service\TwigRenderService\TwigRenderService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * まとめ買い値引リスト表示サポート
 *
 * Class ProductEventSubscriber
 * @package Plugin\QuantityDiscount\EventSubscriber
 */
class ProductEventSubscriber implements EventSubscriberInterface
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
     * 商品詳細 テンプレート
     *
     * @param TemplateEvent $event
     */
    public function onTemplateProductDetail(TemplateEvent $event)
    {

        if ($this->configService->isKeyBool(ConfigService::SETTING_KEY_DETAIL_LIST_VIEW)) {

            // 一覧表示用CSS
            $event->addAsset('@QuantityDiscount/default/Product/detail_ex_css.twig');

            // 規格選択時のBold JS
            $event->addSnippet('@QuantityDiscount/default/Product/detail_ex_js.twig');

            // 一覧挿入
            $this->twigRenderService->initRenderService($event);

            $insertBuilder = $this->twigRenderService->insertBuilder();

            if($this->configService->getKeyInteger(ConfigService::SETTING_KEY_DETAIL_LIST_POSITION)
                == ConfigService::DISCOUNT_POSITION_DETAIL) {

                $insertBuilder
                    ->find('.ec-productRole__profile')
                    ->eq(0);

            } else {

                $insertBuilder
                    ->find('.ec-productRole__actions')
                    ->eq(0);
            }

            $insertBuilder
                ->setTemplate("@QuantityDiscount/default/Product/detail_ex.twig")
                ->setTargetId("qd_list")
                ->setInsertModeAppend();

            $this->twigRenderService->addSupportSnippet();
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
            'Product/detail.twig' => ['onTemplateProductDetail']
        ];
    }
}
