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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PostCarrierCsvImportType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('group_name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    //new Assert\Length(['max' => $this->eccubeConfig['eccube_stext_len']]),
                ],
            ])
            ->add('import_file', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false, // グループ名の更新
                // 'constraints' => [
                //     new Assert\NotBlank(),
                //     new Assert\File([
                //         'maxSize' => $this->csvMaxSize.'M',
                //     ]),
                // ],
            ])
            ->add('group_id', HiddenType::class, [
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'post_carrier_csv_import';
    }
}
