<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/30
 */

namespace Plugin\QuantityDiscount\Form\Type;


use Eccube\Form\Type\ToggleSwitchType;
use Plugin\QuantityDiscount\Entity\QdConfig;
use Plugin\QuantityDiscount\Service\ConfigService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QdConfigRowType extends AbstractType
{

    private $settingOptions = [
        // 割引方式
        ConfigService::SETTING_KEY_MODE => [
            'choices' => [
                'quantity_discount.admin.config_mode_1' => ConfigService::DISCOUNT_MODE_NORMAL,
                'quantity_discount.admin.config_mode_2' => ConfigService::DISCOUNT_MODE_DIRECT,
            ],
            'expanded' => true,
            'multiple' => false,
        ],
        // 送料無料判定方式
        ConfigService::SETTING_KEY_DELIVERY_FEE_MODE => [
            'choices' => [
                'quantity_discount.admin.config_delivery_fee_mode_1' => ConfigService::DISCOUNT_AFTER_PRICE,
                'quantity_discount.admin.config_delivery_fee_mode_2' => ConfigService::DISCOUNT_BEFORE_PRICE,
            ],
            'expanded' => true,
            'multiple' => false,
        ],
        // 割引端数処理
        ConfigService::SETTING_KEY_RATE_TYPE => [
            'choices' => [
                'quantity_discount.admin.config_rate_1' => ConfigService::DISCOUNT_RATE_TYPE_ROUND,
                'quantity_discount.admin.config_rate_2' => ConfigService::DISCOUNT_RATE_TYPE_ROUND_DOWN,
                'quantity_discount.admin.config_rate_3' => ConfigService::DISCOUNT_RATE_TYPE_ROUND_UP,
            ],
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'col-2']
        ],
        // 割引レコード課税区分
        ConfigService::SETTING_KEY_DISCOUNT_TAX => [
            'choices' => [
                'quantity_discount.admin.config_tax_1' => ConfigService::DISCOUNT_RATE_TYPE_ROUND,
                'quantity_discount.admin.config_tax_2' => ConfigService::DISCOUNT_RATE_TYPE_ROUND_DOWN,
                'quantity_discount.admin.config_tax_3' => ConfigService::DISCOUNT_RATE_TYPE_ROUND_UP,
            ],
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'col-2']
        ],
        // まとめ買い価格一覧表示位置
        ConfigService::SETTING_KEY_DETAIL_LIST_POSITION => [
            'choices' => [
                'quantity_discount.admin.config_position_1' => ConfigService::DISCOUNT_POSITION_DETAIL,
                'quantity_discount.admin.config_position_2' => ConfigService::DISCOUNT_POSITION_QUANTITY,
            ],
            'expanded' => true,
            'multiple' => false,
        ],
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $form = $event->getForm();

                /** @var QdConfig $data */
                $data = $event->getData();

                if (!empty($data)) {

                    $options = [
                        'label' => $data->getName(),
                    ];

                    if (isset($this->settingOptions[$data->getConfigKey()])) {
                        $options = array_merge($options, $this->settingOptions[$data->getConfigKey()]);
                    }

                    switch ($data->getConfigType()) {
                        case QdCOnfig::TYPE_STRING:
                            $form
                                ->add('textValue', TextType::class, $options);
                            break;
                        case QdConfig::TYPE_CHOICE:
                            $form
                                ->add('intValue', ChoiceType::class, $options);
                            break;
                        case QdConfig::TYPE_BOOL:
                            $form
                                ->add('boolValue', ToggleSwitchType::class, $options);
                            break;
                    }
                }

            });

        $builder
            ->add('configType', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('groupId', HiddenType::class, [
                'mapped' => false,
            ])
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {

                $form = $event->getForm();

                /** @var QdConfig $data */
                $data = $event->getData();

                if (!empty($data)) {
                    $form->get('configType')->setData($data->getConfigType());
                    $form->get('groupId')->setData($data->getGroupId());
                }

            });

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Plugin\QuantityDiscount\Entity\QdConfig',
        ]);
    }
}
