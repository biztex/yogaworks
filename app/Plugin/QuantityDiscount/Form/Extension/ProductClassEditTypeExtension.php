<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/16
 */

namespace Plugin\QuantityDiscount\Form\Extension;


use Eccube\Form\Type\Admin\ProductClassEditType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductClassEditTypeExtension extends AbstractProductClassTypeExtension
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addQdProductClassesBuilder($builder, true);
    }

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return ProductClassEditType::class;
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductClassEditType::class];
    }
}
