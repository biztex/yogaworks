<?php

/*
 * Plugin Name: JoolenPromotionModal4
 *
 * Copyright(c) joolen inc. All Rights Reserved.
 *
 * https://www.joolen.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\JoolenPromotionModal4\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\JoolenPromotionModal4\Entity\PromotionModal;
use Plugin\JoolenPromotionModal4\Form\Type\Admin\PromotionModalType;
use Plugin\JoolenPromotionModal4\Repository\PromotionModalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PromotionModalController extends AbstractController
{
    /**
     * @var PromotionModalRepository
     */
    protected $promotionModalRepository;

    /**
     * ConfigController constructor.
     *
     * @param PromotionModalRepository $promotionModalRepository
     */
    public function __construct(PromotionModalRepository $promotionModalRepository)
    {
        $this->promotionModalRepository = $promotionModalRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/joolen_promotion_modal4/config", name="joolen_promotion_modal4_admin_config")
     * @Template("@JoolenPromotionModal4/admin/config.twig")
     */
    public function index(Request $request)
    {
        $PromotionModal = $this->promotionModalRepository->get();
        if (!$PromotionModal) {
            $PromotionModal = new PromotionModal();
            $PromotionModal->setVisible(false);
        }
        $form = $this->createForm(PromotionModalType::class, $PromotionModal);
        // 既に画像保存されてる場合は取得する
        $oldImage = $PromotionModal->getImage();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $PromotionModal = $form->getData();
            // ファイルアップロード
            $file = $form['image']->getData();
            $fs = new Filesystem();
            if ($file && $fs->exists($this->getParameter('eccube_temp_image_dir').'/'.$file)) {
                $fs->rename(
                    $this->getParameter('eccube_temp_image_dir').'/'.$file,
                    $this->getParameter('eccube_save_image_dir').'/'.$file
                );
            }
            $this->entityManager->persist($PromotionModal);
            $this->entityManager->flush($PromotionModal);
            $this->addSuccess('登録しました。', 'admin');

            return $this->redirectToRoute('joolen_promotion_modal4_admin_config');
        }

        return [
            'form' => $form->createView(),
            'oldImage' => $oldImage,
        ];
    }

    /**
     * @Route("/%eccube_admin_route%/config/joolen_promotion_modal4/image/add", name="joolen_promotion_modal4_admin_config_image_add")
     */
    public function imageAdd(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new BadRequestHttpException();
        }

        $images = $request->files->get('promotion_modal');
        $allowExtensions = ['gif', 'jpg', 'jpeg', 'png'];
        $filename = null;
        if (isset($images['image_file'])) {
            $image = $images['image_file'];

            //ファイルフォーマット検証
            $mimeType = $image->getMimeType();
            if (0 !== strpos($mimeType, 'image')) {
                throw new UnsupportedMediaTypeHttpException();
            }

            // 拡張子
            $extension = $image->getClientOriginalExtension();
            if (!in_array(strtolower($extension), $allowExtensions)) {
                throw new UnsupportedMediaTypeHttpException();
            }

            $filename = date('mdHis').uniqid('_').'.'.$extension;
            $image->move($this->getParameter('eccube_temp_image_dir'), $filename);
        }

        return $this->json(['filename' => $filename], 200);
    }
}
