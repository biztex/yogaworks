<?php

namespace Plugin\ProductReserve4\Form\Extension;

use Eccube\Common\Constant;
use Eccube\Common\EccubeConfig;
use Doctrine\Common\Collections\ArrayCollection;
use Eccube\Entity\Order;
use Eccube\Form\Type\Shopping\ShippingType;
use Eccube\Repository\PaymentRepository;
use Eccube\Entity\Payment;
use Eccube\Entity\Delivery;
use Eccube\Entity\DeliveryTime;
use Eccube\Entity\Shipping;
use Eccube\Repository\DeliveryRepository;
use Eccube\Repository\DeliveryFeeRepository;

use Eccube\Repository\PluginRepository;
use Plugin\DeliveryDate4\Entity\Config;
use Plugin\DeliveryDate4\Entity\DeliveryDate;
use Plugin\DeliveryDate4\Entity\Holiday;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type;

use Plugin\ProductReserve4\Repository\ProductExtraRepository;
use Plugin\ProductReserve4\Repository\ProductClassExtraRepository;
use Plugin\ProductReserve4\Service\ProductReserveService;

class ReservationShippingExtension extends AbstractTypeExtension
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;
    /**
     * @var PluginRepository
     */
    protected $pluginRepository;
    protected $container;

    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    private $configRepository = null;
    private $deliveryDateRepository = null;
    private $holidayRepository = null;

    /**
     * @var ProductExtraRepository
     */
    protected $productExtraRepository;

    /**
     * @var ProductClassExtraRepository
     */
    protected $productClassExtraRepository;

    protected $productReserveService;

    public function __construct(
        ContainerInterface $container,
        EccubeConfig $eccubeConfig,
        PaymentRepository $paymentRepository,
        ProductExtraRepository $productExtraRepository,
        ProductClassExtraRepository $productClassExtraRepository,
        ProductReserveService $productReserveService,
        PluginRepository $pluginRepository
    )
    {
        $this->paymentRepository = $paymentRepository;
        $this->container = $container;
        $this->eccubeConfig = $eccubeConfig;
        $this->pluginRepository = $pluginRepository;

        $this->productExtraRepository = $productExtraRepository;
        $this->productClassExtraRepository = $productClassExtraRepository;
        $this->productReserveService = $productReserveService;
    }

    public function getDeliveryDates(Shipping $Shipping, Delivery $Delivery)
    {
        $minDate = 0;
        $deliveryDateFlag = true;
        $deliveryDates = [];

        foreach ($Shipping->getOrderItems() as $orderItem) {
            $ProductClass = $orderItem->getProductClass();
            if(is_null($ProductClass))continue;

            $Product = $ProductClass->getProduct();
            $product_id = $Product->getId();
            $reserve_product_extra = $this->productExtraRepository->get($product_id);
            if($this->productReserveService->getProductReserveStatus($reserve_product_extra) !== ProductReserveService::STATUS_RESERVE){
                $reserve_product_extra = $this->productClassExtraRepository->getByProductClassId($ProductClass->getId());
            }
            if( $reserve_product_extra ) {
                if(!$reserve_product_extra->getShippingDate()) {
                    $deliveryDateFlag = false;
                    break;
                }
                $reserve_shipping_day = $reserve_product_extra->getShippingDate()->diff(new \DateTime("now"))->d + 1;
            } else {
                $reserve_shipping_day = 0;
            }

            $days = $ProductClass->getDeliveryDateDays();
            if (!is_null($days)) {
                $days += $reserve_shipping_day;
                if ($minDate < $days) {
                    $minDate = $days;
                }
            }else{
                $deliveryDateFlag = false;
                break;
            }
        }

        if($deliveryDateFlag){
            $Method = $this->configRepository->findOneBy(['name' => 'method']);
            $AcceptTime = $this->configRepository->findOneBy(['name' => 'accept_time']);
            if($AcceptTime){
                $time = (int)$AcceptTime->getValue();
                if($minDate == 0 && $time > 0){
                    $isHoliday = false;
                    if($Method){
                        if($Method->getValue() != 1){
                            $date = new \DateTime();
                            if($this->holidayRepository->checkHoliday($date)){
                                $isHoliday = true;
                            }
                        }
                    }
                    if(!$isHoliday){
                        $now = getdate();
                        if($now['hours'] >= $time){
                            $minDate = 1;
                        }
                    }
                }
            }

            if($Method){
                if($Method->getValue() != 1){
                    $shippingDate = $minDate;
                    $i=0;
                    while($shippingDate >= 0){
                        $date = new \DateTime($i . 'day');
                        if($this->holidayRepository->checkHoliday($date)){
                            $minDate++;
                        }else{
                            $shippingDate--;
                        }
                        $i++;
                    }
                }
            }

            $DeliveryDate = $this->deliveryDateRepository->findOneBy([
                'Delivery' => $Delivery,
                'Pref' => $Shipping->getPref(),
            ]);
            if($DeliveryDate){
                $dates = $DeliveryDate->getDates();
                if(!is_null($dates)){
                    $minDate += $dates;
                }else{
                    return [];
                }
            }else{
                return [];
            }

            $deliveryDates = [];

            $period = new \DatePeriod (
                new \DateTime($minDate . ' day'),
                new \DateInterval('P1D'),
                new \DateTime($minDate + $this->eccubeConfig['eccube_deliv_date_end_max'] . ' day')
            );

            $dateFormatter = \IntlDateFormatter::create(
                'ja_JP@calendar=japanese',
                \IntlDateFormatter::FULL,
                \IntlDateFormatter::FULL,
                'Asia/Tokyo',
                \IntlDateFormatter::TRADITIONAL,
                'E'
            );

            foreach ($period as $day) {
                $deliveryDates[$day->format('Y/m/d')] = $day->format('Y/m/d').'('.$dateFormatter->format($day).')';
            }
        }

        return $deliveryDates;
    }

    public function isEnabledPlugin() {
        $pluginCodes = ['DeliveryDate4'];
        $Plugins = $this->pluginRepository->findBy([
            'enabled' => Constant::ENABLED,
            'code' => $pluginCodes,
        ]);
        if (count($Plugins) == 1) {
            return true;
        }
        return false;
    }

    public function buildFormForReserve($builder) {
        // お届け日のプルダウンを生成
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $Shipping = $event->getData();
                if (is_null($Shipping) || !$Shipping->getId()) {
                    return;
                }

                // お届け日の設定
                $minDate = 0;
                $deliveryDurationFlag = false;

                // 配送時に最大となる商品日数を取得
                foreach ($Shipping->getOrderItems() as $detail) {
                    $ProductClass = $detail->getProductClass();
                    if (is_null($ProductClass)) {
                        continue;
                    }
                    $deliveryDuration = $ProductClass->getDeliveryDuration();
                    if (is_null($deliveryDuration)) {
                        continue;
                    }
                    if ($deliveryDuration->getDuration() < 0) {
                        // 配送日数がマイナスの場合はお取り寄せなのでスキップする
                        $deliveryDurationFlag = false;
                        break;
                    }
                    $Product = $ProductClass->getProduct();
                    $product_id = $Product->getId();
                    $reserve_product_extra = $this->productExtraRepository->get($product_id);
                    if($this->productReserveService->getProductReserveStatus($reserve_product_extra) !== ProductReserveService::STATUS_RESERVE){
                        $reserve_product_extra = $this->productClassExtraRepository->getByProductClassId($ProductClass->getId());
                    }
                    if( $reserve_product_extra ) {
                        if(!$reserve_product_extra->getShippingDate()) {
                            $deliveryDurationFlag = false;
                            break;
                        }
                        $reserve_shipping_day = $reserve_product_extra->getShippingDate()->diff(new \DateTime("now"))->d + 1;

                        if ($minDate < ($deliveryDuration->getDuration() + $reserve_shipping_day) ) {
                            $minDate = ($deliveryDuration->getDuration() + $reserve_shipping_day);
                        }
                    } else {
                        if ($minDate < $deliveryDuration->getDuration()) {
                            $minDate = $deliveryDuration->getDuration();
                        }
                    }
                    // 配送日数が設定されている
                    $deliveryDurationFlag = true;
                }

                // 配達最大日数期間を設定
                $deliveryDurations = [];

                // 配送日数が設定されている
                if ($deliveryDurationFlag) {
                    $period = new \DatePeriod(
                        new \DateTime($minDate.' day'),
                        new \DateInterval('P1D'),
                        new \DateTime($minDate + $this->eccubeConfig['eccube_deliv_date_end_max'].' day')
                    );

                    // 曜日設定用
                    $dateFormatter = \IntlDateFormatter::create(
                        'ja_JP@calendar=japanese',
                        \IntlDateFormatter::FULL,
                        \IntlDateFormatter::FULL,
                        'Asia/Tokyo',
                        \IntlDateFormatter::TRADITIONAL,
                        'E'
                    );

                    foreach ($period as $day) {
                        $deliveryDurations[$day->format('Y/m/d')] = $day->format('Y/m/d').'('.$dateFormatter->format($day).')';
                    }
                }

                $form = $event->getForm();
                $form->remove('shipping_delivery_date');
                $form->add(
                    'shipping_delivery_date',
                    ChoiceType::class,
                    [
                        'choices' => array_flip($deliveryDurations),
                        'required' => false,
                        'placeholder' => 'common.select__unspecified',
                        'mapped' => false,
                        'data' => $Shipping->getShippingDeliveryDate() ? $Shipping->getShippingDeliveryDate()->format('Y/m/d') : null,
                    ]
                );
            }
        );
    }

    public function buildFromForReserveAndDelivery($builder) {

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var \Eccube\Entity\Shipping $data */
                $data = $event->getData();
                /** @var \Symfony\Component\Form\Form $form */
                $form = $event->getForm();

                $delivery = $data->getDelivery();
                if (is_null($delivery)) {
                    return;
                }

                $emptyValue = trans('deliverydate.shopping.shipping.form.nothing');
                $deliveryDates = $this->getDeliveryDates($data, $delivery);

                if($delivery->getDeliveryDateFlg() || empty($deliveryDates)) {
                    $emptyValue = trans('deliverydate.shopping.shipping.form.cannot');
                    $deliveryDates = [];
                }
                $form->remove('shipping_delivery_date');
                $form
                    ->add('shipping_delivery_date', Type\ChoiceType::class, [
                        'choices' => array_flip($deliveryDates),
                        'required' => false,
                        'placeholder' => $emptyValue,
                        'mapped' => false,
                        'data' => $data->getShippingDeliveryDate() ? $data->getShippingDeliveryDate()->format('Y/m/d') : null,
                    ]);
            });
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$this->isEnabledPlugin()) {
            $this->buildFormForReserve($builder);
            return;
        }
        $em = $this->container->get('doctrine.orm.entity_manager');
        $this->configRepository = $em->getRepository(Config::class);
        $this->deliveryDateRepository = $em->getRepository(DeliveryDate::class);
        $this->holidayRepository = $em->getRepository(Holiday::class);

        if (!$this->configRepository
            || !$this->deliveryDateRepository
            || !$this->holidayRepository
        )
        {
            $this->buildFormForReserve($builder);
            return;
        }

        try {
            $this->buildFromForReserveAndDelivery($builder);
        } catch (\Exception $exception) {
            return;
        }
    }

    public function getExtendedType()
    {
        return ShippingType::class;
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        return [ShippingType::class];
    }

}
