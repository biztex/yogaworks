<?php

namespace Plugin\ProductReserve4;

use Eccube\Plugin\AbstractPluginManager;
use Eccube\Entity\MailTemplate;
use Eccube\Common\Constant;

use Plugin\ProductReserve4\Entity\Config;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class PluginManager.
 */
class PluginManager extends AbstractPluginManager
{
    private $originalDir = __DIR__.'/Resource/template/default/Mail/';

    private $originalAssetDir = __DIR__ . '/Resource/asset';
    private $targetAssetDir = __DIR__ . '/../../../html/template/admin/assets/reserve4';

    private $mail_templates = [
        'order_reservation.twig',
        'order_reservation.html.twig',
        'reservation_shipping_change.twig',
        'reservation_shipping_change.html.twig',
    ];

    public function get_version_mail_dir() {
        $version_dir = '';
        switch( Constant::VERSION ) {
            case '4.0.1':
            case '4.0.0':
                $version_dir = '4.0.1/';
                break;
            case '4.0.2':
                $version_dir = '4.0.2/';
                break;
            case '4.0.3':
            default:
                $version_dir = '4.0.3/';
                break;
        }
        return $version_dir;
    }

    /**
     * Install the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function install(array $meta, ContainerInterface $container)
    {
    }

    /**
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function uninstall(array $meta, ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        $this->migration($entityManager->getConnection(), $meta['code'], 0);
        parent::uninstall($meta, $container);
    }

    /**
     * Update the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function update(array $meta, ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        $this->migration($entityManager->getConnection(), $meta['code']);
        // Replace Mail Templates
        $this->copyMailTemplates($container);
    }

    /**
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function enable(array $meta, ContainerInterface $container)
    {
        $this->copyAssets();
        $this->addMailTemple($container);
    }

    /**
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function disable(array $meta, ContainerInterface $container)
    {
        $this->removeAssets();
        $this->removeMailTemplate($container);
    }

    private function addMailTemple(ContainerInterface $container) {
        $this->copyMailTemplates($container);
        $em = $container->get('doctrine.orm.entity_manager');
        $mailTemplate1 = new MailTemplate();
        $mailTemplate1->setName("商品予約メール")
            ->setFileName('Reserve4/order_reservation.twig')
            ->setMailSubject('ご予約注文ありがとうございます');

        $em->persist($mailTemplate1);
        $em->flush($mailTemplate1);

        $em->getRepository(Config::class)->setConfig('mail_order_reservation', $mailTemplate1->getId());

        $mailTemplate2 = new MailTemplate();
        $mailTemplate2->setName("発売予定日変更通知メール")
            ->setFileName('Reserve4/reservation_shipping_change.twig')
            ->setMailSubject('予約商品の発送予定日変更のお知らせ');

        $em->persist($mailTemplate2);
        $em->flush($mailTemplate2);
        $em->getRepository(Config::class)->setConfig('mail_reservation_shipping_change', $mailTemplate2->getId());

    }

    private function removeMailTemplate(ContainerInterface $container) {
        $em = $container->get('doctrine.orm.entity_manager');

        $mail_order_reservation = $em->getRepository(Config::class)->getConfig('mail_order_reservation');
        if( $mail_order_reservation ) {
            $mail_template = $em->getRepository(MailTemplate::class)->find($mail_order_reservation);
            if( $mail_template ) {
                $em->remove($mail_template);
                $em->flush($mail_template);
            }
        }
        $mail_reservation_shipping_change = $em->getRepository(Config::class)->getConfig('mail_reservation_shipping_change');
        if( $mail_reservation_shipping_change ) {
            $mail_template = $em->getRepository(MailTemplate::class)->find($mail_reservation_shipping_change);
            if( $mail_template ) {
                $em->remove($mail_template);
                $em->flush($mail_template);
            }
        }

        $this->removeMailTemplates($container);

    }

    /**
     * Copy template files.
     *
     * @param ContainerInterface $container
     */
    private function copyMailTemplates(ContainerInterface $container)
    {
        $templateDir = $container->getParameter('eccube_theme_front_dir');
        $mail_version_dir = $this->get_version_mail_dir();
        // ファイルコピー
        $file = new Filesystem();
        foreach($this->mail_templates as $temp) {
            $file->copy($this->originalDir . $mail_version_dir . $temp, $templateDir.'/Reserve4/'.$temp, true);
        }
    }

    /**
     * Remove block template.
     *
     * @param ContainerInterface $container
     */
    private function removeMailTemplates(ContainerInterface $container)
    {
        $templateDir = $container->getParameter('eccube_theme_front_dir');
        $file = new Filesystem();
        foreach($this->mail_templates as $temp) {
            $file->remove($templateDir.'/Reserve4/'.$temp);
        }
    }

    private function copyAssets()
    {
        $file = new Filesystem();

        $file->mkdir($this->targetAssetDir);
        $file->mirror($this->originalAssetDir, $this->targetAssetDir);
    }

    /**
     * コピーしたファイルを削除
     */
    private function removeAssets()
    {
        $file = new Filesystem();
        $file->remove($this->targetAssetDir);
    }
}
