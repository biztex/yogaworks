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

namespace Plugin\PostCarrier4\Form\Extension;

use Eccube\Entity\Customer;
use Eccube\Form\Type\Front\EntryType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;

class EntryPostCarrierTypeExtension extends AbstractTypeExtension
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * EntryPostCarrierTypeExtension constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $postcarrierFlg = null;
        $token = $this->tokenStorage->getToken();
        $Customer = $token ? $token->getUser() : null;

        if ($Customer instanceof Customer && $Customer->getId()) {
            $postcarrierFlg = $Customer->getPostcarrierFlg();
        }

        $builder
            ->add('postcarrier_flg', ChoiceType::class, [
                'label' => 'admin.postcarrier.customer.label_mailmagazine',
                'label_attr' => [
                    'class' => 'ec-label',
                ],
                'choices' => [
                    'admin.postcarrier.customer.label_mailmagazine_yes' => '1',
                    'admin.postcarrier.customer.label_mailmagazine_no' => '0',
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'mapped' => true,
                'data' => $postcarrierFlg,
                'eccube_form_options' => [
                    'auto_render' => true,
                    'form_theme' => '@PostCarrier4/entry_add_postcarrier.twig',
                ],
            ])
            ;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getExtendedType()
    {
        return EntryType::class;
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        return [EntryType::class];
    }
}
