<?php

namespace Plugin\ApgRichEditor\Form\Type\Admin;

use Plugin\ApgRichEditor\Domain\ImageUploadType;
use Plugin\ApgRichEditor\Domain\RichEditorType;
use Plugin\ApgRichEditor\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ConfigType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_description_detail', ChoiceType::class, array(
                    'label' => '商品登録 - 商品説明',
                    'required' => true,
                    'choices' => RichEditorType::getSelectBox(),
                    'choice_label' => function ($type) {
                        return RichEditorType::getDisplayName($type);
                    },
                    'constraints' => array(
                        new Assert\NotBlank(),
                    ),
                )
            )
            ->add('product_free_area', ChoiceType::class, array(
                    'label' => '商品登録 - フリーエリア',
                    'required' => true,
                    'choices' => RichEditorType::getSelectBox(),
                    'choice_label' => function ($type) {
                        return RichEditorType::getDisplayName($type);
                    },
                    'constraints' => array(
                        new Assert\NotBlank(),
                    ),
                )
            )
            ->add('news_description', ChoiceType::class, array(
                    'label' => '新着情報管理 - 本文',
                    'required' => true,
                    'choices' => RichEditorType::getSelectBox(),
                    'choice_label' => function ($type) {
                        return RichEditorType::getDisplayName($type);
                    },
                )
            )
            ->add('image_upload_type', ChoiceType::class, array(
                    'label' => '画像アップロード',
                    'required' => true,
                    'choices' => ImageUploadType::getSelectBox(),
                    'choice_label' => function ($type) {
                        return ImageUploadType::getDisplayName($type);
                    },
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
        ]);
    }
}
