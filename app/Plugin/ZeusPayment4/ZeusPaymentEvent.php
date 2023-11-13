<?php


namespace Plugin\ZeusPayment4;

use Eccube\Common\EccubeConfig;
use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Event\TemplateEvent;
use Plugin\ZeusPayment4\Service\Method\EbankPayment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Plugin\ZeusPayment4\Repository\ConfigRepository;
use Plugin\ZeusPayment4\Service\ZeusPaymentService;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Eccube\Service\CartService;
use Eccube\Service\OrderHelper;
use Eccube\Repository\OrderRepository;
use Plugin\ZeusPayment4\Service\Method\CvsPayment;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/*
 * イベント処理
 */
class ZeusPaymentEvent implements EventSubscriberInterface
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;
    protected $paymentService;
    protected $eccubeConfig;
    protected $cartService;
    protected $orderHelper;
    protected $orderRepository;
    protected $entityManager;
    protected $router;
    protected $session;

    public function __construct(
        ConfigRepository $configRepository,
        ZeusPaymentService $paymentService,
        EccubeConfig $eccubeConfig,
        CartService $cartService,
        OrderHelper $orderHelper,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        SessionInterface $session
    )
    {
        $this->configRepository = $configRepository;
        $this->paymentService = $paymentService;
        $this->eccubeConfig = $eccubeConfig;
        $this->cartService = $cartService;
        $this->orderHelper = $orderHelper;
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Shopping/index.twig' => 'onShoppingIndexTwig',
            'Shopping/confirm.twig' => 'onShoppingConfirmTwig',
            '@admin/Order/index.twig' => 'adminOrderIndexTwig',
            '@admin/Order/edit.twig' => 'adminOrderEditTwig',
            KernelEvents::CONTROLLER => array('onKernelController', 130)
        ];
    }

    public function onShoppingIndexTwig(TemplateEvent $event)
    {
        $event->addSnippet('@ZeusPayment4/credit_input_move_point.twig');

        $config = $this->configRepository->get();
        if (!$config || !$config->getCreditPayment()) {
            return;
        }

        $parameters = $event->getParameters();


        $zeus_credit = array();
        $zeus_credit['credit_class_name'] = \Plugin\ZeusPayment4\Service\Method\CreditPayment::class;
        $zeus_credit['config'] = $config;

        $order = $parameters['Order'];
        $payment = $order->getPayment();
        if (!$payment || $payment->getMethodClass() != $zeus_credit['credit_class_name']) {
            return;
        }
        $zeus_credit['payment_id'] = $payment->getId();
        $shippings = $payment->getPaymentOptions();
        $zeus_credit['shippings'] = "[]";
        if ($shippings) {
            $aShippings = [];
            foreach ($shippings as $shipping) {
                $aShippings[] = $shipping->getDeliveryId();
            }
            $zeus_credit['shippings'] = "[" . implode(',', $aShippings) . "]";
        }

        //if this field not exists,do not display
        if (!$parameters['form']['ZeusCreditPaymentCardNo']) {
            return;
        }

        $event->addSnippet('@ZeusPayment4/credit_input.twig');
        $parameters = $event->getParameters();

        $quickOK = $this->paymentService->isQuickChargeOK($order, $config->getCreditPayment());
        if ($quickOK) {
            $lastMaskedCard = $this->paymentService->fetchMaskedCard($order, $config);
            $zeus_credit['lastMaskedCard'] = $lastMaskedCard;
        } else {
            $zeus_credit['lastMaskedCard'] = '';
        }
        $zeus_credit['isQuickChargeOK'] = $quickOK;
        $parameters['zeus_credit'] = $zeus_credit;
        $event->setParameters($parameters);
    }

    public function onShoppingConfirmTwig(TemplateEvent $event)
    {
        $event->addSnippet('@ZeusPayment4/credit_confirm_move_point.twig');

        $config = $this->configRepository->get();

        if (!$config || !$config->getCreditPayment()) {
            return;
        }

        $this->csvRenameButton($event,$config);
        $this->ebankRenameButton($event,$config);

        $parameters = $event->getParameters();
        $zeus_credit = array();
        $zeus_credit['credit_class_name'] = \Plugin\ZeusPayment4\Service\Method\CreditPayment::class;
        $zeus_credit['config'] = $config;

        $order = $parameters['Order'];
        $payment = $order->getPayment();
        if (!$payment || $payment->getMethodClass() != $zeus_credit['credit_class_name']) {
            return;
        }
        $zeus_credit['payment_method'] = $payment->getMethod();

        $event->addSnippet('@ZeusPayment4/credit_confirm.twig');
        $parameters = $event->getParameters();
        $formview = $parameters['form'];
        $zeus_credit['mask_cark_no'] = $this->paymentService->getMaskedCard($formview['ZeusCreditPaymentCardNo']->vars['value']);

        $paras = $this->eccubeConfig['zeus_credit_options'];
        $methods = $paras['payment_choices'];
        $paymentMethod = $formview['ZeusCreditPaymentMethod']->vars['value'];
        $zeus_credit['payment_method_name'] = $methods[$paymentMethod];



        $quickOK = $this->paymentService->isQuickChargeOK($order, $config->getCreditPayment());
        if ($quickOK) {
            $lastMaskedCard = $this->paymentService->fetchMaskedCard($order, $config);
            $zeus_credit['lastMaskedCard'] = $lastMaskedCard;
        } else {
            $zeus_credit['lastMaskedCard'] = '';
        }
        $zeus_credit['isQuickChargeOK'] = $quickOK;

        $parameters['zeus_credit'] = $zeus_credit;

        $event->setParameters($parameters);
    }


    private function csvRenameButton($event, $config){

        $parameters = $event->getParameters();
        $order = $parameters['Order'];

        $payment = $order->getPayment();
        if (!$payment || $payment->getMethodClass() != \Plugin\ZeusPayment4\Service\Method\CvsPayment::class) {
            return;
        }

        $event->addSnippet('@ZeusPayment4/cvs_confirm_rename_button.twig');
    }

    private function ebankRenameButton($event, $config){

        $parameters = $event->getParameters();
        $order = $parameters['Order'];

        $payment = $order->getPayment();
        if (!$payment || $payment->getMethodClass() != \Plugin\ZeusPayment4\Service\Method\EbankPayment::class) {
            return;
        }

        $event->addSnippet('@ZeusPayment4/ebank_confirm_rename_button.twig');
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        ///only front page
        if(strpos($request->getRequestUri(),$this->eccubeConfig['eccube_admin_route'])!==false){
            return;
        }

        $preOrderId = $this->cartService->getPreOrderId();
        $order = $this->orderRepository->findOneBy([
            'pre_order_id' => $preOrderId
            //'OrderStatus' => OrderStatus::PENDING,
        ]);
        if(!$order){
            return;
        }
        $payment = $order->getPayment();
        if(!$payment){
            return;
        }
        if($payment->getMethodClass()!=CvsPayment::class && $payment->getMethodClass()!=EbankPayment::class){
            return;
        }

        if($order->getOrderStatus()->getId()!=OrderStatus::PENDING && $order->getOrderStatus()->getId()!=OrderStatus::PROCESSING){

            $saveOrderErr = "注文情報作成失敗しました。";
            $note = $order->getNote();
            $saveOrderFailed = ($saveOrderErr === substr($note, - strlen($saveOrderErr)));

            log_info('[注文処理] カートをクリアします.', [$order->getId()]);
            $this->cartService->clear();

            if($saveOrderFailed){

                $msg = '';
                if (strlen($order->getNote()) > 0) {
                    $str = $order->getNote() . "\r\n";
                } else {
                    $str = "";
                }

                $msg = "支払手続きは完了している可能性がありますので、サイトまでお問い合わせください。";
                $order->setNote($str . "メッセージ表示中：" . $msg);

                $order->setOrderStatus($this->entityManager->getRepository(OrderStatus::class)->find(OrderStatus::PENDING));

                $this->entityManager->persist($order);
                $this->entityManager->flush();
                $this->entityManager->commit();

                $this->session->getFlashBag()->add('eccube.front.error', '購入処理でエラーが発生しました。' . $msg);

                //$event->setResponse(new RedirectResponse($this->router->generate('shopping_error')));
                $redirect = new RedirectResponse($this->router->generate('shopping_error'));
                $redirect->send();

            }
        }

    }
    
    public function adminOrderIndexTwig(TemplateEvent $event)
    {
        $event->addSnippet('@ZeusPayment4/admin/order_index_js.twig');
    }
    
    public function adminOrderEditTwig(TemplateEvent $event)
    {
        $event->addSnippet('@ZeusPayment4/admin/order_edit_js.twig');
    }
}
