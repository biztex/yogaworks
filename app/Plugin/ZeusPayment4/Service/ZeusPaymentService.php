<?php

namespace Plugin\ZeusPayment4\Service;

use Doctrine\ORM\NoResultException;
use GuzzleHttp\Client;
use Plugin\ZeusPayment4\Entity\Config;
use Plugin\ZeusPayment4\Entity\ZeusOrder;
use Symfony\Component\HttpFoundation\Response;
use Eccube\Common\EccubeConfig;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Entity\Master\OrderStatus;
use GuzzleHttp\Exception\BadResponseException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Routing\RouterInterface;
use Eccube\Entity\Layout;
use Eccube\Entity\Page;
use Eccube\Entity\PageLayout;
use Eccube\Entity\Order;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\MailService;
use Eccube\Service\OrderStateMachine;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/*
 * 決済ロジック処理
 */
class ZeusPaymentService
{
    private $entityManager;
    private $eccubeConfig;
    private $session;
    private $orderStatusRepository;
    private $tokenStorage;
    private $mailService;
    private $authorizationChecker;
    private $orderStateMachine;

    public function __construct(
        EntityManagerInterface $entityManager,
        EccubeConfig $eccubeConfig,
        SessionInterface $session,
        OrderStatusRepository $orderStatusRepository,
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker,
        MailService $mailService,
        RouterInterface $route,
        PurchaseFlow $shoppingPurchaseFlow,
        OrderStateMachine $orderStateMachine
    ) {
        $this->entityManager = $entityManager;
        $this->eccubeConfig = $eccubeConfig;
        $this->session = $session;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->mailService = $mailService;
        $this->route = $route;
        $this->purchaseFlow = $shoppingPurchaseFlow;
        $this->orderStateMachine = $orderStateMachine;
    }

    /*
     * 設定情報をＤＢに保存します。
     */
    public function saveConfig($type, $config)
    {
        //ECCUBE3の旧実装
        // 削除済のpaymentも拾う
        /*$softDeleteFilter = $this->entityManager->getFilters()->getFilter('soft_delete');
        $softDeleteFilter->setExcludes(array(
            'Eccube\Entity\Payment'
        ));*/
        
        // dtb_paymentにデータを登録
        $payment = $config->getPayment($type);
        $methodClass = "Plugin\\ZeusPayment4\\Service\Method\\" . ucfirst(strtolower($type)) . "Payment";

        $paymentRepository = $this->entityManager->getRepository('\Eccube\Entity\Payment');
        if (is_null($payment)) {
            $payment = $paymentRepository->findOneBy(['method_class'=>$methodClass]);
            if ($payment) {
                $config->setPayment($type, $payment);
            }
        }
        
        // 登録されていない場合のみ更新する。
        if (is_null($payment)) {
            $lastPayment = $paymentRepository->findOneBy([], ['sort_no' => 'DESC']);
            $sortNo = $lastPayment ? $lastPayment->getSortNo() + 1 : 1;

            $payment = new \Eccube\Entity\Payment();
            $payment->setMethod($this->eccubeConfig['zeus_payment_method_' . strtolower($type)]);
            $payment->setMethodClass($methodClass);
            $payment->setRuleMin(0);
            $payment->setCharge(0);
            $payment->setSortNo($sortNo);
            $payment->setVisible(true);

            $this->entityManager->persist($payment);
            $this->entityManager->flush();

            $deliveries = $this->entityManager->getRepository('\Eccube\Entity\Delivery')->findAll();
            foreach ($deliveries as $delivery) {
                $paymentOption = new \Eccube\Entity\PaymentOption();
                $paymentOption->setPaymentId($payment->getId())
                    ->setPayment($payment)
                    ->setDeliveryId($delivery->getId())
                    ->setDelivery($delivery);
                $this->entityManager->persist($paymentOption);
                $payment->addPaymentOption($paymentOption);
            }
            $this->entityManager->persist($payment);
            $this->entityManager->flush();
            $config->setPayment($type, $payment);
        } else {
            if (!$payment->isVisible()) {
                $payment->setVisible(true);
                $this->entityManager->persist($payment);
                $this->entityManager->flush();
            }
        }
        
        // zeus_payment_configにデータを登録
        $key = $config->getKey($type);
        if (empty($key)) {
            $config->setKey($type, $this->getUniqKey());
        }


        $this->entityManager->persist($config);
        $this->entityManager->flush();

        if($type=='cvs'){
            $this->savePageLayout('ZEUSコンビニ決済','zeus_cvs_payment','@ZeusPayment4/cvs');
        }
        if($type=="ebank"){
            $this->savePageLayout('ZEUS銀行振込決済','zeus_ebank_payment','@ZeusPayment4/ebank');
        }

    }

    public function savePageLayout($name,$url,$filename)
    {
        $pageRepository = $this->entityManager->getRepository('\Eccube\Entity\Page');
        $page = $pageRepository->findOneBy(['url' => $url]);
        if($page){
            return;
        }

        $page = new Page();
        $page->setEditType(Page::EDIT_TYPE_DEFAULT);
        $page->setName($name);
        $page->setUrl($url);
        $page->setFileName($filename);

        // DB登録
        $this->entityManager->persist($page);
        $this->entityManager->flush($page);
        $layout = $this->entityManager->find(Layout::class, Layout::DEFAULT_LAYOUT_UNDERLAYER_PAGE);
        $PageLayout = new PageLayout();
        $PageLayout->setPage($page)
            ->setPageId($page->getId())
            ->setLayout($layout)
            ->setLayoutId($layout->getId())
            ->setSortNo(0);
        $this->entityManager->persist($PageLayout);
        $this->entityManager->flush($PageLayout);
    }

    /*
     * カード番号にマスクをかける
     */
    public function getMaskedCard($cardNo)
    {
        $len = strlen($cardNo);
        $mask = '';
        for ($i = 0; $i < ($len - 6); $i ++) {
            $mask .= '*';
        }
        return (strlen($cardNo) > 4) ? substr($cardNo, 0, 2) . $mask . substr($cardNo, - 4) : $cardNo;
    }

    /*
     * 処理中かの確認
     */
    public function isProcessing($order)
    {
        return ($order == $this->session->get('ZeusOrdering'));
    }

    /*
         * クレカＡＰＩ処理
         */
    public function sendCreditData($order, $config)
    {
        // 3D認証は以下の処理内でリダイレクト実施。
        $this->session->set('ZeusOrdering', $order);

        try {
            if (!$this->paymentDataSend($order, $config)) {
                return false;
            }
        } catch (\Throwable $e) {
            $this->session->remove('ZeusOrdering');
            throw $e;
        }
        $this->session->remove('ZeusOrdering');
        return true;
    }

    /*
     * クレカデータ送信
     */
    public function paymentDataSend($order, $config)
    {
        $cvvPostData = '';

        if ($order->getZeusCreditPaymentQuick() && $this->isQuickChargeOK($order, $config->getCreditPayment())) {
            if ((strlen($order->getZeusCreditPaymentCvv()) > 0) && ($config->getCvvflg() > 0) && ($config->getCvvflg() != Config::$cvv_first_use)) {
                $cvvPostData = '<cvv>' . $order->getZeusCreditPaymentCvv() . '</cvv>';
            } else {
                $cvvPostData = '';
            }
        } else {
            if (($config->getCvvflg() > 0) && (strlen($order->getZeusCreditPaymentCvv()) > 0)) {
                $cvvPostData = '<cvv>' . $order->getZeusCreditPaymentCvv() . '</cvv>';
            } else {
                $cvvPostData = '';
            }
        }
        $enrolXid = '';
        $enrolAcsUrl = '';
        $enrolPaReq = '';

        if (!$order->getZeusCreditPaymentToken()) {
            log_error('ZeusTokenが送信されていません');
            return false;
        }

        /// 3d secure
        if ($config->getSecure3dflg()) {
            // Enrol Action Start
            $toApiPostData = $this->getZeusPostData3dToEnrolReq($order, $config, $cvvPostData);
            $response = '';
            try {
                $response = $this->secureSendAction($this->eccubeConfig['zeus_secure_3d_link_url'], $toApiPostData);
                //$toApiPostData = $this->setMaskCardNumber($toApiPostData); // カード番号の一部をマスク
                //log_notice('ゼウス送信内容(3D_EnrolReq)：' . $toApiPostData);
                log_notice('ゼウス応答結果(3D_EnrolReq)：' . $response);
            } catch (BadResponseException $e) {
                log_error('ゼウス通信失敗：' . $e->getMessage());
                return false;
            }
            if (strstr($response, '<status>invalid</status>') !== false) {
                return false;
            }
            if (strstr($response, '<status>success</status>') !== false) {
            } elseif (strstr($response, '<status>outside</status>') !== false) {
                $enrolXid = $this->getEnrolXid($response);
                $toApiPostData = $this->getZeusPostData3dToPayReq($enrolXid);
                try {
                    $response = $this->secureSendAction($this->eccubeConfig['zeus_secure_3d_link_url'], $toApiPostData);
                    //$toApiPostData = $this->setMaskCardNumber($toApiPostData); // カード番号の一部をマスク
                    //log_notice('ゼウス送信内容：' . $toApiPostData);
                    log_notice('ゼウス応答結果：' . $response);
                } catch (BadResponseException $e) {
                    log_error('ゼウス通信失敗：' . $e->getMessage());
                    return false;
                }

                if (strstr($response, '<status>success</status>') !== false) {
                    return $this->createZeusOrderCredit($order, $toApiPostData, $response, $config);
                } else {
                    return false;
                }
            } else {
                return false;
            }
            $enrolXid = $this->getEnrolXid($response);
            $enrolAcsUrl = $this->getEnrolAcsUrl($response);
            $enrolPaReq = $this->getEnrolPaReq($response);

            // Enrol Action End
            // PaReq Action Start(PaReqは本人認証URLをユーザページよりリダイレクトさせ本人認証ページを表示させます。)
            $termUrl = $this->route->generate("zeus_payment_return_index", array(
                'mode' => 'pares'
            ), UrlGeneratorInterface::ABSOLUTE_URL);
            $paReqRequest = array(
                'MD' => $enrolXid,
                'PaReq' => $enrolPaReq,
                'TermUrl' => $termUrl
            );
            log_notice('3Dセキュア認証ページへ転送');
            $this->acsPostRedirect($enrolAcsUrl, $paReqRequest);
            return false;
        } else { // not 3d
            $toApiPostData = $this->getZeusPostData($order, $config, $cvvPostData);
        }

        $response = '';
        try {
            $response = $this->secureSendAction($this->eccubeConfig['zeus_secure_link_url'], $toApiPostData);
            log_notice('ゼウス応答結果：' . $response);
        } catch (BadResponseException $e) {
            log_error('ゼウス通信失敗：' . $e->getMessage());
            return false;
        }

        if (strstr($response, '<status>success</status>') !== false) {
            return $this->createZeusOrderCredit($order, $toApiPostData, $response, $config);
        } else {
            return false;
        }
    }

    /*
     * ゼウス注文番号を取得
     */
    public function getZeusOrderId($zeusResponse)
    {
        $pattern = "/<order_number>(.*)<\/order_number>/";
        preg_match($pattern, $zeusResponse, $matches);
        return (count($matches) > 1) ? $matches[1] : "";
    }

    public function getZeusPostData($order, $config, $cvvPostData)
    {
        $customer = $order->getCustomer();
        $sendid = "";
        if (is_null($customer)) {
            $sendid = "ORD" . $order->getId();
        } else {
            $sendid = $customer->getId();
        }
        $tokenKey = "";
        if ($order->getZeusCreditPaymentToken()) {
            $tokenKey = '<token_key>' . $order->getZeusCreditPaymentToken() . '</token_key>';
        }
        if ($order->getZeusCreditPaymentQuick() && $this->isQuickChargeOK($order, $config->getCreditPayment())) {
            return "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . "  <request service=\"secure_link\" action=\"payment\">" . "    <authentication>" . "      <clientip>" . $config->getClientip() . "</clientip>" . "      <key>" . $config->getClientauthkey() . "</key>" . "    </authentication>" . $tokenKey . "    <card>" . "      <history action=\"send_email\">" . "        <key>telno</key>" . "        <key>sendid</key>" . "      </history>" . $cvvPostData . "    </card>" . "    <payment>" . "      <amount>" . $order->getPaymentTotal() . "</amount>" . "      <count>" . $order->getZeusCreditPaymentMethod() . "</count>" . "    </payment>" . "    <user>" . "      <email>" . $order->getEmail() . "</email>" . "      <telno validation=\"permissive\">" . $order->getPhoneNumber() . "</telno>" . "    </user>" . "    <uniq_key>" . "      <sendid>" . $sendid . "</sendid>" . "      <sendpoint>" . $order->getId() . "</sendpoint>" . "    </uniq_key>" . "</request>";
        } else {
            return "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . "  <request service=\"secure_link\" action=\"payment\">" . "    <authentication>" . "      <clientip>" . $config->getClientip() . "</clientip>" . "      <key>" . $config->getClientauthkey() . "</key>" . "    </authentication>" . $tokenKey . "    <payment>" . "      <amount>" . $order->getPaymentTotal() . "</amount>" . "      <count>" . $order->getZeusCreditPaymentMethod() . "</count>" . "    </payment>" . "    <user>" . "      <email>" . $order->getEmail() . "</email>" . "      <telno validation=\"permissive\">" . $order->getPhoneNumber() . "</telno>" . "    </user>" . "    <uniq_key>" . "      <sendid>" . $sendid . "</sendid>" . "      <sendpoint>" . $order->getId() . "</sendpoint>" . "    </uniq_key>" . "</request>";
        }
    }

    /*
     * ＵＲＬ送信
     */
    public function secureSendAction($url, $postData)
    {
        $client = new Client();

        $error = '';
        try {
            $httpResponse = $client->post($url, [
                'headers'=>['Content-Type' => 'application/xml'],
                'body'=>$postData]);
            if ($httpResponse->getStatusCode() != 200) {
                $error = $httpResponse->getReasonPhrase();
            } else {
                $response = $httpResponse->getBody(true);
                return $response;
            }
        } catch (BadResponseException $e) {
            $error = $e->getMessage();
        }

        throw new BadResponseException($error, null, $httpResponse);
    }

    public function secureSendRequest($url, $params, $method = "POST")
    {
        $client = new Client();
        
        $error = '';
        try {
            
            $httpResponse = $client->request($method, $url, [
                'form_params' => $params
            ]);
            if ($httpResponse->getStatusCode() != 200) {
                $error = $httpResponse->getReasonPhrase();
            } else {
                return $httpResponse->getBody(true);
            }
        } catch (BadResponseException $e) {
            $error = $e->getMessage();
        }
        
        throw new BadResponseException($error, null, $httpResponse);
    }
    
    /*
    * クレカ決済のゼウス注文情報を生成
    */
    public function createZeusOrderCredit($order, $toApiPostData, $response, $config)
    {
        $order->setZeusOrderId($this->getZeusOrderId($response));
        $order->setZeusRequestData($toApiPostData);
        $order->setZeusResponseData($response);
        //3d secure戻り処理する際は purchaseflow経由してなくて注文日がセットされない
        if (null === $order->getOrderDate()) {
            $order->setOrderDate(new \DateTime());
        }

        $prefix = $this->getZeusResultData($response, "/<prefix>(.*)<\/prefix>/");
        $suffix = $this->getZeusResultData($response, "/<suffix>(.*)<\/suffix>/");
        if (strlen($order->getNote()) > 0) {
            $str = $order->getNote() . "\r\n";
        } else {
            $str = "";
        }
        $order->setNote($str . '[' . date("Y-m-d H:i:s") . '] 決済処理（' . 
            $config->getSaleTypeString(). '）を行いました。ZEUS_ORDER_ID:[' . $this->getZeusOrderId($response) . ']'); //prefix:[' . $prefix . '] suffix:[' . $suffix . ']'
        $order->setZeusSaleType($config->getSaleType());
        
        return $order;
    }


    /*
     * quick charge 機能利用できるかの確認
     */
    public function isQuickChargeOK($CurOrder, $CreditPayment)
    {
        if (! $CurOrder) {
            return false;
        }
        // 未ログインの場合
        if (! $this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            return false;
        }
        $customer = $this->tokenStorage->getToken()->getUser();

        $orderRepo = $this->entityManager->getRepository('\Eccube\Entity\Order');

        try {
            $preOrder = $orderRepo->createQueryBuilder('o')
                ->setMaxResults(1)
                ->where('o.Payment = :Payment')
                ->andWhere("o.OrderStatus not in (:OrderStatus)")
                ->andWhere("o.id != :order_id")
                ->andWhere('o.Customer = :Customer')
                ->setParameter('order_id', $CurOrder->getId())
                ->setParameter('Customer', $customer)
                ->setParameter('OrderStatus', [OrderStatus::PENDING,OrderStatus::PROCESSING])
                ->setParameter('Payment', $CreditPayment)
                ->addOrderBy('o.id', 'DESC')
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            // 結果がない場合はFalseを返す.
            return false;
        }
        
        if ($preOrder) {
            $telno = $preOrder->getPhoneNumber();
            $curTelno = $customer->getPhoneNumber();
            if ($telno == $curTelno) {
                return true;
            }
        }
        return false;
    }
    
    
    /*
     * クレカ用clientipの確認
     */
    public function verifyConfig($clientip, $clientauthkey, $config)
    {
        $toApiPostData = $this->getZeusPostDataInformation($clientip, $clientauthkey);
        $response = '';
        try {
            $response = $this->secureSendAction($this->eccubeConfig['zeus_secure_3d_information_link_url'], $toApiPostData);
        } catch (BadResponseException $e) {
            log_error('ゼウス通信失敗：' . $e->getMessage());
            return 'NETERR';
        }
        
        if (strstr($response, '<status>success</status>') === false) {
            $errorCode = $this->getZeusResultData($response, "/<code>(.*)<\/code>/");
            return $errorCode;
        } else {
            $config->setDetailname($this->getZeusResultData($response, "/<name>(.*)<\/name>/"));
            $config->setSecure3dflg($this->getZeusResultData($response, "/<threed>(.*)<\/threed>/") === 'on' ? 1 : 0);
            $config->setSaletype($this->getZeusResultData($response, "/<auth>(.*)<\/auth>/") === 'on' ? 1 : 0);
            
            $getCvvPatternFirst = $this->getZeusResultData($response, "/<first>(.*)<\/first>/");
            $getCvvPatternQuick = $this->getZeusResultData($response, "/<quick>(.*)<\/quick>/");
            if ($getCvvPatternFirst === 'on' && $getCvvPatternQuick === 'on') {
                $config->setCvvflg(Config::$cvv_on);
            } elseif ($getCvvPatternFirst === 'on' && $getCvvPatternQuick === 'off') {
                $config->setCvvflg(Config::$cvv_first_use);
            } elseif ($getCvvPatternFirst === 'on' && $getCvvPatternQuick === 'optional') {
                $config->setCvvflg(Config::$cvv_first_on_quick_opt);
            } elseif ($getCvvPatternFirst === 'optional' && $getCvvPatternQuick === 'optional') {
                $config->setCvvflg(Config::$cvv_first_opt_quick_opt);
            } else {
                $config->setCvvflg(0);
            }
            $config->setQuickchargeflg(1);
            
            return '';
        }
    }
    

    /*
     * 継続会員：カード番号下4桁取得
     */
    public function fetchMaskedCard($order, $config)
    {
        $customer = $order->getCustomer();
        $sendid = "";
        if (is_null($customer)) {
            $sendid = "ORD" . $order->getId();
        } else {
            $sendid = $customer->getId();
        }
        
        $toApiPostData = "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . "  <request service=\"keizoku\" action=\"inquiry\">" .
        "    <authentication>" . "      <clientip>" . $config->getClientip() . "</clientip>" . "      <key>" . $config->getClientauthkey() . "</key>" .
        "    </authentication>" . "<search_key><sendid>" . $sendid . "</sendid>" .
        "    <telno>" . $order->getPhoneNumber() . "</telno>" .
        "    </search_key></request>";

        try {
            $response = $this->secureSendAction($this->eccubeConfig['zeus_fetch_customer_info_url'], $toApiPostData);
            log_notice('応答：' . $response);
            log_notice('ゼウス応答結果：' . $this->getStatus($response));
        } catch (BadResponseException $e) {
            log_error('ゼウス通信失敗：' . $e->getMessage());
            return false;
        }
        
        if (strstr($response, '<status>success</status>') !== false) {
            $masked = $this->getMaskCardNumber($response);
            if (!empty($masked)) {
                return preg_replace("/^[0-9]{4}\*/", "*****", $masked);
            }
        }
        return "";
    }

    /*
     * クレカデータ送信（３Ｄ認証）
     */
    public function paymentDataSendAuthorize($request, $order, $config)
    {
        $paResMD = $request->get('MD');
        $paResPARES = $request->get('PaRes');
        // AuthReq
        $toApiPostData = $this->getZeusPostData3dToAuthReq($paResMD, $paResPARES);
        $response = '';
        try {
            $response = $this->secureSendAction($this->eccubeConfig['zeus_secure_3d_link_url'], $toApiPostData);
            //log_notice('ゼウス送信内容(3D_AuthReq)：' . $toApiPostData);
            log_notice('ゼウス応答結果(3D_AuthReq)：' . $response);
        } catch (BadResponseException $e) {
            log_error('ゼウス通信失敗：' . $e->getMessage());
            return false;
        }
        if (strstr($response, '<status>invalid</status>') !== false) {
            return false;
        }
        if (strstr($response, '<status>success</status>') === false) {
            return false;
        }
        
        // PayReq
        $toApiPostData = $this->getZeusPostData3dToPayReq($paResMD);
        $response = '';
        try {
            $response = $this->secureSendAction($this->eccubeConfig['zeus_secure_3d_link_url'], $toApiPostData);
            //log_notice('ゼウス送信内容：' . $toApiPostData);
            log_notice('ゼウス応答結果：' . $response);
        } catch (BadResponseException $e) {
            log_error('ゼウス通信失敗：' . $e->getMessage());
            return false;
        }
        
        if (strstr($response, '<status>success</status>') !== false) {
            if (!$this->createZeusOrderCredit($order, $toApiPostData, $response, $config)) {
                return false;
            } else {
                
                $OrderStatus = $this->orderStatusRepository->find($config->getOrderStatusForSaleType());
                $order->setOrderStatus($OrderStatus);
                $order->setPaymentDate(new \DateTime());
            }
        } else {
            return false;
        }
        return true;
    }

    /*
     * 取消
     */
    public function paymentCancel($order, $config)
    {
        $toApiPostData = array(
            'clientip' => $config->getClientip(),
            'return' => 'yes',
            'ordd' => $order->getZeusOrderId(),
        );
        
        try {
            $response = $this->secureSendRequest($this->eccubeConfig['zeus_secure_link_batch_url'], $toApiPostData, "POST");
            log_notice('ゼウス応答結果(cancel)：' . $response);
            if (strstr($response, 'SuccessOK')) {
                return true;
            } else {
                log_error('ゼウス取消に失敗(' . $order->getZeusOrderId() .')：' . $response);
                return false;
            }
            
        } catch (BadResponseException $e) {
            log_error('ゼウス通信失敗：' . $e->getMessage());
            return false;
        }
    }
    
    /*
     * 取消
     */
    public function paymentSetSale($order, $config, $king = 0, $date = null, $authtype = 'sale')
    {
        if (($king != 0) && (($king < $order->getPaymentTotal() - 5000) || ($king > $order->getPaymentTotal() + 5000))) {
            return "実売上の金額は仮売上時の金額より±5000円以内のみ変更可能。";
        }
        
        if ($king == 0) {
            $king = intval($order->getPaymentTotal());
        }
        
        if ($date == null) {
            $date = date('Ymd');
        }
            
        $toApiPostData = array(
            'clientip' => $config->getClientip(),
            'king' => $king,
            'date' => $date,
            'ordd' => $order->getZeusOrderId(),
            'autype' => $authtype
        );
        
        try {
            $response = $this->secureSendRequest($this->eccubeConfig['zeus_secure_link_batch_url'], $toApiPostData, "POST");
            log_notice('ゼウス応答結果(' . $authtype . ')：' . $response);
            if (strstr($response, 'Success_order')) {
                return true;
            } else {
                log_error('ゼウス実売上に失敗(' . $order->getZeusOrderId() .')：' . $response);
                return false;
            }
            
        } catch (BadResponseException $e) {
            log_error('ゼウス通信失敗：' . $e->getMessage());
            return false;
        }
    }
    
    
    public function getEnrolXid($zeusResponse)
    {
        $pattern = "/<xid>(.*)<\/xid>/";
        preg_match($pattern, $zeusResponse, $matches);
        return (count($matches) > 1) ? $matches[1] : "";
    }

    public function getEnrolPaReq($zeusResponse)
    {
        $pattern = "/<PaReq>(.*)<\/PaReq>/";
        preg_match($pattern, $zeusResponse, $matches);
        return (count($matches) > 1) ? $matches[1] : "";
    }

    public function getEnrolAcsUrl($zeusResponse)
    {
        $pattern = "/<acs_url>(.*)<\/acs_url>/";
        preg_match($pattern, $zeusResponse, $matches);
        return (count($matches) > 1) ? $matches[1] : "";
    }
    
    public function getMaskCardNumber($zeusResponse)
    {
        $pattern = "/<number>(.*)<\/number>/";
        preg_match($pattern, $zeusResponse, $matches);
        return (count($matches) > 1) ? $matches[1] : "";
    }
    
    public function getStatus($zeusResponse)
    {
        $pattern = "/<status>(.*)<\/status>/";
        preg_match($pattern, $zeusResponse, $matches);
        return (count($matches) > 1) ? $matches[1] : "";
    }
    
    /*
     * カード番号にマスクをかける
     */
    public function setMaskCardNumber($zeusRequest)
    {
        $pattern = "/<number>(.*)<\/number>/";
        preg_match($pattern, $zeusRequest, $matches);
        if (count($matches) > 1) {
            $zeusRequest = str_replace($matches[1], $this->getMaskedCard($matches[1]), $zeusRequest);
        }
        return $zeusRequest;
    }

    public function getZeusPostData3dToEnrolReq($order, $config, $cvvPostData)
    {
        $customer = $order->getCustomer();
        $sendid = "";
        if (is_null($customer)) {
            $sendid = "ORD" . $order->getId();
        } else {
            $sendid = $customer->getId();
        }
        $tokenKey = '<token_key>' . $order->getZeusCreditPaymentToken() . '</token_key>';
        if ($order->getZeusCreditPaymentQuick() && $this->isQuickChargeOK($order, $config->getCreditPayment())) {
            return "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . "  <request  service=\"secure_link_3d\" action=\"enroll\">" . "    <authentication>" . "      <clientip>" . $config->getClientip() . "</clientip>" . "      <key>" . $config->getClientauthkey() . "</key>" . "    </authentication>" . $tokenKey . "    <card>" . "      <history action=\"send_email\">" . "        <key>telno</key>" . "        <key>sendid</key>" . "      </history>" . $cvvPostData . "    </card>" . "    <payment>" . "      <amount>" . $order->getPaymentTotal() . "</amount>" . "      <count>" . $order->getZeusCreditPaymentMethod() . "</count>" . "    </payment>" . "    <user>" . "      <email>" . $order->getEmail() . "</email>" . "      <telno validation=\"permissive\">" . $order->getPhoneNumber() . "</telno>" . "    </user>" . "    <uniq_key>" . "      <sendid>" . $sendid . "</sendid>" . "      <sendpoint>" . $order->getId() . "</sendpoint>" . "    </uniq_key>" . "</request>";
        } else {
            return "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . "  <request  service=\"secure_link_3d\" action=\"enroll\">" . "    <authentication>" . "      <clientip>" . $config->getClientip() . "</clientip>" . "      <key>" . $config->getClientauthkey() . "</key>" . "    </authentication>" . $tokenKey . "    <payment>" . "      <amount>" . $order->getPaymentTotal() . "</amount>" . "      <count>" . $order->getZeusCreditPaymentMethod() . "</count>" . "    </payment>" . "    <user>" . "      <email>" . $order->getEmail() . "</email>" . "      <telno validation=\"permissive\">" . $order->getPhoneNumber() . "</telno>" . "    </user>" . "    <uniq_key>" . "      <sendid>" . $sendid . "</sendid>" . "      <sendpoint>" . $order->getId() . "</sendpoint>" . "    </uniq_key>" . "</request>";
        }
    }

    public function getZeusPostData3dToAuthReq($md, $pares)
    {
        return "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . "  <request service=\"secure_link_3d\" action=\"authentication\">" . "    <xid>" . $md . "</xid>" . "    <PaRes>" . $pares . "</PaRes>" . "</request>";
    }

    public function getZeusPostData3dToPayReq($md)
    {
        return "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . "  <request service=\"secure_link_3d\" action=\"payment\">" . "  <xid>" . $md . "</xid>" . "</request>";
    }

    public function acsPostRedirect($url, $postdata = '')
    {
        $this->response = new Response(
            "<html>\n" . "<head>\n" . "<title>3D Secure</title>\n" . "<SCRIPT LANGUAGE=\"Javascript\">\n" . "<!--  \n" . "function OnLoadEvent() {  \n" . " document.downloadForm.submit(); \n" . "} \n" . "//-->  \n" . "</SCRIPT>  \n" . "</head>  " . "<body onload=\"OnLoadEvent();\">  " . "<form name=\"downloadForm\" action=\"" . $url . "\" method=\"POST\">  " . "<noscript>  " . "<h3>Please click Submit to continue the processing of your 3-D Secure transaction.</h3><BR>  " . "<input type=\"submit\" value=\"処理を続ける\">  " . "</div>  " . "</noscript>  " . "<input type=\"hidden\" name=\"PaReq\"   value=\"" . htmlspecialchars($postdata['PaReq']) . "\">  " . "<input type=\"hidden\" name=\"MD\"      value=\"" . htmlspecialchars($postdata['MD']) . "\">  " . "<input type=\"hidden\" name=\"TermUrl\" value=\"" . htmlspecialchars($postdata['TermUrl']) . "\">  " . "</form>  " . "</body>  " . "</html>",
            Response::HTTP_OK,
            array('content-type' => 'text/html; charset=utf-8',
                'Cache-Control' => 'no-cache, must-revalidate')
            );
    }

    public function getZeusPostDataInformation($ipcode, $key)
    {
        return "<?xml version=\"1.0\" encoding=\"utf-8\"?>" . "<request service=\"information\" action=\"ec_plugin\">" . "  <authentication>" . "    <clientip>" . $ipcode . "</clientip>" . "    <key>" . $key . "</key>" . "  </authentication>" . "</request>";
    }
    
    public function getZeusResultData($zeusResponse, $pattern)
    {
        preg_match($pattern, $zeusResponse, $matches);
        return (count($matches) > 1) ? $matches[1] : "";
    }

    public function getUniqKey()
    {
        return sha1(uniqid(mt_rand(), true));
    }

    function getSendPoint($privateKey, $ipcode, $orderId)
    {
        return sha1($privateKey . $this->numberToStrReplace($ipcode . $orderId));
    }

    function numberToStrReplace($val)
    {
        $search = array(
            0,
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9
        );
        $replace = array(
            'D',
            'Y',
            'Z',
            'J',
            'W',
            'M',
            'T',
            'S',
            'B',
            'P'
        );
        return str_replace($search, $replace, $val);
    }

    /*
     * コンビニ決済、銀行振り込みの戻り処理
     */
    public function receive($type, $zeusResponse, $mdlName)
    {
        $ip = $this->getIp();
        if (!$this->isValidIp($ip)) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更]IP(' . $ip . ')が許可されていません。' . trim($this->eccubeConfig['zeus_resp_server_ips']));
        }
        // EC-CUBEデータの取得
        $configRepository = $this->entityManager->getRepository(Config::class);
        $config = $configRepository->get();
        if (empty($config)) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更]管理画面での設定が完了しておりません。');
        }

        // リクエスト情報チェック
        if (empty($zeusResponse['order_no'])) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] ゼウスリクエストデータのオーダー番号が不正です。order_no:' . $zeusResponse['order_no']);
        }
        if ($config->getClientipByType($type) != $zeusResponse['clientip']) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] ゼウスリクエストデータのIPコードが不正です。clientip:' . $zeusResponse['clientip']);
        }
        if (empty($zeusResponse['sendid'])) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] ユニークキーが設定されていません。sendid:' . $zeusResponse['sendid']);
        }

        $orderRepository = $this->entityManager->getRepository(Order::class);
        $order = $orderRepository->find($zeusResponse['sendid']);
        if (empty($order)) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] この注文情報は登録されていません。注文番号:' . $zeusResponse['sendid']);
        }
        if ($order->getPayment() != $config->getPayment($type)) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] ' . $mdlName . 'データではありません。注文番号:' . $zeusResponse['sendid']);
        }
        if (empty($zeusResponse['money'])) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] ユニークキーが設定されていません。money:' . $zeusResponse['money']);
        }
        if (intval($zeusResponse['money'])!=round($order->getPaymentTotal())) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] フリーパラメータが不正です。money:' . $zeusResponse['money']);
        }
        if (empty($zeusResponse['sendpoint'])) {
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] フリーパラメータが設定されていません。sendpoint:' . $zeusResponse['sendpoint']);
        }

        if ($this->sendPointCheck($zeusResponse['sendpoint'], $config->getKey($type), $zeusResponse['clientip'], $zeusResponse['sendid'])) { // EC-CUBE order_id
            return $this->errorExit('[ゼウス' . $mdlName . 'ステータス変更] フリーパラメータが不正です。sendpoint:' . $zeusResponse['sendpoint']);
        }

        switch ($type) {
            case 'cvs':
                if (! $this->orderStatusUpdateCvs($order, $zeusResponse)) {
                    return "Failed";
                }
                break;
            case 'ebank':
                if (! $this->orderStatusUpdateEbank($order, $zeusResponse)) {
                    return "Failed";
                }
                break;
            default:
                break;
        }
        log_notice('[ゼウス' . $mdlName . 'ステータス変更]処理終了');
        return "OK";
    }

    /*
     * コンビニ決済の注文データを更新
     */
    function orderStatusUpdateCvs($order, $zeusResponse)
    {
        if ($order) {
            $payNo = (empty($zeusResponse['pay_no1'])) ? $zeusResponse['pay_no2'] : $zeusResponse['pay_no1'];
            $payLimit = (strlen($zeusResponse['pay_limit']) == 8) ? substr($zeusResponse['pay_limit'], 0, 4) . '/' . substr($zeusResponse['pay_limit'], 4, 2) . '/' . substr($zeusResponse['pay_limit'], 6, 2) : $zeusResponse['pay_limit'];
            $memo = "ゼウスオーダー番号：[" . $zeusResponse['order_no'] . "]\n" . "払込番号：[" . $payNo . "]\n" . "支払期日：[" . $payLimit . "]\nステータス：[" . $zeusResponse['status'] . "]\n";

            $orderStatus = '';

            $oldOrderStatusObject = $order->getOrderStatus();

            switch ($zeusResponse['status']) {
                case $this->eccubeConfig['zeus_cvs_not_credited']: // 未入金
                    $orderStatus = OrderStatus::NEW; // ->入金待ち
                    break;

                case $this->eccubeConfig['zeus_cvs_preliminary_deposit']: // 速報済（入金速報時）
                    $order->setPaymentDate(new \DateTime());
                    $orderStatus = OrderStatus::PAID; // ->入金済み(注文受付)
                    break;

                case $this->eccubeConfig['zeus_cvs_cancel_payment']: // 速報取消（入金取消時）
                    $orderStatus = OrderStatus::CANCEL; // ->キャンセル
                    break;
                default:
                    return true;
            }
            $saveOrderErr = "注文情報作成失敗しました。";
            try {
                $note = $order->getNote();
                $saveOrderFailed = ($saveOrderErr === substr($note, - strlen($saveOrderErr)));
                if (strlen($note) > 0) {
                    $str = $note . "\r\n";
                    if ($saveOrderFailed) {
                        $memo = $memo . "\r\n" . $saveOrderErr;
                    }
                } else {
                    $str = "";
                }
                $order->setNote($str . $memo);
                $newOrderStatus = $this->orderStatusRepository->find($orderStatus);
                $order->setOrderStatus($newOrderStatus);

                if ($zeusResponse['status'] == $this->eccubeConfig['zeus_cvs_not_credited']) {
                    $order->setZeusOrderId($zeusResponse['order_no']);
                    $order->setZeusResponseData(print_r($zeusResponse,true));
                    if (null === $order->getOrderDate()) {
                        $order->setOrderDate(new \DateTime());
                    }

                    //$this->checkStock($order);

                    $this->purchaseFlow->prepare($order, new PurchaseContext());
                    $this->purchaseFlow->commit($order, new PurchaseContext());
                } elseif($zeusResponse['status'] == $this->eccubeConfig['zeus_cvs_cancel_payment'] && $oldOrderStatusObject->getId()!=$orderStatus){
                    $order->setOrderStatus($oldOrderStatusObject);
                    $this->orderStateMachine->apply($order, $newOrderStatus);
                }
                $order->setOrderStatus($this->orderStatusRepository->find($orderStatus));
                $this->entityManager->persist($order);
                $this->entityManager->flush();
                if ($zeusResponse['status'] == $this->eccubeConfig['zeus_cvs_not_credited']) {
                    $this->mailService->sendOrderMail($order);
                    $this->entityManager->flush();
                }


            } catch (\Throwable $e) {
                $this->errorExit('[ゼウスコンビニ決済ステータス変更] ステータス変更失敗。sendpoint:' . $zeusResponse['sendpoint'] . " " . $e->getMessage());
                log_error($e);

                $orderRepository = $this->entityManager->getRepository(Order::class);
                $order = $orderRepository->find($zeusResponse['sendid']);

                $curStatusId = $order->getOrderStatus()->getId();
                if ($curStatusId != $orderStatus) {
                    $order->setNote($str . $memo);
                    $order->setOrderStatus($this->orderStatusRepository->find->find($orderStatus));
                }

                if (strlen($order->getNote()) > 0) {
                    $str = $order->getNote() . "\r\n";
                } else {
                    $str = "";
                }
                $order->setNote($str . $saveOrderErr);
                $this->entityManager->persist($order);
                $this->entityManager->flush();
                return false;
            }
        }
        return true;
    }

    /*
     * 銀行振込決済の注文データを更新
     */
    function orderStatusUpdateEbank($order, $zeusResponse)
    {
        if ($order) {
            $memo = "ゼウスオーダー番号：[" . $zeusResponse['order_no'] . "]\n" . "受付番号：[" . $zeusResponse['tracking_no'] . "]\nステータス：[" . $zeusResponse['status'] . "]\n";

            $orderStatus = '';
            switch ($zeusResponse['status']) {
                case $this->eccubeConfig['zeus_ebank_wait']: // 受付中
                case $this->eccubeConfig['zeus_ebank_not_paid']: // 未入金
                    $orderStatus = OrderStatus::NEW; // ->入金待ち
                    break;
                case $this->eccubeConfig['zeus_ebank_paid']: // 入金済
                    $order->setPaymentDate(new \DateTime());
                    $orderStatus = OrderStatus::PAID; // ->入金済み(注文受付)
                    break;
                case $this->eccubeConfig['zeus_ebank_error']: // エラー
                    return true;
                case $this->eccubeConfig['zeus_ebank_failed']: // 未入金
                    $orderStatus = OrderStatus::CANCEL; // ->キャンセル
                    break;
                default:
                    return true;
            }
            try {
                if (strlen($order->getNote()) > 0) {
                    $str = $order->getNote() . "\r\n";
                } else {
                    $str = "";
                }
                $order->setNote($str . $memo);
                $order->setOrderStatus($this->orderStatusRepository->find($orderStatus));

                if ($zeusResponse['status'] == $this->eccubeConfig['zeus_ebank_paid']) {

                    $order->setZeusOrderId($zeusResponse['order_no']);
                    $order->setZeusResponseData(print_r($zeusResponse,true));
                    if (null === $order->getOrderDate()) {
                        $order->setOrderDate(new \DateTime());
                    }

                    //$this->checkStock($order);

                    $this->purchaseFlow->prepare($order, new PurchaseContext());
                    $this->purchaseFlow->commit($order, new PurchaseContext());
                }
                $order->setOrderStatus($this->orderStatusRepository->find($orderStatus));
                $this->entityManager->persist($order);
                $this->entityManager->flush();
                if ($zeusResponse['status'] == $this->eccubeConfig['zeus_ebank_paid']) {
                    $this->mailService->sendOrderMail($order);
                    $this->entityManager->flush();
                }

            } catch (\Throwable $e) {
                $this->errorExit('[ゼウス銀行振込決済ステータス変更] ステータス変更失敗。sendpoint:' . $zeusResponse['sendpoint'] . " " . $e->getMessage());
                log_error($e);

                $orderRepository = $this->entityManager->getRepository(Order::class);
                $order = $orderRepository->find($zeusResponse['sendid']);

                $curStatusId = $order->getOrderStatus()->getId();
                if ($curStatusId != $orderStatus) {
                    $order->setNote($str . $memo);
                    $order->setOrderStatus($this->app['eccube.repository.order_status']->find($orderStatus));
                }

                if (strlen($order->getNote()) > 0) {
                    $str = $order->getNote() . "\r\n";
                } else {
                    $str = "";
                }
                $order->setNote($str . "注文情報作成失敗しました。");
                $this->entityManager->persist($order);
                $this->entityManager->flush();
                return false;
            }
        }
        return true;
    }

/* 支払成功の場合は在庫チェックしない
    function checkStock($order)
    {
        foreach($order->getItems() as $item){
            if (!$item->isProduct()) {
                continue;
            }
            if ($item->getProductClass()->isStockUnlimited()) {
                continue;
            }
            $stock = $item->getProductClass()->getStock();
            $quantity = $item->getQuantity();
            if ($stock == 0) {
                throw new \Exception("商品ステータスが変更されました。");
            }
            if ($stock < $quantity) {
                throw new \Exception("商品ステータスが変更されました。");
            }
        }
    }
*/
    function sendPointCheck($sendpoint, $privateKey, $ipcode, $orderId)
    {
        $checkUniqKey = sha1($privateKey . $this->numberToStrReplace($ipcode . $orderId));
        return ! ($sendpoint === $checkUniqKey);
    }

    function getIp() {
        $fields = array(
            'HTTP_CF_CONNECTING_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        );

        foreach ( $fields as $ip_field ) {
            if ( ! empty( $_SERVER[ $ip_field ] ) ) {
                return $_SERVER[ $ip_field ];
            }
        }
        return null;
    }

    function isValidIp($ip) {
        $allowedIps = trim($this->eccubeConfig['zeus_resp_server_ips']);

        if ($allowedIps != '') {
            $ips = explode(",", $allowedIps);
            return in_array($ip, $ips);
        }

        return true; //allow all ips if not set
    }

    function errorExit($message)
    {
        log_error($message);
        log_error('処理終了_受信データが不正です');
        header('HTTP/1.1 400 Bad Request');
        return "Failed";
    }
    
    function formatPrice($number) {
        $locale = $this->eccubeConfig['locale'];
        $currency = $this->eccubeConfig['currency'];
        $formatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        
        return $formatter->formatCurrency($number, $currency);
        
    }
}
