<?php

/*
 * Plugin Name: JoolenPointsForMemberRegistration4
 *
 * Copyright(c) joolen inc. All Rights Reserved.
 *
 * https://www.joolen.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\JoolenPointsForMemberRegistration4;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\BaseInfo;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Eccube\Repository\BaseInfoRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Event implements EventSubscriberInterface
{
    /**
     * @var BaseInfo
     */
    private $baseInfo;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(
        BaseInfoRepository $baseInfoRepository,
        EntityManagerInterface $entityManager)
    {
        $this->baseInfo = $baseInfoRepository->get();
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            // --------------
            // Admin
            // --------------
            '@admin/Setting/Shop/shop_master.twig' => 'onRenderShopMaster',

            //---------------
            // Front
            // --------------
            EccubeEvents::FRONT_ENTRY_ACTIVATE_COMPLETE => 'onEntryActivateComplete',
        ];
    }

    /**
     * [管理]設定＞店舗設定＞基本設定画面の表示
     */
    public function onRenderShopMaster(TemplateEvent $event)
    {
        $twig = '@JoolenPointsForMemberRegistration4/admin/Setting/Shop/shop_master.twig';
        $event->addSnippet($twig);
    }

    /**
     * [フロント]メール認証時
     * 仮会員機能が無効の場合、EntryController内でentryActivateの処理を実行するため「FRONT_ENTRY_ACTIVATE_COMPLETE」イベントに該当する
     *       〃 が有効な場合、メールにて送信されたURLにアクセスすることで「FRONT_ENTRY_ACTIVATE_COMPLETE」イベントが実行される
     */
    public function onEntryActivateComplete(EventArgs $EventArgs)
    {
        // ポイント機能が無効な場合は終了
        if (!$this->baseInfo->isOptionPoint()) {
            return false;
        }

        // 付与期間外の場合はポイントを付与しない
        $TimeService = \Plugin\JoolenPointsForMemberRegistration4\Service\TimeService::getInstance();
        if (!$TimeService->isInTerm(
            $this->baseInfo->getApplyDatetimeStart(),
            $this->baseInfo->getApplyDatetimeEnd()
        )){
            return;
        }

        $Customer = $EventArgs->getArgument('Customer');

        // 設定したポイントを取得
        $memberRegistrationPoint = $this->baseInfo->getMemberRegistrationPoint();

        // 現在の保持ポイントに付与ポイントを加算
        $addPoint = $memberRegistrationPoint + $Customer->getPoint();

        // ポイントをセット
        $Customer->setPoint($addPoint);
        $this->entityManager->flush();
    }
}
