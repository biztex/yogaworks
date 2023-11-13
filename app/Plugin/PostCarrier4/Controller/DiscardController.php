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
use Plugin\PostCarrier4\Form\Type\PostCarrierDiscardType;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DiscardController extends AbstractController
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
     * @Route("/%eccube_admin_route%/plugin/post_carrier/discard", name="plugin_post_carrier_discard")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/discard/{page_no}",
     *     requirements={"page_no" = "\d+"},
     *     name="plugin_post_carrier_discard_page"
     * )
     * @Template("@PostCarrier4/admin/discard_list.twig")
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

        $searched = false;

        $form = $this->formFactory
            ->createBuilder(PostCarrierDiscardType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $email = $form->get('email')->getData();
                $action = $form->getClickedButton()->getName();
                switch ($action) {
                case 'search':
                    $searched = true;
                    $apiData = $postCarrierService->searchDiscard($isError, $email);
                    if ($isError) {
                        $this->addError('検索できませんでした。', 'admin');
                        $items = [];
                        $itemCount = 0;
                    } else {
                        $items = $apiData;
                        $itemCount = count($apiData);
                    }
                    break;
                case 'save':
                    $apiData = $postCarrierService->saveDiscard($isError, $email);
                    if ($isError) {
                        $this->addError('登録できませんでした。', 'admin');
                    } else {
                        $this->addSuccess('登録しました。', 'admin');
                    }
                    break;
                case 'delete':
                    $postCarrierService->deleteDiscard($isError, $email);
                    if ($isError) {
                        $this->addError('削除できませんでした。', 'admin');
                    } else {
                        $this->addSuccess('削除しました。', 'admin');
                    }
                    break;
                default:
                    // error
                    break;
                }
            } else {

            }
        }

        if (!$searched) {
            $items = $postCarrierService->getDiscardList($isError, $itemCount, $pageCount, $offsetNo);
            if ($isError) {
                $this->addError('postcarrier.common.get.failure', 'admin');

                $items = [];
                $itemCount = 0;
            }
        }

        $pagination = $paginator->paginate([], $pageNo, $pageCount);
        $pagination->setItems($items);
        $pagination->setTotalItemCount($itemCount);

        return [
            'form' => $form->createView(),
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_count' => $pageCount,
        ];
    }

    /**
     * 除外リストをダウンロード.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/discard/export",
     *      name="plugin_post_carrier_discard_export",
     * )
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function export()
    {
        $postCarrierService = $this->postCarrierService;

        set_time_limit(0);

        $apiData = $postCarrierService->downloadDiscardList($isError);
        if (!$isError) {
            $response = new StreamedResponse();
            $response->setCallback(function () use ($apiData) {
                $fp = fopen('php://output', 'w');
                fwrite($fp, $apiData);
                fclose($fp);
            });
            $filename = "discard_address.zip";
            $response->headers->set('Content-Type', 'application/octet-stream; name='.$filename);
            $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

            return $response;
        } else {
            $this->addError('postcarrier.common.get.failure', 'admin');
            return $this->redirectToRoute('plugin_post_carrier_discard');
        }
    }
}
