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

use Doctrine\ORM\Query;
use Eccube\Common\Constant;
use Eccube\Controller\Admin\AbstractCsvImportController;
use Eccube\Entity\Master\Sex;
use Eccube\Repository\Master\PageMaxRepository;
use Eccube\Util\FormUtil;
use Eccube\Util\StringUtil;
use Knp\Component\Pager\PaginatorInterface;
use Plugin\PostCarrier4\Entity\PostCarrierGroup;
use Plugin\PostCarrier4\Entity\PostCarrierGroupCustomer;
use Plugin\PostCarrier4\Form\Type\PostCarrierCsvImportType;
use Plugin\PostCarrier4\Form\Type\PostCarrierGroupType;
use Plugin\PostCarrier4\Repository\PostCarrierGroupCustomerRepository;
use Plugin\PostCarrier4\Repository\PostCarrierGroupRepository;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Plugin\PostCarrier4\Util\PostCarrierUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

class MailCustomerController extends AbstractCsvImportController
{
    /**
     * @var PostCarrierService
     */
    protected $postCarrierService;

    /**
     * @var PostCarrierUtil
     */
    protected $postCarrierUtil;

    /**
     * @var PostCarrierGroupRepository
     */
    protected $postCarrierGroupRepository;

    /**
     * @var PostCarrierGroupCustomerRepository
     */
    protected $postCarrierGroupCustomerRepository;

    /**
     * @var PageMaxRepository
     */
    protected $pageMaxRepository;

    /**
     * MailCustomerController constructor.
     *
     * @param PostCarrierService $postCarrierService
     * @param PostCarrierGroupRepository $postCarrierGroupRepository
     * @param PostCarrierUtil $postCarrierUtil
     * @param PostCarrierGroupCustomerRepository $postCarrierGroupCustomerRepository
     * @param PageMaxRepository $pageMaxRepository
     */
    public function __construct(
        PostCarrierService $postCarrierService,
        PostCarrierGroupRepository $postCarrierGroupRepository,
        PostCarrierUtil $postCarrierUtil,
        PostCarrierGroupCustomerRepository $postCarrierGroupCustomerRepository,
        PageMaxRepository $pageMaxRepository
    ) {
        $this->postCarrierService = $postCarrierService;
        $this->postCarrierGroupRepository = $postCarrierGroupRepository;
        $this->postCarrierUtil = $postCarrierUtil;
        $this->postCarrierGroupCustomerRepository = $postCarrierGroupCustomerRepository;
        $this->pageMaxRepository = $pageMaxRepository;
    }

    /**
     * 一覧表示
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer", name="plugin_post_carrier_mail_customer")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{page_no}", requirements={"page_no" = "\d+"}, name="plugin_post_carrier_mail_customer_page")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{page_no}/edit/{edit_id}", requirements={"page_no" = "\d+", "edit_id" = "\d+"}, defaults={"page_no" = 1}, name="plugin_post_carrier_mail_customer_edit_group")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{page_no}/cancel/{cancel_id}", requirements={"page_no" = "\d+", "cancel_id" = "\d+"}, defaults={"page_no" = 1}, name="plugin_post_carrier_mail_customer_cancel_group")
     * @Template("@PostCarrier4/admin/mail_customer.twig")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param integer $page_no
     * @param integer $edit_id
     * @param integer $cancel_id
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function index(Request $request, PaginatorInterface $paginator, $page_no = null, $edit_id = null, $cancel_id = null)
    {
        if ($this->postCarrierService->isNotConfigured()) {
            $this->addWarning('postcarrier.common.need_configure', 'admin');
            return $this->redirectToRoute('post_carrier4_admin_config');
        }

        $session = $this->session;

        $pageMaxis = $this->pageMaxRepository->findAll();
        $pageCount = $session->get('eccube.plg_postcarrier.mail_customer.page_count', $this->eccubeConfig['eccube_default_page_count']);
        $pageCountParam = $request->get('page_count');
        if ($pageCountParam && is_numeric($pageCountParam)) {
            foreach ($pageMaxis as $pageMax) {
                if ($pageCountParam == $pageMax->getName()) {
                    $pageCount = $pageMax->getName();
                    $session->set('eccube.plg_postcarrier.mail_customer.page_count', $pageCount);
                    break;
                }
            }
        }

        $page_no = $page_no ?? 1;
        $offsetNo = $pageCount * ($page_no - 1);

        /*
         * フォーム処理
         */

        $builder = $this->formFactory
            ->createBuilder(PostCarrierCsvImportType::class);
        $form = $builder->getForm();

        if ('POST' === $request->getMethod()) {
            if ($edit_id !== null) {
                // TODO message 追加
                if ($Group = $this->postCarrierGroupRepository->find($edit_id)) {
                    $form->get('group_id')->setData($edit_id);
                    $form->get('group_name')->setData($Group->getGroupName());
                } else {
                    $this->addError('選択されたグループが存在しません。', 'admin');
                }
            } else if ($cancel_id !== null) {
                // TODO message 追加
                $form = $builder->getForm();
            } else {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    set_time_limit(0);
                    if ($this->processImportFile($form)) {
                        // 成功したらフォームをクリアする
                        $form = $builder->getForm();
                    }
                }
            }
        }

        /*
         * グループ一覧取得
         */

        $dql = 'SELECT COUNT(g) FROM Plugin\PostCarrier4\Entity\PostCarrierGroup g';
        $q = $this->entityManager
            ->createQuery($dql);
        $itemCount = $q->getScalarResult()[0][1]; // XXX

        $dql = 'SELECT g, COUNT(c) AS cnt FROM Plugin\PostCarrier4\Entity\PostCarrierGroup g LEFT JOIN Plugin\PostCarrier4\Entity\PostCarrierGroupCustomer c WITH g.id = c.group_id AND c.status = 2 GROUP BY g ORDER BY g.id';
        $q = $this->entityManager
            ->createQuery($dql)
            ->setMaxResults($pageCount)
            ->setFirstResult($offsetNo);
        $items = $q->getResult(Query::HYDRATE_ARRAY);

        $pagination = $paginator->paginate([], $page_no, $pageCount);
        $pagination->setItems($items);
        $pagination->setTotalItemCount($itemCount);

        $headers = $this->getCsvHeader();

        return [
            'form' => $form->createView(),
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_count' => $pageCount,
            'page_no' => $page_no,
            'headers' => $headers,
        ];
    }

    /**
     * 削除
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{id}/delete", requirements={"id" = "\d+"}, name="plugin_post_carrier_mail_customer_delete")
     *
     * @param Request $request
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function delete(Request $request, $id)
    {
        if ('DELETE' === $request->getMethod()) {
            if (is_null($id)) {
                $this->addError('admin.postcarrier.group.data.illegalaccess', 'admin'); // TODO ありえるのか？
                return $this->redirectToRoute('plugin_post_carrier_mail_customer');
            }

            $Group = $this->postCarrierGroupRepository->find($id);
            if (is_null($Group)) {
                $this->addError('admin.postcarrier.group.data.notfound', 'admin');  // TODO
                return $this->redirectToRoute('plugin_post_carrier_mail_customer');
            }

            $dql = 'DELETE FROM Plugin\PostCarrier4\Entity\PostCarrierGroupCustomer gc WHERE gc.group_id = :group_id';
            $q = $this->entityManager->createQuery($dql)
                ->setParameter('group_id', $Group->getId());
            $q->execute();

            $this->entityManager->remove($Group);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('plugin_post_carrier_mail_customer');
    }

    /**
     * エクスポート
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{id}/export", requirements={"id" = "\d+"}, name="plugin_post_carrier_mail_customer_export")
     *
     * @param Request $request
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function export(Request $request, $id)
    {
        // TODO eccube本体のコントローラを確認

        // タイムアウトを無効にする.
        set_time_limit(0);

        // sql loggerを無効にする. TODO
        $em = $this->entityManager;
        //$em->getConfiguration()->setSQLLogger(null);

        $header = "メールアドレス,登録日,自由項目1,自由項目2,自由項目3,自由項目4,自由項目5,自由項目6,自由項目7,自由項目8,自由項目9,自由項目10";
        $sql = 'SELECT * FROM plg_post_carrier_group_customer WHERE group_id = ? AND status = 2';
        $sqlval = array($id);

        $now = new \DateTime();
        $filename = 'csvgroup_' . $now->format('YmdHis') . '.csv';
        Header("Content-disposition: attachment; filename=${filename}");
        Header("Content-type: application/octet-stream; name=${filename}");
        Header("Cache-Control: ");
        Header("Pragma: ");

        echo mb_convert_encoding($header, 'SJIS-Win', 'UTF-8');
        echo "\r\n";

        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sqlval);
        while ($data = $stmt->fetch()) {
            $row = array();
            $row[] = PostCarrierUtil::escapeCsvData($data['email']);
            $row[] = PostCarrierUtil::escapeCsvData($data['create_date']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo01']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo02']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo03']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo04']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo05']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo06']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo07']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo08']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo09']);
            $row[] = PostCarrierUtil::escapeCsvData($data['memo10']);

            echo mb_convert_encoding(implode(",", $row), 'SJIS-Win', 'UTF-8');
            echo "\r\n";
            ob_flush();
            flush();
        }

        exit;
    }

    /**
     * 検索
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/search", name="plugin_post_carrier_mail_customer_search")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/search/{page_no}", requirements={"page_no" = "\d+"}, name="plugin_post_carrier_mail_customer_search_page")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{id}/search", requirements={"id" = "\d+"}, name="plugin_post_carrier_mail_customer_idsearch")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{id}/search/{page_no}", requirements={"id" = "\d+", "page_no" = "\d+"}, name="plugin_post_carrier_mail_customer_idsearch_page")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{edit_id}/edit", requirements={"edit_id" = "\d+"}, name="plugin_post_carrier_mail_customer_edit")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/{reuse_id}/reuse", requirements={"reuse_id" = "\d+"}, name="plugin_post_carrier_mail_customer_reuse")
     * @Template("@PostCarrier4/admin/mail_customer_search.twig")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param integer $page_no
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function search(Request $request, PaginatorInterface $paginator, $id = null, $page_no = null, $edit_id = null, $reuse_id = null)
    {
        $postCarrierService = $this->postCarrierService;

        $formVals = [];
        if ($id !== null) {
            $formVals['Group'] = [ $this->postCarrierGroupRepository->find($id) ];
        }

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

            // Entity of type "Plugin\PostCarrier4\Entity\PostCarrierGroup" passed to the choice field must be managed. Maybe you forget to persist it in the entity manager?
            $em = $this->entityManager;
            if (isset($researchData['Group'])) {
                foreach ($researchData['Group'] as $i => $Group) {
                    $researchData['Group'][$i] = $em->getRepository(PostCarrierGroup::class)->find($Group->getId());
                }
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
        $pageCount = $session->get('postcarrier.mail_customer.search.page_count', $this->eccubeConfig['eccube_default_page_count']);
        $pageCountParam = $request->get('page_count');
        if ($pageCountParam && is_numeric($pageCountParam)) {
            foreach ($pageMaxis as $pageMax) {
                if ($pageCountParam == $pageMax->getName()) {
                    $pageCount = $pageMax->getName();
                    $session->set('postcarrier.mail_customer.search.page_count', $pageCount);
                    break;
                }
            }
        }
        $pageMax = $this->eccubeConfig['eccube_default_page_count'];

        $defaults = $researchData ?? $formVals;
        //dump($defaults);
        $searchForm = $this->formFactory
            ->createBuilder(PostCarrierGroupType::class, $defaults, ['search_form'=>true])
            ->getForm();

        if ('POST' === $request->getMethod()) {
            $searchForm->handleRequest($request);
            if ($searchForm->isValid()) {
                $searchData = $searchForm->getData();
                $pageNo = 1;
                $session->set('postcarrier.mail_customer.search', FormUtil::getViewData($searchForm));
                $session->set('postcarrier.mail_customer.search.page_no', $pageNo);
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
                    $session->set('postcarrier.mail_customer.search.page_no', (int) $pageNo);
                } else {
                    $pageNo = $session->get('postcarrier.mail_customer.search.page_no', 1);
                }
                $viewData = $session->get('postcarrier.mail_customer.search', []);
            } else {
                $pageNo = 1;
                $viewData = FormUtil::getViewData($searchForm);
                $session->set('postcarrier.mail_customer.search', $viewData);
                $session->set('postcarrier.mail_customer.search.page_no', $pageNo);
            }
            $searchData = FormUtil::submitAndGetData($searchForm, $viewData);
        }

        $qb = $this->postCarrierGroupCustomerRepository->getQueryBuilderBySearchData($searchData);

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
     * 削除
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/search/{id}/delete", requirements={"id" = "\d+"}, name="plugin_post_carrier_mail_customer_search_delete")
     *
     * @param Request $request
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function delete2(Request $request, $id)
    {
        if ('DELETE' === $request->getMethod()) {
            // if (is_null($id)) {
            //     $this->addError('admin.postcarrier.group.data.illegalaccess', 'admin'); // TODO ありえるのか？
            //     return $this->redirectToRoute('plugin_post_carrier_mail_customer');
            // }

            $dql = 'DELETE FROM Plugin\PostCarrier4\Entity\PostCarrierGroupCustomer gc WHERE gc.id = :id';
            $q = $this->entityManager->createQuery($dql)
                ->setParameter('id', $id);
            $q->execute();
        }

        // TODO 条件保存
        return $this->redirectToRoute('plugin_post_carrier_mail_customer_search');
    }

    /**
     * テンプレート選択
     * RequestがPOST以外の場合はBadRequestHttpExceptionを発生させる.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/select/{id}",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_mail_customer_select",
     *     methods={"POST"}
     * )
     * @Template("@PostCarrier4/admin/mail_customer_template_select.twig")
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
              ->createBuilder(PostCarrierGroupType::class)
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
                    ->createBuilder(PostCarrierGroupType::class)
                    ->getForm();

                $templateData = $service->extractTemplate($apiData);
                // 検索データとテンプレート情報をマージしてフォームに設定する
                $form->setData(array_merge($formData, $templateData));
                $form->get('d__template')->setData($apiData['template_id']);
            } else {
                // Form値をhandleRequest後に再設定するため、Form自体を作り直して値を引き継ぐ
                $form = $this->formFactory
                    ->createBuilder(PostCarrierGroupType::class)
                    ->getForm();

                $form->setData($formData);
                // テンプレート「無し」が選択された場合は、フォームをクリアする
                $form->get('d__subject')->setData('');
                $form->get('d__body')->setData('');
                $form->get('d__htmlBody')->setData('');
            }
        } elseif ($request->get('mode') == 'confirm') {
            if ($form->isValid()) {
                return $this->render('@PostCarrier4/admin/mail_customer_confirm.twig', [
                    'form' => $form->createView(),
                    'stepDisp' => PostCarrierUtil::getStepmailString($form->getData()),
                ]);
            }
        } else {
            $formData = $form->getData();

            // Form値をhandleRequest後に再設定するため、Form自体を作り直して値を引き継ぐ
            $form = $this->formFactory
                ->createBuilder(PostCarrierGroupType::class)
                ->getForm();

            $defaults = $this->postCarrierUtil->createTemplateDefaults();
            $defaults['d__kind'] = 2;
            $defaults['d__trigger'] = 'immediate';
            $defaults['d__sch_date'] = new \DateTime();
            if ($formData['d__sch_date'] < $defaults['d__sch_date']) {
                unset($formData['d__sch_date']); // 過去時間の場合はリセットする
            }
            // 5分単位に切り上げ
            $defaults['d__sch_date']->modify('+'.(5 - ($defaults['d__sch_date']->format('i') + 5) % 5).' minute');

            $defaults['d__testEmail'] = $service->getAdminEmail();

            // null値ならデフォルト値を設定する
            foreach ($defaults as $key => $val) {
                if (!isset($formData[$key])) {
                    unset($formData[$key]);
                }
            }

            $form->setData(array_merge($defaults, $formData));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * テストメール送信
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer/test", name="plugin_post_carrier_mail_customer_test", methods={"POST"})
     * @Template("@PostCarrier4/admin/mail_customer_template_select.twig")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|array
     */
    public function sendTest(Request $request)
    {
        $service = $this->postCarrierService;

        $form = $this->formFactory
            ->createBuilder(PostCarrierGroupType::class, null, ['test_mail' => true])
            ->getForm();
        $form->handleRequest($request);
        if (!$form->isValid()) {
            if ($request->isXmlHttpRequest()) {
                return $this->json(['status' => false]);
            } else {
                return [
                    'form' => $form->createView(),
                ];
            }
        }

        // 差し込みテスト用データを一件取得
        $searchData = $form->getData();
        $qb = $this->postCarrierGroupCustomerRepository->getQueryBuilderBySearchData($searchData);
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
            $customerData = [$data['c_id'], 'mail', $data['c_email'], $data['c_memo01'], $data['c_memo02'], $data['c_memo03'], $data['c_memo04'], $data['c_memo05'], $data['c_memo06'], $data['c_memo07'], $data['c_memo08'], $data['c_memo09'], $data['c_memo10']];
        } else {
            $customerData = [];
        }

        $data = $this->postCarrierUtil->detectLink($searchData);
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
            ];
        }
    }

    /**
     * 配信前処理
     * 配信履歴データを作成する.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/mail_customer_prepare", name="plugin_post_carrier_mail_customer_prepare", methods={"POST"})
     *
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function prepare(Request $request)
    {
        $service = $this->postCarrierService;

        $form = $this->formFactory
            ->createBuilder(PostCarrierGroupType::class)
            ->getForm();
        $form->handleRequest($request);
        if (!$form->isValid()) {
            return $this->render('@PostCarrier4/admin/post_carrier_mail_customer_template_select.twig', [
                'form' => $form->createView(),
            ]);
        }

        // タイムアウトしないようにする
        set_time_limit(0);

        $formData = $form->getData();
        $formData = $this->postCarrierUtil->detectLink($formData);
        $id = $service->delivery($isError, $formData, $formData['d__count']);

        //debug
        // dump($formData);
        // return $this->render('@PostCarrier4/admin/mail_customer_template_select.twig', [
        //     'form' => $form->createView(),
        // ]);

        if (is_null($id)) {
            $this->addError('admin.postcarrier.send.register.failure', 'admin');

            return $this->render('@PostCarrier4/admin/mail_customer_confirm.twig', [
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
            return $this->redirectToRoute('plugin_post_carrier_stepmail');
        case 'periodic':
        default:
            assert(false);
        }
    }

    protected function getImportData2(UploadedFile $formFile)
    {
        // アップロードされたCSVファイルを一時ディレクトリに保存
        $this->csvFileName = 'upload_'.StringUtil::random().'.'.$formFile->getClientOriginalExtension();
        $formFile->move($this->eccubeConfig['eccube_csv_temp_realdir'], $this->csvFileName);

        return $this->sfEncodeFile($this->eccubeConfig['eccube_csv_temp_realdir'].'/'.$this->csvFileName);
    }

    private function sfEncodeFile($filepath) {
        $basename = basename($filepath);
        $out_dir = dirname($filepath);
        $outpath = $out_dir . '/enc_' . $basename;

        $file = file_get_contents($filepath);
        // アップロードされたファイルがUTF-8以外は文字コード変換を行う
        $encode = StringUtil::characterEncoding(substr($file, 0, 6));
        if ($encode != 'UTF-8') {
            $file = mb_convert_encoding($file, 'UTF-8', $encode);
        }
        $file = StringUtil::convertLineFeed($file);

        $tmp = fopen($outpath, 'w+');
        fwrite($tmp, $file);
        fclose($tmp);

        return $outpath;
    }

    private function lfCSVRecordCount($fp) {

        $count = 1;
        while(!feof($fp)) {
            $arrCSV = fgetcsv($fp, 10000);
            $count++;
        }
        // ファイルポインタを戻す
        if (rewind($fp)) {
            return $count-1;
        } else {
            //SC_Utils_Ex::sfDispError("");
        }
    }

    private function lfRegist($group_id, $arrCSV, $pre_insert, $pre_update) {
        $pre_insert->bindValue('group_id', $group_id);
        $pre_insert->bindValue('email', $arrCSV[0]);
        $pre_insert->bindValue('create_date', $arrCSV[1]);
        $pre_insert->bindValue('memo01', $arrCSV[2]);
        $pre_insert->bindValue('memo02', $arrCSV[3]);
        $pre_insert->bindValue('memo03', $arrCSV[4]);
        $pre_insert->bindValue('memo04', $arrCSV[5]);
        $pre_insert->bindValue('memo05', $arrCSV[6]);
        $pre_insert->bindValue('memo06', $arrCSV[7]);
        $pre_insert->bindValue('memo07', $arrCSV[8]);
        $pre_insert->bindValue('memo08', $arrCSV[9]);
        $pre_insert->bindValue('memo09', $arrCSV[10]);
        $pre_insert->bindValue('memo10', $arrCSV[11]);
        $pre_insert->execute();

        $insert_flg = true;
        if ($pre_insert->rowCount() == 0) {
            $pre_update->bindValue('group_id', $group_id);
            $pre_update->bindValue('email', $arrCSV[0]);
            $pre_update->bindValue('create_date', $arrCSV[1]);
            $pre_update->bindValue('memo01', $arrCSV[2]);
            $pre_update->bindValue('memo02', $arrCSV[3]);
            $pre_update->bindValue('memo03', $arrCSV[4]);
            $pre_update->bindValue('memo04', $arrCSV[5]);
            $pre_update->bindValue('memo05', $arrCSV[6]);
            $pre_update->bindValue('memo06', $arrCSV[7]);
            $pre_update->bindValue('memo07', $arrCSV[8]);
            $pre_update->bindValue('memo08', $arrCSV[9]);
            $pre_update->bindValue('memo09', $arrCSV[10]);
            $pre_update->bindValue('memo10', $arrCSV[11]);
            $pre_update->execute();

            $insert_flg = false;
        }

        return $insert_flg;
    }

    private function checkError(&$arrCSV) {
        //dump("arrCSV=".print_r($arrCSV,true));

        $arrErr = [];
        $email = $arrCSV[0];

        $errors = $this->get('validator')->validate($email, [
            new Assert\NotBlank(),
            // configでこの辺りは変えられる方が良さそう
            new Assert\Email(['strict' => true]),
            new Assert\Regex([
                'pattern' => '/^[[:graph:][:space:]]+$/i',
                'message' => 'form.type.graph.invalid',
            ]),
            new Assert\Length(['max' => 128]),
        ]);
        if ($errors->count() != 0) {
            $arrErr[] = "メールアドレスの形式に誤りがあります: $email";
        }

        if (array_key_exists(1, $arrCSV) && $arrCSV[1] != '') {
            $ts = strtotime($arrCSV[1]);
            if ($ts) {
                $arrCSV[1] = date('Y-m-d H:i:s', $ts);
            } else {
                $arrErr[] = "登録日の形式に誤りがあります: ${arrCSV[1]}";
            }
        } else {
            $arrCSV[1] = date('Y-m-d H:i:s');
        }

        $rec_count = count($arrCSV);
        for ($i = 2; $i < $rec_count; $i++) {
        }
        for ($i = $rec_count; $i < 12; $i++) {
            $arrCSV[$i] = '';
        }

        //dump("error=".print_r($errors,true));

        return $arrErr;
    }

    protected function processImportFile($form) {
        $formFile = $form['import_file']->getData();
        $formData = $form->getData();

        if (!empty($formFile)) {
            $enc_filepath = $this->getImportData2($formFile);

            $fp = fopen($enc_filepath, "r");
            if ($fp === false) {
                $this->addError('CSVのアップロードに失敗しました。', 'admin');
                return false;
            }

            // レコード数を得る
            $rec_count = $this->lfCSVRecordCount($fp);

            $em = $this->entityManager;
            $conn = $em->getConnection();
            $conn->getConfiguration()->setSQLLogger(null);
            $conn->beginTransaction();


            $Group = null;
            if ($formData['group_id']) {
                $Group = $this->postCarrierGroupRepository->find($formData['group_id']);
            } else {
                $Group = new PostCarrierGroup();
            }
            $Group->setGroupName($formData['group_name']);
            $Group->setUpdateDate(new \DateTime());
            $em->persist($Group);
            $em->flush($Group);

            if ($conn->getDatabasePlatform()->getName() == "mysql") {
                $pre_insert = $conn
                            ->prepare("INSERT INTO plg_post_carrier_group_customer(email,create_date,memo01,memo02,memo03,memo04,memo05,memo06,memo07,memo08,memo09,memo10,group_id,update_date) SELECT :email, :create_date, :memo01, :memo02, :memo03, :memo04, :memo05, :memo06, :memo07, :memo08, :memo09, :memo10, :group_id, CURRENT_TIMESTAMP FROM dual WHERE NOT EXISTS(SELECT 1 FROM plg_post_carrier_group_customer WHERE group_id = :group_id AND email = :email)");
            } else {
                // CAST と FROM dual が異なる
                $pre_insert = $conn
                            ->prepare("INSERT INTO plg_post_carrier_group_customer(email,create_date,memo01,memo02,memo03,memo04,memo05,memo06,memo07,memo08,memo09,memo10,group_id,update_date) SELECT CAST(:email AS VARCHAR), :create_date, :memo01, :memo02, :memo03, :memo04, :memo05, :memo06, :memo07, :memo08, :memo09, :memo10, :group_id, CURRENT_TIMESTAMP WHERE NOT EXISTS(SELECT 1 FROM plg_post_carrier_group_customer WHERE group_id = :group_id AND email = :email)");
            }
            $pre_update = $conn
                        ->prepare("UPDATE plg_post_carrier_group_customer SET email=:email, create_date=:create_date, memo01=:memo01, memo02=:memo02, memo03=:memo03, memo04=:memo04, memo05=:memo05, memo06=:memo06, memo07=:memo07, memo08=:memo08, memo09=:memo09, memo10=:memo10, status=2, update_date=CURRENT_TIMESTAMP WHERE group_id = :group_id AND email = :email");

            $line = 0;      // 行数
            $regist = 0;    // 登録数
            $insert = 0;

            $batchSize = 100;
            $colmax = 12;
            $err = false;
            while(!feof($fp) && !$err) {
                $arrCSV = fgetcsv($fp, 10000);

                ++$line;

                // ヘッダ行はスキップ
                if($line == 1) {
                    continue;
                }

                // 空行はスキップ
                if ($arrCSV === false) {
                    continue;
                }

                // 項目数カウント
                $max = count($arrCSV);

                // 空行はスキップ
                $cnt = count($arrCSV);
                if ($cnt == 0) {
                    continue;
                }

                // 項目数が1未満の場合はスキップ
                if ($max < 1) {
                    continue;
                }

                // 項目数チェック
                if($max > $colmax) {
                    $msg = "${line}行目: 項目数が" . $cnt . "個検出されました。項目数は最大" . $colmax . "個です。";
                    $this->addError($msg, 'admin');
                    $conn->rollback();
                    return false;
                } else {
                    $arrErr = $this->checkError($arrCSV);
                    if ($arrErr) {
                        foreach ($arrErr as $msg) {
                            $this->addError("${line}行目: $msg", 'admin');
                        }
                        $conn->rollback();
                        return false;
                    }
                }

                if(!$err) {
                    $insert_flg = $this->lfRegist($Group->getId(), $arrCSV, $pre_insert, $pre_update);
                    if ($insert_flg) ++$insert;

                    ++$regist;
                }

                if ($regist % $batchSize === 0) {
                    //$conn->commit();
                    gc_collect_cycles();
                }
            }

            $conn->commit();
            gc_collect_cycles();

            $update = $regist - $insert;
            $msg = "処理総件数:${regist}件、新規登録:${insert}件、更新:${update}件 アップロードしました。";
            $this->addSuccess($msg, 'admin');
        } else {
            // ファイル未指定の場合
            if ($formData['group_id']) {
                // グループ名のみ更新
                $Group = $this->postCarrierGroupRepository->find($formData['group_id']);
                $Group->setGroupName($formData['group_name']);
                $Group->setUpdateDate(new \DateTime());
                $em = $this->entityManager;
                $em->persist($Group);
                $em->flush($Group);

                $msg = "グループ名を更新しました。";
                $this->addSuccess($msg, 'admin');
            } else {
                $msg = "CSVファイルを選択するか、グループの編集を選択してください。";
                $this->addError($msg, 'admin');
                return false;
            }
        }

        return true;
    }

    /**
     * メルマガ専用会員登録CSVヘッダー定義
     *
     * @return array
     */
    protected function getCsvHeader()
    {
        return [
            trans('postcarrier.mail_customer.csv.email_col') => [
                'description' => 'postcarrier.mail_customer.csv.email_description',
                'required' => true,
            ],
            trans('postcarrier.mail_customer.csv.create_date_col') => [
                'description' => 'postcarrier.mail_customer.csv.create_date_description',
                'required' => false,
            ],
            trans('postcarrier.mail_customer.csv.memo01_col') => [
                'description' => 'postcarrier.mail_customer.csv.memo01_description',
                'required' => false,
            ],
            trans('postcarrier.mail_customer.csv.memo02_col') => [
                'description' => 'postcarrier.mail_customer.csv.memo02_description',
                'required' => false,
            ],
        ];
    }

    /**
     * アップロード用CSV雛形ファイルダウンロード
     *
     * @Route("/%eccube_admin_route%/post_carrier/mail_customer/csv_template",  name="plugin_post_carrier_mail_customer_csv_template")
     */
    public function csvTemplate(Request $request)
    {
        $headers = $this->getCsvHeader();
        $filename = 'mailmaga.csv';

        return $this->sendTemplateResponse($request, array_keys($headers), $filename);
    }
}
