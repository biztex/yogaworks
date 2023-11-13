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

use Eccube\Common\Constant;
use Eccube\Entity\Customer;
use Eccube\Form\Type\Admin\CustomerType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerPostCarrierTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $postcarrierFlg = null;

        /** @var Customer $Customer */
        $Customer = $builder->getData();
        if ($Customer instanceof Customer && $Customer->getId()) {
            $postcarrierFlg = $Customer->getPostcarrierFlg();
        }

        $options = [
            'label' => 'admin.postcarrier.customer.label_mailmagazine',
            'choices' => [
                'admin.postcarrier.customer.label_mailmagazine_yes' => Constant::ENABLED,
                'admin.postcarrier.customer.label_mailmagazine_no' => Constant::DISABLED,
            ],
            'expanded' => true,
            'multiple' => false,
            'required' => true,
            'constraints' => [
                new Assert\NotBlank(),
            ],
            'mapped' => true,
            'eccube_form_options' => [
                'auto_render' => true,
                'form_theme' => '@PostCarrier4/admin/postcarrier.twig',
            ],
        ];

        if (!is_null($postcarrierFlg)) {
            $options['data'] = $postcarrierFlg;
        }

        $builder->add('postcarrier_flg', ChoiceType::class, $options);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getExtendedType()
    {
        return CustomerType::class;
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        return [CustomerType::class];
    }
}
