<?php

namespace Plugin\ProductReserve4\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Entity\ClassCategory;
use Eccube\Entity\Product;
use Eccube\Entity\ProductClass;

/**
 * Config
 *
 * @ORM\Table(name="plg_product_class_reserve4_extra")
 * @ORM\Entity(repositoryClass="Plugin\ProductReserve4\Repository\ProductClassExtraRepository")
 */
class ProductClassExtra
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Eccube\Entity\ProductClass
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\ProductClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_class_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $ProductClass;
    /**
     * @var \Eccube\Entity\ClassCategory
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\ClassCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="class_category_id1", referencedColumnName="id", nullable=true)
     * })
     */
    private $ClassCategory1;

    /**
     * @var \Eccube\Entity\ClassCategory
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\ClassCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="class_category_id2", referencedColumnName="id", nullable=true)
     * })
     */
    private $ClassCategory2;
    /**
     * @var \Eccube\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $Product;

    /**
     * @var int
     *
     * @ORM\Column(name="is_allowed", type="integer", options={"default":0})
     */
    private $is_allowed;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="start_date", type="datetimetz", nullable=true)
     */
    private $start_date;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date", type="datetimetz", nullable=true)
     */
    private $end_date;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="shipping_date", type="datetimetz", nullable=true)
     */
    private $shipping_date;

    /**
     * @var int
     *
     * @ORM\Column(name="shipping_date_changed", type="integer", options={"default":0})
     */
    private $shipping_date_changed;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_date", type="datetimetz")
     */
    private $create_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetimetz")
     */
    private $update_date;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get productClass
     *
     * @return \Eccube\Entity\ProductClass|null
     */
    public function getProductClass()
    {
        return $this->ProductClass;
    }

    /**
     * Set productClass
     *
     * @param \Eccube\Entity\ProductClass|null $productClass
     * @return ProductClassExtra
     */
    public function setProductClass(\Eccube\Entity\ProductClass $productClass = null)
    {
        $this->ProductClass = $productClass;
        return $this;
    }

    /**
     * Set classCategory1.
     *
     * @param \Eccube\Entity\ClassCategory|null $classCategory1
     *
     * @return ProductClassExtra
     */
    public function setClassCategory1(\Eccube\Entity\ClassCategory $classCategory1 = null)
    {
        $this->ClassCategory1 = $classCategory1;

        return $this;
    }

    /**
     * Get classCategory1.
     *
     * @return \Eccube\Entity\ClassCategory|null
     */
    public function getClassCategory1()
    {
        return $this->ClassCategory1;
    }

    /**
     * Set classCategory2.
     *
     * @param \Eccube\Entity\ClassCategory|null $classCategory2
     *
     * @return ProductClassExtra
     */
    public function setClassCategory2(\Eccube\Entity\ClassCategory $classCategory2 = null)
    {
        $this->ClassCategory2 = $classCategory2;

        return $this;
    }

    /**
     * Get classCategory2.
     *
     * @return \Eccube\Entity\ClassCategory|null
     */
    public function getClassCategory2()
    {
        return $this->ClassCategory2;
    }

    /**
     * Set product.
     *
     * @param \Eccube\Entity\Product|null $product
     *
     * @return ProductClassExtra
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
     * @return int
     */
    public function isAllowed()
    {
        return $this->is_allowed;
    }

    /**
     * @param int $is_allowed
     *
     * @return ProductClassExtra
     */
    public function setAllowed($is_allowed)
    {
        $this->is_allowed = $is_allowed;

        return $this;
    }

    /**
     * Set startDate.
     *
     * @param \DateTime $startDate
     *
     * @return ProductClassExtra
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime $endDate
     *
     * @return ProductClassExtra
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set shippingDate.
     *
     * @param \DateTime $shippingDate
     *
     * @return ProductClassExtra
     */
    public function setShippingDate($shippingDate)
    {
        $this->shipping_date = $shippingDate;

        return $this;
    }

    /**
     * Get shippingDate.
     *
     * @return \DateTime
     */
    public function getShippingDate()
    {
        return $this->shipping_date;
    }

    /**
     * Set shippingDateChanged.
     *
     * @param \Integer $shippingDateChanged
     *
     * @return ProductClassExtra
     */
    public function setShippingDateChanged($shippingDateChanged)
    {
        $this->shipping_date_changed = $shippingDateChanged;

        return $this;
    }

    /**
     * Get shippingDateChanged.
     *
     * @return \Integer
     */
    public function getShippingDateChanged()
    {
        return $this->shipping_date_changed;
    }

    /**
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return ProductClassExtra
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get createDate.
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set updateDate.
     *
     * @param \DateTime $updateDate
     *
     * @return ProductClassExtra
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get updateDate.
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
