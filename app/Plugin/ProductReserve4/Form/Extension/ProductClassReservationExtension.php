<?php

namespace Plugin\ProductReserve4\Form\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;
use Eccube\Form\Type\Admin\ProductClassEditType;
use Eccube\Repository\ProductRepository;
use Plugin\ProductReserve4\Entity\ProductClassExtra;
use Plugin\ProductReserve4\Form\Subscriber\ProductClassExtraSubscriber;
use Plugin\ProductReserve4\Repository\ProductClassExtraRepository;
use Plugin\ProductReserve4\Service\ProductReserveService;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Routing\RequestContext;
use function MongoDB\Driver\Monitoring\addSubscriber;


class ProductClassReservationExtension extends AbstractTypeExtension
{
    /**
     * @var Integer
     */
    private static $request_product_id = null;
    /**
     * @var ProductRepository
     */
    protected $productRepository;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ProductClassExtraRepository
     */
    protected $productClassExtraRepository;

    /**
     * @var ProductReserveService
     */
    protected $reserveService;

    /**
     * @var ProductClassExtraSubscriber
     */
    protected $productClassExtraSubscriber;

    public function __construct(
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager,
        ProductClassExtraRepository $productClassExtraRepository,
        ProductReserveService $reserveService)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->productClassExtraRepository = $productClassExtraRepository;
        $this->reserveService = $reserveService;
        $this->productClassExtraSubscriber = new ProductClassExtraSubscriber($this);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->productClassExtraSubscriber);
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            $isAllowed = false;
            $startDate = null;
            $isNoUseStart = false;
            $endDate = null;
            $isNoUseEnd = false;
            $shippingDate = null;
            $isNoUseShipping = false;

            if($data instanceof ProductClass && $data->getId()) {
                $productClassExtra = $this->productClassExtraRepository->getByProductClassId($data->getId());
                if( $productClassExtra ) {
                    // Send Shippping Changed Mail
                    if($productClassExtra->getShippingDateChanged()){

                        $productClassExtra->setShippingDateChanged(false);
                        $this->entityManager->persist($productClassExtra);
                        $this->entityManager->flush();

                        $product_id = $productClassExtra->getProduct()->getId();
                        $product_class_id = $productClassExtra->getProductClass()->getId();
                        $shippingDate = $productClassExtra->getShippingDate();
                        $this->reserveService->procClassShippingChanged($product_id, $product_class_id, $shippingDate);
                    }
                } else {
                    // Set ProductClassID
                    if($data->getClassCategory2()){
                        $productClassExtra = $this->productClassExtraRepository->findOneBy(['Product' => $data->getProduct()->getId(), 'ClassCategory1' => $data->getClassCategory1()->getId(), 'ClassCategory2' => $data->getClassCategory2()->getId()]);
                    }
                    else{
                        $productClassExtra = $this->productClassExtraRepository->findOneBy(['Product' => $data->getProduct()->getId(), 'ClassCategory1' => $data->getClassCategory1()->getId()]);
                    }
                    if($productClassExtra){
                        $productClassExtra->setProductClass($data);
                        $productClassExtra->setProductClass($data);
                        $this->entityManager->persist($productClassExtra);
                        $this->entityManager->flush();
                    }
                }
                if($productClassExtra){
                    $isAllowed = $productClassExtra->isAllowed()? true:false;

                    $startDate = $productClassExtra->getStartDate();
                    $isNoUseStart = $startDate? false:true;
                    if($isNoUseStart) {
                        $startDate = null;
                    }

                    $endDate = $productClassExtra->getEndDate();
                    $isNoUseEnd = $endDate ? false:true;
                    if($isNoUseEnd) {
                        $endDate = null;
                    }

                    $shippingDate = $productClassExtra->getShippingDate();
                    $isNoUseShipping = $shippingDate? false:true;
                    if($isNoUseShipping) {
                        $shippingDate = null;
                    }
                }
            }

            $form->add('reservation_isAllowed', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => '予約商品',
                'data' => $isAllowed,
            ]);

            $form->add('reservation_startDateTime', DateTimeType::class, [
                'mapped' => false,
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd HH:mm',
                'data' => $startDate,
                'placeholder' => [
                    'year' => '----', 'month' => '--', 'day' => '--', "hour" => "--", "minute" => "--",
                ],
            ]);

            $form->add('reservation_isNoUseStartDateTime', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => trans('plugin_reserve4.admin.no_use'),
                'data' => $isNoUseStart,
            ]);

            $form->add('reservation_endDateTime', DateTimeType::class, [
                'mapped' => false,
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd HH:mm',
                'data' => $endDate,
                'placeholder' => [
                    'year' => '----', 'month' => '--', 'day' => '--', "hour" => "--", "minute" => "--",
                ],
            ]);

            $form->add('reservation_isNoUseEndDateTime', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => trans('plugin_reserve4.admin.no_use'),
                'data' => $isNoUseEnd,
            ]);

            $form->add('reservation_shippingDate', DateTimeType::class, [
                'mapped' => false,
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd HH:mm',
                'data' => $shippingDate,
                'placeholder' => ['year' => '----', 'month' => '--', 'day' => '--', "hour" => "--", "minute" => "--",],
            ]);

            $form->add('reservation_isNoUseShippingDateTime', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => trans('plugin_reserve4.admin.no_use'),
                'data' => $isNoUseShipping,
            ]);

//            $form->add('reservation_shippingDate', DateType::class, [
//                'mapped' => false,
//                'required' => false,
//                'input' => 'datetime',
//                'widget' => 'single_text',
//                'format' => 'yyyy-MM-dd',
//                'data' => $shippingDate,
//                'placeholder' => ['year' => '----', 'month' => '--', 'day' => '--'],
//                'attr' => [
//                    'class' => 'datetimepicker-input',
//                    'data-target' => '#admin_product_reservation_shippingDate',
//                    'data-toggle' => 'datetimepicker',
//                ],
//            ]);

        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event){
            $form = $event->getForm();
            $data = $form->getData();

            if(!$data instanceof ProductClass){
                return;
            }

            $ProductClass = $data;
            $Product = $ProductClass->getProduct();
            if(!$Product){
                if(self::$request_product_id){
                    $Product = $this->findProduct(self::$request_product_id);
                } else {
                    return;
                }
            }

            $ClassCategory1 = $ProductClass->getClassCategory1();
            $ClassCategory2 = $ProductClass->getClassCategory2();

            $isAllowed =  $form['reservation_isAllowed']->getData();
            if( !$isAllowed ) {
                $this->productClassExtraRepository->remove($Product, $ClassCategory1, $ClassCategory2);
                return;
            }
            $isNoUseStartDateTime = $form['reservation_isNoUseStartDateTime']->getData();
            $isNoUseEndDateTime = $form['reservation_isNoUseEndDateTime']->getData();
            $isNoUseShippingDateTime = $form['reservation_isNoUseShippingDateTime']->getData();

            $start_date = $form['reservation_startDateTime']->getData();
            if( !$isNoUseStartDateTime && !$start_date ) {
                $form['reservation_startDateTime']->addError(new FormError(trans('plugin_reserve4.product_class.require_start_date')));
            }

            $end_date = $form['reservation_endDateTime']->getData();
            if( !$isNoUseEndDateTime && !$end_date ) {
                $form['reservation_endDateTime']->addError(new FormError(trans('plugin_reserve4.product_class.require_end_date')));
            }

            if( !$isNoUseStartDateTime && !$isNoUseEndDateTime && $start_date && $end_date && $start_date > $end_date) {
                $form['reservation_endDateTime']->addError(new FormError(trans('plugin_reserve4.product_class.invalid_end_date')));
            }

            $shipping_date = $form['reservation_shippingDate']->getData();
            if(!$isNoUseShippingDateTime) {
                if( !$shipping_date ) {
                    $form['reservation_shippingDate']->addError(new FormError(trans('plugin_reserve4.product_class.require_shipping_date')));
                } else {
                    if( $shipping_date && $end_date && $end_date > $shipping_date ) {
                        $form['reservation_shippingDate']->addError(new FormError(trans('plugin_reserve4.product_class.invalid_shipping_date')));
                    }
                }
            }

            if($form->isValid()){
                $productClassExtra = $this->productClassExtraRepository->getByProductClassId($ProductClass->getId());

                $isPrevNormal = true;
                if(!$productClassExtra || !$productClassExtra->isAllowed()){
                    $old_shippingDate = false;
                }else{
                    $isPrevNormal = false;
                    $old_shippingDate = $productClassExtra->getShippingDate();
                    if( $old_shippingDate ) {
                        $old_shippingDate = $productClassExtra->getShippingDate()? $productClassExtra->getShippingDate()->format("Y年n月j日 H:i"):false;
                    } else {
                        $old_shippingDate = false;
                    }
                }

                $isAllowed = $form->get('reservation_isAllowed')->getData();
                $shippingDateChanged = true;
                if( $isPrevNormal || !$isAllowed ) {
                    $shippingDateChanged = false;
                }
                $shippingDate = $form->get('reservation_shippingDate')->getData();
                $isNoUseShippingDateTime = $form->get('reservation_isNoUseShippingDateTime')->getData();
                if( $isNoUseShippingDateTime ) {
                    $new_shippingDate = false;
                } else {
                    $shippingDate->setTimeZone(new \DateTimeZone(date_default_timezone_get()));
                    $new_shippingDate = $shippingDate->format("Y年n月j日 H:i");
                }

                $shippingDateChanged &= $old_shippingDate != $new_shippingDate;
                $this->productClassExtraRepository->set($ProductClass, $ClassCategory1, $ClassCategory2, $Product, $shippingDateChanged , $form);

            }
        });

    }

    /**
     * 商品を取得する.
     * 商品規格はvisible=trueのものだけを取得し, 規格分類はsort_no=DESCでソートされている.
     *
     * @param $id
     *
     * @return Product|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function findProduct($id)
    {
        $qb = $this->productRepository->createQueryBuilder('p')
            ->addSelect(['pc', 'cc1', 'cc2'])
            ->leftJoin('p.ProductClasses', 'pc')
            ->leftJoin('pc.ClassCategory1', 'cc1')
            ->leftJoin('pc.ClassCategory2', 'cc2')
            ->where('p.id = :id')
            ->andWhere('pc.visible = :pc_visible')
            ->setParameter('id', $id)
            ->setParameter('pc_visible', true)
            ->orderBy('cc1.sort_no', 'DESC')
            ->addOrderBy('cc2.sort_no', 'DESC');

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function setProductId($product_id){
        self::$request_product_id = $product_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return ProductClassEditType::class;
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        return [ProductClassEditType::class];
    }
}
