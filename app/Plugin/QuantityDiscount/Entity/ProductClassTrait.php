<?php
/**
 * Created by PhpStorm.
 * User: systemkd
 * Date: 2019/03/09
 * Time: 14:24
 */

namespace Plugin\QuantityDiscount\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation as Eccube;
use Eccube\Entity\ProductClass;

/**
 * Trait ProductClassTrait
 * @package Plugin\QuantityDiscount\Entity
 * @Eccube\EntityExtension("Eccube\Entity\ProductClass")
 */
trait ProductClassTrait
{

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Plugin\QuantityDiscount\Entity\QdProductClass", mappedBy="ProductClass", cascade={"persist", "remove"})
     * @ORM\OrderBy({
     *     "quantity"="ASC"
     * })
     */
    private $QdProductClasses;

    /**
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function getQdProductClasses()
    {
        return $this->QdProductClasses;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection|null $QdProductClasses
     * @return ProductClass
     */
    public function setQdProductClasses($QdProductClasses)
    {
        $this->QdProductClasses = $QdProductClasses;

        return $this;
    }

    /**
     * Copy
     *
     */
    public function copyQdProductClasses()
    {
        $newQdProductClasses = new ArrayCollection();

        /** @var QdProductClass $qdProductClass */
        foreach ($this->QdProductClasses as $qdProductClass) {

            $newQdProductClass = clone $qdProductClass;
            $newQdProductClass->setProductClass($this);
            $newQdProductClasses->add($newQdProductClass);
        }

        $this->QdProductClasses = $newQdProductClasses;
    }
}
