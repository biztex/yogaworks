<?php
namespace Plugin\ZeusPayment4\Controller\Admin;

use Eccube\Controller\Admin\AbstractCsvImportController;
use Eccube\Entity\Order;
use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\Master\PageMax;
use Eccube\Repository\OrderRepository;
use Eccube\Service\CsvImportService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Plugin\ZeusPayment4\Form\Type\Admin\OrderFormType;
use Knp\Component\Pager\PaginatorInterface;
use Plugin\ZeusPayment4\Repository\ConfigRepository;
use Plugin\ZeusPayment4\Entity\Config;
use Plugin\ZeusPayment4\Form\Type\Admin\CsvImportType;
use Eccube\Service\OrderStateMachine;
use Symfony\Component\Workflow\StateMachine;
use Plugin\ZeusPayment4\Service\ZeusPaymentService;

/*
 * ゼウス取消CSVコントローラー
 */
class CancelCsvController extends AbstractCsvImportController
{

    protected $title;

    protected $subtitle;

    protected $orderStateMachine;

    protected $machine;

    protected $zeusPaymentService;

    protected $configRepository;

    /**
     *
     * @var OrderRepository
     */
    protected $orderRepository;

    public function __construct(OrderStateMachine $orderStateMachine, StateMachine $_orderStateMachine, ZeusPaymentService $zeusPaymentService, OrderRepository $orderRepository, ConfigRepository $configRepository)
    {
        $this->title = '受注管理';
        $this->subtitle = 'ゼウス取消CSV';
        $this->orderStateMachine = $orderStateMachine;
        $this->machine = $_orderStateMachine;
        $this->zeusPaymentService = $zeusPaymentService;
        $this->orderRepository = $orderRepository;
        $this->configRepository = $configRepository;
    }

    /**
     * ゼウス取消CSV登録管理画面
     *
     * @Route("/%eccube_admin_route%/order/zeus_cancel_csv", name="zeus_cancel_csv")
     * @Template("@ZeusPayment4/admin/cancel_csv.twig")
     */
    public function index(Request $request)
    {
        $form = $this->formFactory->createBuilder(CsvImportType::class)->getForm();
        $columnConfig = $this->getColumnConfig();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $formFile = $form['import_file']->getData();

                if (! empty($formFile)) {
                    $csv = $this->getImportData($formFile);

                    try {
                        $this->entityManager->getConfiguration()->setSQLLogger(null);
                        $this->entityManager->getConnection()->beginTransaction();

                        $this->loadCsv($csv);
                    } finally {
                        $this->removeUploadedFile();
                    }
                }
            }
        }

        return [
            'maintitle' => $this->title,
            'subtitle' => $this->subtitle,
            'form' => $form->createView(),
            'headers' => $columnConfig,
            'errors' => []
        ];
    }

    protected function loadCsv(CsvImportService $csv)
    {
        $columnConfig = $this->getColumnConfig();

        if ($csv === false) {
            $this->addErrors(trans('admin.common.csv_invalid_format'));
            return;
        }

        // 必須カラムの確認
        $requiredColumns = array_map(function ($value) {
            return $value['name'];
        }, array_filter($columnConfig, function ($value) {
            return $value['required'];
        }));
        $csvColumns = $csv->getColumnHeaders();
        if (count(array_diff($requiredColumns, $csvColumns)) > 0) {
            $this->addErrors(trans('admin.common.csv_invalid_format') . '（項目名が一致していません）' );
            return;
        }

        // 行数の確認
        $size = count($csv);
        if ($size < 1) {
            $this->addErrors(trans('admin.common.csv_invalid_format') . "（データがありません）");
            return;
        }

        $columnNames = array_combine(array_keys($columnConfig), array_column($columnConfig, 'name'));

        $ids = "";
        $fail_ids = "";
        $fail_zeus_ids = "";
        $not_zeus_ids = "";
        $not_creditpayment_ids = "";
        $config = $this->configRepository->get();
        $paymentIds = [-1];
        $payments = $config->getPayments();
        foreach ($payments as $payment) {
            $paymentIds[] = $payment->getId();
        }
        $creditPaymentId = $config->getCreditPayment()->getId();
        $orderStatus = $this->entityManager->getRepository(
            '\Eccube\Entity\Master\OrderStatus'
            )->find(OrderStatus::CANCEL);
        
        $errors = [];            
        foreach ($csv as $line => $row) {
            // 注文IDがなければエラー
            if (! isset($row[$columnNames['id']])) {
                $errors[] = trans('admin.common.csv_invalid_required', [
                    '%line%' => $line + 1,
                    '%name%' => $columnNames['id']
                ]);
                continue;
            }

            $id = $row[$columnNames['id']];
            $order = is_numeric($id) ? $this->orderRepository->find($id) : null;

            if (is_null($order)) {
                $errors[] = trans('admin.common.csv_invalid_not_found', [
                    '%line%' => $line + 1,
                    '%name%' => $columnNames['id']
                ]);
                continue;
            }

            $payment = $order->getPayment();
            if ($payment && in_array($payment->getId(), $paymentIds)) {
                if ($this->orderStateMachine->can($order, $orderStatus)) {
                    $order->setZeusSkipCancel(true);
                    $ids = $id . ', ' . $ids;
                    $this->orderStateMachine->apply($order, $orderStatus);
                    
                    //cancel zeus
                    if ($payment->getId() == $creditPaymentId) {
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
                    } else {
                        $not_creditpayment_ids = $id . ', ' . $not_creditpayment_ids;
                    }
                    $order->setZeusSkipCancel(false);
                    $order->setUpdateDate(new \DateTime());
                    $this->entityManager->persist($order);
                } else {
                    $fail_ids = $id . ', ' . $fail_ids;
                }
            } else {
                $not_zeus_ids = $id . ', ' . $not_zeus_ids;
            }
        }

        $ids = substr($ids, 0, - 2);
        $fail_ids = substr($fail_ids, 0, - 2);
        $fail_zeus_ids = substr($fail_zeus_ids, 0, - 2);
        $not_creditpayment_ids = substr($not_creditpayment_ids, 0, - 2);
        $not_zeus_ids = substr($not_zeus_ids, 0, - 2);

        if ($fail_zeus_ids) {
            $errors[] = 'ゼウス側の取消操作に失敗しました。( ID => ' . $fail_zeus_ids . ' )';
        }
        if ($fail_ids) {
            $errors[] = 'すでに取消済か、取消不可の注文ステータスです。( ID => ' . $fail_ids . ' )';
        }
        if ($not_creditpayment_ids) {
            $errors[] = 'クレカ払いではない支払方法です。ゼウス側の取消はゼウス側管理画面で操作してください。( ID => ' . $not_creditpayment_ids . ' )';
        }
        if ($not_zeus_ids) {
            $errors[] = 'ゼウスの支払方法ではないので、一括取消できません。( ID => ' . $not_zeus_ids . ' )';
        }
        
        if ($ids) {
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
            $this->addInfo('取消操作を実行しました。( ID => ' . $ids . ' )', 'admin');
        } 
        
        if (count($errors) > 0) {
            foreach ($errors as $err) {
                $this->addError($err, 'admin');
            }
        } elseif (!$ids) {
            $this->addInfo('取消実行対象ありませんでした', 'admin');
        }
    }
    
    function addErrors($errors) {
        if (is_array($errors)) {
            foreach ($errors as $err) {
                $this->addError($err, 'admin');
            }
        } else {
            $this->addError($errors, 'admin');
        }
    }

    /**
     * アップロード用CSV雛形ファイルダウンロード
     *
     * @Route("/%eccube_admin_route%/order/zeus_cancel_csv_template", name="zeus_cancel_csv_template")
     */
    public function csvTemplate(Request $request)
    {
        $columns = array_column($this->getColumnConfig(), 'name');

        return $this->sendTemplateResponse($request, $columns, 'zeus_cancel.csv');
    }

    protected function getColumnConfig()
    {
        return [
            'id' => [
                'name' => '注文ID',
                'description' => '注文ID',
                'required' => true
            ]
        ];
    }
}
