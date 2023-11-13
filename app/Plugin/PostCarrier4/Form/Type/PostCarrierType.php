<?php

/*
 * This file is part of PostCarrier for EC-CUBE
 *
 * Copyright(c) IPLOGIC CO.,LTD. All Rights Reserved.
 *
 * http://www.iplogic.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * [メルマガ配信]-[配信内容設定]用Form
 */

namespace Plugin\PostCarrier4\Form\Type;

use Eccube\Common\EccubeConfig;
use Eccube\Form\Type\Admin\SearchCustomerType;
use Eccube\Repository\Master\CustomerStatusRepository;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Plugin\PostCarrier4\Util\PostCarrierUtil;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PostCarrierType extends SearchCustomerType
{
    /**
     * @var PostCarrierService
     */
    protected $postCarrierService;

    /**
     * PostCarrierType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     * @param CustomerStatusRepository $customerStatusRepository
     * @param PostCarrierService $postCarrierService
     */
    public function __construct(
        CustomerStatusRepository $customerStatusRepository,
        EccubeConfig $eccubeConfig,
        PostCarrierService $postCarrierService
    ) {
        parent::__construct($customerStatusRepository, $eccubeConfig);
        $this->postCarrierService = $postCarrierService;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $templateList = [];
        $apiData = $this->postCarrierService->getTemplateList($isError, $total, 50);
        if (!$isError) {
            foreach ($apiData['templates'] as $t) {
                $kind = PostCarrierUtil::decodeTemplateKind($t);
                if ($kind == 1 || $kind == 3) {
                    $templateLabel = "【" . $t['type'] . "】" . $t['subject'];
                    $templateList[$templateLabel] = $t['template_id'];
                }
            }
        }

        $isValidateStep = !($options['search_form'] || $options['test_mail']);

        $checkInsertItem = function ($data, ExecutionContextInterface $context) {
            // choicesをとれないか？
            //dump($context->getRoot()->get('d__varList'));
            $items = ['name','email','point','id'];
            $errors = PostCarrierUtil::checkInsertItem($data, $items);
            foreach ($errors as $msg) {
                $context->buildViolation($msg)
                    ->addViolation();
            }
        };

        $builder
            ->add('d__template', ChoiceType::class, [
                'label' => 'postcarrier.select.label_template',
                'required' => false,
                'placeholder' => 'postcarrier.select.select_template',
                'choices' => $templateList,
            ])
            // 他のフォーム値により動的に選択肢が変化するフォーム
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($options, $isValidateStep) {
                    $form = $event->getForm();
                    $data = $event->getData();

                    $choices = [
                        '即時配信' => 'immediate',
                        'スケジュール配信' => 'schedule',
                        'ステップメール' => 'event',
                        //'定期配信' => 'periodic',
                    ];

                    // 再編集では配信種別の変更を許さない
                    if (isset($data['d__id']) && $data['d__id'] !== null) {
                        switch($data['d__trigger']) {
                        case 'schedule':
                            $choices = ['スケジュール配信' => 'schedule']; break;
                        case 'event':
                            $choices = ['ステップメール' => 'event']; break;
                        case 'periodic':
                            $choices = ['定期配信' => 'periodic']; break;
                        default:
                            assert(false); break;
                        }
                    }

                    $form->add('d__trigger', ChoiceType::class, [
                        'label' => 'postcarrier.select.label_trigger',
                        'required' => false,
                        'placeholder' => false, // 空の選択肢を表示しない
                        'choices' => $choices,
                        'constraints' => $isValidateStep ? [
                            new Assert\NotBlank(),
                        ] : [],
                    ]);

                    // SearchCustomerType dataオプションの影響で会員ステータス条件がリセットされるのを防ぐ
                    $customer_status_config = $form->get('customer_status')->getConfig();
                    $customer_status_options = $customer_status_config->getOptions();
                    unset($customer_status_options['data']);
                    $form->add('customer_status', get_class($customer_status_config->getType()->getInnerType()), $customer_status_options);

                    // FIXMIE: 誕生日前を選択して検索画面に戻るとバリデーションエラーになるため。$data['b__event'] が取得できない.
                    if (!isset($data['b__event']) || $data['b__event'] == 'birthday') {
                        $choices = [
                            '前' => 'front',
                            '後' => 'back',
                        ];
                    } else {
                        $choices = [
                            '後' => 'back',
                        ];
                    }

                    $form->add('b__eventDaySelect', ChoiceType::class, [
                        'choices' => $choices,
                        'required' => false,
                        'placeholder' => false, // 空の選択肢を表示しない
                        'constraints' => $isValidateStep ? [
                            new Assert\NotBlank(),
                        ] : [],
                    ]);
                }
            )
            ->add('d__sch_date', DateTimeType::class, [
                'label' => 'スケジュール予約日時',
                'required' => false,
                'input' => 'datetime',
                // select利用
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') + 1),
                'minutes' => range(0, 55, 5),
                'placeholder' => ['year' => '----', 'month' => '--', 'day' => '--', 'hour' => '--', 'minute'  => '--'],
                // datetimepicker利用
                // 'widget' => 'single_text',
                // 'format' => 'yyyy-MM-dd HH:mm',
                // 'html5' => false,
                // 'attr' => [
                //     'class' => 'datetimepicker-input',
                //     'data-target' => '#'.$this->getBlockPrefix().'_sch_date',
                //     'data-toggle' => 'datetimepicker',
                // ],
                'constraints' => $isValidateStep ? [
                    new Assert\Callback(function (
                        $data, ExecutionContextInterface $context
                    ) {
                        $trigger = $context->getRoot()->get('d__trigger')->getData();
                        if ($trigger == 'schedule') {
                            $context
                                ->getValidator()
                                ->inContext($context)
                                ->validate($data, [
                                    new Assert\NotBlank(),
                                    new Assert\DateTime(),
                                    new Assert\GreaterThan('now'),
                                ]);
                        }
                    }),
                ] : [],
            ])
            // ステップメール配信
            ->add('b__event', ChoiceType::class, [
                'choices' => [
                    '会員登録日' => 'memberRegistrationDate',
                    '誕生日' => 'birthday',
                    '入金日' => 'paymentDate',
                    '受注日' => 'orderDate',
                    '最終受注日' => 'latestOrderDate',
                    '発送日' => 'commitDate',
                    '最終発送日' => 'latestCommitDate',
                ],
                'constraints' => $isValidateStep ? [
                    new Assert\Callback(function (
                        $data, ExecutionContextInterface $context
                    ) {
                        $trigger = $context->getRoot()->get('d__trigger')->getData();
                        if ($trigger == 'event') {
                            $context
                                ->getValidator()
                                ->inContext($context)
                                ->validate($data, [
                                    new Assert\NotBlank(),
                                ]);
                        }
                    }),
                ] : [],
            ])
            ->add('b__eventDay', IntegerType::class, [
                'required' => false,
                'constraints' => $isValidateStep ? [
                    new Assert\Callback(function (
                        $data, ExecutionContextInterface $context
                    ) {
                        $trigger = $context->getRoot()->get('d__trigger')->getData();
                        if ($trigger == 'event') {
                            $event = $context->getRoot()->get('b__event')->getData();
                            $min = $event == 'birthday' ? 0 : 1; // 当日は誕生日のみ

                            $context
                                ->getValidator()
                                ->inContext($context)
                                ->validate($data, [
                                    new Assert\NotBlank(),
                                    new Assert\Range(['min' => $min, 'max' => 365]),
                                ]);
                        }
                    }),
                ] : [],
            ])
            ->add('d__stepmail_time', TimeType::class, [
                'label' => '配信時刻',
                'required' => false,
                'input' => 'datetime',
                'widget' => 'choice',
                'constraints' => $isValidateStep ? [
                    new Assert\Callback(function (
                        $data, ExecutionContextInterface $context
                    ) {
                        $trigger = $context->getRoot()->get('d__trigger')->getData();
                        if ($trigger == 'event') {
                            $context
                                ->getValidator()
                                ->inContext($context)
                                ->validate($data, [
                                    new Assert\NotBlank(),
                                ]);
                        }
                    }),
                ] : [],
            ])
            ->add('OrderItems', CollectionType::class, [
                'entry_type' => PostCarrierOrderItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ])
            ->add('OrderStopItems', CollectionType::class, [
                'entry_type' => PostCarrierOrderItemType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ])
            // メール内容
            ->add('d__mail_method', ChoiceType::class, [
                'label' => 'メール形式',
                // 非表示ページでは、'required' = false にすることで、下記エラーを回避する。
                // An invalid form control with name='post_carrier[mail_method]' is not focusable.
                'required' => !$options['search_form'],
                'expanded' => true,
                'choices' => ['HTML' => 1, 'テキスト'=> 2],
            ])
            ->add('d__fromAddr', EmailType::class, [
                'label' => '送信者アドレス',
                'required' => false,
                'constraints' => $options['search_form'] ? [] : [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Regex([
                        'pattern' => '/^[[:graph:][:space:]]+$/i',
                        'message' => 'form.type.graph.invalid',
                    ]),
                    new Assert\Length(['max' => 128]),
                ],
            ])
            ->add('d__fromDisp', TextType::class, [
                'label' => '送信者表示名',
                'required' => false,
                'constraints' => [
                    new Assert\Length(['max' => 50]),
                ],
            ])
            ->add('d__subject', TextType::class, [
                'label' => 'postcarrier.select.label_subject',
                'required' => false,
                'constraints' => $options['search_form'] ? [] : [
                    new Assert\NotBlank(),
                    new Assert\Callback($checkInsertItem),
                ],
            ])
            ->add('d__body', TextareaType::class, [
                'label' => 'postcarrier.select.label_body',
                'required' => false,
                'constraints' => $options['search_form'] ? [] : [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 100000]),
                    new Assert\Callback($checkInsertItem),
                ],
            ])
            ->add('d__htmlBody', TextareaType::class, [
                'label' => 'postcarrier.select.label_body_html',
                'required' => false,
                'constraints' => $options['search_form'] ? [] : [
                    new Assert\Callback(function (
                        $data, ExecutionContextInterface $context
                    ) use ($checkInsertItem) {
                        $mail_method = $context->getRoot()->get('d__mail_method')->getData();
                        if ($mail_method == 1) {
                            $context
                                ->getValidator()
                                ->inContext($context)
                                ->validate($data, [
                                    new Assert\NotBlank(),
                                    new Assert\Length(['max' => 100000]),
                                ]);

                            $checkInsertItem($data, $context);
                        }
                    }),
                ]
            ])
            ->add('discriminator_type', HiddenType::class, [
                'data' => 'customer'
            ])
            ->add('d__id', HiddenType::class) // 配信ID 配信内容編集
            ->add('d__count', HiddenType::class) // 配信予定件数
            ->add('d__varList',  ChoiceType::class, [
                'label' => '差し込み項目',
                'required' => false,
                'placeholder' => '-- 差し込み項目 --',
                'choices' => ['名前' => '{name}', 'メールアドレス' => '{email}', 'ポイント' => '{point}', '会員ID' => '{id}'],
                'data' => null,
            ])
            ->add('d__varList2',  ChoiceType::class, [
                'label' => '差し込み項目',
                'required' => false,
                'placeholder' => '-- 差し込み項目 --',
                'choices' => ['名前' => '{name}', 'メールアドレス' => '{email}', 'ポイント' => '{point}', '会員ID' => '{id}'],
                'data' => null,
            ])
            ->add('d__testEmail', EmailType::class, [
                'label' => 'テスト配信アドレス',
                'required' => false,
                'constraints' => $options['test_mail'] ? [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ] : [],
            ])
            ->add('ignore_permissions', CheckboxType::class, [
                'label' => 'postcarrier.mail_customer.label_ignore_permissions',
                'required' => false,
            ])
            ->add('d__kind', HiddenType::class)
            ;

        // 都道府県を複数選択可能にする
        // $builder
        //     ->add('pref', \Eccube\Form\Type\Master\PrefType::class, [
        //         'label' => 'admin.common.pref',
        //         'required' => false,
        //         'multiple' => true,
        //     ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'search_form' => false,
            'test_mail' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'post_carrier';
    }
}
