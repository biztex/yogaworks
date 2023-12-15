<?php

namespace Plugin\ProductReserve4\Form\Extension;

use Eccube\Form\Type\Admin\ProductType;
use Eccube\Repository\ProductRepository;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Plugin\ProductReserve4\Repository\ProductExtraRepository;

class ProductReservationExtension extends AbstractTypeExtension
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;
    protected $productExtraRepository;

    public function __construct(ProductRepository $productRepository, ProductExtraRepository $productExtraRepository)
    {
        $this->productRepository = $productRepository;
        $this->productExtraRepository = $productExtraRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $Product = $event->getForm()->getData();
            $isAllowed = false;
            $startDate = null;
            $isNoUseStart = false;
            $endDate = null;
            $isNoUseEnd = false;
            $shippingDate = null;
            $isNoUseShipping = false;
            if( $Product->getId() ) {
                $productExtra = $this->productExtraRepository->get($Product->getId());
                if( $productExtra ) {
                    $isAllowed = $productExtra->isAllowed()? true:false;

                    $startDate = $productExtra->getStartDate();
                    $isNoUseStart = $startDate? false:true;
                    if($isNoUseStart) {
                        $startDate = null;
                    }

                    $endDate = $productExtra->getEndDate();
                    $isNoUseEnd = $endDate ? false:true;
                    if($isNoUseEnd) {
                        $endDate = null;
                    }

                    $shippingDate = $productExtra->getShippingDate();
                    $isNoUseShipping = $shippingDate? false:true;
                    if($isNoUseShipping) {
                        $shippingDate = null;
                    }
                }
            }

            $form->add('reservation_isAllowed', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => false,
                'data' => $isAllowed,
            ]);

            $form->add('reservation_startDateTime', DateTimeType::class, [
                'mapped' => false,
                'required' => false,
                'input' => 'datetime',
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
                'input' => 'datetime',
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
                'input' => 'datetime',
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

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $isAllowed = $form->get('reservation_isAllowed')->getData();
            if( !$isAllowed ) {
                return;
            }
            $isNoUseStartDateTime = $form->get('reservation_isNoUseStartDateTime')->getData();
            $isNoUseEndDateTime = $form->get('reservation_isNoUseEndDateTime')->getData();
            $isNoUseShippingDateTime = $form->get('reservation_isNoUseShippingDateTime')->getData();

            $start_date = $form->get('reservation_startDateTime')->getData();
            if( !$isNoUseStartDateTime && !$start_date ) {
                $form->get('reservation_startDateTime')->addError(new FormError(trans('plugin_reserve4.admin.require_start_date')));
            }

            $end_date = $form->get('reservation_endDateTime')->getData();
            if( !$isNoUseEndDateTime && !$end_date ) {
                $form->get('reservation_endDateTime')->addError(new FormError(trans('plugin_reserve4.admin.require_end_date')));
            }

            if( !$isNoUseStartDateTime && !$isNoUseEndDateTime && $start_date && $end_date && $start_date > $end_date) {
                $form->get('reservation_endDateTime')->addError(new FormError(trans('plugin_reserve4.admin.invalid_end_date')));
            }

            $shipping_date = $form->get('reservation_shippingDate')->getData();
            if(!$isNoUseShippingDateTime) {
                if( !$shipping_date ) {
                    $form->get('reservation_shippingDate')->addError(new FormError(trans('plugin_reserve4.admin.require_shipping_date')));
                } else {
                    if( $shipping_date && $end_date && $end_date > $shipping_date ) {
                        $form->get('reservation_shippingDate')->addError(new FormError(trans('plugin_reserve4.admin.invalid_shipping_date')));
                    }
                }
            }
        });
    }


    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return ProductType::class;
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}
