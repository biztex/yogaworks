<?php

namespace Plugin\OrderCsvCustomize4\Form\Type\Admin;

use Plugin\OrderCsvCustomize4\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConfigType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])
//            ->add('date_format', TextType::class, [
//                'constraints' => [
//                    new NotBlank(),
//                    new Length(['max' => 32]),
//                ],
//            ])
//            ->add('is_integer', CheckboxType::class, [
//                'label' => '整数出力',
//                'required' => false,
//            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
        ]);
    }
}
