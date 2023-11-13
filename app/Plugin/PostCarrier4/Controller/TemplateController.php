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
use Plugin\PostCarrier4\Form\Type\PostCarrierTemplateEditType;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Plugin\PostCarrier4\Util\PostCarrierUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
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
     * @var PageMaxRepository
     */
    protected $pageMaxRepository;

    /**
     * PostCarrierTemplateController constructor.
     *
     * @param PostCarrierService $postCarrierService
     * @param PostCarrierUtil $postCarrierUtil
     * @param PageMaxRepository $pageMaxRepository
     */
    public function __construct(
        PostCarrierService $postCarrierService,
        PostCarrierUtil $postCarrierUtil,
        PageMaxRepository $pageMaxRepository
    ) {
        $this->postCarrierService = $postCarrierService;
        $this->postCarrierUtil = $postCarrierUtil;
        $this->pageMaxRepository = $pageMaxRepository;
    }

    /**
     * テンプレート一覧表示.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/template", name="plugin_post_carrier_template")
     * @Route("/%eccube_admin_route%/plugin/post_carrier/template/{page_no}",
     *     requirements={"page_no" = "\d+"},
     *     name="plugin_post_carrier_template_page"
     * )
     * @Template("@PostCarrier4/admin/template_list.twig")
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

        $templateList = [];
        $postCarrierService->getTemplateList($isError, $itemCount, 0);
        if ($isError) {
            $this->addError('postcarrier.common.get.failure', 'admin');
            $items = [];
            $itemCount = 0;
        } else {
            $apiData = $postCarrierService->getTemplateList($isError, $dummy, $pageCount, $offset);
            if ($isError) {
                $this->addError('postcarrier.common.get.failure', 'admin');
                $items = [];
                $itemCount = 0;
            } else {
                $templateList = $apiData['templates'];
                // 種別を設定
                foreach ($templateList as &$template) {
                    $template['kind'] = PostCarrierUtil::templateKindToString(PostCarrierUtil::decodeTemplateKind($template));
                }
            }
        }

        $pagination = $paginator->paginate([], $pageNo, $pageCount);
        $pagination->setItems($templateList);
        $pagination->setTotalItemCount($itemCount);

        return [
            'pagination' => $pagination,
            'pageMaxis' => $pageMaxis,
            'page_count' => $pageCount,
        ];
    }

    /**
     * preview画面表示.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/template/{id}/preview",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_template_preview"
     * )
     * @Template("@PostCarrier4/admin/preview.twig")
     *
     * @param int $id
     *
     * @return array
     */
    public function preview($id)
    {
        $postCarrierService = $this->postCarrierService;

        // TODO: テキスト部分も取得する
        $apiData = $postCarrierService->previewTemplate($isError, $id);
        if ($isError) {
            $this->addError('postcarrier.common.get.failure', 'admin');
            return $this->redirectToRoute('plugin_post_carrier_template');
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
        ];
    }

    /**
     * メルマガテンプレート削除.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/template/{id}/delete",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_template_delete",
     *     methods={"POST"}
     * )
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $postCarrierService = $this->postCarrierService;

        $postCarrierService->deleteTemplate($isError, $id);
        if ($isError) {
            $this->addError('admin.common.delete_error', 'admin');
        } else {
            $this->addSuccess('admin.common.delete_complete', 'admin');
        }

        return $this->redirectToRoute('plugin_post_carrier_template');
    }

    /**
     * テンプレート編集画面表示.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/template/{id}/edit",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_template_edit"
     * )
     * @Template("@PostCarrier4/admin/template_edit.twig")
     *
     * @param Request $request
     * @param int $id
     *
     * @return array
     */
    public function edit(Request $request, $id = null)
    {
        $postCarrierService = $this->postCarrierService;

        $apiData = $postCarrierService->getTemplate($isError, $id);

        $templateData = $postCarrierService->extractTemplate($apiData);

        $form = $this->formFactory
            ->createBuilder(PostCarrierTemplateEditType::class, $templateData, ['d__kind'=>$templateData['d__kind']])
            ->getForm();

        return [
            'form' => $form->createView(),
            'template_id' => $id,
        ];
    }

    /**
     * コピー編集画面表示.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/template/{id}/copy",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_template_copy"
     * )
     * @Template("@PostCarrier4/admin/template_edit.twig")
     *
     * @param int $id
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function copy($id)
    {
        $postCarrierService = $this->postCarrierService;

        $apiData = $postCarrierService->getTemplate($isError, $id);

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
     * テンプレート編集確定処理.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/template/commit/{id}",
     *     requirements={"id":"\d+"},
     *     name="plugin_post_carrier_template_commit",
     *     methods={"POST"}
     * )
     * @Template("@PostCarrier4/admin/template_edit.twig")
     *
     * @param Request $request
     * @param int $id
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function commit(Request $request, $id = null)
    {
        $postCarrierService = $this->postCarrierService;

        $builder = $this->formFactory->createBuilder(PostCarrierTemplateEditType::class);
        $form = $builder->getForm();
        $form->handleRequest($request);

        if ($request->get('mode') == 'kind') {
            $formData = $form->getData();

            $form = $this->formFactory
                ->createBuilder(PostCarrierTemplateEditType::class, $formData, ['d__kind'=>$formData['d__kind']])
                ->getForm();

            return [
                'form' => $form->createView(),
                'template_id' => $id,
            ];
        }

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addError('admin.common.save_error', 'admin');

                return [
                    'form' => $form->createView(),
                    'template_id' => $id,
                ];
            }

            $templateData = $form->getData();
            if ($id !== null) $templateData['id'] = $id; // 既存テンプレート編集

            $postCarrierService->saveTemplate($isError, $templateData);
            if ($isError) {
                $this->addError('admin.postcarrier.template.save.failure', 'admin');

                return [
                    'form' => $form->createView(),
                    'template_id' => $id,
                ];
            } else {
                $this->addSuccess('admin.postcarrier.template.save.complete', 'admin');
            }
        }

        return $this->redirectToRoute('plugin_post_carrier_template');
    }

    /**
     * テンプレート新規登録画面表示.
     *
     * @Route("/%eccube_admin_route%/plugin/post_carrier/template/regist", name="plugin_post_carrier_template_regist")
     * @Template("@PostCarrier4/admin/template_edit.twig")
     *
     * @return array
     */
    public function regsit()
    {
        $defaults = $this->postCarrierUtil->createTemplateDefaults();

        $form = $this->formFactory
            ->createBuilder(PostCarrierTemplateEditType::class, $defaults)
            ->getForm();

        return [
            'form' => $form->createView(),
            'template_id' => null, // 新規作成
        ];
    }
}
