<?php
/**
 * Created by PhpStorm.
 * User: k_akiyoshi
 * Date: 2018/12/13
 * Time: 11:31
 */

namespace Plugin\ApgRichEditor\Form\Extension;


use Eccube\Form\Type\Admin\NewsType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class AdminNewsExtension
 * @package Plugin\ApgRichEditor\Form\Extension
 * @FormExtension
 */
class AdminNewsExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('plg_markdown_description', HiddenType::class, [
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
        return NewsType::class;
    }

    /**
     * Return the class of the type being extended.
     */
    public static function getExtendedTypes(): iterable
    {
        return [NewsType::class];
    }
}
