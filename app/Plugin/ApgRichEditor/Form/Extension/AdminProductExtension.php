<?php
/**
 * Created by PhpStorm.
 * User: k_akiyoshi
 * Date: 2018/12/13
 * Time: 11:31
 */

namespace Plugin\ApgRichEditor\Form\Extension;


use Eccube\Form\Type\Admin\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class AdminProductExtension
 * @package Plugin\ApgRichEditor\Form\Extension
 * @FormExtension
 */
class AdminProductExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('plg_markdown_description_detail', HiddenType::class, [
                'required' => false,
                'eccube_form_options' => [
                    'auto_render' => true,
                ]
            ]);
        $builder
            ->add('plg_markdown_free_area', HiddenType::class, [
                'required' => false,
                'eccube_form_options' => [
                    'auto_render' => true,
                ]
            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return ProductType::class;
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}
