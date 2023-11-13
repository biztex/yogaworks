<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/09
 */

namespace Plugin\QuantityDiscount\Repository;


use Doctrine\Common\Persistence\ManagerRegistry;
use Eccube\Entity\ProductClass;
use Eccube\Repository\AbstractRepository;
use Plugin\QuantityDiscount\Entity\QdProductClass;

class QdProductClassRepository extends AbstractRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QdProductClass::class);
    }

    /**
     * まとめ買い価格情報取得
     *
     * @param ProductClass $productClass
     * @param integer|null $quantity
     * @param string $sort
     * @return mixed
     */
    public function findProductClassPrice(ProductClass $productClass, $quantity = null, $sort = "desc")
    {

        $qb = $this->createQueryBuilder('qd')
            ->andWhere('qd.ProductClass = :productClass')
            ->setParameter('productClass', $productClass)
            ->orderBy('qd.quantity', $sort);

        if(!is_null($quantity)) {
            $qb
                ->andWhere('qd.quantity <= :quantity')
                ->setParameter('quantity', $quantity);
        }

        $result = $qb->getQuery()->getResult();

        return $result;
    }
}
