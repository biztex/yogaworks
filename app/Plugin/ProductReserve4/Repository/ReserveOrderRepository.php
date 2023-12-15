<?php

namespace Plugin\ProductReserve4\Repository;

use Eccube\Repository\AbstractRepository;
use Plugin\ProductReserve4\Entity\ReserveOrder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReserveOrderRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReserveOrder::class);
    }

    public function getReserveOrderByProduct($Product)
    {
        $ReserveOrders = $this->findby(array('Product' => $Product));
        return $ReserveOrders;
    }

    public function getReserveOrderByProductEx($product_id, $order_status)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r')
            ->leftJoin('r.Order', 'o');
        $qb
            ->andWhere('r.Product = :product_id')
            ->setParameter('product_id', $product_id)
            ->andWhere('o.OrderStatus = :order_status')
            ->setParameter('order_status', $order_status);

        return $qb->getQuery()->getResult();
    }

    public function getReserveOrder($orderId)
    {
        return $this->findby(array('Order' => $orderId));
    }

    public function deleteReserveOrder($orderId)
    {
        $em = $this->getEntityManager();
//        $em->createQuery("DELETE \Plugin\ProductReserve4\Entity\ReserveOrder ro WHERE ro.Order = :order_id")->execute(['order_id' => $orderId]);
        $reserveOrders = $this->getReserveOrder($orderId);
        foreach($reserveOrders as $reserveOrder) {
            $em->remove($reserveOrder);
            $em->flush($reserveOrder);
        }
    }
}
