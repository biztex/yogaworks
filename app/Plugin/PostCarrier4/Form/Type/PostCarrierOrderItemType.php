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

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\Master\OrderItemType as OrderItemTypeMaster;
use Eccube\Entity\ProductClass;
use Eccube\Form\DataTransformer;
use Eccube\Form\Type\Admin\OrderItemType;
use Eccube\Form\Type\PriceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class PostCarrierOrderItemType.
 */
class PostCarrierOrderItemType extends AbstractType
{
    /**
     * PostCarrierOrderItemType constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param OrderItemRepository $orderItemRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        EccubeConfig $eccubeConfig
    ) {
        $this->entityManager = $entityManager;
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_mtext_len'],
                    ]),
                ],
            ])
            // 使用しない
            ->add('price', PriceType::class, [
                'accept_minus' => true,
            ])
            // 回数として利用する
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'max' => $this->eccubeConfig['eccube_int_len'],
                    ]),
                    new Assert\Range(['min' => 0, 'max' => 100]),
                    // new Assert\Callback(function (
                    //     $data, ExecutionContextInterface $context
                    // ) {
                    //     $trigger = $context->getRoot()->get('d__trigger')->getData();
                    //     if ($trigger == 'event') {
                    //         //dump($context->getRoot()->getData());
                    //         $order_item_type = $context->getRoot()->get('OrderItems')->getData();
                    //         dump($order_item_type);
                    //         // $min = $order_item_type == 1 ? 0 : 1; // 商品は 0 を許す
                    //         // $context
                    //         //     ->getValidator()
                    //         //     ->inContext($context)
                    //         //     ->validate($data, [
                    //         //         new Assert\NotBlank(),
                    //         //         new Assert\Length([
                    //         //             'max' => $this->eccubeConfig['eccube_int_len'],
                    //         //         ]),
                    //         //         new Assert\Range(['min' => $min, 'max' => 100]),
                    //         //     ]);
                    //     }
                    // }),
                ],
            ]);

        $builder
            ->add($builder->create('order_item_type', HiddenType::class)
                ->addModelTransformer(new DataTransformer\EntityToIdTransformer(
                    $this->entityManager,
                    OrderItemTypeMaster::class
                )))
            ->add($builder->create('ProductClass', HiddenType::class)
                ->addModelTransformer(new DataTransformer\EntityToIdTransformer(
                    $this->entityManager,
                    ProductClass::class
                )));

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $OrderItem = $event->getData();

            $OrderItemType = $OrderItem->getOrderItemType();
            switch ($OrderItemType->getId()) {
                case OrderItemTypeMaster::PRODUCT:
                    $ProductClass = $OrderItem->getProductClass();
                    $Product = $ProductClass->getProduct();
                    $OrderItem->setProduct($Product);
                    if (null === $OrderItem->getPrice()) {
                        $OrderItem->setPrice($ProductClass->getPrice02());
                    }
                    if (null === $OrderItem->getProductCode()) {
                        $OrderItem->setProductCode($ProductClass->getCode());
                    }
                    if (null === $OrderItem->getClassName1() && $ProductClass->hasClassCategory1()) {
                        $ClassCategory1 = $ProductClass->getClassCategory1();
                        $OrderItem->setClassName1($ClassCategory1->getClassName()->getName());
                        $OrderItem->setClassCategoryName1($ClassCategory1->getName());
                    }
                    if (null === $OrderItem->getClassName2() && $ProductClass->hasClassCategory2()) {
                        if ($ClassCategory2 = $ProductClass->getClassCategory2()) {
                            $OrderItem->setClassName2($ClassCategory2->getClassName()->getName());
                            $OrderItem->setClassCategoryName2($ClassCategory2->getName());
                        }
                    }
                    break;

                default:
                    break;
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostCarrierOrderItem::class,
        ]);
    }
}
