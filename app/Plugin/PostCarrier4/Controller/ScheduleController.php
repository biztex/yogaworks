<?php
/*
 * This file is part of the PostCarrier
 *
 * Copyright(c) 2016 IPLOGIC CO.,LTD. All Rights Reserved.
 * http://www.iplogic.co.jp
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\PostCarrier4\Controller;

use Eccube\Controller\AbstractController;
use Eccube\Entity\Master\Sex;
use Eccube\Repository\Master\PageMaxRepository;
use Knp\Component\Pager\PaginatorInterface;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Plugin\PostCarrier4\Util\PostCarrierUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
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
     * 一覧表示
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/schedule", name="plugin_post_carrier_schedule")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/schedule/{page_no}", requirements={"page_no" = "\d+"}, name="plugin_post_carrier_schedule_page")
     * @Template("@PostCarrier4/admin/schedule_list.twig")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param integer $page_no
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function index(Request $request, PaginatorInterface $paginator, $page_no = null)
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
        $items = $postCarrierService->getScheduleList($isError, 'SCHEDULE', $itemCount, $pageCount, $offsetNo);
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
     * 削除
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/schedule/{id}/delete", requirements={"id" = "\d+"}, name="plugin_post_carrier_schedule_delete")
     *
     * @param Request $request
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function delete(Request $request, $id)
    {
        if ('POST' === $request->getMethod()) {
            $this->postCarrierService->schedulerDelete($id);
        }

        return $this->redirectToRoute('plugin_post_carrier_schedule');
    }

    /**
     * 編集
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/schedule/{id}/edit", requirements={"id" = "\d+"}, name="plugin_post_carrier_schedule_edit")
     *
     * @param Request $request
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function edit(Request $request, $id)
    {
        $this->addInfo('postcarrier.schedule.edit_message', 'admin');

        return $this->redirectToRoute('plugin_post_carrier_edit', ['edit_id' => $id]);
    }

    /**
     * 即時配信
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/schedule/{id}/run", requirements={"id" = "\d+"}, name="plugin_post_carrier_schedule_run")
     *
     * @param Request $request
     * @param integer $id
     *
     * @return \Symfony\Component\HttpFoundation\Response|array
     */
    public function run(Request $request, $id)
    {
        $this->postCarrierService->schedulerExecute($id);

        return $this->redirectToRoute('plugin_post_carrier_history');
    }
}
