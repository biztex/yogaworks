<?php
namespace Plugin\ZeusPayment4\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\ZeusPayment4\Repository\ConfigRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Plugin\ZeusPayment4\Form\Type\Admin\ConfigFormCreditType;
use Plugin\ZeusPayment4\Form\Type\Admin\ConfigFormCvsType;
use Plugin\ZeusPayment4\Form\Type\Admin\ConfigFormEbankType;
use Plugin\ZeusPayment4\Service\ZeusPaymentService;
use Plugin\ZeusPayment4\Validator\Constraints as ZeusPaymentAssert;

/*
 * 設定画面コントローラー
 */
class ConfigController extends AbstractController
{

    /**
     *
     * @var ConfigRepository
     */
    protected $configRepository;

    /*
     * 入力中
     */
    protected $isInputting;

    /*
     * アクティブタブ
     */
    protected $selectedTab;

    protected $zeusPaymentService;

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

    /**
     * 設定情報編集画面
     * @Route("/%eccube_admin_route%/zeus_payment4/config", name="zeus_payment4_admin_config")
     * @Template("@ZeusPayment4/admin/config.twig")
     */
    public function index(Request $request)
    {
        
        // 設定情報を取得
        $config = $this->configRepository->get();
        
        // フォームに値を渡す
        $builders = array(
            'credit' => $this->formFactory->createBuilder(ConfigFormCreditType::class, $config, array(
                'constraints' => array(
                    new ZeusPaymentAssert\ClientIp()
                ),
            )),
            'cvs' => $this->formFactory->createBuilder(ConfigFormCvsType::class, $config),
            'ebank' => $this->formFactory->createBuilder(ConfigFormEbankType::class, $config),
        );
        
        // フォームに値を渡す
        $forms = array();
        foreach ($builders as $key => $builder) {
            $forms[$key] = $builder->getForm();
        }
        
        // アクティブタブ
        $this->selectedTab = $request->get('disp_zeus_tab_selected');
        switch ($this->selectedTab) {
            case 'ebank':
            case 'edy':
            case 'cvs':
                break;
            default:
                $this->selectedTab = 'credit'; // デフォルトはクレジットカード設定画面
                break;
        }

        $subtitle = "設定画面";
        $this->isInputting = true;
        switch ($request->get('mode')) {
            case 'confirm':
                $forms[$this->selectedTab]->handleRequest($request);
                
                if ($forms[$this->selectedTab]->isSubmitted() && $forms[$this->selectedTab]->isValid()) {
                    $this->isInputting = false;
                    $forms[$this->selectedTab] = $builders[$this->selectedTab]->getForm();
                    $forms[$this->selectedTab]->handleRequest($request);
                    $subtitle = "確認画面";
                }
                break;
            case 'complete':
                $forms[$this->selectedTab]->handleRequest($request);
                if ($forms[$this->selectedTab]->isSubmitted() && $forms[$this->selectedTab]->isValid()) { // 設定保存・完了画面
                    try {
                        $this->entityManager->getConnection()->beginTransaction();
                        $this->zeusPaymentService->saveConfig(
                            $this->selectedTab,
                            $forms[$this->selectedTab]->getData()
                        );
                        $this->entityManager->getConnection()->commit();
                        $this->addSuccess($this->eccubeConfig['zeus_payment_method_' . $this->selectedTab] .
                            'モジュールの登録が完了致しました。', 'admin');
                    } catch (\Exception $e) {
                        $msg = $this->eccubeConfig['zeus_payment_method_' . $this->selectedTab] .
                            'モジュールを保存できませんでした。' . $e->getMessage();
                        $this->addError($msg, 'admin');
                        log_notice($msg);
                    }
                }
                break;
            case 'back':
                if ($this->selectedTab == 'credit') { // クレカの場合のみbuilderをconfigから再作成が必要（デフォルト表示項目があるため）
                    $forms[$this->selectedTab] = $builder = $this->formFactory->createBuilder(
                        ConfigFormCreditType::class,
                        $config,
                        array(
                        'constraints' => array(
                            new ZeusPaymentAssert\ClientIp()
                        )
                    )
                    )->getForm();
                }
                $forms[$this->selectedTab]->handleRequest($request);
            // no break
            default:
                break;
        }
        
        // フォームを表示する
        return [
            'subtitle' => $subtitle,
            'isInputting' => $this->isInputting,
            'selectedTab' => $this->selectedTab,
            'formCredit' => $forms['credit']->createView(),
            'formCvs' => $forms['cvs']->createView(),
            'formEbank' => $forms['ebank']->createView()
        ];
    }
}
