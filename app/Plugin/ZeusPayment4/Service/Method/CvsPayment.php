<?php

namespace Plugin\ZeusPayment4\Service\Method;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\Order;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Service\Payment\PaymentMethodInterface;
use Eccube\Service\Payment\PaymentResult;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Service\PurchaseFlow\PurchaseFlow;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Eccube\Service\Payment\PaymentDispatcher;

/**
 * ゼウス決済クレジットカード(トークン決済)の決済処理を行う.
 */
class CvsPayment implements PaymentMethodInterface
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

    /**
     * @var PurchaseFlow
     */
    private $purchaseFlow;

    private $entityManager;

    private $router;


    /**
     * CreditCard constructor.
     *
     * @param OrderStatusRepository $orderStatusRepository
     * @param PurchaseFlow $shoppingPurchaseFlow
     */
    public function __construct(
        OrderStatusRepository $orderStatusRepository,
        PurchaseFlow $shoppingPurchaseFlow,
        EntityManagerInterface $entityManager,
        RouterInterface $router
    ) {
        $this->orderStatusRepository = $orderStatusRepository;
        $this->purchaseFlow = $shoppingPurchaseFlow;
        $this->entityManager = $entityManager;
        $this->router = $router;
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
        $result = new PaymentResult();
        $result->setSuccess(true);

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

        //reduce stoage move to ZeusPaymentService.php =======
        //$this->purchaseFlow->prepare($this->Order, new PurchaseContext());

        //$url = '/zeus_cvs_payment';
        $url = $this->router->generate('zeus_cvs_payment');
        $response = new RedirectResponse($url);
        $dispatcher = new PaymentDispatcher();
        $dispatcher->setResponse($response);

        return $dispatcher;
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
        $result = new PaymentResult();
        $result->setSuccess(true);
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
