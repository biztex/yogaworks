<?php

namespace Plugin\QuantityDiscount\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlgQdProductClass
 *
 * @ORM\Table(name="plg_qd_product_class")
 * @ORM\Entity(repositoryClass="Plugin\QuantityDiscount\Repository\QdProductClassRepository")
 */
class QdProductClass extends \Eccube\Entity\AbstractEntity
{

    // 割引種類　価格
    const QD_TYPE_PRICE = 1;

    // 割引種類　割引率
    const QD_TYPE_RATE = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Eccube\Entity\ProductClass
     *
     * @ORM\ManyToOne(targetEntity="Eccube\Entity\ProductClass", inversedBy="QdProductClasses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_class_id", referencedColumnName="id")
     * })
     */
    private $ProductClass;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="qd_type", type="integer", nullable=false)
     */
    private $qdType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="rate", type="integer", nullable=true)
     */
    private $rate;

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
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return QdProductClass
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set qdType.
     *
     * @param int $qdType
     *
     * @return QdProductClass
     */
    public function setQdType($qdType)
    {
        $this->qdType = $qdType;

        return $this;
    }

    /**
     * Get qdType.
     *
     * @return int
     */
    public function getQdType()
    {
        return $this->qdType;
    }

    /**
     * Set price.
     *
     * @param string|null $price
     *
     * @return QdProductClass
     */
    public function setPrice($price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set rate.
     *
     * @param int|null $rate
     *
     * @return QdProductClass
     */
    public function setRate($rate = null)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate.
     *
     * @return int|null
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set productClass.
     *
     * @param \Eccube\Entity\ProductClass|null $productClass
     *
     * @return QdProductClass
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

    public function isQdTypePrice()
    {
        return $this->qdType == self::QD_TYPE_PRICE;
    }

    public function isQdTypeRate()
    {
        return $this->qdType == self::QD_TYPE_RATE;
    }

    public function __clone()
    {
        $this->id = null;
    }
}
