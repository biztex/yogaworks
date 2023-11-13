<?php

namespace Plugin\ZeusPayment4\Form\Type\Admin;

use Eccube\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/*
 * ゼウス決済検索画面フォーム定義
 */
class OrderFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // 注文番号・オーダーNo
        $builder->add('multi', TextType::class, array(
            'label' => '注文番号・ゼウスオーダーNo',
            'required' => false
        ))
            ->add('order_id', TextType::class, array(
            'required' => false
        ))
        ->add('zeus_order_id', TextType::class, array(
            'required' => false
        ))
        ->add('zeus_sale_type', ChoiceType::class, array(
            'choices'  => [
                'すべて' => '-1',
                '仮売上' => '1',
                '実売上' => '0',
            ],
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'zeus_payment_order';
    }
}
