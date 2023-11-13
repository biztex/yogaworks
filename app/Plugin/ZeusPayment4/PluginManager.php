<?php

namespace Plugin\ZeusPayment4;

use Eccube\Plugin\AbstractPluginManager;
use Plugin\ZeusPayment4\Entity\Config;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Eccube\Entity\PaymentOption;
use Eccube\Entity\Order;
use Eccube\Repository\PluginRepository;
use Eccube\Service\PluginService;

use Eccube\Entity\Page;
use Eccube\Entity\PageLayout;

/*
 * Plugin管理
 */
class PluginManager extends AbstractPluginManager
{
    public function install(array $meta, ContainerInterface $container)
    {
        // リソースファイルのコピー
    }

    public function uninstall(array $meta, ContainerInterface $container)
    {
        // 支払方法削除のためし
        $this->removePayment($container);
        $this->removePage($container);
    }

    public function enable(array $meta, ContainerInterface $container)
    {
        $this->createConfig($container);
        $this->enablePayment($container);
    }

    public function disable(array $meta, ContainerInterface $container)
    {
        $this->disablePayment($container);
    }

    // アップデート時
    public function update(array $meta, ContainerInterface $container)
    {
        $Plugin = $container->get(PluginRepository::class)->findByCode('ZeusPayment4');
        $PluginService = $container->get(PluginService::class);
        
        if (!$Plugin) {
            throw new NotFoundHttpException();
        }
        
        $config = $PluginService->readConfig($PluginService->calcPluginDir($Plugin->getCode()));
        
        $PluginService->generateProxyAndUpdateSchema($Plugin, $config);
    }
    
    private function createConfig(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $Config = $entityManager->find(Config::class, 1);
        if ($Config) {
            return;
        }

        $Config = new Config();

        $entityManager->persist($Config);
        $entityManager->flush($Config);
    }

    private function enablePayment($container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $config = $entityManager->find(Config::class, 1);
        
        if (!$config) {
            return;
        }
        
        $payments = $config->getPayments();
        foreach ($payments as $payment) {
            if (!$payment->isVisible()) {
                $payment->setVisible(true);
                $entityManager->persist($payment);
                $entityManager->flush($payment);
            }
        }
    }

    private function disablePayment($container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $config = $entityManager->find(Config::class, 1);

        if (!$config) {
            return;
        }

        $payments = $config->getPayments();

        foreach ($payments as $payment) {
            if ($payment) {
                $payment->setVisible(false);
                $entityManager->persist($payment);
                $entityManager->flush($payment);
            }
        }
    }

    private function removePayment($container)
    {
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $config = $entityManager->find(Config::class, 1);
        
        if (!$config) {
            return;
        }
        
        $payments = $config->getPayments();
        $deliveries = null;

        //remove configuration
        $entityManager->remove($config);
        $entityManager->flush();

        $paymentOptionRepository = $entityManager->getRepository(PaymentOption::class);
        $orderRepository = $entityManager->getRepository(Order::class);

        foreach ($payments as $payment) {
            if ($payment) {
                //check if order exists
                $orders = $orderRepository->findBy([
                    'Payment' => $payment
                ]);
                if ($orders && count($orders) > 0) {
                    continue;
                }

                //remove payment
                $paymentOptions = $paymentOptionRepository->findBy([
                    'payment_id' => $payment->getId()
                ]);
                try {
                    if ($paymentOptions != null) {
                        foreach ($paymentOptions as $paymentOption) {
                            $entityManager->remove($paymentOption);
                            $entityManager->flush();
                        }
                    }

                    $entityManager->remove($payment);
                    $entityManager->flush();
                } catch (\Exception $e) {
                    $message = trans('admin.common.delete_error_foreign_key', ['%name%' => $payment->getMethod()]);
                    log_warning($message, ['exception' => $e]);
                }
            }
        }
    }

    protected function removePage($container)
    {
        $em = $container->get('doctrine.orm.entity_manager');

        $urls = ['zeus_cvs_payment','zeus_ebank_payment'];

        foreach($urls as $url){
            $Page = $em->getRepository(Page::class)->findOneBy(['url' => $url]);

            if (!$Page) {
                continue;
            }
            foreach ($Page->getPageLayouts() as $PageLayout) {
                $em->remove($PageLayout);
                $em->flush($PageLayout);
            }

            $em->remove($Page);
            $em->flush($Page);
        }

    }
}
