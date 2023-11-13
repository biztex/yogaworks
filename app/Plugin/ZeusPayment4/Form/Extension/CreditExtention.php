<?php

namespace Plugin\ZeusPayment4\Form\Extension;

use Eccube\Entity\Order;
use Eccube\Form\Type\Shopping\OrderType;
use Eccube\Repository\PaymentRepository;
use Plugin\ZeusPayment4\Service\Method\CreditPayment;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Eccube\Common\EccubeConfig;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Plugin\ZeusPayment4\Repository\ConfigRepository;
use \Plugin\ZeusPayment4\Entity\Config;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/*
 * クレジット入力フォームエクステンション
 */
class CreditExtention extends AbstractTypeExtension
{
    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;
    protected $eccubeConfig;
    protected $session;
    protected $requestStack;
    private $configRepository;

    public function __construct(
        PaymentRepository $paymentRepository,
        EccubeConfig $eccubeConfig,
        ConfigRepository $configRepository,
        SessionInterface $session,
        RequestStack $requestStack
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->eccubeConfig = $eccubeConfig;
        $this->configRepository = $configRepository;
        $this->session = $session;
        $this->requestStack = $requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            /** @var Order $data */
            $data = $event->getData();
            $form = $event->getForm();

            $groups = $this->getGroups($data, $form);

            $Config = $this->configRepository->get();
            if (!$Config || !$Config->getCreditPayment()) {
                return;
            }
            $creditPaymentId = $Config->getCreditPayment()->getId();

            $request = $this->requestStack->getCurrentRequest();

            $isBuildCredit = false;
            if ($request->isMethod('POST')) {
                $dataBag = $request->request->get('_shopping_order');
                if (isset($dataBag['Payment'])) {
                    if ($dataBag['Payment']==$creditPaymentId) {
                        $isBuildCredit = true;
                    }
                } else {
                    $payment = $data->getPayment();
                    if ($payment && $payment->getMethodClass() === CreditPayment::class) {
                        $isBuildCredit = true;
                    }
                }
            } else {
                $payment = $data->getPayment();
                if ($payment && $payment->getMethodClass() === CreditPayment::class) {
                    $isBuildCredit = true;
                }
            }

            if ($isBuildCredit) {
                $fieldOptions = [
                    'label' => '支払回数',
                    'attr' => array(
                        'class' => 'zeus_payment_form'
                    ),
                    'choices' => $this->getMethods(),
                    'expanded' => false,
                    'multiple' => false,
                    'mapped' => true,
                ];
                $constrains = [];
                if (in_array('card', $groups)) {
                    $constrains[] = new Assert\NotBlank();
                }
                $fieldOptions['constraints'] = $constrains;
                if (!$this->needValid()) {
                    if ($this->session->has('zeus_card.method')) {
                        $fieldOptions['data'] = $this->session->get('zeus_card.method');
                    }
                }
                $form->add('ZeusCreditPaymentMethod', ChoiceType::class, $fieldOptions);

                $fieldOptions = [
                    'required' => false,
                    'mapped' => true,
                ];
                $form->add('ZeusCreditPaymentToken', HiddenType::class, $fieldOptions);

                $fieldOptions = [
                    'label' => '前回利用したカード情報を利用する。',
                    'attr' => array(
                        'class' => 'zeus_payment_form'
                    ),
                    'required' => false,
                    'mapped' => true,
                ];
                if (!$this->needValid()) {
                    if ($this->session->has('zeus_card.quick')) {
                        $fieldOptions['data'] = ($this->session->get('zeus_card.quick')?true:false);
                    }
                }
                $form->add('ZeusCreditPaymentQuick', CheckboxType::class, $fieldOptions);

                $fieldOptions = [
                    'label' => '名（英字）',
                    'mapped' => true,
                    'attr' => array(
                        'class' => 'zeus_payment_form',
                        'maxlength' => '50'
                    ),
                ];
                $constrains = [];
                if (in_array('card', $groups)) {
                    $constrains[] = new Assert\NotBlank();
                    $constrains[] = new Assert\Regex(array(
                        'pattern' => '/^[[:alnum:]. -]+$/i',
                        'message' => '半角英数字記号(利用可能記号：.[ドット] –[マイナス] 半角スペース)で入力してください。'
                    ));
                    $constrains[] = new Assert\Callback([
                        'callback'=>function ($object, ExecutionContextInterface $context, $payload) {
                            $order = $context->getObject()->getParent()->getData();
                            $name = $object.$order->getZeusCreditPaymentCardName2();
                            if (strlen($name)>50) {
                                $context->buildViolation('氏名は５０文字以内で入力してください。')
                                    ->addViolation();
                            }
                        }
                    ]);
                }
                $fieldOptions['constraints'] = $constrains;
                if (!$this->needValid()) {
                    if ($this->session->has('zeus_card.name1')) {
                        $fieldOptions['data'] = $this->session->get('zeus_card.name1');
                    }
                }
                $form->add('ZeusCreditPaymentCardName1', TextType::class, $fieldOptions);

                $fieldOptions = [
                    'label' => '姓（英字）',
                    'mapped' => true,
                    'attr' => array(
                        'class' => 'zeus_payment_form',
                        'maxlength' => '50'
                    )
                ];
                $constrains = [];
                if (in_array('card', $groups)) {
                    $constrains[] = new Assert\NotBlank();
                    $constrains[] = new Assert\Regex(array(
                        'pattern' => '/^[[:alnum:]. -]+$/i',
                        'message' => '半角英数字記号(利用可能記号：.[ドット] –[マイナス] 半角スペース)で入力してください。'
                    ));
                }
                $fieldOptions['constraints'] = $constrains;
                if (!$this->needValid()) {
                    if ($this->session->has('zeus_card.name2')) {
                        $fieldOptions['data'] = $this->session->get('zeus_card.name2');
                    }
                }
                $form->add('ZeusCreditPaymentCardName2', TextType::class, $fieldOptions);

                $fieldOptions = [
                    'label' => 'カード番号',
                    'attr' => array(
                        'class' => 'zeus_payment_form',
                        'maxlength' => '16'
                    ),
                    'mapped' => true,
                    'constraints' => array(
                        new Assert\NotBlank(['groups'=>['card']]),
                        new Assert\Regex(array(
                            'pattern' => '/\A[\d|\*]+\z/',
                            'message' => '半角数字で入力してください。',
                            'groups'=>['card']
                        ))
                    )
                ];
                $constrains = [];
                if (in_array('card', $groups)) {
                    $constrains[] = new Assert\NotBlank();
                    $constrains[] = new Assert\Regex(array(
                        'pattern' => '/\A[\d|\*]+\z/',
                        'message' => '半角数字で入力してください。'
                    ));
                }
                $fieldOptions['constraints'] = $constrains;
                $form->add('ZeusCreditPaymentCardNo', TextType::class, $fieldOptions);

                $fieldOptions = [
                    'mapped' => true,
                    'label' => '有効期限(月)',
                    'attr' => array(
                        'class' => 'zeus_payment_form'
                    ),
                    'placeholder' => '--',
                    'choices' => $this->getZeroMonth()
                ];
                $constrains = [];
                if (in_array('card', $groups)) {
                    $constrains[] = new Assert\NotBlank();
                    $constrains[] = new Assert\Regex(array(
                        'pattern' => '/\A\d+\z/',
                        'message' => '半角数字で入力してください。'
                    ));
                }
                $fieldOptions['constraints'] = $constrains;
                if (!$this->needValid()) {
                    if ($this->session->has('zeus_card.month')) {
                        $fieldOptions['data'] = $this->session->get('zeus_card.month');
                    }
                }
                $form->add('ZeusCreditPaymentMonth', ChoiceType::class, $fieldOptions);

                $fieldOptions = [
                    'label' => '有効期限(年)',
                    'attr' => array(
                        'class' => 'zeus_payment_form'
                    ),
                    //'required' => true,
                    'mapped' => true,
                    'placeholder' => '----',
                    'choices' => $this->getZeroYear(date('Y'), date('Y') + 10)
                ];
                if (in_array('card', $groups)) {
                    $constrains[] = new Assert\NotBlank();
                    $constrains[] = new Assert\Regex(array(
                        'pattern' => '/\A\d+\z/',
                        'message' => '半角数字で入力してください。'
                    ));
                }
                $fieldOptions['constraints'] = $constrains;
                if (!$this->needValid()) {
                    if ($this->session->has('zeus_card.year')) {
                        $fieldOptions['data'] = $this->session->get('zeus_card.year');
                    }
                }
                $form->add('ZeusCreditPaymentYear', ChoiceType::class, $fieldOptions);

                $fieldOptions = [
                    'mapped' => true,
                    'label' => 'クレジットカード・セキュリティコード',
                    'attr' => array(
                        'class' => 'zeus_payment_form',
                        'maxlength' => '4'
                    )
                ];
                $constrains = [];
                if (in_array('cvv_blank', $groups)) {
                    $constrains[] = new Assert\NotBlank();
                }
                if (in_array('cvv', $groups)) {
                    $constrains[] = new Assert\Regex(array(
                        'pattern' => '/\A[\d|\*]+\z/',
                        'message' => '半角数字で入力してください。'
                    ));
                }
                $fieldOptions['constraints'] = $constrains;
                $form->add('ZeusCreditPaymentCvv', TextType::class, $fieldOptions);
            }
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();

            $request = $this->requestStack->getCurrentRequest();
            if ($request->isMethod('POST') && isset($data['ZeusCreditPaymentMethod'])) {
                $this->session->set('zeus_card.method', $data['ZeusCreditPaymentMethod']);
                $this->session->set(
                    'zeus_card.quick',
                    (isset($data['ZeusCreditPaymentQuick'])?$data['ZeusCreditPaymentQuick']:false)
                );
                $this->session->set('zeus_card.name1', $data['ZeusCreditPaymentCardName1']);
                $this->session->set('zeus_card.name2', $data['ZeusCreditPaymentCardName2']);
                $this->session->set('zeus_card.month', $data['ZeusCreditPaymentMonth']);
                $this->session->set('zeus_card.year', $data['ZeusCreditPaymentYear']);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ZeusPayment_credit';
    }

    public function getZeroMonth()
    {
        $month_array = array();
        for ($i = 1; $i <= 12; $i ++) {
            $val = sprintf('%02d', $i);
            $month_array[$val] = $val;
        }

        return $month_array;
    }

    public function getZeroYear($star_year, $end_year, $year = '')
    {
        if ($year) {
            $this->setStartYear($year);
        }

        $year = $star_year;
        if (! $year) {
            $year = DATE('Y');
        }

        $end_year = $end_year;
        if (! $end_year) {
            $end_year = (DATE('Y') + 3);
        }

        $year_array = array();
        for ($i = $year; $i <= $end_year; $i ++) {
            $year_array[$i] = $i;
        }

        return $year_array;
    }

    public function getMethods()
    {
        $paras = $this->eccubeConfig['zeus_credit_options'];

        return array_flip($paras['payment_choices']);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return OrderType::class;
    }

    public function getGroups($data, $form)
    {
        $needValid = $this->needValid();
        $config = $this->configRepository->get();

        $thisGroup = [];
        if (!$data['Payment'] || !$config || !$config->getCreditPayment()) {
            $thisGroup = ['Default'];
        } elseif ($data['Payment'] && $data['Payment']->getId()!=$config->getCreditPayment()->getId()) {
            $thisGroup = ['Default'];
        } elseif (!$needValid) {
            $thisGroup =  [];
        } else {
            //if ($data['ZeusCreditPaymentQuick']) {
            if (isset($_POST['_shopping_order']['ZeusCreditPaymentQuick']) && $_POST['_shopping_order']['ZeusCreditPaymentQuick']) {
                if ($config->getCvvflg() == Config::$cvv_on) {
                    $thisGroup =  array(
                        'Default',
                        'cvv',
                        'cvv_blank'
                    );
                } elseif (($config->getCvvflg() == Config::$cvv_first_on_quick_opt) ||
                    ($config->getCvvflg() == Config::$cvv_first_opt_quick_opt)) {
                    $thisGroup =  array(
                        'Default',
                        'cvv',
                        'cvv_blank' //check anyway
                    );
                } else {
                    $thisGroup =  array(
                        'Default'
                    );
                }
            } else {
                if ($config->getCvvflg() == Config::$cvv_first_opt_quick_opt) {
                    return array(
                        'Default',
                        'card',
                        'cvv',
                        'cvv_blank' //check anyway
                    );
                } elseif ($config->getCvvflg() > 0) {
                    return array(
                        'Default',
                        'card',
                        'cvv',
                        'cvv_blank'
                    );
                } else {
                    $thisGroup =  array(
                        'Default',
                        'card'
                    );
                }
            }
        }

        return $thisGroup;
    }

    public function needValid()
    {
        $request = $this->requestStack->getCurrentRequest();
        $ret = ('shopping_redirect_to'!=$request->attributes->get('_route') && $request->isMethod('POST'));
        return $ret;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true
        ));
    }
    
    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        // return FormType::class to modify (nearly) every field in the system
        return [OrderType::class];
    }
}
