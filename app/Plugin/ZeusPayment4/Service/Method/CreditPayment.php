<?php

namespace Plugin\ZeusPayment4\Service\Method;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\Order;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Service\Payment\PaymentMethodInterface;
use Eccube\Service\Payment\PaymentResult;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Plugin\ZeusPayment4\Repository\ConfigRepository;
use Plugin\ZeusPayment4\Service\ZeusPaymentService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * ゼウス決済クレジットカード(トークン決済)の決済処理を行う.
 */
class CreditPayment implements PaymentMethodInterface
{
    /**
     * @var Order
     */
    protected $Order;

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var OrderStatusRepository
     */
    private $orderStatusRepository;

    private $configRepository;

    /**
     * @var PurchaseFlow
     */
    private $purchaseFlow;

    private $paymentService;

    private $entityManager;

    private $route;

    private $eccubeConfig;

    /**
     * CreditCard constructor.
     *
     * @param OrderStatusRepository $orderStatusRepository
     * @param PurchaseFlow $shoppingPurchaseFlow
     */
    public function __construct(
        OrderStatusRepository $orderStatusRepository,
        PurchaseFlow $shoppingPurchaseFlow,
        ZeusPaymentService $paymentService,
        ConfigRepository $configRepository,
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        RouterInterface $route,
        EccubeConfig $eccubeConfig

    ) {
        $this->orderStatusRepository = $orderStatusRepository;
        $this->purchaseFlow = $shoppingPurchaseFlow;
        $this->paymentService = $paymentService;
        $this->configRepository = $configRepository;
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->route = $route;
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * 注文確認画面遷移時に呼び出される.
     *
     * クレジットカードの有効性チェックを行う.
     *
     * @return PaymentResult
     *
     * @throws \Eccube\Service\PurchaseFlow\PurchaseException
     */
    public function verify()
    {
        $token = $this->Order->getZeusCreditPaymentToken();
        if ($token) {
            $result = new PaymentResult();
            $result->setSuccess(true);
        } else {
            $result = new PaymentResult();
            $result->setSuccess(false);
            $result->setErrors([$this->eccubeConfig['zeus_auth_error_message']]);
        }

        return $result;
    }

    /**
     * 注文時に呼び出される.
     *
     * 受注ステータス, 決済ステータスを更新する.
     * ここでは決済サーバとの通信は行わない.
     *
     * @return PaymentDispatcher|null
     */
    public function apply()
    {
        $OrderStatus = $this->orderStatusRepository->find(OrderStatus::PENDING);
        $this->Order->setOrderStatus($OrderStatus);
    }

    /**
     * 注文時に呼び出される.
     *
     * クレジットカードの決済処理を行う.
     *
     * @return PaymentResult
     */
    public function checkout()
    {
        // 決済サーバに仮売上のリクエスト送る(設定等によって送るリクエストは異なる)
        $token = $this->Order->getZeusCreditPaymentToken();
        $config = $this->configRepository->get();
        $error_message = '';
        $to_error_page = false;
        if ($token) {
            if ($this->paymentService->isProcessing($this->Order)) {
                $error_message = $this->eccubeConfig['zeus_processing_error_message'];
            } else {
                try {
                    $this->paymentService->response = null;

                    if (! $this->paymentService->sendCreditData($this->Order, $config)) {
                        if ($this->paymentService->response != null) {
                            $result = new PaymentResult();
                            $result->setResponse($this->paymentService->response);
                            return $result;
                        }
                        $error_message = $this->eccubeConfig['zeus_auth_error_message'];
                    }


                    $this->purchaseFlow->prepare($this->Order, new PurchaseContext());
                    // purchaseFlow::commitを呼び出し, 購入処理を完了させる.
                    $this->purchaseFlow->commit($this->Order, new PurchaseContext());

                    $OrderStatus = $this->orderStatusRepository->find($config->getOrderStatusForSaleType());
                    $this->Order->setOrderStatus($OrderStatus);
                    $this->Order->setPaymentDate(new \DateTime());


                } catch (\Throwable $e) {
                    log_error('注文完了できません。' . $e->getMessage()); //$e->getMessage()
                    log_error($e);

                    $error_message = '購入処理でエラーが発生しました。支払手続きは完了している可能性がありますので、サイトまでお問い合わせください。';
                }
            }

        } else {
            $error_message = $this->eccubeConfig['zeus_auth_error_message'];
        }

        $result = new PaymentResult();
        if ($error_message) {
            if ($to_error_page) {
                $result->setSuccess(false);
                $result->setErrors([$error_message]);
            } else {
                $this->entityManager->flush();
                $this->entityManager->rollback();
                $this->session->getFlashBag()->add('eccube.front.error', $error_message);
                $result->setResponse(new RedirectResponse($this->route->generate('shopping')));
            }
        } else {
            $result->setSuccess(true);

            $this->session->remove('zeus_card.method');
            $this->session->remove('zeus_card.token');
            $this->session->remove('zeus_card.quick');
            $this->session->remove('zeus_card.name1');
            $this->session->remove('zeus_card.name2');
            $this->session->remove('zeus_card.month');
            $this->session->remove('zeus_card.year');
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormType(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrder(Order $Order)
    {
        $this->Order = $Order;
    }
}
