<?php

namespace Plugin\ProductReserve4\Form\Extension;

use Doctrine\Common\Collections\ArrayCollection;
use Eccube\Entity\Delivery;
use Eccube\Entity\Order;
use Eccube\Form\Type\Shopping\OrderType;
use Eccube\Repository\PaymentRepository;
use Eccube\Entity\Payment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

use Plugin\ProductReserve4\Repository\ProductExtraRepository;
use Plugin\ProductReserve4\Repository\ConfigRepository;
use Plugin\ProductReserve4\Service\ProductReserveService;

class ReservationPaymentExtension extends AbstractTypeExtension
{
    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    /**
     * @var ProductExtraRepository
     */
    protected $productExtraRepository;

    /**
     * @var ConfigRepository
     */
    protected $configRepository;

    protected $productReserveService;

    public function __construct(
        PaymentRepository $paymentRepository,
        ProductExtraRepository $productExtraRepository,
        ConfigRepository $configRepository,
        ProductReserveService $productReserveService
    )
    {
        $this->paymentRepository = $paymentRepository;
        $this->productExtraRepository = $productExtraRepository;
        $this->configRepository = $configRepository;
        $this->productReserveService = $productReserveService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
            $form = $event->getForm();
            $Order = $event->getForm()->getData();
            $result = $this->productReserveService->canReserveOrder($Order);
            if($result != ProductReserveService::ERROR_SUCCESS_NORMAL && $result != ProductReserveService::ERROR_SUCCESS_RESERVE ) {
                $form->addError(new FormError("Can't reserve"));
            }

            if ($options['skip_add_form']) {
                //means checkout page
                if($result == ProductReserveService::ERROR_SUCCESS_RESERVE) {
//                    $this->productReserveService->removeReserveOrder($Order);
                    $this->productReserveService->setReserveOrder($Order);
                }
                return;
            }
        });

        // ShoppingController::checkoutから呼ばれる場合は, フォーム項目の定義をスキップする.
        if ($options['skip_add_form']) {
            return;
        }

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            /** @var Order $Order */
            $Order = $event->getData();
            if (null === $Order || !$Order->getId()) {
                return;
            }

            if( !$this->productReserveService->isReserveOrder($Order) ) {
                return;
            }

            $Deliveries = $this->getDeliveries($Order);
            $Payments = $this->getPaymentsByConfig($Deliveries);
            $Payments = $this->filterPayments($Payments, $Order->getPaymentTotal());

            $form = $event->getForm();
            $this->addPaymentForm($form, $Payments, $Order->getPayment());
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            /** @var Order $Order */
            $Order = $event->getForm()->getData();
            $data = $event->getData();

            if( !$this->productReserveService->isReserveOrder($Order) ) {
                return;
            }

            $Deliveries = $this->getDeliveries($Order);
            $Payments = $this->getPaymentsByConfig($Deliveries);
            if( !$Payments ) {
                return;
            }
            $Payments = $this->filterPayments($Payments, $Order->getPaymentTotal());

            $form = $event->getForm();
            $this->addPaymentForm($form, $Payments);
        });
    }

    /**
     * 出荷に紐づく配送方法を取得する.
     *
     * @param Order $Order
     *
     * @return Delivery[]
     */
    private function getDeliveries(Order $Order)
    {
        $Deliveries = [];
        foreach ($Order->getShippings() as $Shipping) {
            $Delivery = $Shipping->getDelivery();
            if ($Delivery->isVisible()) {
                $Deliveries[] = $Shipping->getDelivery();
            }
        }

        return array_unique($Deliveries);
    }

    /**
     * 配送方法に紐づく支払い方法を取得する
     * 各配送方法に共通する支払い方法のみ返す.
     *
     * @param Delivery[] $Deliveries
     *
     * @return ArrayCollection
     */
    private function getPaymentsByConfig($Deliveries)
    {
        $PaymentsByDeliveries = [];
        foreach ($Deliveries as $Delivery) {
            $PaymentOptions = $Delivery->getPaymentOptions();
            foreach ($PaymentOptions as $PaymentOption) {
                /** @var Payment $Payment */
                $Payment = $PaymentOption->getPayment();
                if ($Payment->isVisible()) {
                    $PaymentsByDeliveries[$Delivery->getId()][] = $Payment;
                }
            }
        }

        $payment_ids = $this->configRepository->getConfig('payments');
        $payment_ids = explode(',', $payment_ids);

        if (empty($PaymentsByDeliveries) || empty($payment_ids)) {
            return new ArrayCollection();
        }

        $i = 0;
        $PaymentsIntersected = [];
        foreach ($PaymentsByDeliveries as $Payments) {
            if ($i === 0) {
                $PaymentsIntersected = $Payments;
            } else {
                $PaymentsIntersected = array_intersect($PaymentsIntersected, $Payments);
            }
            $i++;
        }

        $list = [];
        foreach($PaymentsIntersected as $payment) {
            if(in_array($payment->getId(), $payment_ids)) {
                $list[] = $payment;
            }
        }

        return new ArrayCollection($list);
    }

    private function filterPayments(ArrayCollection $Payments, $total)
    {
        $PaymentArrays = $Payments->filter(function (Payment $Payment) use ($total) {
            $min = $Payment->getRuleMin();
            $max = $Payment->getRuleMax();

            if (null !== $min && $total < $min) {
                return false;
            }

            if (null !== $max && $total > $max) {
                return false;
            }

            return true;
        })->toArray();
        usort($PaymentArrays, function (Payment $a, Payment $b) {
            return $a->getSortNo() < $b->getSortNo() ? 1 : -1;
        });

        return $PaymentArrays;
    }

    private function addPaymentForm(FormInterface $form, array $choices, Payment $data = null)
    {
        $message = trans('front.shopping.payment_method_unselected');

        if (empty($choices)) {
            $message = trans('front.shopping.payment_method_not_fount');
        }

        $form->remove('Payment');

        $form->add('Payment', EntityType::class, [
            'class' => Payment::class,
            'choice_label' => 'method',
            'expanded' => true,
            'multiple' => false,
            'placeholder' => false,
            'constraints' => [
                new NotBlank(['message' => $message]),
            ],
            'choices' => $choices,
            'data' => $data,
            'invalid_message' => $message,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return OrderType::class;
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        return [OrderType::class];
    }
}
