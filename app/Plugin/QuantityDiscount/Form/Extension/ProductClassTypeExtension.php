<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/10
 */

namespace Plugin\QuantityDiscount\Form\Extension;


use Eccube\Form\Type\Admin\ProductClassType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductClassTypeExtension extends AbstractProductClassTypeExtension
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addQdProductClassesBuilder($builder, false);
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return ProductClassType::class;
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductClassType::class];
    }

}
