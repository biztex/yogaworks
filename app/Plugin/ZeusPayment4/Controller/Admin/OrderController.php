<?php

namespace Plugin\ZeusPayment4\Controller\Admin;

use Eccube\Controller\AbstractController;
use Eccube\Entity\Order;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\Master\PageMax;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Plugin\ZeusPayment4\Form\Type\Admin\OrderFormType;
use Knp\Component\Pager\PaginatorInterface;
use Plugin\ZeusPayment4\Repository\ConfigRepository;
use Plugin\ZeusPayment4\Entity\Config;
use Eccube\Service\OrderStateMachine;
use Symfony\Component\Workflow\StateMachine;
use Plugin\ZeusPayment4\Service\ZeusPaymentService;

/*
 * ゼウス注文管理コントローラー
 */
class OrderController extends AbstractController
{
    protected $title;
    protected $subtitle;
    protected $orderStateMachine;
    protected $machine;
    protected $zeusPaymentService;
    
    public function __construct(OrderStateMachine $orderStateMachine, StateMachine $_orderStateMachine, ZeusPaymentService $zeusPaymentService)
    {
        $this->title = '受注管理';
        $this->subtitle = 'ゼウス受注管理';
        $this->orderStateMachine = $orderStateMachine;
        $this->machine = $_orderStateMachine;
        $this->zeusPaymentService = $zeusPaymentService;
    }

    /**
     * ゼウス受注管理画面
     * @Route("/%eccube_admin_route%/order/zeus_payment/{page_no}", name="zeus_order_list")
     * @Template("@ZeusPayment4/admin/order.twig")
     */
    public function index(Request $request, PaginatorInterface $paginator, $page_no = null)
    {
        $session = $request->getSession();
        $searchForm = $this->formFactory->createBuilder(OrderFormType::class)->getForm();

        $pagination = array();
        $pageMaxis = $this->entityManager->getRepository(PageMax::class)->findAll();
        $page_count = $this->eccubeConfig->get('eccube_default_page_count');

        $active = false;
        
        $configRepository = $this->entityManager->getRepository(Config::class);
        $config = $configRepository->get();
        if ('POST' === $request->getMethod()) {
            $searchForm->handleRequest($request);
            
            if ($searchForm->isSubmitted() && $searchForm->isValid()) {
                $searchData = $searchForm->getData();

                // paginator
                $qb = $this->getSearchQd($searchData, $config);
                $page_no = 1;
                $pagination = $paginator->paginate($qb, $page_no, $page_count);
                
                // sessionのデータ保持
                $session->set('eccube.plugin.zeus_payment.admin.order.search', $searchData);
                $active = true;
            }
        } else {
            if (is_null($page_no)) {
                // sessionを削除
                $session->remove('eccube.plugin.zeus_payment.admin.order.search');
            } else {
                // pagingなどの処理
                $searchData = $session->get('eccube.plugin.zeus_payment.admin.order.search');
                if (! is_null($searchData)) {
                    // 表示件数
                    $pcount = $request->get('page_count');
                    $page_count = empty($pcount) ? $page_count : $pcount;
                    
                    $qb = $this->getSearchQd($searchData, $config);
                    $pagination = $paginator->paginate($qb, $page_no, $page_count);

                    // セッションから検索条件を復元
                    $searchForm->setData($searchData);
                    $active = true;
                }
            }
        }
        return[
            'maintitle' => $this->title,
            'subtitle' => $this->subtitle,
            'searchForm' => $searchForm->createView(),
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_no' => $page_no,
            'page_count' => $page_count,
            'active' => $active,
            'can_cancel_status' => $this->getCanCancelStates(),
            'credit_payment_method' => $config->getCreditPayment()->getMethod()
        ];
    }

    private function getSearchQd($searchData, $config)
    {
        $repository = $this->entityManager->getRepository(Order::class);
        $paymentIds = [-1];
        $payments = $config->getPayments();
        foreach ($payments as $payment) {
            $paymentIds[] = $payment->getId();
        }
        //add join to keep same results as eccube order list
        $query = $repository->createQueryBuilder('o')->where("o.Payment IN (:Payments)")
        ->leftJoin('o.OrderItems', 'oi')
        ->leftJoin('o.Pref', 'pref')
        ->innerJoin('o.Shippings', 's');
        $query->andWhere($query->expr()->notIn('o.OrderStatus', ':order_status'))
        ->setParameter('order_status', [OrderStatus::PROCESSING, OrderStatus::PENDING]);
        
        $query->setParameter('Payments', $paymentIds);
        $orderId = isset($searchData['order_id'])?trim($searchData['order_id']):'';
        if (! empty($orderId) && $orderId) {
            $query->andWhere('o.id = :order_id')->setParameter('order_id', $this->toInt($orderId));
        }

        // zeus_order_id
        $zeusOrderId = isset($searchData['zeus_order_id'])?trim($searchData['zeus_order_id']):'';
        if ($zeusOrderId!=='') {
            $query->andWhere('o.zeus_order_id LIKE :zeus_order_id')->setParameter(
                'zeus_order_id',
                '%' . $zeusOrderId . '%'
            );
        }

        // zeus_sale_type
        $zeusSaleType = isset($searchData['zeus_sale_type'])?trim($searchData['zeus_sale_type']):'-1';
        if ($zeusSaleType >= 0) {
            $query->andWhere('o.zeus_sale_type = :zeus_sale_type')->setParameter(
                'zeus_sale_type',
                $zeusSaleType
                );
            $query->andWhere('o.Payment = :zeus_credit_payment')->setParameter(
                'zeus_credit_payment',
                $config->getCreditPayment()
                );
        }
        
        // multi
        $multi = isset($searchData['multi'])?trim($searchData['multi']):'';
        //$multi = preg_match('/^\d+$/', $multi) ? $multi : '';
        if ($multi!=='') {
            $query->andWhere('o.id = :multi OR o.zeus_order_id LIKE :likemulti ')
                ->setParameter('multi', $this->toInt($multi))
                ->setParameter('likemulti', '%' . $multi . '%');
        }

        // Order By
        $query->addOrderBy('o.id', 'DESC');

        return $query;
    }

    /**
     * 一括キャンセル
     * @Route("/%eccube_admin_route%/order/zeus_cancel", name="zeus_order_cancel")
     */
    public function cancelAll(Request $request)
    {
        $ids = "";
        $fail_ids = "";
        $fail_zeus_ids = "";
        $orderStatus = $this->entityManager->getRepository(
            '\Eccube\Entity\Master\OrderStatus'
        )->find(OrderStatus::CANCEL);
        $orderRepo = $this->entityManager->getRepository('\Eccube\Entity\Order');

        $configRepository = $this->entityManager->getRepository(Config::class);
        $config = $configRepository->get();
        $paymentIds = [-1];
        $payments = $config->getPayments();
        foreach ($payments as $payment) {
            $paymentIds[] = $payment->getId();
        }

        $cnt = 0;
        foreach ($request->query->all() as $key => $value) {
            $cnt++;
            $id = str_replace('ids', '', $key);
            $order = $orderRepo->find($id);
            $payment = $order->getPayment();
            if ($order && $payment && in_array($payment->getId(), $paymentIds)) {
                if ($this->orderStateMachine->can($order, $orderStatus)) {
                    $order->setZeusSkipCancel(true);
                    $ids = $id . ', ' . $ids;
                    $this->orderStateMachine->apply($order, $orderStatus);
                    
                    //cancel zeus
                    if ($payment->getId() == $config->getCreditPayment()->getId()) {
                        if (!$this->zeusPaymentService->paymentCancel($order, $config)) {
                            $fail_zeus_ids = $id . ', ' . $fail_zeus_ids;
                        } else {
                            if (strlen($order->getNote()) > 0) {
                                $str = $order->getNote() . "\r\n";
                            } else {
                                $str = "";
                            }
                            $order->setNote($str . '[' . date("Y-m-d H:i:s") . '] 取消処理を行いました。');
                        }
                    }
                    $order->setZeusSkipCancel(false);
                    $this->entityManager->persist($order);
                    
                } else {
                    $fail_ids = $id . ', ' . $fail_ids;
                }
            }
        }
        $this->entityManager->flush();
        $ids = substr($ids, 0, - 2);
        $fail_ids = substr($fail_ids, 0, - 2);
        $fail_zeus_ids = substr($fail_zeus_ids, 0, - 2);

        if ($ids) {
            $this->addSuccess((($cnt > 1)?'一括':'') . 'キャンセルしました。( ID => ' . $ids . ' )', 'admin');
        }
        if ($fail_zeus_ids) {
            $this->addWarning('ゼウス側の取消に失敗しました。( ID => ' . $fail_zeus_ids . ' )', 'admin');
        }
        if ($fail_ids) {
            $this->addWarning((($cnt > 1)?'一括':'') . 'キャンセルに失敗しました。( ID => ' . $fail_ids . ' )', 'admin');
        }
        $pageNo = $request->get('page_no');
        if (empty($pageNo)) {
            $pageNo = 1;
        }
        return $this->redirect($this->generateUrl('zeus_order_list', ['page_no' => $pageNo, 'page_count' => $request->get('page_count')]));
    }

    /**
     * 一括実売上
     * @Route("/%eccube_admin_route%/order/zeus_setsale", name="zeus_order_setsale")
     */
    public function setSaleAll(Request $request)
    {
        $ids = "";
        $fail_ids = "";
        $fail_zeus_ids = "";
        $not_creditpayment_ids = "";
        $orderStatus = $this->entityManager->getRepository(
            '\Eccube\Entity\Master\OrderStatus'
            )->find(OrderStatus::PAID);
            $orderRepo = $this->entityManager->getRepository('\Eccube\Entity\Order');
            
	        $configRepository = $this->entityManager->getRepository(Config::class);
	        $config = $configRepository->get();
            $creditPaymentId = $config->getCreditPayment()->getId();
            $cnt = 0;
            foreach ($request->query->all() as $key => $value) {
                $cnt++;
                $id = str_replace('ids', '', $key);
                $order = $orderRepo->find($id);
                $payment = $order->getPayment();
                if ($order && $payment && ($payment->getId() == $creditPaymentId)) {
                    $id = str_replace('ids', '', $key);
                    if ($this->orderStateMachine->can($order, $orderStatus)) {
                        $ids = $id . ', ' . $ids;
                        if (strlen($order->getNote()) > 0) {
                            $str = $order->getNote() . "\r\n";
                        } else {
                            $str = "";
                        }
                        $ret = $this->zeusPaymentService->paymentSetSale($order, $config);
                        if ($ret !== true) {
                            $fail_zeus_ids = $id . ', ' . $fail_zeus_ids;
                            if ($ret !== false) {
                                $this->addWarning($ret . '( ID => ' . $id . ' )', 'admin');
                            }
                            $order->setNote($str . '[' . date("Y-m-d H:i:s") . '] 実売上処理失敗しました。');
                        } else {
                            $order->setNote($str . '[' . date("Y-m-d H:i:s") . '] 実売上処理を行いました。');
                            $order->setZeusSaleType(0);
                            $this->orderStateMachine->apply($order, $orderStatus);
                            $order->setPaymentDate(new \DateTime());
                        }
                        $order->setUpdateDate(new \DateTime());
                        $this->entityManager->persist($order);
                    } else {
                        $fail_ids = $id . ', ' . $fail_ids;
                    }
                } else {
                    $not_creditpayment_ids = $id . ', ' . $not_creditpayment_ids;
                }
            }
            $this->entityManager->flush();
            $ids = substr($ids, 0, - 2);
            $fail_ids = substr($fail_ids, 0, - 2);
            $fail_zeus_ids = substr($fail_zeus_ids, 0, - 2);
            $fail_zeus_ids = substr($not_creditpayment_ids, 0, - 2);
            
            
            if ($ids) {
                $this->addSuccess((($cnt > 1)?'一括':'') . '実売上を実行しました。( ID => ' . $ids . ' )', 'admin');
            }
            if ($fail_zeus_ids) {
                $this->addWarning('ゼウス側の実売上操作に失敗しました。( ID => ' . $fail_zeus_ids . ' )', 'admin');
            }
            if ($fail_ids) {
                $this->addWarning((($cnt > 1)?'一括':'') . '実売上操作に失敗しました。( ID => ' . $fail_ids . ' )', 'admin');
            }
            if ($not_creditpayment_ids) {
                $this->addWarning('クレカ払いではないので、実売上操作不要です。( ID => ' . $not_creditpayment_ids . ' )', 'admin');
            }
            
            $pageNo = $request->get('page_no');
            if (empty($pageNo)) {
                $pageNo = 1;
            }
            return $this->redirect($this->generateUrl('zeus_order_list', ['page_no' => $pageNo, 'page_count' => $request->get('page_count')]));
    }
    
    private function toInt($sid){

        $max = 0xffffffff;
        $max = ($max-1)/2;
        $sid = intval($sid);
        if($sid>$max || $sid<0){
            $sid = 0;
        }

        return $sid;
    }

    private function getCanCancelStates()
    {
        $transitions = $this->machine->getDefinition()->getTransitions();
        $status = [];
        foreach ($transitions as $t) {
            if ($t->getName() == 'cancel') {
                $status =  array_merge($status, $t->getFroms());
            }
        }
        return $status;
    }
}
