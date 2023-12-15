<?php

namespace Plugin\ProductReserve4;

use Carbon\Carbon;
use Eccube\Entity\Order;
use Eccube\Entity\Product;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Repository\OrderRepository;
use Eccube\Repository\ProductRepository;
use Eccube\Request\Context;
use Eccube\Common\EccubeConfig;

use Eccube\Controller\ProductController;

use Plugin\ProductReserve4\Repository\ProductClassExtraRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\HttpFoundation\JsonResponse;

use Plugin\ProductReserve4\Repository\ConfigRepository;
use Plugin\ProductReserve4\Repository\ProductExtraRepository;
use Plugin\ProductReserve4\Service\ProductReserveService;

class Event implements EventSubscriberInterface
{
    private $context;
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * @var ProductExtraRepository
     */
    private $productExtraRepository;

    /**
     * @var ProductClassExtraRepository
     */
    private $productClassExtraRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var ProductReserveService
     */
    private $reserveService;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    const PRIORITY_CONFIG = __DIR__ . "/Resource/priority.config";

    public function __construct(
        Context $context,
        ConfigRepository $configRepository,
        ProductExtraRepository $productExtraRepository,
        ProductClassExtraRepository $productClassExtraRepository,
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        ProductReserveService $reserveService,
        EccubeConfig $eccubeConfig
    )
    {
        $this->context = $context;
        $this->configRepository = $configRepository;
        $this->productExtraRepository = $productExtraRepository;
        $this->productClassExtraRepository = $productClassExtraRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->reserveService = $reserveService;
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        if (\is_file(self::PRIORITY_CONFIG)) {
            $content = \file_get_contents(self::PRIORITY_CONFIG);
            $priority = ($content == "on") ? -1 : 0;
        } else {
            $priority = 0;
        }
        return [
            'Product/detail.twig' => 'onProductDetailView',
            'Product/list.twig' => 'onProductListView',
            'Shopping/index.twig' => 'onShopping',
            'Shopping/confirm.twig' => 'onShoppingConfirm',
            '@admin/Product/product.twig' => 'onAdminProductEditView',
            '@admin/Product/product_class.twig' => 'onAdminProductClassEditView',
            EccubeEvents::ADMIN_PRODUCT_EDIT_COMPLETE => 'onAdminProductEditComplete',
            EccubeEvents::FRONT_PRODUCT_CART_ADD_COMPLETE => 'onFrontProductCarTAddComplete',
            EccubeEvents::FRONT_SHOPPING_COMPLETE_INITIALIZE => ['onFrontShoppingCompleteInitialize', $priority],
            EccubeEvents::MAIL_ORDER => 'onMailOrder',
//            KernelEvents::CONTROLLER => ['onController', 1],
        ];
    }

    /**
     * @param TemplateEvent $event
     */
    public function onProductDetailView(TemplateEvent $event) {
        $twig = '@ProductReserve4/default/Product/product_detail.twig';
        $event->addSnippet($twig);
        $parameters = $event->getParameters();
        $product_id = $parameters['Product']->getId();
        $extra = $this->productExtraRepository->get($product_id);
        $product_reserve_status = $this->reserveService->getProductReserveStatus($extra);
        $parameters['productreserve4_reserve_status'] = $product_reserve_status;
        $parameters['productreserve4_has_class_detail'] = false;
        if( $product_reserve_status != ProductReserveService::STATUS_NORMAL ) {
            $shippingDate = $extra->getShippingDate()? $extra->getShippingDate()->format('Y年n月j日 H:i'):trans('plugin_reserve4.admin.no_shipping_date');
            $startDate = $extra->getStartDate()? $extra->getStartDate()->format('Y年n月j日 H:i'):false;
            $endDate = $extra->getEndDate()? $extra->getEndDate()->format('Y年n月j日 H:i'):false;

            $product_reserve = [
                'product_id' => $extra->getProductId(),
                'product_reserve_status' => $product_reserve_status,
                'shipping_date' => $shippingDate,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
            $parameters['productreserve4_detail'] = $product_reserve;
        } else {
            $productClassExtras = $this->productClassExtraRepository->findBy(['Product' => $product_id]);
            $classList = [];
            foreach ($productClassExtras as $classExtra) {
                $product_reserve_status = $this->reserveService->getProductClassReserveStatus($classExtra);
                if ($product_reserve_status != ProductReserveService::STATUS_NORMAL) {
                    $shippingDate = $classExtra->getShippingDate() ? $classExtra->getShippingDate()->format('Y年n月j日 H:i') : trans('plugin_reserve4.admin.no_shipping_date');
                    $startDate = $classExtra->getStartDate() ? $classExtra->getStartDate()->format('Y年n月j日 H:i') : false;
                    $endDate = $classExtra->getEndDate() ? $classExtra->getEndDate()->format('Y年n月j日 H:i') : false;
                    $classList[] = [
                        'product_id' => $classExtra->getProduct()->getId(),
                        'product_class_id' => $classExtra->getProductClass()->getId(),
                        'product_class_category_id1' => $classExtra->getClassCategory1()->getId(),
                        'product_class_category_id2' => $classExtra->getClassCategory2()?$classExtra->getClassCategory2()->getId():0,
                        'product_reserve_status' => $product_reserve_status,
                        'shipping_date' => $shippingDate,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ];
                }

            }
            if($classList !== []){
                $parameters['product_id'] = $product_id;
                $parameters['productreserve4_class_detail'] = $classList;
                $parameters['productreserve4_has_class_detail'] = true;
            }
        }

        $event->setParameters($parameters);
    }

    /**
     * @param TemplateEvent $event
     */
    public function onProductListView(TemplateEvent $event) {
        $twig = '@ProductReserve4/default/Product/product_list.twig';
        $event->addSnippet($twig);
        $parameters = $event->getParameters();
        $pagination = $parameters['pagination'];
        $product_ids = [];
        foreach($pagination as $product) {
            $product_ids[] = $product->getId();
        }
        $results = $this->reserveService->getProductExtrList($product_ids);
        $list = [];
        $classList = [];
        foreach($results['ProductExtras'] as $extra) {
            $product_reserve_status = $this->reserveService->getProductReserveStatus($extra);
            if( $product_reserve_status != ProductReserveService::STATUS_NORMAL ) {
                $shippingDate = $extra->getShippingDate()? $extra->getShippingDate()->format('Y年n月j日 H:i'):trans('plugin_reserve4.admin.no_shipping_date');
                $startDate = $extra->getStartDate()? $extra->getStartDate()->format('Y年n月j日 H:i'):false;
                $endDate = $extra->getEndDate()? $extra->getEndDate()->format('Y年n月j日 H:i'):false;
                $list[] = [
                    'product_id' => $extra->getProductId(),
                    'product_reserve_status' => $product_reserve_status,
                    'shipping_date' => $shippingDate,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    ];
            } else {
                foreach ($results['ProductClassExtras'] as $classExtra){
                    if($classExtra->getProduct()->getId() == $extra->getProductId()){
                        $product_reserve_status = $this->reserveService->getProductClassReserveStatus($classExtra);
                        if( $product_reserve_status != ProductReserveService::STATUS_NORMAL ) {
                            $shippingDate = $classExtra->getShippingDate() ? $classExtra->getShippingDate()->format('Y年n月j日 H:i') : trans('plugin_reserve4.admin.no_shipping_date');
                            $startDate = $classExtra->getStartDate() ? $classExtra->getStartDate()->format('Y年n月j日 H:i') : false;
                            $endDate = $classExtra->getEndDate() ? $classExtra->getEndDate()->format('Y年n月j日 H:i') : false;
                            $classList[] = [
                                'product_id' => $classExtra->getProduct()->getId(),
                                'product_class_id' => $classExtra->getProductClass()->getId(),
                                'product_class_category_id1' => $classExtra->getClassCategory1()->getId(),
                                'product_class_category_id2' => $classExtra->getClassCategory2()?$classExtra->getClassCategory2()->getId():0,
                                'product_reserve_status' => $product_reserve_status,
                                'shipping_date' => $shippingDate,
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                            ];
                        }
                    }
                }
            }
        }

        $parameters['productreserve4_list'] = $list;
        $parameters['productreserve4_class_list'] = $classList;
        $event->setParameters($parameters);
    }

    protected function procShipping($event)
    {
        $parameters = $event->getParameters();
        $Order = $parameters['Order'];
        $result = $this->reserveService->canReserveOrder($Order);
        $is_reserve_order = $result == ProductReserveService::ERROR_SUCCESS_RESERVE;
        $is_can_order = ($result == ProductReserveService::ERROR_SUCCESS_NORMAL) || ($result == ProductReserveService::ERROR_SUCCESS_RESERVE);
        $is_normal_order = $is_can_order && !$is_reserve_order;
        $parameters['productreserve4_is_normal_order'] = $is_normal_order;
        $parameters['productreserve4_reserve_status'] = $result;

        if ($is_normal_order) {
            $event->setParameters($parameters);
            return;
        }

        $items = $Order->getItems();
        $list = [];

        foreach($items as $OrderItem) {
            if( !$OrderItem->isProduct() )  {
                continue;
            }
            $Product = $OrderItem->getProduct();
            $ProductClass = $OrderItem->getProductClass();
            if( !$Product ) {
                continue;
            }
            $product_id = $Product->getId();
            $product_reserve_status = $this->reserveService->getProductReserveStatus($product_id);
            if($product_reserve_status == ProductReserveService::STATUS_NORMAL){
                $product_class_reserve_status = $this->reserveService->getProductClassReserveStatus($ProductClass->getId());
                $product_reserve_status = $product_class_reserve_status;
                if($product_class_reserve_status == ProductReserveService::STATUS_RESERVE) {
                    $reserve = $this->productClassExtraRepository->getByProductClassId($ProductClass->getId());
                } else {
                    $reserve = null;
                }
            } else {
                $reserve = $this->productExtraRepository->get($product_id);
            }
            if($reserve) {
                $shippingDate = $reserve->getShippingDate()? $reserve->getShippingDate()->format('Y年n月j日 H:i'):trans('plugin_reserve4.admin.no_shipping_date');
            } else {
                $shippingDate = '';
            }
            $list[] = [
                'reserve_status' => $product_reserve_status,
                'shipping_date' => $shippingDate,
            ];
        }
        $parameters['productreserve4_list'] = $list;
        $event->setParameters($parameters);
    }

    public function onShopping(TemplateEvent $event) {
        $twig = '@ProductReserve4/default/Shopping/shopping.twig';
        $event->addSnippet($twig);
        $this->procShipping($event);
    }

    public function onShoppingConfirm(TemplateEvent $event) {
        $twig = '@ProductReserve4/default/Shopping/shopping_confirm.twig';
        $event->addSnippet($twig);
        $this->procShipping($event);
    }

    /**
     * @param TemplateEvent $event
     */
    public function onAdminProductEditView(TemplateEvent $event) {
        $twig = '@ProductReserve4/admin/Product/reservation_field.twig';
        $event->addSnippet($twig);
        $parameters = $event->getParameters();
        $parameters['reserve_start_date_default'] = Carbon::now()->format('Y/m/d');
        $event->setParameters($parameters);
    }

    public function onAdminProductClassEditView(TemplateEvent $event){
        $twig = '@ProductReserve4/admin/Product/class_reservation_field.twig';
        $event->addSnippet($twig);
        $parameters = $event->getParameters();
        $parameters['reserve_start_date_default'] = Carbon::now()->format('Y/m/d');
        $event->setParameters($parameters);
    }

    public function onAdminProductEditComplete(EventArgs $event) {
        $form = $event->getArgument('form');
        $Product = $event->getArgument('Product');

        $product_id = $Product->getId();
        $productExtra = $this->productExtraRepository->get($product_id);

        $isPrevNormal = true;
        if( $productExtra == null || !$productExtra->isAllowed() ) {
            $old_shippingDate = false;
        } else {
            $isPrevNormal = false;
            $old_shippingDate = $productExtra->getShippingDate();
            if( $old_shippingDate ) {
                $old_shippingDate = $productExtra->getShippingDate()? $productExtra->getShippingDate()->format("Y年n月j日 H:i"):false;
            } else {
                $old_shippingDate = false;
            }
        }

        $this->productExtraRepository->set($product_id, $form);
        $isAllowed = $form->get('reservation_isAllowed')->getData();
        if( $isPrevNormal || !$isAllowed ) {
            return;
        }
        $shippingDate = $form->get('reservation_shippingDate')->getData();
        $isNoUseShippingDateTime = $form->get('reservation_isNoUseShippingDateTime')->getData();
        if( $isNoUseShippingDateTime ) {
            $shippingDate = false;
            $new_shippingDate = false;
        } else {
            $shippingDate->setTimeZone(new \DateTimeZone(date_default_timezone_get()));
            $new_shippingDate = $shippingDate->format("Y年n月j日 H:i");
        }
        if( $old_shippingDate != $new_shippingDate ) {
            $this->reserveService->procShippingChanged($product_id, $shippingDate);
        }
    }

    public function onFrontProductCarTAddComplete(EventArgs $event) {
        $form = $event->getArgument('form');
        $Product = $event->getArgument('Product');
        $addCartData = $form->getData();
        $product_class_id = $addCartData['product_class_id'];
        $error_code = $this->reserveService->validateCart($product_class_id, $Product);
        if( $error_code ) {
            if( $error_code == ProductReserveService::STATUS_NORMAL ) {
                $event->setResponse(new JsonResponse(['done' => false, 'messages' => [trans('plugin_reserve4.front.cart_exist_reserve')]], 200, []));
            } else if( $error_code == ProductReserveService::STATUS_RESERVE ) {
                $event->setResponse(new JsonResponse(['done' => false, 'messages' => [trans('plugin_reserve4.front.cart_exist_normal')]], 200, []));
            } else {
                $event->setResponse(new JsonResponse(['done' => false, 'messages' => [trans('plugin_reserve4.front.cart_invalid_request')]], 200, []));
            }
        }
        return ;
    }

    public function onFrontShoppingCompleteInitialize(EventArgs $event) {
        $Order = $event->getArgument('Order');
        $this->reserveService->setOrderStatusByConfig($Order);
    }

    public function onMailOrder(EventArgs $event) {
        $Order = $event->getArgument('Order');
        $message = $event->getArgument('message');
        $this->reserveService->setOrderReserveMail($Order, $message);
    }
}
