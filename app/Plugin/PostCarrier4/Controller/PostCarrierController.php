<?php

/*
 * This file is part of PostCarrier for EC-CUBE
 *
 * Copyright(c) IPLOGIC CO.,LTD. All Rights Reserved.
 *
 * http://www.iplogic.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\PostCarrier4\Controller;

use Eccube\Common\Constant;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Master\OrderItemType as OrderItemTypeMaster;
use Eccube\Form\Type\Admin\SearchProductType;
use Eccube\Repository\Master\OrderItemTypeRepository;
use Eccube\Repository\Master\PageMaxRepository;
use Eccube\Util\FormUtil;
use Knp\Component\Pager\PaginatorInterface;
use Plugin\PostCarrier4\Form\Type\PostCarrierOrderItem;
use Plugin\PostCarrier4\Form\Type\PostCarrierType;
use Plugin\PostCarrier4\Repository\PostCarrierCustomerRepository;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Plugin\PostCarrier4\Util\HtmlParser;
use Plugin\PostCarrier4\Util\PostCarrierUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostCarrierController
 */
class PostCarrierController extends AbstractController
{
    /**
     * @var PostCarrierService
     */
    protected $postCarrierService;

    /**
     * @var PostCarrierCustomerRepository
     */
    protected $customerRepository;

    /**
     * @var PostCarrierUtil
     */
    protected $postCarrierUtil;

    /**
     * @var PageMaxRepository
     */
    protected $pageMaxRepository;

    /**
     * @var OrderItemTypeRepository
     */
    protected $orderItemTypeRepository;

    /**
     * PostCarrierController constructor.
     *
     * @param PostCarrierService $postCarrierService
     * @param PostCarrierCustomerRepository $customerRepository
     * @param PostCarrierUtil $postCarrierUtil
     * @param PageMaxRepository $pageMaxRepository
     */
    public function __construct(
        PostCarrierService $postCarrierService,
        PostCarrierCustomerRepository $customerRepository,
        PostCarrierUtil $postCarrierUtil,
        PageMaxRepository $pageMaxRepository,
        OrderItemTypeRepository $orderItemTypeRepository
    ) {
        $this->postCarrierService = $postCarrierService;
        $this->customerRepository = $customerRepository;
        $this->postCarrierUtil = $postCarrierUtil;
        $this->pageMaxRepository = $pageMaxRepository;
        $this->orderItemTypeRepository = $orderItemTypeRepository;
    }

    /**
     * 配信内容設定検索画面を表示する.
     * 左ナビゲーションの選択はGETで遷移する.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier", name="plugin_post_carrier")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/{page_no}", requirements={"page_no" = "\d+"}, name="plugin_post_carrier_page")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/{edit_id}/edit", requirements={"edit_id" = "\d+"}, name="plugin_post_carrier_edit")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/{reuse_id}/reuse", requirements={"reuse_id" = "\d+"}, name="plugin_post_carrier_reuse")
     * @Template("@PostCarrier4/admin/index.twig")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param integer $page_no
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function index(Request $request, PaginatorInterface $paginator, $page_no = null, $edit_id = null, $reuse_id = null)
    {
        $postCarrierService = $this->postCarrierService;

        if ($postCarrierService->isNotConfigured()) {
            $this->addWarning('postcarrier.common.need_configure', 'admin');
            return $this->redirectToRoute('post_carrier4_admin_config');
        }

        $em = $this->entityManager;

        // 再検索条件の設定
        $researchData = null;
        $id = $edit_id ?? $reuse_id;
        if ($id !== null) {
            $apiData = $postCarrierService->getDelivery($id);
            $researchData = $postCarrierService->decodeMemo($apiData['memo']);
            //dump($researchData);
            if ($researchData === null) {
                $this->addError('postcarrier.common.get.failure', 'admin');
                if ($edit_id) {
                    return $this->redirectToRoute('plugin_post_carrier_schedule');
                } else {
                    return $this->redirectToRoute('plugin_post_carrier_history');
                }
            }

            // メルマガ専用会員のコントローラに飛ばす
            if ($researchData['discriminator_type'] === 'mail_customer') {
                if ($edit_id) {
                    return $this->redirectToRoute('plugin_post_carrier_mail_customer_edit', ['edit_id' => $id]);
                } else {
                    return $this->redirectToRoute('plugin_post_carrier_mail_customer_reuse', ['reuse_id' => $id]);
                }
            }

            // Entity of type "Eccube\Entity\Master\Sex" passed to the choice field must be managed. Maybe you forget to persist it in the entity manager?
            if (isset($researchData['sex'])) {
                foreach ($researchData['sex'] as $i => $Sex) {
                    $researchData['sex'][$i] = $em->getRepository(\Eccube\Entity\Master\Sex::class)->find($Sex->getId());
                }
            }

            if (isset($researchData['customer_status'])) {
                foreach ($researchData['customer_status'] as $i => $Status) {
                    $researchData['customer_status'][$i] = $em->getRepository(\Eccube\Entity\Master\CustomerStatus::class)->find($Status->getId());
                }
            }

            if (isset($researchData['pref'])) {
                $researchData['pref'] = $em->getRepository(\Eccube\Entity\Master\Pref::class)->find($researchData['pref']->getId());
            }

            // 編集時は既存の配信IDを保持する
            if ($edit_id !== null)
                $researchData['d__id'] = $edit_id;

            // trigger復元 XXX
            if ($apiData['trigger'] == 'immediate') {
                $researchData['d__trigger'] = 'immediate';
            } else if (strncmp($apiData['trigger'], 'EVENT:', strlen('EVENT:')) == 0) {
                $researchData['d__trigger'] = 'event';
                $researchData['d__stepmail_time'] = \DateTime::createFromFormat('!\E\V\E\N\T\:Hi', $apiData['trigger']);
            } else {
                $researchData['d__trigger'] = 'schedule';
                $researchData['d__sch_date'] = \DateTime::createFromFormat('!YmdHi', $apiData['trigger']);
            }

            // subject,bodyを復元
            $templateData = $postCarrierService->extractTemplate($apiData);
            $researchData = array_merge($researchData, $templateData);
        }

        $session = $request->getSession();
        $pageNo = $page_no;
        $pageMaxis = $this->pageMaxRepository->findAll();
        $pageCount = $session->get('postcarrier.search.page_count', $this->eccubeConfig['eccube_default_page_count']);
        $pageCountParam = $request->get('page_count');
        if ($pageCountParam && is_numeric($pageCountParam)) {
            foreach ($pageMaxis as $pageMax) {
                if ($pageCountParam == $pageMax->getName()) {
                    $pageCount = $pageMax->getName();
                    $session->set('postcarrier.search.page_count', $pageCount);
                    break;
                }
            }
        }
        $pageMax = $this->eccubeConfig['eccube_default_page_count'];

        $defaults = $researchData ?? $this->postCarrierUtil->createSearchDefaults();
        $searchForm = $this->formFactory
            ->createBuilder(PostCarrierType::class, $defaults, ['search_form'=>true])
            ->getForm();

        if ('POST' === $request->getMethod()) {
            $searchForm->handleRequest($request);
            if ($searchForm->isValid()) {
                $searchData = $searchForm->getData();
                $pageNo = 1;
                $session->set('postcarrier.search', FormUtil::getViewData($searchForm));
                $session->set('postcarrier.search.page_no', $pageNo);
            } else {
                return [
                    'searchForm' => $searchForm->createView(),
                    'pagination' => [],
                    'pageMaxis' => $pageMaxis,
                    'page_count' => $pageCount,
                    'has_errors' => true,
                ];
            }
        } else {
            if (null !== $pageNo || $request->get('resume')) {
                if ($pageNo) {
                    $session->set('postcarrier.search.page_no', (int) $pageNo);
                } else {
                    $pageNo = $session->get('postcarrier.search.page_no', 1);
                }
                $viewData = $session->get('postcarrier.search', []);
            } else {
                $pageNo = 1;
                $viewData = FormUtil::getViewData($searchForm);
                $session->set('postcarrier.search', $viewData);
                $session->set('postcarrier.search.page_no', $pageNo);
            }
            $searchData = FormUtil::submitAndGetData($searchForm, $viewData);
        }

        //$searchData['plg_postcarrier_flg'] = Constant::ENABLED;
        $qb = $this->customerRepository->getQueryBuilderBySearchData($searchData);

        $pagination = $paginator->paginate(
            $qb,
            $pageNo,
            $pageCount
        );

        return [
            'searchForm' => $searchForm->createView(),
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_count' => $pageCount,
            'has_errors' => false,
        ];
    }

    /**
     * テンプレート選択
     * RequestがPOST以外の場合はBadRequestHttpExceptionを発生させる.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/select/{id}",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_select",
     *     methods={"POST"}
     * )
     * @Template("@PostCarrier4/admin/template_select.twig")
     *
     * @param Request     $request
     * @param string      $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function select(Request $request, $id = null)
    {
        $service = $this->postCarrierService;

        $form = $this->formFactory
              ->createBuilder(PostCarrierType::class)
              ->getForm();
        $form->handleRequest($request);

        if ($request->get('mode') == 'select') {
            $formData = $form->getData();

            if ($id) {
                $apiData = $service->getTemplate($isError, $id);
                if ($isError) {
                    $this->addError('postcarrier.common.get.failure', 'admin');

                    return [
                        'form' => $form->createView(),
                    ];
                }

                // Form値をhandleRequest後に再設定するため、Form自体を作り直して値を引き継ぐ
                $form = $this->formFactory
                    ->createBuilder(PostCarrierType::class)
                    ->getForm();

                $templateData = $service->extractTemplate($apiData);
                // 検索データとテンプレート情報をマージしてフォームに設定する
                $form->setData(array_merge($formData, $templateData));
                $form->get('d__template')->setData($apiData['template_id']);
            } else {
                // Form値をhandleRequest後に再設定するため、Form自体を作り直して値を引き継ぐ
                $form = $this->formFactory
                    ->createBuilder(PostCarrierType::class)
                    ->getForm();

                $form->setData($formData);
                // テンプレート「無し」が選択された場合は、フォームをクリアする
                $form->get('d__subject')->setData('');
                $form->get('d__body')->setData('');
                $form->get('d__htmlBody')->setData('');
            }
        } elseif ($request->get('mode') == 'confirm') {
            if ($form->isValid()) {
                return $this->render('@PostCarrier4/admin/confirm.twig', [
                    'form' => $form->createView(),
                    'stepDisp' => PostCarrierUtil::getStepmailString($form->getData()),
                ]);
            }
        } else {
            $formData = $form->getData();

            // Form値をhandleRequest後に再設定するため、Form自体を作り直して値を引き継ぐ
            $form = $this->formFactory
                ->createBuilder(PostCarrierType::class)
                ->getForm();

            $defaults = $this->postCarrierUtil->createTemplateDefaults();
            $defaults['d__trigger'] = 'immediate';
            $defaults['d__sch_date'] = new \DateTime();
            if ($formData['d__sch_date'] < $defaults['d__sch_date']) {
                unset($formData['d__sch_date']); // 過去時間の場合はリセットする
            }
            // 5分単位に切り上げ
            $defaults['d__sch_date']->modify('+'.(5 - ($defaults['d__sch_date']->format('i') + 5) % 5).' minute');

            $defaults['d__testEmail'] = $service->getAdminEmail();

            // デフォルトは無条件とする
            $initOrderItem = new PostCarrierOrderItem();
            $initOrderItem->setProductName('無条件。購入商品に関係なく配信されます。');
            $OrderItemType = $this->orderItemTypeRepository->find(OrderItemTypeMaster::CHARGE);
            $initOrderItem->setOrderItemType($OrderItemType);
            $defaults['OrderItems'] = [ $initOrderItem ];

            $initOrderStopItem = new PostCarrierOrderItem();
            $initOrderStopItem->setProductName('無条件。購入商品による除外はありません。');
            $OrderItemType = $this->orderItemTypeRepository->find(OrderItemTypeMaster::CHARGE);
            $initOrderStopItem->setOrderItemType($OrderItemType);
            $defaults['OrderStopItems'] = [ $initOrderStopItem ];

            // null値ならデフォルト値を設定する
            foreach ($defaults as $key => $val) {
                if (!isset($formData[$key])) {
                    unset($formData[$key]);
                }
            }
            if (isset($formData['OrderItems']) && count($formData['OrderItems']) == 0) {
                unset($formData['OrderItems']);
            }
            if (isset($formData['OrderStopItems']) && count($formData['OrderStopItems']) == 0) {
                unset($formData['OrderStopItems']);
            }
            $form->setData(array_merge($defaults, $formData));
        }

        $builder = $this->formFactory
            ->createBuilder(SearchProductType::class);
        $searchProductModalForm = $builder->getForm();

        return [
            'form' => $form->createView(),
            'searchProductModalForm' => $searchProductModalForm->createView(),
        ];
    }

    /**
     * 配信前処理
     * 配信履歴データを作成する.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/prepare", name="plugin_post_carrier_prepare", methods={"POST"})
     *
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function prepare(Request $request)
    {
        $service = $this->postCarrierService;

        $builder = $this->formFactory
                 ->createBuilder(SearchProductType::class);
        $searchProductModalForm = $builder->getForm();

        $form = $this->formFactory
            ->createBuilder(PostCarrierType::class)
            ->getForm();
        $form->handleRequest($request);
        if (!$form->isValid()) {
            return $this->render('@PostCarrier4/admin/template_select.twig', [
                'form' => $form->createView(),
                'searchProductModalForm' => $searchProductModalForm->createView(),
            ]);
        }

        // タイムアウトしないようにする
        set_time_limit(0);

        $formData = $form->getData();
        $formData = $this->detectLink($formData);
        $id = $service->delivery($isError, $formData, $formData['d__count']);

        // dump($formData);
        // return $this->render('@PostCarrier4/admin/template_select.twig', [
        //     'form' => $form->createView(),
        //     'searchProductModalForm' => $searchProductModalForm->createView(),
        // ]);

        if (is_null($id)) {
            $this->addError('admin.postcarrier.send.register.failure', 'admin');

            return $this->render('@PostCarrier4/admin/confirm.twig', [
                'form' => $form->createView(),
            ]);
        }

        switch ($formData['d__trigger']) {
        case 'immediate':
            // フラッシュスコープにIDを保持してリダイレクト後に送信処理を開始できるようにする
            $this->session->getFlashBag()->add('eccube.postcarrier.history', $id);

            return $this->redirectToRoute('plugin_post_carrier_history');
        case 'schedule':
            return $this->redirectToRoute('plugin_post_carrier_schedule');
        case 'event':
        case 'periodic':
            return $this->redirectToRoute('plugin_post_carrier_stepmail');
        default:
            assert(false);
        }
    }

    /**
     * 即時配信時に配信先CSVをアップロード
     * RequestがAjaxかつPOSTでなければBadRequestHttpExceptionを発生させる.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/commit", name="plugin_post_carrier_commit", methods={"POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function commit(Request $request)
    {
        if (!$request->isXmlHttpRequest() || 'POST' !== $request->getMethod()) {
            throw new BadRequestHttpException();
        }

        // タイムアウトしないようにする
        set_time_limit(0);

        $service = $this->postCarrierService;

        $id = $request->get('id');
        $n = $service->upload($id);

        return $this->json([
            'status' => ($n !== null), // TODO: エラー要因を報告
            'id' => $id,
            'total' => $n,
            'count' => $n,
        ]);
    }

    /**
     * テストメール送信
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/test", name="plugin_post_carrier_test", methods={"POST"})
     * @Template("@PostCarrier4/admin/template_select.twig")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|array
     */
    public function sendTest(Request $request)
    {
        $service = $this->postCarrierService;

        $builder = $this->formFactory
            ->createBuilder(SearchProductType::class);
        $searchProductModalForm = $builder->getForm();

        $form = $this->formFactory
            ->createBuilder(PostCarrierType::class, null, ['test_mail' => true])
            ->getForm();
        $form->handleRequest($request);
        if (!$form->isValid()) {
            if ($request->isXmlHttpRequest()) {
                return $this->json(['status' => false]);
            } else {
                return [
                    'form' => $form->createView(),
                    'searchProductModalForm' => $searchProductModalForm->createView(),
                ];
            }
        }

        // 差し込みテスト用データを一件取得
        $searchData = $form->getData();
        $qb = $this->customerRepository->getQueryBuilderBySearchData($searchData);
        $qb->setFirstResult(0); // TODO:毎回インクリメントしたい
        $qb->setMaxResults(1);
        list($sql, $params, $types, $columnNameMap) = PostCarrierUtil::getRawSQLFromQB($qb);
        $em = $this->entityManager;
        $rows = $em->getConnection()->fetchAll($sql, $params, $types);
        if (count($rows) == 1) {
            $row = $rows[0];
            foreach ($columnNameMap as $sqlColAlias => $key) {
                $data[$key] = $row[$sqlColAlias];
            }
            $customerData = [$data['c_id'], 'web', $data['c_email'], $data['c_name01']." ".$data['c_name02'], $data['c_point']];
        } else {
            $customerData = [];
        }

        $data = $this->detectLink($searchData);
        $service->sendTestMail($isError, $data, $customerData, $data['d__testEmail']);

        if ($request->isXmlHttpRequest()) {
            if ($isError) {
                return $this->json(['status' => false]);
            } else {
                return $this->json(['status' => true]);
            }
        } else {
            if ($isError) {
                $this->addError('postcarrier.confirm.modal.confirm_test_fail_message', 'admin');
            } else {
                $this->addSuccess('postcarrier.confirm.modal.confirm_test_success_message', 'admin');
            }

            return [
                'form' => $form->createView(),
                'searchProductModalForm' => $searchProductModalForm->createView(),
            ];
        }
    }

    protected function detectLink($formData)
    {
        if (defined('POSTCARRIER_ENABLE_CLICK_COUNT_FLG') && POSTCARRIER_ENABLE_CLICK_COUNT_FLG === false) {
            return $formData;
        }

        $linkArrays = [];
        if ($formData['d__mail_method'] == 1) {
            $parser = new HtmlParser($formData['d__htmlBody']);
            while ($parser->parse()) {
                if ($parser->iNodeType == HtmlParser::NODE_TYPE_ELEMENT
                    && ($parser->iNodeName === "a" || $parser->iNodeName === "A"))
                {
                    $subject = $parser->iNodeAttributes["href"];
                    $parser->parse();	//text部まで進める
                    $pattern = "{s?https?://[-_.!~*'()a-zA-Z0-9;/?:@&=+$,%#]+}";

                    if (preg_match($pattern, $subject)) {
                        $linkArrays[] = array($subject, $parser->iNodeValue);
                    }
                }
            }

            $tmpBody = $formData['d__htmlBody'];
            $tmpCount = 1;
            foreach ($linkArrays as $linkArray) {
                $pattern = "(<a(\s.*?)href( |)=( |)('|\")".preg_quote($linkArray[0])."('|\"))i";
                $replacement = '<a${1}href="${リンク#'.$tmpCount.'}"';
                $tmpBody = preg_replace($pattern, $replacement, $tmpBody, 1);
                $tmpCount++;
            }

            $formData['d__htmlBody'] = $tmpBody;
        }else if ($formData['d__mail_method'] == "2") {
            $tmpBody = $formData['d__body'];
            $tmpCount = 1;
            $pattern = "{s?https?://[-_.!~*'()a-zA-Z0-9;/?:@&=+$,%#]+}";
            while (preg_match($pattern, $tmpBody, $matches)) {
                $replacement = '${リンク#'.$tmpCount.'}';
                $tmpBody = preg_replace($pattern, $replacement, $tmpBody, 1);

                $tmpArray = explode('/',$matches[0]);
                $linkArrays[] = [$matches[0], substr($matches[0], strlen($tmpArray[0].'/'.$tmpArray[1].'/'.$tmpArray[2]))];
                $tmpCount++;
            }

            $formData['d__body'] = $tmpBody;
        }

        $formData['link_count'] = count($linkArrays);
        for ($i=0; $i < count($linkArrays); $i++) {
            $formData['linkUrl'.($i+1)] = $linkArrays[$i][0];
            $formData['linkValue'.($i+1)] = $linkArrays[$i][1];
        }

        return $formData;
    }
}
