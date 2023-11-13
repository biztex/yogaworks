<?php

namespace Plugin\ZeusPayment4\Controller;

use Eccube\Controller\AbstractShoppingController;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Repository\OrderRepository;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Service\CartService;
use Eccube\Service\MailService;
use Eccube\Service\OrderHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Plugin\ZeusPayment4\Service\ZeusPaymentService;
use Plugin\ZeusPayment4\Service\Method\CvsPayment;
use Plugin\ZeusPayment4\Service\Method\EbankPayment;
use Plugin\ZeusPayment4\Service\Method\CreditPayment;
use Plugin\ZeusPayment4\Repository\ConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Eccube\Service\PurchaseFlow\PurchaseContext;

/**
 * ３Dセキュアの戻り画面用コントローラー.
 */
class ZeusPaymentReturn extends AbstractShoppingController
{
    /**
     * @var CartService
     */
    protected $cartService;
    
    /**
     * @var MailService
     */
    protected $mailService;
    
    /**
     * @var OrderRepository
     */
    protected $orderRepository;
    
    /**
     * @var OrderHelper
     */
    protected $orderHelper;
    
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;
    
    /**
     * @var ZeusPaymentService
     */
    protected $paymentService;

    protected $configRepository;

    protected $purchaseFlow;

    /**
     * PaymentController constructor.
     *
     * @param OrderRepository $orderRepository
     * @param ShoppingService $shoppingService
     */
    public function __construct(
        CartService $cartService,
        MailService $mailService,
        OrderRepository $orderRepository,
        OrderStatusRepository $orderStatusRepository,
        OrderHelper $orderHelper,
        EccubeConfig $eccubeConfig,
        ZeusPaymentService $paymentService,
        ConfigRepository $configRepository,
        PurchaseFlow $shoppingPurchaseFlow
        ) {
        $this->cartService = $cartService;
        $this->mailService = $mailService;
        $this->orderRepository = $orderRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->orderHelper = $orderHelper;
        $this->eccubeConfig = $eccubeConfig;
        $this->paymentService = $paymentService;
        $this->configRepository = $configRepository;
        $this->purchaseFlow = $shoppingPurchaseFlow;
    }


    /**
     * @Route("/zeus_cvs_payment", name="zeus_cvs_payment")
     * @Template("@ZeusPayment4/cvs.twig")
     */
    public function csvPayment(Request $request)
    {
        // ログイン状態のチェック.
        if ($this->orderHelper->isLoginRequired()) {
            log_info('[注文処理] 未ログインもしくはRememberMeログインのため, ログイン画面に遷移します.');

            return $this->redirectToRoute('shopping_login');
        }

        // 受注の存在チェック
        $preOrderId = $this->cartService->getPreOrderId();
        $order = $this->orderRepository->findOneBy([
            'pre_order_id' => $preOrderId,
            'OrderStatus' => OrderStatus::PENDING,
        ]);
        if (!$order) {
            log_info('[注文処理] 決済処理中の受注が存在しません.', [$preOrderId]);

            return $this->redirectToRoute('shopping_error');
        }
        $paymentClass = $order->getPayment()->getMethodClass();
        if($paymentClass!=CvsPayment::class){
            log_info('[注文処理] order do not use Zeus cvs Payment method 。', [$preOrderId]);
            return $this->redirectToRoute('shopping_error');
        }

        $config = $this->configRepository->get();
        $paymentType = 'cvs';
        $kananame = mb_convert_kana($order->getKana01() . '　' . $order->getKana02(), 'KVS', "UTF-8");
        $sendPoint = $this->paymentService->getSendPoint($config->getKey($paymentType), $config->getClientipByType($paymentType), $order->getId());

        return [
            'order' => $order,
            'eccubeConfig' => $this->eccubeConfig,
            'config' => $config,
            'sendPoint' => $sendPoint,
            'kananame' => $kananame,
        ];

    }

    /**
     * @Route("/zeuspayment/cvs_recv", name="zeus_csv_receive")
     */
    public function csvReceive(Request $request){
        log_notice('[ゼウスコンビニ決済ステータス変更]処理開始');

        //$requestData = '';
        $logData = '';
        foreach ($_REQUEST as $k => $val) {
            //$requestData .= ' [' . $k . ']=> ' . mb_convert_encoding($val, "UTF-8", 'SJIS');
            if ($k == 'status' || $k == 'order_no' || $k == 'tracking_no' || $k == 'sendid' || $k == 'sendpoint'|| $k == 'error_code') {
                $logData .= ' [' . $k . ']=> ' . mb_convert_encoding($val, "UTF-8", 'SJIS');
            }
        }


        log_notice('[ゼウスコンビニ決済ステータス変更]ゼウスリクエストメソッド情報:' . $_SERVER['REQUEST_METHOD'] . ' リクエスト情報:' . $logData);

        // リクエスト情報チェック
        $zeusResponse = array(
            'status' => $request->get('status'),
            'order_no' => $request->get('order_no'),
            'clientip' => $request->get('clientip'),
            'money' => $request->get('money'),
            'telno' => $request->get('telno'),
            'email' => $request->get('email'),
            'username' => mb_convert_encoding($request->get('username'), "UTF-8", 'SJIS'),
            'sendid' => $request->get('sendid'),
            'sendpoint' => $request->get('sendpoint'),
            'pay_cvs' => $request->get('pay_cvs'),
            'pay_limit' => $request->get('pay_limit'),
            'pay_no1' => $request->get('pay_no1'),
            'pay_no2' => $request->get('pay_no2'),
            'error_code' => $request->get('error_code')
        );

        $return = $this->paymentService->receive('cvs', $zeusResponse, 'コンビニ決済');
        return new Response($return) ;

    }

    /**
     * @Route("/zeus_ebank_payment", name="zeus_ebank_payment")
     * @Template("@ZeusPayment4/ebank.twig")
     */
    public function ebankPayment(Request $request)
    {
        // ログイン状態のチェック.
        if ($this->orderHelper->isLoginRequired()) {
            log_info('[注文処理] 未ログインもしくはRememberMeログインのため, ログイン画面に遷移します.');

            return $this->redirectToRoute('shopping_login');
        }

        // 受注の存在チェック
        $preOrderId = $this->cartService->getPreOrderId();
        $order = $this->orderRepository->findOneBy([
            'pre_order_id' => $preOrderId,
            'OrderStatus' => OrderStatus::PENDING,
        ]);
        if (!$order) {
            log_info('[注文処理] 決済処理中の受注が存在しません.', [$preOrderId]);

            return $this->redirectToRoute('shopping_error');
        }
        $paymentClass = $order->getPayment()->getMethodClass();
        if($paymentClass!=EbankPayment::class){
            log_info('[注文処理] order do not use Zeus cvs Payment method 。', [$preOrderId]);
            return $this->redirectToRoute('shopping_error');
        }

        $config = $this->configRepository->get();
        $paymentType = 'ebank';
        $kananame = mb_convert_kana($order->getKana01() . '　' . $order->getKana02(), 'KVS', "UTF-8");
        $sendPoint = $this->paymentService->getSendPoint($config->getKey($paymentType), $config->getClientipByType($paymentType), $order->getId());

        return [
            'order' => $order,
            'eccubeConfig' => $this->eccubeConfig,
            'config' => $config,
            'sendPoint' => $sendPoint,
            'kananame' => $kananame,
        ];

    }


    /**
     * @Route("/zeuspayment/ebank_recv", name="zeus_ebank_receive")
     */
    public function ebankReceive(Request $request)
    {
        $zeusPaymentService = $app['eccube.plugin.zeus_payment.service.zeuspayment'];

        log_notice('[ゼウス銀行振込決済ステータス変更]処理開始');

        //$requestData = '';
        $logData = '';
        foreach ($_REQUEST as $k => $val) {
            //$requestData .= ' [' . $k . ']=> ' . mb_convert_encoding($val, "UTF-8", 'SJIS');
            if ($k == 'status' || $k == 'order_no' || $k == 'tracking_no' || $k == 'sendid' || $k == 'sendpoint' || $k == 'error_message') {
                $logData .= ' [' . $k . ']=> ' . mb_convert_encoding($val, "UTF-8", 'SJIS');
            }
        }

        log_notice('[ゼウス銀行振込決済ステータス変更]ゼウスリクエストメソッド情報:' . $_SERVER['REQUEST_METHOD'] . ' リクエスト情報:' . $logData);

        // リクエスト情報チェック
        $zeusResponse = array(
            'status' => $request->get('status'),
            'order_no' => $request->get('order_no'),
            'clientip' => $request->get('clientip'),
            'money' => $request->get('money'),
            'telno' => $request->get('telno'),
            'email' => $request->get('email'),
            'sendid' => $request->get('sendid'),
            'sendpoint' => $request->get('sendpoint'),
            'tracking_no' => $request->get('tracking_no'),
            'payment' => $request->get('payment'),
            'error_message' => mb_convert_encoding($request->get('error_message'), "UTF-8", 'SJIS')
        );

        $return = $this->paymentService->receive('ebank', $zeusResponse, '銀行振込決済');
        return new Response($return) ;
    }

    /**
     * @Route("/zeus_payment_return", name="zeus_payment_return_index")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        // ログイン状態のチェック.
        if ($this->orderHelper->isLoginRequired()) {
            log_info('[注文処理] 未ログインもしくはRememberMeログインのため, ログイン画面に遷移します.');
            
            return $this->redirectToRoute('shopping_login');
        }
        
        // 受注の存在チェック
        $preOrderId = $this->cartService->getPreOrderId();
        $Order = $this->orderRepository->findOneBy([
            'pre_order_id' => $preOrderId,
            'OrderStatus' => OrderStatus::PENDING,
        ]);
        if (!$Order) {
            log_info('[注文処理] 決済処理中の受注が存在しません.', [$preOrderId]);
            
            return $this->redirectToRoute('shopping_error');
        }

        $paymentClass = $Order->getPayment()->getMethodClass();
        if($paymentClass!=CreditPayment::class){
            $errorMessage = '購入処理でエラーが発生しました。';
            $this->addError($errorMessage);
            log_error('注文完了できません。');
            log_error($paymentClass);
            return $this->redirectToRoute('shopping_error');
        }
        
        $mode = $request->get("mode");
        try {
            $config = $this->configRepository->get();
            if ($mode != 'pares' || !$this->paymentService->paymentDataSendAuthorize($request, $Order, $config)) {
                $this->addError($this->eccubeConfig['zeus_auth_error_message']);
                return $this->redirectToRoute('shopping');
            }
            $this->purchaseFlow->prepare($Order, new PurchaseContext());
            // purchaseFlow::commitを呼び出し, 購入処理を完了させる.
            $this->purchaseFlow->commit($Order, new PurchaseContext());
            
            log_info('[注文処理] カートをクリアします.', [$Order->getId()]);
            $this->cartService->clear();
            
            $OrderStatus = $this->orderStatusRepository->find(($paymentClass!=CreditPayment::class)?OrderStatus::PAID:$config->getOrderStatusForSaleType());
            
            $Order->setOrderStatus($OrderStatus);
            $Order->setPaymentDate(new \DateTime());
            
            // 受注IDをセッションにセット
            $this->session->set(OrderHelper::SESSION_ORDER_ID, $Order->getId());
            
            // メール送信
            log_info('[注文処理] 注文メールの送信を行います.', [$Order->getId()]);
            $this->mailService->sendOrderMail($Order);
            $this->entityManager->flush();
            
            log_info('[注文処理] 注文処理が完了しました. 購入完了画面へ遷移します.', [$Order->getId()]);
            
            return $this->redirectToRoute('shopping_complete');
        } catch (\Throwable $e) {
            log_error('注文完了できません。');
            log_error($e); //make sure no card info in exception - checked
            $errorMessage = '購入処理でエラーが発生しました。支払手続きは完了している可能性がありますので、サイトまでお問い合わせください。';
            $this->addError($errorMessage);
            return $this->redirectToRoute('shopping_error');
        }
    }

    /**
     * @Route("/zeus_payment_back", name="zeus_payment_back")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function back(Request $request){
        // ログイン状態のチェック.
        if ($this->orderHelper->isLoginRequired()) {
            log_info('[注文処理] 未ログインもしくはRememberMeログインのため, ログイン画面に遷移します.');

            return $this->redirectToRoute('shopping_login');
        }

        $preOrderId = $this->cartService->getPreOrderId();
        $Order = $this->orderRepository->findOneBy([
            'pre_order_id' => $preOrderId,
            'OrderStatus' => OrderStatus::PENDING,
        ]);

        if($Order){
            $OrderStatus = $this->entityManager->getRepository(OrderStatus::class)->find(OrderStatus::PROCESSING);
            $Order->setOrderStatus($OrderStatus);
            $this->entityManager->persist($Order);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('shopping');
    }
}
