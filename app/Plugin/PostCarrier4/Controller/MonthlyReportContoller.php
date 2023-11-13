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
use Eccube\Repository\Master\PageMaxRepository;
use Knp\Component\Pager\PaginatorInterface;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MonthlyReportContoller extends AbstractController
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
     * 配信除外アドレス一覧.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/monthly_report", name="plugin_post_carrier_monthly_report")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/monthly_report/{page_no}",
     *     requirements={"page_no" = "\d+"},
     *     name="plugin_post_carrier_monthly_report_page"
     * )
     * @Template("@PostCarrier4/admin/monthly_report.twig")
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
        $offset = $pageCount * ($pageNo - 1);

        $monthlyReport = [];
        $postCarrierService->getMonthlyReport($isError, $itemCount, 0);
        if ($isError) {
            $this->addError('postcarrier.common.get.failure', 'admin');
            $items = [];
            $itemCount = 0;
        } else {
            $apiData = $postCarrierService->getMonthlyReport($isError, $dummy, $pageCount, $offset);
            if ($isError) {
                $this->addError('postcarrier.common.get.failure', 'admin');
                $items = [];
                $itemCount = 0;
            } else {
                $monthlyReport = $apiData;
            }
        }

        $pagination = $paginator->paginate([], $pageNo, $pageCount);
        $pagination->setItems($monthlyReport);
        $pagination->setTotalItemCount($itemCount);

        return [
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_count' => $pageCount,
        ];
    }
}
