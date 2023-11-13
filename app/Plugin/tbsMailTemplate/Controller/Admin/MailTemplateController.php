<?php

namespace Plugin\tbsMailTemplate\Controller\Admin;

use Eccube\Controller\AbstractController;
use Eccube\Entity\MailTemplate;
use Eccube\Repository\MailTemplateRepository;
use Eccube\Util\CacheUtil;
use Eccube\Util\StringUtil;
use Plugin\tbsMailTemplate\Form\Type\Admin\MailTemplateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class MailTemplateController extends AbstractController
{
    /**
     * @var MailTemplateRepository
     */
    protected $mailTemplateRepository;

    /**
     * MailTemplateController constructor.
     *
     * @param MailTemplateRepository $mailTemplateRepository
     */
    public function __construct(MailTemplateRepository $mailTemplateRepository)
    {
        $this->mailTemplateRepository = $mailTemplateRepository;
    }

    /**
     * 管理.
     *
     * @Route("%eccube_admin_route%/tbs_mail_template/", name="tbs_mail_template_admin_config")
     * @Template("@tbsMailTemplate/admin/index.twig")
     *
     * @return array|RedirectResponse
     */
    public function index()
    {
        $MailTemplates = $this->mailTemplateRepository->findBy(array(), array('id' => 'ASC'));

        return [
            'MailTemplates' => $MailTemplates,
        ];
    }

    /**
     * 登録・編集.
     *
     * @Route("%eccube_admin_route%/tbs_mail_template/new", name="tbs_mail_template_admin_config_mail_template_new")
     * @Route("%eccube_admin_route%/tbs_mail_template/{id}/edit", name="tbs_mail_template_admin_config_mail_template_edit")
     * @Template("@tbsMailTemplate/admin/edit.twig")
     *
     * @param Request $request
     * @param MailTemplate $MailTemplate
     *
     * @return array|RedirectResponse
     */
    public function edit(Request $request, MailTemplate $MailTemplate = null, Environment $twig, RouterInterface $router, CacheUtil $cacheUtil)
    {
        $is_new = false;
        $editable = true;
        $htmlFileName = null;
        if (is_null($MailTemplate)) {
            $MailTemplate = new MailTemplate();
            $is_new = true;
        }
        else {
            $htmlFileName = $this->getHtmlFileName($MailTemplate->getFileName());
        }

        $builder = $this->formFactory
            ->createBuilder(MailTemplateType::class, $MailTemplate);

        // $event = new EventArgs(
        //     [
        //         'builder' => $builder,
        //         'Mail' => $MailTemplate,
        //     ],
        //     $request
        // );
        // $this->eventDispatcher->dispatch(EccubeEvents::ADMIN_SETTING_SHOP_MAIL_INDEX_INITIALIZE, $event);

        $form = $builder->getForm();
        $form['name']->setData($MailTemplate);

        // 更新時
        if (!$is_new) {
            $editable = ($MailTemplate->getId() > $this->eccubeConfig['eccube_shipping_notify_mail_template_id']) ? true : false;

            $file_name = $MailTemplate->getFileName();
            $arr = explode('/', $file_name);
            $arr = explode('.', $arr[1]);
            $form->get('file_name_cut')->setData($arr[0]);

            // テンプレートファイルの取得
            $source = $twig->getLoader()
                ->getSourceContext($MailTemplate->getFileName())
                ->getCode();

            $form->get('tpl_data')->setData($source);
            if ($twig->getLoader()->exists($htmlFileName)) {
                $source = $twig->getLoader()
                    ->getSourceContext($htmlFileName)
                    ->getCode();

                $form->get('html_tpl_data')->setData($source);
            }
        }

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($is_new) {
                    $file_name_cut = $form->get('file_name_cut')->getData();
                    $file_name = 'Mail/' . $file_name_cut . '.twig';

                    // 重複チェック
                    if ($this->mailTemplateRepository->findOneBy(array('file_name' => $file_name))) {
                        $this->addError('tbs_mail_template.admin.duplicated', 'admin');
                        return [
                            'form' => $form->createView(),
                            'editable' => $editable,
                            'is_new' => $is_new,
                        ];
                    }

                    $MailTemplate->setFileName($file_name);
                }

                $this->entityManager->persist($MailTemplate);
                $this->entityManager->flush();

                // ファイル生成・更新
                $templatePath = $this->getParameter('eccube_theme_front_dir');
                $filePath = $templatePath.'/'.$MailTemplate->getFileName();

                $fs = new Filesystem();
                $mailData = $form->get('tpl_data')->getData();
                $mailData = StringUtil::convertLineFeed($mailData);
                $fs->dumpFile($filePath, $mailData);

                // HTMLファイル用
                $htmlFileName = $this->getHtmlFileName($MailTemplate->getFileName());
                $filePath = $templatePath.'/'.$htmlFileName;

                $htmlMailData = $form->get('html_tpl_data')->getData();
                if ($htmlMailData) {
                    $htmlMailData = StringUtil::convertLineFeed($htmlMailData);
                    $fs->dumpFile($filePath, $htmlMailData);
                }

                // $event = new EventArgs(
                //     [
                //         'form' => $form,
                //         'Mail' => $MailTemplate,
                //         'templatePath' => $templatePath,
                //         'filePath' => $filePath,
                //     ],
                //     $request
                // );
                // $this->eventDispatcher->dispatch(EccubeEvents::ADMIN_SETTING_SHOP_MAIL_INDEX_COMPLETE, $event);

                $this->addSuccess('admin.common.save_complete', 'admin');

                // キャッシュの削除
                $cacheUtil->clearTwigCache();

                if ($returnLink = $form['return_link']->getData()) {
                    try {
                        // $returnLinkはpathの形式で渡される. pathが存在するかをルータでチェックする.
                        $pattern = '/^'.preg_quote($request->getBasePath(), '/').'/';
                        $returnLink = preg_replace($pattern, '', $returnLink);
                        $result = $router->match($returnLink);
                        // パラメータのみ抽出
                        $params = array_filter($result, function ($key) {
                            return 0 !== \strpos($key, '_');
                        }, ARRAY_FILTER_USE_KEY);

                        // pathからurlを再構築してリダイレクト.
                        return $this->redirectToRoute($result['_route'], $params);
                    } catch (\Exception $e) {
                        // マッチしない場合はログ出力してスキップ.
                        log_warning('URLの形式が不正です。');
                    }
                }

                return $this->redirectToRoute('tbs_mail_template_admin_config_mail_template_edit', ['id' => $MailTemplate->getId()]);
            }
        }

        return [
            'form' => $form->createView(),
            'editable' => $editable,
            'is_new' => $is_new,
        ];
    }

    /**
     * 削除.
     *
     * @Method("DELETE")
     * @Route("%eccube_admin_route%/tbs_mail_template/{id}/delete", name="tbs_mail_template_admin_config_mail_template_delete")
     *
     * @param MailTemplate $MailTemplate
     *
     * @return RedirectResponse
     */
    public function delete(MailTemplate $MailTemplate)
    {
        $this->isTokenValid();

        if ($MailTemplate->getId() <= $this->eccubeConfig['eccube_shipping_notify_mail_template_id']) {
            $this->addError('tbs_mail_template.admin.cannot_delete', 'admin');
            return $this->redirect($this->generateUrl('tbs_mail_template_admin_config'));
        }

        $this->entityManager->remove($MailTemplate);
        $this->entityManager->flush($MailTemplate);

        // テンプレートファイルを削除
        $fileName = $MailTemplate->getFileName();
        $htmlFileName = $this->getHtmlFileName($fileName);
        $file = new Filesystem();
        $file->remove(sprintf("%s/%s", $this->eccubeConfig['eccube_theme_front_dir'], $fileName));
        $file->remove(sprintf("%s/%s", $this->eccubeConfig['eccube_theme_front_dir'], $htmlFileName));

        $this->addSuccess('tbs_mail_template.admin.delete.complete', 'admin');

        log_info('MailTemplate delete', ['id' => $MailTemplate->getId()]);

        return $this->redirect($this->generateUrl('tbs_mail_template_admin_config'));
    }

    /**
     * @Route("/%eccube_admin_route%/tbs_mail_template/preview", name="tbs_mail_template_mail_template_preview")
     * @Template("@tbsMailTemplate/admin/mail_view.twig")
     */
    public function preview(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new BadRequestHttpException();
        }

        $html_body = $request->get('html_body');

        // $event = new EventArgs(
        //     [
        //         'html_body' => $html_body,
        //     ],
        //     $request
        // );
        // $this->eventDispatcher->dispatch(EccubeEvents::ADMIN_SETTING_SHOP_MAIL_PREVIEW_COMPLETE, $event);

        return [
            'html_body' => $html_body,
        ];
    }

    /**
     * HTML用テンプレート名を取得する
     *
     * @param  string $fileName
     *
     * @return string
     */
    protected function getHtmlFileName($fileName)
    {
        // HTMLテンプレートファイルの取得
        $targetTemplate = explode('.', $fileName);
        $suffix = '.html';

        return $targetTemplate[0].$suffix.'.'.$targetTemplate[1];
    }
}
