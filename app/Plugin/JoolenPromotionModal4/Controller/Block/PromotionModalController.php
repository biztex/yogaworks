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

namespace Plugin\JoolenPromotionModal4\Controller\Block;

use Plugin\JoolenPromotionModal4\Repository\PromotionModalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Eccube\Controller\AbstractController;

/**
 * Class PromotionModalController
 */
class PromotionModalController extends AbstractController
{
    /**
     * @var PromotionModalRepository
     */
    protected $promotionModalRepository;

    /**
     * @var string Cookie Name
     */
    const PROMOTION_MODAL_COOKIE_NAME = 'plg_promotion_modal';

    /**
     * PromotionModalController constructor.
     *
     * @param PromotionModalRepository $promotionModalRepository
     */
    public function __construct(PromotionModalRepository $promotionModalRepository)
    {
        $this->promotionModalRepository = $promotionModalRepository;
    }

    /**
     * @Route("/block/plg_promotion_modal", name="block_plg_promotion_modal")
     * @Template("Block/plg_promotion_modal.twig")
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $PromotionModal = $this->promotionModalRepository->get();
        if (!$PromotionModal) {
            return[];
        }

        if (!$PromotionModal->isVisible()) {
            return[];
        }

        if ($this->isGranted('ROLE_USER')) {
            if (!$PromotionModal->isLoginUserDisplay()) {
                return[];
            }
        } else {
            if (!$PromotionModal->isNonMemberDisplay()) {
                return[];
            }
        }

        if ($PromotionModal->isIntervalUnlimited()) {
            setcookie(self::PROMOTION_MODAL_COOKIE_NAME);
        } else {
            $now = new \DateTime();
            if(isset($_COOKIE[self::PROMOTION_MODAL_COOKIE_NAME])){
                if ($PromotionModal->getUpdateDate()->format('Y-m-d H:i:s') < $_COOKIE[self::PROMOTION_MODAL_COOKIE_NAME] ) {
                    return[];
                }
            }

            $expires = time() + 3600 * 24 * $PromotionModal->getIntervalDate();
            setcookie(self::PROMOTION_MODAL_COOKIE_NAME,$now->format('Y-m-d H:i:s'), $expires);
        }

        return [
            'PromotionModal' => $PromotionModal
        ];
    }
}
