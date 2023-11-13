<?php

namespace Plugin\tbsMailTemplate\Form\Type\Admin;

use Eccube\Common\EccubeConfig;
use Eccube\Form\Validator\TwigLint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MailTemplateType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * MailTemplateType constructor.
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
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                ],
            ])
            // ->add('file_name', TextType::class, [
            //     'required' => true,
            //     'constraints' => [
            //         new Assert\NotBlank(),
            //         new Assert\Length([
            //             'max' => $this->eccubeConfig['eccube_stext_len'],
            //         ]),
            //         new Assert\Regex([
            //             'pattern' => '/^[0-9a-zA-Z\/_\.]+$/',
            //         ]),
            //     ],
            // ])
            ->add('file_name_cut', TextType::class, [
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_stext_len'],
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[0-9a-zA-Z\/_]+$/',
                    ]),
                ],
            ])
            ->add('mail_subject', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('tpl_data', TextareaType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new TwigLint(),
                ],
            ])
            ->add('html_tpl_data', TextareaType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new TwigLint(),
                ],
            ])
            ->add('return_link', HiddenType::class, [
                'mapped' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mail';
    }
}
