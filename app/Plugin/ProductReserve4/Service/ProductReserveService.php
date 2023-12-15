<?php


namespace Plugin\ProductReserve4\Service;


use Carbon\Carbon;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\Order;
use Eccube\Entity\OrderItem;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\MailHistory;
use Eccube\Entity\MailTemplate;

use Eccube\Service\CartService;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Eccube\Service\PurchaseFlow\PurchaseContext;

use Eccube\Repository\MailTemplateRepository;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\OrderRepository;
use Eccube\Repository\OrderItemRepository;
use Eccube\Repository\ShippingRepository;
use Eccube\Repository\Master\OrderStatusRepository;

use Eccube\Repository\MailHistoryRepository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

use Plugin\ProductReserve4\Entity\ProductClassExtra;
use Plugin\ProductReserve4\Entity\ReserveOrder;
use Plugin\ProductReserve4\Repository\ProductClassExtraRepository;
use Plugin\ProductReserve4\Repository\ReserveOrderRepository;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


use Plugin\ProductReserve4\Repository\ConfigRepository;
use Plugin\ProductReserve4\Repository\ProductExtraRepository;
use Plugin\ProductReserve4\Entity\ProductExtra;

//use Plugin\ProductReserve4\Service\PurchaseFlow\Processor\ReserveValidator;

class ProductReserveService
{

    const STATUS_RESERVE_BEFORE = 10;
    const STATUS_RESERVE_END = 11;
    const STATUS_RESERVE = 1;
    const STATUS_NORMAL = 2;

    const ERROR_UNKNOWN = 10;
    const ERROR_CANT_ORDER = 13;
    const ERROR_MIXED = 12;
    const ERROR_CANT_RESERVE = 11;
    const ERROR_SUCCESS_NORMAL = 1;
    const ERROR_SUCCESS_RESERVE = 0;

    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * @var ProductExtraRepository
     */
    private $productExtraRepository;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var EccubeConfig
     */
    private $eccubeConfig;

    private $purchaseFlow;

    /**
     * @var CartService
     */
    protected $cartService;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var OrderStatusRepository
     */
    protected $orderStatusRepository;
    /**
     * @var ReserveValidator
     */
//    private $reserveValidator;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var BaseInfo
     */
    protected $BaseInfo;

    protected $orderRepository;
    protected $orderItemRepository;
    protected $shippingRepository;
    protected $reserveOrderRepository;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var MailHistoryRepository
     */
    private $mailHistoryRepository;

    /**
     * @var MailTemplateRepository
     */
    protected $mailTemplateRepository;

    /**
     * @var ProductClassExtraRepository
     */
    protected $productClassExtraRepository;

    public function __construct(
        \Swift_Mailer $mailer,
        MailHistoryRepository $mailHistoryRepository,
        RequestStack $request,
        ConfigRepository $configRepository,
        UrlGeneratorInterface $router,
        EccubeConfig $eccubeConfig,
        ProductExtraRepository $productExtraRepository,
        ProductClassExtraRepository $productClassExtraRepository,
        CartService $cartService,
        TokenStorageInterface $tokenStorage,
        PurchaseFlow $purchaseFlow,
        OrderStatusRepository $orderStatusRepository,
        EntityManagerInterface $entityManager,
        \Twig_Environment $twig,
        MailTemplateRepository $mailTemplateRepository,
        BaseInfoRepository $baseInfoRepository,
        OrderItemRepository $orderItemRepository,
        OrderRepository $orderRepository,
        ShippingRepository $shippingRepository,
        ReserveOrderRepository $reserveOrderRepository
//        ReserveValidator $reserveValidator
    )
    {
        $this->configRepository = $configRepository;
        $this->productExtraRepository = $productExtraRepository;
        $this->productClassExtraRepository = $productClassExtraRepository;
        $this->router = $router;
        $this->request = $request->getCurrentRequest();
        $this->eccubeConfig = $eccubeConfig;
        $this->cartService = $cartService;
        $this->purchaseFlow = $purchaseFlow;
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->mailTemplateRepository = $mailTemplateRepository;
        $this->mailHistoryRepository = $mailHistoryRepository;
        $this->BaseInfo = $baseInfoRepository->get();
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
        $this->shippingRepository = $shippingRepository;
        $this->reserveOrderRepository = $reserveOrderRepository;
    }

    protected $error_code;
    protected $error_message;

    protected function setError($code, $message = null)
    {
        $this->error_code = $code;
        $this->error_message = $message;
    }

    public function getErrorCode()
    {
        return $this->error_code;
    }

    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param ResponseInterface $response
     * @return bool|mixed
     */
    protected function parseResponse($response)
    {
        //if ($response->getStatusCode())
        $result = @json_decode((string)$response->getBody(), true);
        if (!$result || !isset($result['status'])) {
            $this->setError(-1, 'Invalid request.');
            return false;
        }
        if ($result['status'] != 'OK') {
            $this->setError($result['code'], $result['message']);
            return false;
        }
        return $result;
    }

    /**
     * @param array $product_ids ProductExtra in product_ids
     *
     * @return ArrayCollection|array
     */
    public function getProductExtrList($product_ids)
    {
        $productExtras = $this->productExtraRepository->findBy(['product_id' => $product_ids]);
        $productClassExtras = $this->productClassExtraRepository->findBy(['Product' => $product_ids]);
        return [
            'ProductExtras' => $productExtras,
            'ProductClassExtras' => $productClassExtras];
    }


    protected function getUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }

    public function canReserveOrder(Order $Order)
    {
        $items = $Order->getItems();
        $totalCount = 0;
        $countReserve = 0;
        $countNormal = 0;
        foreach ($items as $OrderItem) {
            if (!$OrderItem->isProduct()) {
                continue;
            }
            $Product = $OrderItem->getProduct();
            $ProductClass = $OrderItem->getProductClass();
            if (!$Product) {
                continue;
            }
            $totalCount++;
            $product_id = $Product->getId();
            $reserve_status = $this->getReserveStatus($product_id, $ProductClass->getId());
            switch ($reserve_status) {
                case self::STATUS_NORMAL:
                    $countNormal++;
                    break;
                case self::STATUS_RESERVE:
                    $countReserve++;
                    break;
            }
        }
        if ($totalCount == 0) {
            return self::ERROR_UNKNOWN;
        }
        if ($totalCount == $countReserve) {
            return self::ERROR_SUCCESS_RESERVE;
        }
        if ($totalCount == $countNormal) {
            return self::ERROR_SUCCESS_NORMAL;
        }
        if ($countNormal > 0 && $countReserve > 0) {
            return self::ERROR_MIXED;
        }
        if ($countNormal == 0) {
            return self::ERROR_CANT_RESERVE;
        }
        if($countReserve == 0) {
            return self::ERROR_CANT_ORDER;
        }

        return self::ERROR_UNKNOWN;
    }

    public function isReserveOrder(Order $Order)
    {
        $status = $this->canReserveOrder($Order);
        if($status == self::ERROR_SUCCESS_RESERVE) {
            return true;
        }
        return false;
//        $items = $Order->getItems();
//        $bProductFound = false;
//        foreach ($items as $OrderItem) {
//            if ($OrderItem->isProduct()) {
//                $bProductFound = true;
//                break;
//            }
//        }
//        if ($bProductFound === false) {
//            return false;
//        }
//        $Product = $OrderItem->getProduct();
//        $ProductClass = $OrderItem->getProductClass();
//        if (!$Product) {
//            return false;
//        }
//        $product_id = $Product->getId();
//        $reserve_status = $this->getReserveStatus($product_id, $ProductClass->getId());
//        if ($reserve_status == self::STATUS_NORMAL) {
//            return false;
//        }
//        return true;
    }

    public function getReserveStatus($product_id, $product_class_id)
    {
        $product_reserve_status = $this->getProductReserveStatus($product_id);
        if ($product_reserve_status === self::STATUS_NORMAL) {
            $product_reserve_status = $this->getProductClassReserveStatus($product_class_id);
        }
        return $product_reserve_status;
    }

    public function getProductReserveStatus($product_extra)
    {
        if ($product_extra && !$product_extra instanceof ProductExtra) {
            $product_id = $product_extra;
            $product_extra = $this->productExtraRepository->get($product_id);
        }
        if (!$product_extra || !$product_extra->isAllowed()) {
            return self::STATUS_NORMAL;
        }
        $now = Carbon::now();

        $isNoUseStart = $product_extra->getStartDate() ? false : true;
        $isNoUseEnd = $product_extra->getEndDate() ? false : true;
        $isNoUseShipping = $product_extra->getShippingDate() ? false : true;

        if ($isNoUseStart) {
            $start_date = false;
        } else {
            $start_date = Carbon::parse($product_extra->getStartDate()->format('Y-m-d H:i:s'));
        }
        if ($isNoUseEnd) {
            $end_date = false;
        } else {
            $end_date = Carbon::parse($product_extra->getEndDate()->format('Y-m-d H:i:s'));
        }
        if ($isNoUseShipping) {
            $shipping_date = false;
        } else {
            $shipping_date = Carbon::parse($product_extra->getShippingDate()->format('Y-m-d H:i:s'));
        }

        if (!$isNoUseShipping) {
            if ($now >= $shipping_date) {
                return self::STATUS_NORMAL;
            }
        }

        if ($isNoUseStart && !$isNoUseEnd) {
            if ($now <= $end_date) {
                return self::STATUS_RESERVE;
            }
        } else if (!$isNoUseStart && $isNoUseEnd) {
            if ($now >= $start_date) {
                return self::STATUS_RESERVE;
            }
        } else if (!$isNoUseStart && !$isNoUseEnd) {
            if ($now >= $start_date && $now <= $end_date) {
                return self::STATUS_RESERVE;
            }
        } else {
            return self::STATUS_RESERVE;
        }

        if (!$isNoUseStart) {
            if ($now < $start_date) {
                return self::STATUS_RESERVE_BEFORE;
            }
        }
        return self::STATUS_RESERVE_END;
    }

    public function getProductClassReserveStatus($product_class_extra)
    {
        if ($product_class_extra && !$product_class_extra instanceof ProductClassExtra) {
            $product_class_id = $product_class_extra;
            $product_class_extra = $this->productClassExtraRepository->getByProductClassId($product_class_id);
        }
        if (!$product_class_extra || !$product_class_extra->isAllowed()) {
            return self::STATUS_NORMAL;
        }
        $now = Carbon::now();

        $isNoUseStart = $product_class_extra->getStartDate() ? false : true;
        $isNoUseEnd = $product_class_extra->getEndDate() ? false : true;
        $isNoUseShipping = $product_class_extra->getShippingDate() ? false : true;

        if ($isNoUseStart) {
            $start_date = false;
        } else {
            $start_date = Carbon::parse($product_class_extra->getStartDate()->format('Y-m-d H:i:s'));
        }
        if ($isNoUseEnd) {
            $end_date = false;
        } else {
            $end_date = Carbon::parse($product_class_extra->getEndDate()->format('Y-m-d H:i:s'));
        }
        if ($isNoUseShipping) {
            $shipping_date = false;
        } else {
            $shipping_date = Carbon::parse($product_class_extra->getShippingDate()->format('Y-m-d H:i:s'));
        }

        if (!$isNoUseShipping) {
            if ($now >= $shipping_date) {
                return self::STATUS_NORMAL;
            }
        }

        if ($isNoUseStart && !$isNoUseEnd) {
            if ($now <= $end_date) {
                return self::STATUS_RESERVE;
            }
        } else if (!$isNoUseStart && $isNoUseEnd) {
            if ($now >= $start_date) {
                return self::STATUS_RESERVE;
            }
        } else if (!$isNoUseStart && !$isNoUseEnd) {
            if ($now >= $start_date && $now <= $end_date) {
                return self::STATUS_RESERVE;
            }
        } else {
            return self::STATUS_RESERVE;
        }

        if (!$isNoUseStart) {
            if ($now < $start_date) {
                return self::STATUS_RESERVE_BEFORE;
            }
        }
        return self::STATUS_RESERVE_END;
    }

    /**
     * @param $product_class_id
     * @param $Product
     * @return error code; 0: success, otherwise error code.
     */
    public function validateCart($product_class_id, $Product)
    {
        $Carts = $this->cartService->getCarts();
        $cur_product_status = $this->getReserveStatus($Product->getId(), $product_class_id);
        if ($cur_product_status == self::STATUS_RESERVE_END || $cur_product_status == self::STATUS_RESERVE_BEFORE) {
            $valid = false;
        } else {
            $valid = true;
            foreach ($Carts as $Cart) {
                $items = $Cart->getItems();
                foreach ($items as $item) {
                    $product_class = $item->getProductClass();
                    if ($product_class->getId() == $product_class_id) {
                        continue;
                    }
                    $product = $product_class->getProduct();
                    $product_id = $product->getId();
                    $product_status = $this->getReserveStatus($product_id, $product_class->getId());
                    if ($cur_product_status != $product_status) {
                        $valid = false;
                    }
                }
                if (!$valid) {
                    break;
                }
            }
        }

        if (!$valid) {
            $this->cartService->removeProduct($product_class_id);
            $Carts = $this->cartService->getCarts();
            foreach ($Carts as $Cart) {
                $result = $this->purchaseFlow->validate($Cart, new PurchaseContext($Cart, $this->getUser()));
            }
            $this->cartService->save();
        }
        if ($valid) {
            return 0;
        } else {
            return $cur_product_status;
        }
    }

    public function setReserveOrder(Order $Order)
    {
        $items = $Order->getItems();
        foreach ($items as $OrderItem) {
            if (!$OrderItem->isProduct()) {
                continue;
            }
            $Product = $OrderItem->getProduct();
            $ProductClass = $OrderItem->getProductClass();
            if (!$Product) {
                continue;
            }
            $product_id = $Product->getId();
            $reserve_status = $this->getReserveStatus($product_id, $ProductClass->getId());
            if ($reserve_status == self::STATUS_NORMAL) {
                continue;
            }
            $ReserveOrder = new ReserveOrder();
            $ReserveOrder->setOrder($Order);
            $ReserveOrder->setProduct($Product);
            $ReserveOrder->setCreatedAt(new \DateTime());
            $this->entityManager->persist($ReserveOrder);
        }
        $this->entityManager->flush();
    }

    public function removeReserveOrder(Order $Order) {
        $this->reserveOrderRepository->deleteReserveOrder($Order->getId());
    }

    public function setOrderStatusByConfig(Order $Order)
    {
        if (!$this->isReserveOrder($Order)) { //fixed 20200402
            return;
        }
        $config_order_status = $this->configRepository->getConfig('order_status');
        if (!$config_order_status) {
            return;
        }
        $OrderStatus = $this->orderStatusRepository->find($config_order_status);
        if (!$OrderStatus) {
            return;
        }
        $Order->setOrderStatus($OrderStatus);
        $this->entityManager->persist($Order);
        $this->entityManager->flush();
    }

    public function procShippingChanged($product_id, $shipping_date)
    {
        $reserve_order_status = $this->configRepository->getConfig('order_status');
//        $ReserveOrders = $this->reserveOrderRepository->findBy(['Product' => $product_id]);
        $order_ids = [];
        $Orders = [];
        $ReserveOrders = $this->reserveOrderRepository->getReserveOrderByProductEx($product_id, $reserve_order_status);
        foreach ($ReserveOrders as $item) {
            $order_ids[] = $item->getOrder()->getId();
            $Orders[] = $item->getOrder();
        }
        $order_items = $this->orderItemRepository->findBy(['Product' => $product_id, 'Order' => $order_ids]);
//        $Orders = $this->orderRepository->findBy(['id' => $order_ids, 'OrderStatus' => $reserve_order_status]);

        if ($shipping_date) {
            $shipping_date = $shipping_date->format('Y年n月j日 H:i');
        } else {
            $shipping_date = trans('plugin_reserve4.admin.no_shipping_date');
        }

        $MailTemplate = $this->mailTemplateRepository->find($this->configRepository->getConfig('mail_reservation_shipping_change'));
        foreach ($Orders as $Order) {
            $Shipping = $this->shippingRepository->findOneBy(['Order' => $Order->getId()]);
            foreach ($order_items as $OrderItem) {
                if ($OrderItem->getOrderId() == $Order->getId()) {
                    $this->sendShippingChangedMail($MailTemplate, $Order, $Shipping, $OrderItem, $shipping_date);
                    break;
                }
            }
        }
    }

    public function procClassShippingChanged($product_id, $product_class_id, $shipping_date)
    {
//        $ReserveOrders = $this->reserveOrderRepository->findBy(['Product' => $product_id]);
        $reserve_order_status = $this->configRepository->getConfig('order_status');
        $order_ids = [];
        $Orders = [];
        $ReserveOrders = $this->reserveOrderRepository->getReserveOrderByProductEx($product_id, $reserve_order_status);
        foreach ($ReserveOrders as $item) {
            $order_ids[] = $item->getOrder()->getId();
            $Orders[] = $item->getOrder();
        }
        $order_items = $this->orderItemRepository->findBy(['Product' => $product_id, 'ProductClass' => $product_class_id, 'Order' => $order_ids]);
//        $Orders = $this->orderRepository->findBy(['id' => $order_ids, 'OrderStatus' => $reserve_order_status]);

        if ($shipping_date) {
            $shipping_date = $shipping_date->format('Y年n月j日 H:i');
        } else {
            $shipping_date = trans('plugin_reserve4.admin.no_shipping_date');
        }

        $MailTemplate = $this->mailTemplateRepository->find($this->configRepository->getConfig('mail_reservation_shipping_change'));
        foreach ($Orders as $Order) {
            $Shipping = $this->shippingRepository->findOneBy(['Order' => $Order->getId()]);
            foreach ($order_items as $OrderItem) {
                if ($OrderItem->getOrderId() == $Order->getId()) {
                    $this->sendShippingChangedMail($MailTemplate, $Order, $Shipping, $OrderItem, $shipping_date);
                    break;
                }
            }
        }
    }

    public function sendShippingChangedMail($MailTemplate, $Order, $Shipping, $OrderItem, $shipping_date)
    {

        $params = [
            'Order' => $Order,
            'Shipping' => $Shipping,
            'Product' => $OrderItem,
            'Reserve' => ['shipping_date' => $shipping_date ? $shipping_date : trans('plugin_reserve4.admin.no_shipping_date')],
        ];
        $body = $this->twig->render($MailTemplate->getFileName(), $params);

        $message = (new \Swift_Message())
            ->setSubject('[' . $this->BaseInfo->getShopName() . '] ' . $MailTemplate->getMailSubject())
            ->setFrom([$this->BaseInfo->getEmail01() => $this->BaseInfo->getShopName()])
            ->setTo([$Order->getEmail()])
            ->setBcc($this->BaseInfo->getEmail01())
            ->setReplyTo($this->BaseInfo->getEmail03())
            ->setReturnPath($this->BaseInfo->getEmail04());

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->twig->render($htmlFileName, $params);

            $message
                ->setContentType('text/plain; charset=UTF-8')
                ->setBody($body, 'text/plain')
                ->addPart($htmlBody, 'text/html');
        } else {
            $message->setBody($body);
        }

        $count = $this->mailer->send($message);

        $MailHistory = new MailHistory();
        $MailHistory->setMailSubject($message->getSubject())
            ->setMailBody($message->getBody())
            ->setOrder($Order)
            ->setSendDate(new \DateTime());

        // HTML用メールの設定
        $multipart = $message->getChildren();
        if (count($multipart) > 0) {
            $MailHistory->setMailHtmlBody($multipart[0]->getBody());
        }

        $this->mailHistoryRepository->save($MailHistory);
    }


    public function setOrderReserveMail($Order, $message)
    {
        //step1: check reserve order
        if (!$this->isReserveOrder($Order)) {
            return;
        }

        //step2: get reservation info
        $ClassReserve = [];
        $Reserve = [];
        $items = $Order->getItems();
        foreach ($items as $OrderItem) {
            if ($OrderItem->isProduct()) {
                $product_id = $OrderItem->getProduct()->getId();
                $product_class_id = $OrderItem->getProductClass()->getId();

                $product_reserve_status = $this->getProductReserveStatus($product_id);
                if ($product_reserve_status === self::STATUS_NORMAL) {
                    $reserve = $this->productClassExtraRepository->findOneBy(['ProductClass' => $product_class_id]);
                    $shippingDate = $reserve->getShippingDate() ? $reserve->getShippingDate()->format('Y年n月j日 H:i') : trans('plugin_reserve4.admin.no_shipping_date');
                    $ClassReserve[$product_id][$product_class_id] = [
                        'shipping_date' => $shippingDate,
                    ];
                } else {
                    $reserve = $this->productExtraRepository->findOneBy(['product_id' => $product_id]);
                    $shippingDate = $reserve->getShippingDate() ? $reserve->getShippingDate()->format('Y年n月j日 H:i') : trans('plugin_reserve4.admin.no_shipping_date');
                    $Reserve[$product_id] = [
                        'shipping_date' => $shippingDate,
                    ];
                }
            }
        }


        $mail_order_reservation = $this->configRepository->getConfig('mail_order_reservation');
        if (!$mail_order_reservation) {
            return;
        }
        $MailTemplate = $this->mailTemplateRepository->find($mail_order_reservation);

        $params = [
            'Order' => $Order,
            'Reserve' => $Reserve,
            'ClassReserve' => $ClassReserve
        ];

        $body = $this->twig->render($MailTemplate->getFileName(), $params);

        $message->setSubject('[' . $this->BaseInfo->getShopName() . '] ' . $MailTemplate->getMailSubject());

        // HTMLテンプレートが存在する場合
        $htmlFileName = $this->getHtmlTemplate($MailTemplate->getFileName());
        if (!is_null($htmlFileName)) {
            $htmlBody = $this->twig->render($htmlFileName, $params);

            foreach ($message->getChildren() as $child) {
                $message->detach($child);
            }
            $message
                ->setContentType('text/plain; charset=UTF-8')
                ->setBody($body, 'text/plain')
                ->addPart($htmlBody, 'text/html');
        } else {
            $message->setBody($body);
        }
    }

    public function getHtmlTemplate($templateName)
    {
        // メールテンプレート名からHTMLメール用テンプレート名を生成
        $fileName = explode('.', $templateName);
        $suffix = '.html';
        $htmlFileName = $fileName[0] . $suffix . '.' . $fileName[1];

        // HTMLメール用テンプレートの存在チェック
        if ($this->twig->getLoader()->exists($htmlFileName)) {
            return $htmlFileName;
        } else {
            return null;
        }
    }

}
