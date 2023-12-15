<?php

namespace Plugin\ProductReserve4\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Config
 *
 * @ORM\Table(name="plg_product_reserve4_extra")
 * @ORM\Entity(repositoryClass="Plugin\UKOMI4\Repository\ProductExtraRepository")
 */
class ProductExtra
{
    /**
     * @var int
     *
     * @ORM\Column(name="product_id", type="integer", options={"unsigned":true})
     * @ORM\Id
     */
    private $product_id;

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
     * @var \Date|null
     *
     * @ORM\Column(name="shipping_date", type="datetimetz", nullable=true)
     */
    private $shipping_date;

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
     * @return string
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param $product_id
     *
     * @return ProductExtra
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
        return $this;
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
     * @return ProductExtra
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
     * @return ProductExtra
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
     * @return ProductExtra
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
     * @return ProductExtra
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
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return ProductExtra
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
     * @return ProductExtra
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
