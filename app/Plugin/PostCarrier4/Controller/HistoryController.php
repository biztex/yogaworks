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

use Eccube\Controller\AbstractController;
use Eccube\Entity\Master\Sex;
use Eccube\Repository\Master\PageMaxRepository;
use Knp\Component\Pager\PaginatorInterface;
use Plugin\PostCarrier4\Form\Type\PostCarrierTemplateEditType;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Plugin\PostCarrier4\Util\PostCarrierUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     * @var PostCarrierService
     */
    protected $postCarrierService;

    /**
     * @var PageMaxRepository
     */
    protected $pageMaxRepository;

    /**
     * PostCarrierHistoryController constructor.
     *
     * @param PostCarrierService $postCarrierService
     * @param PageMaxRepository $pageMaxRepository
     */
    public function __construct(
        PostCarrierService $postCarrierService,
        PageMaxRepository $pageMaxRepository
    ) {
        $this->postCarrierService = $postCarrierService;
        $this->pageMaxRepository = $pageMaxRepository;
    }

    /**
     * 配信履歴一覧.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history", name="plugin_post_carrier_history")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{page_no}",
     *     requirements={"page_no" = "\d+"},
     *     name="plugin_post_carrier_history_page"
     * )
     * @Template("@PostCarrier4/admin/history_list.twig")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param int $page_no
     *
     * @return array
     */
    public function index(Request $request, PaginatorInterface $paginator, $page_no = 1)
    {
        $postCarrierService = $this->postCarrierService;

        if ($postCarrierService->isNotConfigured()) {
            $this->addWarning('postcarrier.common.need_configure', 'admin');
            return $this->redirectToRoute('post_carrier4_admin_config');
        }

        $pageNo = $page_no;
        $pageMaxis = $this->pageMaxRepository->findAll();
        $pageCount = $this->eccubeConfig['eccube_default_page_count'];
        $pageCountParam = $request->get('page_count');
        if ($pageCountParam && is_numeric($pageCountParam)) {
            foreach ($pageMaxis as $pageMax) {
                if ($pageCountParam == $pageMax->getName()) {
                    $pageCount = $pageMax->getName();
                    break;
                }
            }
        }

        $offsetNo = $pageCount * ($pageNo - 1);
        $items = $postCarrierService->getMailLogList($isError, $itemCount, $pageCount, $offsetNo);
        if ($isError) {
            $this->addError('postcarrier.common.get.failure', 'admin');

            $items = [];
            $itemCount = 0;
        }

        $pagination = $paginator->paginate([], $pageNo, $pageCount);
        $pagination->setItems($items);
        $pagination->setTotalItemCount($itemCount);

        return [
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_count' => $pageCount,
        ];
    }

    /**
     * プレビュー
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/preview",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_history_preview"
     * )
     * @Template("@PostCarrier4/admin/history_preview.twig")
     *
     * @param int $id
     *
     * @return array
     */
    public function preview($id)
    {
        $postCarrierService = $this->postCarrierService;

        $apiData = $postCarrierService->previewDelivery($isError, $id);
        if ($isError) {
            $this->addError('postcarrier.common.get.failure', 'admin');

            return $this->redirectToRoute('plugin_post_carrier_history');
        }

        $body = $apiData['body'];
        $bgcolor = '#ffffff';

        // bodyタグからbgcolorを取得する。
        if (preg_match('{<body\s.*?bgcolor=("|\')(.+?)\\1}i', $body, $matches)) {
            $bgcolor = $matches[2];
        }
        // bodyタグはdivタグに変換
        $body = preg_replace('{<(|/)body(?:|\s[^>]*)>}i', '<${1}div>', $body);

        return [
            'subject' => $apiData['subject'],
            'previewBody' => $body,
            'bodybgcolor' => $bgcolor,
            'submenu' => 'postcarrier_history',
        ];
    }

    /**
     * 再利用
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/reuse",
     *      requirements={"id":"\d+"},
     *      name="plugin_post_carrier_history_reuse",
     * )
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function reuse($id)
    {
        $this->addInfo('postcarrier.history.reuse_message', 'admin');

        return $this->redirectToRoute('plugin_post_carrier_reuse', ['reuse_id' => $id]);
    }

    /**
     * 配信条件を表示する.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/condition",
     *      requirements={"id":"\d+"},
     *      name="plugin_post_carrier_history_condition",
     * )
     * @Template("@PostCarrier4/admin/history_condition.twig")
     *
     * @param int $id
     *
     * @throws BadRequestHttpException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|array
     */
    public function condition($id)
    {
        $postCarrierService = $this->postCarrierService;

        $apiData = $postCarrierService->getDelivery($id);
        $searchData = $postCarrierService->decodeMemo($apiData['memo']);
        if ($searchData === null) {
            $this->addError('postcarrier.common.get.failure', 'admin');
            return $this->redirectToRoute('plugin_post_carrier_history');
        }

        // 区分値を文字列に変更する
        $displayData = $this->searchDataToDisplayData($searchData);

        $stepDisp = null;
        if ($apiData['triggerType'] == 'EVENT') {
            $stepDisp = PostCarrierUtil::getStepmailString($searchData);
        }

        // メルマガ専用会員
        if ($searchData['discriminator_type'] === 'mail_customer') {
            return $this->render('@PostCarrier4/admin/mail_customer_history_condition.twig', [
                'search_data' => $displayData,
                'subject' => $apiData['subject'],
                'stepDisp' => $stepDisp,
                'searchData' => $searchData,
            ]);
        }

        return [
            'search_data' => $displayData,
            'subject' => $apiData['subject'],
            'stepDisp' => $stepDisp,
            'searchData' => $searchData,
        ];
    }

    /**
     * search_dataの配列を表示用に変換する.
     *
     * @param array $searchData
     *
     * @return array
     */
    protected function searchDataToDisplayData($searchData)
    {
        $data = $searchData;

        // 会員種別
        $val = [];
        if (isset($searchData['customer_status']) && is_array($searchData['customer_status'])) {
            array_map(function ($CustomerStatus) use (&$val) {
                /* @var \Eccube\Entity\Master\CustomerStatus $CustomerStatus */
                $val[] = $CustomerStatus->getName();
            }, $searchData['customer_status']);
        }
        $data['customer_status'] = implode(', ', $val);

        // 性別
        $val = [];
        if (isset($searchData['sex']) && is_array($searchData['sex'])) {
            array_map(function ($Sex) use (&$val) {
                /* @var Sex $Sex */
                $val[] = $Sex->getName();
            }, $searchData['sex']);
        }
        $data['sex'] = implode(', ', $val);

        // メルマガグループ
        $val = [];
        if (isset($searchData['Group'])) {
            $searchData['Group']->map(
                function ($Group) use (&$val) {
                    /* @var Group $Group */
                    $val[] = $Group->getGroupName();
            });
        }
        $data['Group'] = implode(', ', $val);

        if (isset($searchData['ignore_permissions']) && $searchData['ignore_permissions']) {
            switch ($searchData['ignore_permissions']) {
            case 1:
                $data['ignore_permissions'] = 'postcarrier.mail_customer.label_check_permissions'; break;
            case 2:
                $data['ignore_permissions'] = 'postcarrier.mail_customer.label_exclude_customer'; break;
            default:
                $data['ignore_permissions'] = 'postcarrier.mail_customer.label_ignore_permissions'; break;
            }
        }

        return $data;
    }

    /**
     * コピー
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/copy",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_history_copy"
     * )
     * @Template("@PostCarrier4/admin/template_edit.twig")
     *
     * @param int $id
     *
     * @return array
     */
    public function copy($id)
    {
        $postCarrierService = $this->postCarrierService;

        $apiData = $postCarrierService->getDelivery($id);
        $templateData = $postCarrierService->extractTemplate($apiData);

        $form = $this->formFactory
            ->createBuilder(PostCarrierTemplateEditType::class, $templateData)
            ->getForm();

        return [
            'form' => $form->createView(),
            'template_id' => null, // コピー作成
        ];
    }

    /**
     * 配信結果
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/result",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_history_result"
     * )
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/result/{page_no}",
     *     requirements={"id":"\d+", "page_no" = "\d+"},
     *     name="plugin_post_carrier_history_result_page"
     * )
     * @Template("@PostCarrier4/admin/history_result.twig")
     *
     * @param Request $request
     * @param int $id
     * @param PaginatorInterface $paginator
     * @param int $page_no
     *
     * @return mixed
     */
    public function result(Request $request, $id, PaginatorInterface $paginator, $page_no = 1)
    {
        $postCarrierService = $this->postCarrierService;

        $pageNo = $page_no;
        $pageMaxis = $this->pageMaxRepository->findAll();
        $pageCount = $this->eccubeConfig['eccube_default_page_count'];
        $pageCountParam = $request->get('page_count');
        if ($pageCountParam && is_numeric($pageCountParam)) {
            foreach ($pageMaxis as $pageMax) {
                if ($pageCountParam == $pageMax->getName()) {
                    $pageCount = $pageMax->getName();
                    break;
                }
            }
        }

        $offset = $pageCount * ($pageNo - 1);
        $postCarrierService->getMailLog($isError, $id, $itemCount, 0);
        $apiData = $postCarrierService->getMailLog($isError, $id, $dummy, $pageCount, $offset);
        if ($isError || $itemCount <= 0) {
            $this->addError('postcarrier.common.get.failure', 'admin');

            $itemCount = 0;
            $items = [];
        } else {
            $items = $apiData['messages'];
        }

        $pagination = $paginator->paginate([], $pageNo, $pageCount);
        $pagination->setItems($items);
        $pagination->setTotalItemCount($itemCount);

        return [
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_count' => $pageCount,
            'deliveryId' => $id,
        ];
    }

    /**
     * 配信分析
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/analysis",
     *      requirements={"id":"\d+"},
     *      name="plugin_post_carrier_history_analysis",
     * )
     * @Template("@PostCarrier4/admin/history_analysis.twig")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|array
     */
    public function analysis($id)
    {
        $arrMarketing = $this->postCarrierService->getMarketing($id);

        $arrMarketing['nSent2'] = $arrMarketing['nSent'] - $arrMarketing['nClick'];
        $arrMarketing['nClick2'] = $arrMarketing['nClick'] - $arrMarketing['nConversion'];
        //開封率設定
        if ($arrMarketing['nOpened'] == 0 || $arrMarketing['populationOpened'] == 0){
            $arrMarketing['nOpened2'] = 0;
        } else {
            $arrMarketing['nOpened2'] = $arrMarketing['nOpened'] / $arrMarketing['populationOpened'] * 100;
        }

        // 配信履歴からHTML配信か否かのフラグを取得
        $htmlMailFlg = false;
        $result = $this->postCarrierService->getDelivery($id);
        if ($result['message'][0]['type'] == 'html') {
            $htmlMailFlg = true;
        }

        return [
            'id' => $id,
            'subject' => $arrMarketing['subject'],
            'arrMarketing' => $arrMarketing,
            'htmlMailFlg' => $htmlMailFlg,
            'adm_name' => $result['name'],
            'adm_note' => $result['note'],
        ];
    }

    /**
     * 顧客配信分析
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/analysis/customer",
     *      requirements={"id":"\d+"},
     *      name="plugin_post_carrier_history_analysis_customer",
     * )
     * @Template("@PostCarrier4/admin/history_analysis_customer.twig")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|array
     */
    public function analysisCustomer($id)
    {
        $arrMarketing = $this->postCarrierService->getMarketing($id, true);
        $subject = $arrMarketing['subject'];
        $arrMarketing = $this->createCustomersData($arrMarketing);

        return [
            'id' => $id,
            'subject' => $subject,
            'arrMarketing' => $arrMarketing,
        ];
    }

    /**
     * リンク配信分析
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/analysis/link",
     *      requirements={"id":"\d+"},
     *      name="plugin_post_carrier_history_analysis_link",
     * )
     * @Template("@PostCarrier4/admin/history_analysis_link.twig")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response|array
     */
    public function analysisLink($id)
    {
        $arrMarketing = $this->postCarrierService->getMarketing($id);
        $subject = $arrMarketing['subject'];
        list($arrMarketing['links'], $maxcount) = $this->createLinksData($arrMarketing['links']);

        return [
            'id' => $id,
            'subject' => $subject,
            'arrMarketing' => $arrMarketing,
            'maxcount' => $maxcount,
        ];
    }

    private function createCustomersData($arrMarketing)
    {
        $customerData = [];

        $count = 0;
        $countcv = 0;
        foreach ($arrMarketing['result'] as $marketing) {
            $count += $marketing['男']['nTotalClick'] + $marketing['女']['nTotalClick'];
            $countcv += $marketing['男']['nTotalConversion'] + $marketing['女']['nTotalConversion'];
        }
        $customerData['nTotalClick'] = $count;
        $customerData['nTotalConversion'] = $countcv;

        $clickData = [];
        $clickData[0][0] = $arrMarketing['result']['10代']['女']['nTotalClick'];
        $clickData[0][1] = $arrMarketing['result']['20代']['女']['nTotalClick'];
        $clickData[0][2] = $arrMarketing['result']['30代']['女']['nTotalClick'];
        $clickData[0][3] = $arrMarketing['result']['40代']['女']['nTotalClick'];
        $clickData[0][4] = $arrMarketing['result']['50代']['女']['nTotalClick'];
        $clickData[0][5] = $arrMarketing['result']['60代']['女']['nTotalClick'];
        $clickData[0][6] = $arrMarketing['result']['その他']['女']['nTotalClick'];
        $clickData[1][0] = $arrMarketing['result']['10代']['男']['nTotalClick'];
        $clickData[1][1] = $arrMarketing['result']['20代']['男']['nTotalClick'];
        $clickData[1][2] = $arrMarketing['result']['30代']['男']['nTotalClick'];
        $clickData[1][3] = $arrMarketing['result']['40代']['男']['nTotalClick'];
        $clickData[1][4] = $arrMarketing['result']['50代']['男']['nTotalClick'];
        $clickData[1][5] = $arrMarketing['result']['60代']['男']['nTotalClick'];
        $clickData[1][6] = $arrMarketing['result']['その他']['男']['nTotalClick'];
        $customerData['click'] = $clickData;

        $clickPer = [];
        foreach ($customerData['click'] as $sex => $generationData) {
            foreach ($generationData as $generation => $nTotalClick) {
                $clickPer[$sex][$generation] = $customerData['nTotalClick'] == 0 ? 0 : $nTotalClick / $customerData['nTotalClick'] * 100;
            }
        }
        $customerData['clickPer'] = $clickPer;

        $conversionData = [];
        $conversionData[0][0] = $arrMarketing['result']['10代']['女']['nTotalConversion'];
        $conversionData[0][1] = $arrMarketing['result']['20代']['女']['nTotalConversion'];
        $conversionData[0][2] = $arrMarketing['result']['30代']['女']['nTotalConversion'];
        $conversionData[0][3] = $arrMarketing['result']['40代']['女']['nTotalConversion'];
        $conversionData[0][4] = $arrMarketing['result']['50代']['女']['nTotalConversion'];
        $conversionData[0][5] = $arrMarketing['result']['60代']['女']['nTotalConversion'];
        $conversionData[0][6] = $arrMarketing['result']['その他']['女']['nTotalConversion'];
        $conversionData[1][0] = $arrMarketing['result']['10代']['男']['nTotalConversion'];
        $conversionData[1][1] = $arrMarketing['result']['20代']['男']['nTotalConversion'];
        $conversionData[1][2] = $arrMarketing['result']['30代']['男']['nTotalConversion'];
        $conversionData[1][3] = $arrMarketing['result']['40代']['男']['nTotalConversion'];
        $conversionData[1][4] = $arrMarketing['result']['50代']['男']['nTotalConversion'];
        $conversionData[1][5] = $arrMarketing['result']['60代']['男']['nTotalConversion'];
        $conversionData[1][6] = $arrMarketing['result']['その他']['男']['nTotalConversion'];
        $customerData['conversion'] = $conversionData;

        $conversionPer = [];
        foreach ($customerData['conversion'] as $sex => $generationData) {
            foreach ($generationData as $generation => $nTotalConversion) {
                $conversionPer[$sex][$generation] = $clickData[$sex][$generation] == 0 ? 0 : $nTotalConversion / $clickData[$sex][$generation] * 100;
            }
        }
        $customerData['conversionPer'] = $conversionPer;

        return $customerData;
    }

    private function createLinksData($arrMarketing)
    {
        if (!is_array($arrMarketing)) return [];

        ksort($arrMarketing);
        $maxwidth = 90;
        $maxcount = 0;
        foreach ($arrMarketing as $marketing) {
            if ($maxcount < $marketing['nTotalClick']) {
                $maxcount = $marketing['nTotalClick'];
            }
        }

        $tmpArrays = [];
        foreach ($arrMarketing as $marketing) {
            $url = parse_url($marketing['url']);
            $tmpUrl = $url['path'];
            if (array_key_exists('query', $url) && $url['query'] != "") $tmpUrl = $tmpUrl.'?'.$url['query'];
            if (array_key_exists('fragment', $url) && $url['fragment'] != "") $tmpUrl = $tmpUrl.'#'.$url['fragment'];
            $marketing['url_short'] = $tmpUrl;

            $tmpArrays[] = $marketing;
        }

        return [$tmpArrays, $maxcount];
    }

    /**
     * 配信条件を表示する.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/history/{id}/export",
     *      requirements={"id":"\d+"},
     *      name="plugin_post_carrier_history_export",
     * )
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function export($id)
    {
        $postCarrierService = $this->postCarrierService;

        set_time_limit(0);

        $apiData = $postCarrierService->downloadMaillog($isError, $id);
        if (!$isError) {
            $response = new StreamedResponse();
            $response->setCallback(function () use ($apiData) {
                $fp = fopen('php://output', 'w');
                fwrite($fp, $apiData);
                fclose($fp);
            });
            $filename = "maillog-$id.zip";
            $response->headers->set('Content-Type', 'application/octet-stream; name='.$filename);
            $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
    
            return $response;
        } else {
            $this->addError('postcarrier.common.get.failure', 'admin');
            return $this->redirectToRoute('plugin_post_carrier_history_result', ['id' => $id]);
        }
    }
}
