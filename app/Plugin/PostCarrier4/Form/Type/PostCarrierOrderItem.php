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

/**
 * Class PostCarrierOrderItem.
 */
class PostCarrierOrderItem
{
    /**
     * @var string
     */
    public $product_name;

    /**
     * @var string|null
     */
    public $product_code;

    /**
     * @var string|null
     */
    public $class_name1;

    /**
     * @var string|null
     */
    public $class_name2;

    /**
     * @var string|null
     *
     */
    public $class_category_name1;

    /**
     * @var string|null
     */
    public $class_category_name2;

    /**
     * @var string
     */
    public $price = 0;

    /**
     * @var string
     */
    public $quantity = 0;

    /**
     * @var \Eccube\Entity\Product
     */
    public $Product;

    /**
     * @var \Eccube\Entity\ProductClass
     */
    public $ProductClass;

    /**
     * @var \Eccube\Entity\Master\OrderItemType
     */
    public $OrderItemType;

    /**
     * Set productName.
     *
     * @param string $productName
     *
     * @return OrderItem
     */
    public function setProductName($productName)
    {
        $this->product_name = $productName;

        return $this;
    }

    /**
     * Get productName.
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * Set productCode.
     *
     * @param string|null $productCode
     *
     * @return OrderItem
     */
    public function setProductCode($productCode = null)
    {
        $this->product_code = $productCode;

        return $this;
    }

    /**
     * Get productCode.
     *
     * @return string|null
     */
    public function getProductCode()
    {
        return $this->product_code;
    }

    /**
     * Set className1.
     *
     * @param string|null $className1
     *
     * @return OrderItem
     */
    public function setClassName1($className1 = null)
    {
        $this->class_name1 = $className1;

        return $this;
    }

    /**
     * Get className1.
     *
     * @return string|null
     */
    public function getClassName1()
    {
        return $this->class_name1;
    }

    /**
     * Set className2.
     *
     * @param string|null $className2
     *
     * @return OrderItem
     */
    public function setClassName2($className2 = null)
    {
        $this->class_name2 = $className2;

        return $this;
    }

    /**
     * Get className2.
     *
     * @return string|null
     */
    public function getClassName2()
    {
        return $this->class_name2;
    }

    /**
     * Set classCategoryName1.
     *
     * @param string|null $classCategoryName1
     *
     * @return OrderItem
     */
    public function setClassCategoryName1($classCategoryName1 = null)
    {
        $this->class_category_name1 = $classCategoryName1;

        return $this;
    }

    /**
     * Get classCategoryName1.
     *
     * @return string|null
     */
    public function getClassCategoryName1()
    {
        return $this->class_category_name1;
    }

    /**
     * Set classCategoryName2.
     *
     * @param string|null $classCategoryName2
     *
     * @return OrderItem
     */
    public function setClassCategoryName2($classCategoryName2 = null)
    {
        $this->class_category_name2 = $classCategoryName2;

        return $this;
    }

    /**
     * Get classCategoryName2.
     *
     * @return string|null
     */
    public function getClassCategoryName2()
    {
        return $this->class_category_name2;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return OrderItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity.
     *
     * @param string $quantity
     *
     * @return OrderItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set product.
     *
     * @param \Eccube\Entity\Product|null $product
     *
     * @return OrderItem
     */
    public function setProduct(\Eccube\Entity\Product $product = null)
    {
        $this->Product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \Eccube\Entity\Product|null
     */
    public function getProduct()
    {
        return $this->Product;
    }

    /**
     * Set productClass.
     *
     * @param \Eccube\Entity\ProductClass|null $productClass
     *
     * @return OrderItem
     */
    public function setProductClass(\Eccube\Entity\ProductClass $productClass = null)
    {
        $this->ProductClass = $productClass;

        return $this;
    }

    /**
     * Get productClass.
     *
     * @return \Eccube\Entity\ProductClass|null
     */
    public function getProductClass()
    {
        return $this->ProductClass;
    }

    /**
     * Set orderItemType
     *
     * @param \Eccube\Entity\Master\OrderItemType $orderItemType
     *
     * @return OrderItem
     */
    public function setOrderItemType(\Eccube\Entity\Master\OrderItemType $orderItemType = null)
    {
        $this->OrderItemType = $orderItemType;

        return $this;
    }

    /**
     * Get orderItemType
     *
     * @return \Eccube\Entity\Master\OrderItemType
     */
    public function getOrderItemType()
    {
        return $this->OrderItemType;
    }
}
