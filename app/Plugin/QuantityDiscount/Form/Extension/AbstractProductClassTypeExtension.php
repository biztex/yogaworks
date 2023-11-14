<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/18
 */

namespace Plugin\QuantityDiscount\Form\Extension;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;
use Plugin\QuantityDiscount\Entity\QdProductClass;
use Plugin\QuantityDiscount\Form\Type\QdProductClassType;
use Psr\Container\ContainerInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

abstract class AbstractProductClassTypeExtension extends AbstractTypeExtension
{

    protected $entityManager;

    protected $Product;

    public function __construct(EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->entityManager = $entityManager;

        $id = $container->get('request_stack')->getMasterRequest()->attributes->get('id');

        if($id) {
            $Product = $this->entityManager->getRepository(Product::class)->find($id);
            $this->Product = $Product;
        }
    }

    /**
     *
     *
     * @param FormBuilderInterface $builder
     * @param bool $productClassMode
     */
    protected function addQdProductClassesBuilder(FormBuilderInterface $builder, $productClassMode = false)
    {
        $builder
            ->add('QdProductClasses', CollectionType::class, [
                'entry_type' => QdProductClassType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'entry_options' => [
                    'product_class_mode' => $productClassMode,
                ]
            ])
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {

                /** @var FormInterface $form */
                $form = $event->getForm();

                /** @var ProductClass $data */
                $data = $form->getData();

                if (is_null($data)) return;

                /** @var FormInterface $QdProductClassesForm */
                $QdProductClassesForm = $form['QdProductClasses'];

                // 初期値として１枠表示
                if (is_null($data->getQdProductClasses())
                    || $data->getQdProductClasses()->count() == 0) {

                    $defaultObj = new QdProductClass();
                    $defaultObj->setQdType(QdProductClass::QD_TYPE_PRICE);
                    $defaultObj->setProductClass($data);

                    $collection = new \Doctrine\Common\Collections\ArrayCollection();
                    $collection->add($defaultObj);

                    $QdProductClassesForm->setData($collection);
                } else {
                    $QdProductClassesForm->setData($data->getQdProductClasses());
                }
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {

                /** @var FormInterface $form */
                $form = $event->getForm();

                /** @var ProductClass $data */
                $data = $form->getData();

                $qdProductClassesForm = $form->get('QdProductClasses');

                if (!$data->isVisible()) {

                    foreach ($qdProductClassesForm as $key => $qdProductClassForm) {

                        // データ削除
                        $qdProductClass = $qdProductClassForm->getData();
                        $this->entityManager->remove($qdProductClass);

                        /** @var ArrayCollection $parentData */
                        $parentData = $qdProductClassesForm->getData();

                        if ($parentData instanceof Collection) {
                            $parentData->remove($key);
                        } else {
                            // 新規の場合
                            unset($parentData[$key]);
                        }
                    }

                    return;
                }

                // データの相互チェック
                $price02 = $form->get('price02')->getData();
                if (!$this->isValue($qdProductClassesForm, $price02)) {
                    // 入力エラー
                    return;
                }

                /** @var FormInterface $qdProductClassForm */
                foreach ($qdProductClassesForm as $key => $qdProductClassForm) {

                    $quantity = $qdProductClassForm->get('quantity')->getData();
                    $del_flg = $qdProductClassForm->get('del_flg')->getData();

                    // 削除行 or 数量=0 は削除扱いとする
                    if ($del_flg || empty($quantity)) {

                        // データ削除
                        $qdProductClass = $qdProductClassForm->getData();
                        $this->entityManager->remove($qdProductClass);

                        /** @var ArrayCollection $parentData */
                        $parentData = $qdProductClassesForm->getData();

                        if ($parentData instanceof Collection) {
                            $parentData->remove($key);
                        } else {
                            // 新規の場合
                            unset($parentData[$key]);
                        }
                    }
                }

                if(!$data->getId()) {

                    /** @var ProductClass $ExistsProductClass */
                    $ExistsProductClass = $this->entityManager->getRepository(ProductClass::class)->findOneBy([
                        'Product' => $this->Product,
                        'ClassCategory1' => $data->getClassCategory1(),
                        'ClassCategory2' => $data->getClassCategory2(),
                    ]);

                    // 過去の登録情報があればその情報を復旧する.
                    if ($ExistsProductClass) {

                        $QdProductClasses = $ExistsProductClass->getQdProductClasses();
                        // 過去情報クリア
                        foreach ($QdProductClasses as $qdProductClass) {
                            $this->entityManager->remove($qdProductClass);
                        }

                        $ExistsProductClass->copyProperties($data, [
                            'id',
                            'price01_inc_tax',
                            'price02_inc_tax',
                            'create_date',
                            'update_date',
                            'Creator',
                        ]);
                        $data = $ExistsProductClass;
                    }
                }

                $QdProductClasses = $data->getQdProductClasses();

                /** @var QdProductClass $qdProductClass */
                foreach ($QdProductClasses as $qdProductClass) {
                    // ProductClassを紐づけ
                    $qdProductClass->setProductClass($data);
                }

            });
    }

    /**
     * 入力チェック
     *
     * @param $qdProductClassesForm
     * @param $price02
     * @return bool
     */
    private function isValue($qdProductClassesForm, $price02)
    {

        $quantityCheck = [];
        $priceCheck = [];
        $rateCheck = [];

        $result = true;

        /** @var FormInterface $qdProductClassForm */
        foreach ($qdProductClassesForm as $key => $qdProductClassForm) {

            $quantityForm = $qdProductClassForm->get('quantity');
            $quantity = $quantityForm->getData();

            $qdTypeForm = $qdProductClassForm->get('qd_type');
            $qdType = $qdTypeForm->getData();

            $priceForm = $qdProductClassForm->get('price');
            $price = $priceForm->getData();

            $rateForm = $qdProductClassForm->get('rate');
            $rate = $rateForm->getData();

            $delForm = $qdProductClassForm->get('del_flg');
            $del_flg = $delForm->getData();


            // 削除 or 数量 = 0 はチェック対象から外す
            if ($del_flg || empty($quantity)) {

                if(!$del_flg) {

                    if ((QdProductClass::QD_TYPE_PRICE == $qdType && !empty($price))
                        || QdProductClass::QD_TYPE_RATE == $qdType && !empty($rate)) {

                        $quantityForm->addError(
                            new FormError(trans('quantity_discount.admin.form_error.quantity_empty'))
                        );

                        $result = false;
                    }
                } else {
                    continue;
                }
            }

            if(!empty($quantity)) {
                if (QdProductClass::QD_TYPE_PRICE == $qdType && empty($price)) {

                    $priceForm->addError(
                        new FormError(trans('quantity_discount.admin.from_error.price_empty'))
                    );

                    $result = false;

                } else if(QdProductClass::QD_TYPE_RATE == $qdType && empty($rate)) {

                    $rateForm->addError(
                        new FormError(trans('quantity_discount.admin.form_error.rate_empty'))
                    );

                    $result = false;
                }
            }

            if (isset($quantityCheck[$quantity])) {
                // 同一数量の重複
                $quantityForm->addError(
                    new FormError(trans('quantity_discount.admin.form_error.quantity'))
                );

                $result = false;

            } else {
                $quantityCheck[$quantity] = $quantity;
            }

            if (QdProductClass::QD_TYPE_PRICE == $qdType) {

                // 販売価格以下とする
                if (!empty($price02) && $price02 < $price) {
                    $priceForm->addError(
                        new FormError(trans('quantity_discount.admin.form_error.price02'))
                    );

                    $result = false;
                }

                // 価格重複チェック
                if (isset($priceCheck[$price])) {
                    $priceForm->addError(
                        new FormError(trans('quantity_discount.admin.form_error.price'))
                    );

                    $result = false;

                } else {

                    if(!empty($priceCheck)) {
                        $priceCheck[$price] = $priceCheck;
                    }
                }

            } elseif (QdProductClass::QD_TYPE_RATE) {
                // 割引率
                if (isset($rateCheck[$rate])) {
                    $rateForm->addError(
                        new FormError(trans('quantity_discount.admin.form_error.rate'))
                    );

                    $result = false;

                } else {
                    if(!empty($rateCheck)) {
                        $rateCheck[$rate] = $rate;
                    }
                }

            }

        }

        return $result;

    }

}
