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
 * ゼウス注文CSVコントローラー
 */
class OrderCsvController extends AbstractCsvImportController
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
        $this->subtitle = 'ゼウス売上CSV';
        $this->orderStateMachine = $orderStateMachine;
        $this->machine = $_orderStateMachine;
        $this->zeusPaymentService = $zeusPaymentService;
        $this->orderRepository = $orderRepository;
        $this->configRepository = $configRepository;
    }

    /**
     * ゼウス売上CSV管理画面
     *
     * @Route("/%eccube_admin_route%/order/zeus_csv", name="zeus_order_csv")
     * @Template("@ZeusPayment4/admin/order_csv.twig")
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
        $not_creditpayment_ids = "";
        $config = $this->configRepository->get();
        $creditPaymentId = $config->getCreditPayment()->getId();
        $orderStatus = $this->entityManager->find(OrderStatus::class, OrderStatus::PAID);
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

            $date = null;
            $king = 0;
            $processDate = null;
            
            if (isset($row[$columnNames['king']]) && ("" != trim($row[$columnNames['king']]))) {
                if (!is_numeric($row[$columnNames['king']])) {
                    $errors[] = trans('%line%行目の%name%の金額は数字ではありません', [
                        '%line%' => $line + 1,
                        '%name%' => $columnNames['id']
                    ]);
                    continue;
                } else {
                    $king = intval($row[$columnNames['king']]);
                }
                
            }

            if (isset($row[$columnNames['date']]) && !empty($row[$columnNames['date']])) {
                $processDate = \DateTime::createFromFormat('Ymd', $row[$columnNames['date']]);
                $lastErros = \DateTime::getLastErrors();
                if ($processDate === false || $lastErros == false || $lastErros['warning_count'] > 0 || $lastErros['error_count'] > 0 ) {
                    $errors[] = trans('admin.common.csv_invalid_date_format', [
                        '%line%' => $line + 1,
                        '%name%' => $columnNames['date']
                    ]);
                    continue;
                }
                $date = $row[$columnNames['date']];
            }

            $payment = $order->getPayment();
            if ($payment && ($payment->getId() == $creditPaymentId)) {
                if ($this->orderStateMachine->can($order, $orderStatus)) {
                    $ids = $id . ', ' . $ids;
                    $ret = $this->zeusPaymentService->paymentSetSale($order, $config, $king, $date);
                    if (strlen($order->getNote()) > 0) {
                        $str = $order->getNote() . "\r\n";
                    } else {
                        $str = "";
                    }
                    if ($ret !== true ) {
                        $fail_zeus_ids = $id . ', ' . $fail_zeus_ids;
                        if ($ret !== false) {
                            $errors[] = $ret . '( ID => ' . $id . ' )';
                        }
                        $order->setNote($str . '[' . date("Y-m-d H:i:s") . '] 実売上処理失敗しました。');
                    } else {
                        $order->setNote($str . '[' . date("Y-m-d H:i:s") . '] 実売上' . 
                            (($king > 0)?('(実売上金額：'.$this->zeusPaymentService->formatPrice($king).')') : '') .
                            (($date != null)?('(実売上日：'.$date.')') : '') .                            
                            '処理を行いました。');
                        $order->setZeusSaleType(0);
                        $this->orderStateMachine->apply($order, $orderStatus);
                        if ($processDate && $processDate != null) {
                        	$order->setPaymentDate($processDate);
                        } else {
                        	$order->setPaymentDate(new \DateTime());
                        }
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

        $ids = substr($ids, 0, - 2);
        $fail_ids = substr($fail_ids, 0, - 2);
        $fail_zeus_ids = substr($fail_zeus_ids, 0, - 2);
        $not_creditpayment_ids = substr($not_creditpayment_ids, 0, - 2);

        if ($fail_zeus_ids) {
            $errors[] = 'ゼウス側の実売上操作に失敗しました。( ID => ' . $fail_zeus_ids . ' )';
        }
        if ($fail_ids) {
            $errors[] = '実売上操作に失敗しました。( ID => ' . $fail_ids . ' )';
        }
        if ($not_creditpayment_ids) {
            $errors[] = 'ゼウスクレカ払いではないので、実売上操作不要です。( ID => ' . $not_creditpayment_ids . ' )';
        }

        if ($ids) {
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
            $this->addInfo('実売上を実行しました。( ID => ' . $ids . ' )', 'admin');
        } 
        
        if (count($errors) > 0) {
            foreach ($errors as $err) {
                $this->addError($err, 'admin');
            }
        } elseif (!$ids) {
            $this->addInfo('実売上実行対象ありませんでした', 'admin');
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
     * @Route("/%eccube_admin_route%/order/zeus_csv_template", name="zeus_csv_template")
     */
    public function csvTemplate(Request $request)
    {
        $columns = array_column($this->getColumnConfig(), 'name');

        return $this->sendTemplateResponse($request, $columns, 'zeus_order.csv');
    }

    protected function getColumnConfig()
    {
        return [
            'id' => [
                'name' => '注文ID',
                'description' => '注文ID',
                'required' => true
            ],
            'king' => [
                'name' => '決済金額',
                'description' => '実売上にするときの決済金額、仮売上時の金額より±5000円以内で変更可能、空白または0の場合は仮売上時の決済金額となります。',
                'required' => false
            ],
            'date' => [
                'name' => '売上処理日(yyyymmdd)',
                'description' => '決済から90日間は仮売上→実売上処理が可能、空白の場合は今日の日付になります。',
                'required' => false
            ]
        ];
    }
}
