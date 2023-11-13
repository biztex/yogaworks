<?php

namespace Plugin\tbsMailTemplate;

use Doctrine\ORM\EntityRepository;
use Eccube\Common\EccubeConfig;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Eccube\Form\Type\Master\MailTemplateType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class tbsMailTemplateEvent implements EventSubscriberInterface
{
    protected $eccubeConfig;

    /**
     * tbsMailTemplateEvent constructor.
     */
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            EccubeEvents::ADMIN_ORDER_MAIL_INDEX_INITIALIZE => 'adminOrderMailIndexInitialize',
            '@admin/Order/edit.twig' => 'onRenderAdminOrderEdit',
        ];
    }

    /**
     * メールテンプレートの選択肢を追加する.
     *
     * @param TemplateEvent $event
     */
    public function adminOrderMailIndexInitialize(EventArgs $eventArgs)
    {
        $builder = $eventArgs->getArgument('builder');
        $builder->add('template', MailTemplateType::class, [
            'required' => false,
            'mapped' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('mt')
                    ->andWhere('mt.id = :id or mt.id > :id_over')
                    ->setParameter('id', $this->eccubeConfig['eccube_order_mail_template_id'])
                    ->setParameter('id_over', $this->eccubeConfig['eccube_shipping_notify_mail_template_id'])
                    ->orderBy('mt.id', 'ASC');
            },
        ]);
    }

    /**
     * 管理画面受注登録にHTMLメール作成ボタンを表示する.
     *
     * @param TemplateEvent $event
     */
    public function onRenderAdminOrderEdit(TemplateEvent $event)
    {
        $event->addSnippet('@tbsMailTemplate/admin/Order/edit.twig');
    }
}
