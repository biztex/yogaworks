<?php

/*
 * Plugin Name: JoolenPromotionModal4
 *
 * Copyright(c) joolen inc. All Rights Reserved.
 *
 * https://www.joolen.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\JoolenPromotionModal4\Form\Type\Admin;

use Eccube\Common\EccubeConfig;
use Eccube\Form\Type\ToggleSwitchType;
use Plugin\JoolenPromotionModal4\Entity\PromotionModal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PromotionModalType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * ConfigType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image_file', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('image', HiddenType::class, [
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'rows' => 8,
                ],
                'constraints' => [
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_ltext_len']]),
                ],
            ])
            ->add('button_name', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
            ])
            ->add('url', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Url(),
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                ],
            ])
            ->add('interval_date', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => "/^\d+$/u",
                        'message' => 'form_error.numeric_only',
                    ]),
                    new Assert\Range([
                        'min' => 1,
                    ]),
                ],
            ])
            ->add('interval_unlimited', CheckboxType::class, [
                'label' => 'joolenpromotionmodal4.admin.config.modal.interval.unlimited',
                'value' => '1',
                'required' => false,
            ])
            ->add('login_user_display', ToggleSwitchType::class)
            ->add('non_member_display', ToggleSwitchType::class)
            ->add('visible', ChoiceType::class, [
                'label' => false,
                'choices' => ['admin.content.news.display_status__show' => true, 'admin.content.news.display_status__hide' => false],
                'required' => true,
                'expanded' => false,
            ]);
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PromotionModal::class,
        ]);
    }
}
