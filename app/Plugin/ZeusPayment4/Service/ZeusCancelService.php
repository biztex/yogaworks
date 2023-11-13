<?php
namespace Plugin\ZeusPayment4\Service;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Service\PurchaseFlow\PurchaseContext;
use Eccube\Exception\ShoppingException;
use Plugin\ZeusPayment4\Repository\ConfigRepository;
use Plugin\ZeusPayment4\Service\ZeusPaymentService;

// SymfonyのWorkflowコンポーネントのイベントを使用します。
use Symfony\Component\Workflow\Event\Event;

class ZeusCancelService implements EventSubscriberInterface {

    protected $zeusPaymentService;
    protected $configRepository;
    
    /**
     * ConfigController constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository, ZeusPaymentService $zeusPaymentService)
    {
        $this->configRepository = $configRepository;
        $this->zeusPaymentService = $zeusPaymentService;
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.order.transition.cancel' => [['cancel']],
        ];
    }
    
    /**
     * 対応状況が注文取消しに変わったときの処理
     *
     * @param Event $event
     */
    public function cancel(Event $event)
    {
        // 注文取消しになった受注データ
        $order = $event->getSubject()->getOrder();
        
        if (!$order->isZeusSkipCancel()) {
            $payment = $order->getPayment();
            
            $config = $this->configRepository->get();
            //cancel zeus
            if ($payment->getId() == $config->getCreditPayment()->getId()) {
                log_notice('ZEUS注文取消し：ID=>' . $order->getId());
                if (!$this->zeusPaymentService->paymentCancel($order, $config)) {
                    throw new ShoppingException('ゼウス側取消失敗しました。( ID => ' . $order->getId() . ' ) すでに取消済の可能性があります。ゼウス側管理画面をご確認ください。');
                } else {
                    if (strlen($order->getNote()) > 0) {
                        $str = $order->getNote() . "\r\n";
                    } else {
                        $str = "";
                    }
                    $order->setNote($str . '[' . date("Y-m-d H:i:s") . '] 取消処理を行いました。');
                }
            }
        }
    }
}