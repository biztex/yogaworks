<?php

namespace Plugin\ProductReserve4\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\ProductReserve4\Form\Type\Admin\ConfigType;
use Plugin\ProductReserve4\Repository\ConfigRepository;
use Plugin\ProductReserve4\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Eccube\Repository\Master\OrderStatusRepository;
use Eccube\Repository\PaymentRepository;
use Eccube\Util\CacheUtil;


class ConfigController extends AbstractController
{
    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    protected $paymentRepository;

    protected $orderStatusRepository;

    /**
     * ConfigController constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(
        ConfigRepository $configRepository,
        OrderStatusRepository $orderStatusRepository,
        PaymentRepository $paymentRepository
    )
    {
        $this->configRepository = $configRepository;
        $this->paymentRepository = $paymentRepository;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/product_reserve4/config", name="product_reserve4_admin_config")
     * @Template("@ProductReserve4/admin/config.twig")
     */
    public function index(Request $request, CacheUtil $cacheUtil)
    {

        $config_order_status = $this->configRepository->getConfig('order_status');
        $config_payments = $this->configRepository->getConfig('payments');
        $payments = [];
        if( $config_payments ) {
            $payment_ids = explode(',', $config_payments);
            $payments = $this->paymentRepository->findBy(['id'=>$payment_ids]);
        }

        $priority = $this->getPriorityConfig();
        $form = $this->createForm(ConfigType::class, [
            'order_status' => $config_order_status ? $this->orderStatusRepository->find($config_order_status) : null,
            'payments' => $payments,
            'plugin_priority'=> $priority
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->configRepository->setConfig('order_status', $form->get('order_status')->getData() ? $form->get('order_status')->getData()->getId() : 0);
            $payments =  $form->get('payments')->getData() ? $form->get('payments')->getData():[];
            $payment_ids = [];
            foreach($payments as $payment) {
                $payment_ids[] = $payment->getId();
            }
            $this->configRepository->setConfig('payments', implode(',', $payment_ids));

            $new_priority = $form->get('plugin_priority')->getData();
            if ($priority != $new_priority) {
                $this->setPrioritoyConfig($new_priority);
                $cacheUtil->clearCache();
            }

            $this->addSuccess('登録しました。', 'admin');

            return $this->redirectToRoute('product_reserve4_admin_config');
        }

        return [
            'form' => $form->createView(),
        ];
    }
    private function getPriorityConfig()
    {
        if(\is_file(Event::PRIORITY_CONFIG)) {
            $content = \file_get_contents(Event::PRIORITY_CONFIG);
            return $content == "on";
        }
        return false;
    }
    private function setPrioritoyConfig($value)
    {
        \file_put_contents(Event::PRIORITY_CONFIG, $value ? "on" : "off");
    }
}
