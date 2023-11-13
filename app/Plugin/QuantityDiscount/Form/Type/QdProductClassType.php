<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/10
 */

namespace Plugin\QuantityDiscount\Form\Type;


use Eccube\Form\Type\PriceType;
use Plugin\QuantityDiscount\Entity\QdProductClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class QdProductClassType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $productClassMode = $options['product_class_mode'];

        $builder
            ->add('quantity', IntegerType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^\d+$/u",
                        'message' => 'form_error.numeric_only',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'quantity_discount.admin.quantity_label'
                ]
            ]);

        if ($productClassMode) {

            // 規格設定時
            $builder
                ->add('qd_type', HiddenType::class, [
                    'required' => true,
                ]);

        } else {

            $builder
                ->add('qd_type', ChoiceType::class, [
                    'choices' => [
                        'quantity_discount.qd_type_price' => QdProductClass::QD_TYPE_PRICE,
                        'quantity_discount.qd_type_rate' => QdProductClass::QD_TYPE_RATE,
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true,
                    'choice_attr' => function ($choiceValue, $key, $value) {
                        return [
                            'class' => 'qd_type_radio',
                        ];
                    },
                ])
                ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {

                    /** @var QdProductClass $data */
                    $data = $event->getData();

                    if (is_null($data)) {
                        $form = $event->getForm();
                        $form->get('qd_type')->setData(QdProductClass::QD_TYPE_PRICE);
                    }
                });
        }

        $builder
            ->add('price', PriceType::class, [
                'required' => false,
            ])
            ->add('rate', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^\d+$/u",
                        'message' => 'form_error.numeric_only',
                    ]),
                    new Assert\Range([
                        'min' => 1,
                        'max' => 99,
                    ])
                ],
                'attr' => [
                    'placeholder' => 'quantity_discount.qd_type_rate'
                ]
            ])
            ->add('del_flg', HiddenType::class, [
                'mapped' => false,
                'data' => 0
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Plugin\QuantityDiscount\Entity\QdProductClass',
            'product_class_mode' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'admin_qd_product_class';
    }
}
