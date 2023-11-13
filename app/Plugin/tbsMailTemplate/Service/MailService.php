<?php

namespace Plugin\tbsMailTemplate\Service;

use Eccube\Common\EccubeConfig;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\Customer;
use Eccube\Entity\MailHistory;
use Eccube\Entity\MailTemplate;
use Eccube\Entity\Order;
use Eccube\Entity\OrderItem;
use Eccube\Entity\Shipping;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\MailHistoryRepository;
use Eccube\Repository\MailTemplateRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MailService
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var MailTemplateRepository
     */
    protected $mailTemplateRepository;

    /**
     * @var MailHistoryRepository
     */
    private $mailHistoryRepository;

    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var BaseInfo
     */
    protected $BaseInfo;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * MailService constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param MailTemplateRepository $mailTemplateRepository
     * @param MailHistoryRepository $mailHistoryRepository
     * @param BaseInfoRepository $baseInfoRepository
     * @param EventDispatcherInterface $eventDispatcher
     * @param \Twig_Environment $twig
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(
        \Swift_Mailer $mailer,
        MailTemplateRepository $mailTemplateRepository,
        MailHistoryRepository $mailHistoryRepository,
        BaseInfoRepository $baseInfoRepository,
        EventDispatcherInterface $eventDispatcher,
        \Twig_Environment $twig,
        EccubeConfig $eccubeConfig
    ) {
        $this->mailer = $mailer;
        $this->mailTemplateRepository = $mailTemplateRepository;
        $this->mailHistoryRepository = $mailHistoryRepository;
        $this->BaseInfo = $baseInfoRepository->get();
        $this->eventDispatcher = $eventDispatcher;
        $this->eccubeConfig = $eccubeConfig;
        $this->twig = $twig;
    }

    /**
     * Send admin order mail.
     *
     * @param Order $Order 受注情報
     * @param $formData 入力内容
     *
     * @return \Swift_Message
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendAdminOrderMail(Order $Order, $formData)
    {
        log_info('受注管理通知メール送信開始[HTML]');

        $message = (new \Swift_Message())
            ->setSubject('['.$this->BaseInfo->getShopName().'] '.$formData['mail_subject'])
            ->setFrom([$this->BaseInfo->getEmail01() => $this->BaseInfo->getShopName()])
            ->setTo([$Order->getEmail()])
            ->setBcc($this->BaseInfo->getEmail01())
            ->setReplyTo($this->BaseInfo->getEmail03())
            ->setReturnPath($this->BaseInfo->getEmail04())
            ->setBody($formData['tpl_data'], 'text/html');

        $event = new EventArgs(
            [
                'message' => $message,
                'Order' => $Order,
                'formData' => $formData,
                'BaseInfo' => $this->BaseInfo,
            ],
            null
        );
        $this->eventDispatcher->dispatch(EccubeEvents::MAIL_ADMIN_ORDER, $event);

        $count = $this->mailer->send($message);

        log_info('受注管理通知メール送信完了[HTML]', ['count' => $count]);

        return $message;
    }
}
