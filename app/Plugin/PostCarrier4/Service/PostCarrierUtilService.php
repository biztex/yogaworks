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

namespace Plugin\PostCarrier4\Service;

use Eccube\Entity\BaseInfo;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\Master\CustomerStatusRepository;

/**
 * Class PostCarrierUtilService
 */
class PostCarrierUtilService
{
    /**
     * @var BaseInfo
     */
    public $BaseInfo;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    public function __construct(
        BaseInfoRepository $baseInfoRepository,
        \Swift_Mailer $mailer,
        \Twig_Environment $twig
    ) {
        $this->BaseInfo = $baseInfoRepository->get();
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendRegistrationMail($formData)
    {
        $BaseInfo = $this->BaseInfo;

        $body = $this->twig->render('PostCarrier4/Resource/template/Mail/registration.twig', [
            'data' => $formData,
            'BaseInfo' => $BaseInfo,
        ]);

        $message = (new \Swift_Message())
            ->setSubject('[' . $BaseInfo->getShopName() . '] メルマガ会員登録のご確認')
            ->setFrom([$BaseInfo->getEmail02() => $BaseInfo->getShopName()])
            ->setTo([$formData['email']])
            ->setBcc($BaseInfo->getEmail02())
            ->setReplyTo($BaseInfo->getEmail02())
            ->setReturnPath($BaseInfo->getEmail04())
            ->setBody($body);

        $count = $this->mailer->send($message, $failures);
        log_info('仮メルマガ会員登録メール送信完了', ['email' => $formData['email'], 'count' => $count]);
        return $count;
    }

    public function sendUnsubscribeMail($formData)
    {
        $BaseInfo = $this->BaseInfo;

        $body = $this->twig->render('PostCarrier4/Resource/template/Mail/unsubscribe.twig', [
            'data' => $formData,
            'BaseInfo' => $BaseInfo,
        ]);

        $message = (new \Swift_Message())
            ->setSubject('[' . $BaseInfo->getShopName() . '] メルマガ配信停止のご確認')
            ->setFrom([$BaseInfo->getEmail02() => $BaseInfo->getShopName()])
            ->setTo([$formData['email']])
            ->setBcc($BaseInfo->getEmail02())
            ->setReplyTo($BaseInfo->getEmail02())
            ->setReturnPath($BaseInfo->getEmail04())
            ->setBody($body);

        $count = $this->mailer->send($message, $failures);
        return $count;
    }

    public function sendThankyouMail($formData)
    {
        $BaseInfo = $this->BaseInfo;

        $body = $this->twig->render('PostCarrier4/Resource/template/Mail/thankyou.twig', [
            'data' => $formData,
            'BaseInfo' => $BaseInfo,
        ]);

        $message = (new \Swift_Message())
            ->setSubject('[' . $BaseInfo->getShopName() . '] メルマガ会員登録が完了しました')
            ->setFrom([$BaseInfo->getEmail02() => $BaseInfo->getShopName()])
            ->setTo([$formData['email']])
            ->setBcc($BaseInfo->getEmail02())
            ->setReplyTo($BaseInfo->getEmail02())
            ->setReturnPath($BaseInfo->getEmail04())
            ->setBody($body);

        $count = $this->mailer->send($message, $failures);
        return $count;
    }

    public function sendStopMail($formData)
    {
        $BaseInfo = $this->BaseInfo;

        $body = $this->twig->render('PostCarrier4/Resource/template/Mail/stop.twig', [
            'data' => $formData,
            'BaseInfo' => $BaseInfo,
        ]);

        $message = (new \Swift_Message())
            ->setSubject('[' . $BaseInfo->getShopName() . '] メルマガ配信を停止しました')
            ->setFrom([$BaseInfo->getEmail02() => $BaseInfo->getShopName()])
            ->setTo([$formData['email']])
            ->setBcc($BaseInfo->getEmail02())
            ->setReplyTo($BaseInfo->getEmail02())
            ->setReturnPath($BaseInfo->getEmail04())
            ->setBody($body);

        $count = $this->mailer->send($message, $failures);
        return $count;
    }
}
