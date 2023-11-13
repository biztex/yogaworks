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

namespace Plugin\PostCarrier4\Form\Type;

use Eccube\Common\EccubeConfig;
use Plugin\PostCarrier4\Entity\PostCarrierConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class PostCarrierConfigType.
 */
class PostCarrierConfigType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * PostCarrierConfigType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('disable_check', ChoiceType::class, [
                'label' => '動作モード',
                'required' => true,
                'expanded' => true,
                'choices' => [
                    '本番モード' => false,
                    'テストモード' => true,
                ],
            ])
            ->add('server_url', TextType::class, [
                'label' => '接続先サーバーURL',
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Url(),
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                ],
            ])
            ->add('shop_id', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('shop_pass', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('click_ssl_url', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Url(),
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                    // FIXME: /postcarrierの変更を許さない
                    new Assert\Regex([
                        'pattern' => '/\/postcarrier$/',
                        'message' => 'URLは"/postcarrier"で終る必要があります。',
                    ]),
                ],
            ])
            ->add('request_data_url', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Url(),
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                    // /postcarrierの変更を許さない
                    new Assert\Regex([
                        'pattern' => '/\/postcarrier$/',
                        'message' => 'URLは"/postcarrier"で終る必要があります。',
                    ]),
                ],
            ])
            ->add('module_data_url', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Url(),
                    new Assert\Length(['max' => $this->eccubeConfig['eccube_mtext_len']]),
                ],
            ])
            ->add('errors_to', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
            ->add('basic_auth_user', TextType::class, [
                'required' => false,
                'constraints' => new Assert\Callback(function (
                    $data, ExecutionContextInterface $context
                ) {
                    $other = $context->getRoot()->get('basic_auth_pass')->getData();
                    if ($other != null) {
                        $context
                            ->getValidator()
                            ->inContext($context)
                            ->validate($data, [
                                new Assert\NotBlank(),
                            ]);
                    }
                }),

            ])
            ->add('basic_auth_pass', TextType::class, [
                'required' => false,
                'constraints' => new Assert\Callback(function (
                    $data, ExecutionContextInterface $context
                ) {
                    $other = $context->getRoot()->get('basic_auth_user')->getData();
                    if ($other != null) {
                        $context
                            ->getValidator()
                            ->inContext($context)
                            ->validate($data, [
                                new Assert\NotBlank(),
                            ]);
                    }
                }),
            ])
            ;
    }

    /**
     * Config.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostCarrierConfig::class,
        ]);
    }
}
