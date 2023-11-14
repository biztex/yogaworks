<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/30
 */

namespace Plugin\QuantityDiscount\Form\Type;


use Plugin\QuantityDiscount\Repository\QdConfigRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class QdConfigType extends AbstractType
{

    protected $configRepository;

    public function __construct(QdConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $QdConfigs = $options['data'];

        $builder
            ->add('qdConfigs', CollectionType::class, [
                'entry_type' => QdConfigRowType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'data' => $QdConfigs
            ]);
    }

}
