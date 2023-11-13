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

namespace Plugin\PostCarrier4\Repository;

use Eccube\Common\Constant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\EccubeConfig;
use Eccube\Doctrine\Query\Queries;
use Eccube\Entity\Customer;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Repository\CustomerRepository;
use Eccube\Repository\OrderRepository;
use Eccube\Util\StringUtil;
use Plugin\PostCarrier4\Controller\EchoWriteSQLWithoutParamsLogger;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

use Eccube\Entity\Master\OrderStatus;
use Eccube\Entity\Master\OrderItemType as OrderItemTypeMaster;

class PostCarrierCustomerRepository extends CustomerRepository
{
    /**
     * PostCarrierCustomerRepository constructor.
     *
     * @param RegistryInterface $registry
     * @param Queries $queries
     * @param EntityManagerInterface $entityManager
     * @param OrderRepository $orderRepository
     * @param EncoderFactoryInterface $encoderFactory
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(
        RegistryInterface $registry,
        Queries $queries,
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        EncoderFactoryInterface $encoderFactory,
        EccubeConfig $eccubeConfig
    ) {
        parent::__construct($registry, $queries, $entityManager, $orderRepository, $encoderFactory, $eccubeConfig);
    }

    public function getQueryBuilderBySearchData($searchData, $is_event_on = false)
    {
        //log_info(print_r(dump($searchData, 2, true, false), true)); // PostCarrierItemTypeが含まれていると out of memory.

        // 購入処理中、決済処理中、キャンセル、返品は除外
        $excludeOrderStatus = [
            OrderStatus::PROCESSING,
            OrderStatus::PENDING,
            OrderStatus::CANCEL,
            OrderStatus::RETURNED,
        ];

        if (isset($searchData['buy_total_start']) && StringUtil::isNotBlank($searchData['buy_total_start'])) {
            $buy_total_start = $searchData['buy_total_start'];
            unset($searchData['buy_total_start']);
        }

        if (isset($searchData['buy_total_end']) && StringUtil::isNotBlank($searchData['buy_total_end'])) {
            $buy_total_end = $searchData['buy_total_end'];
            unset($searchData['buy_total_end']);
        }

        if (isset($searchData['buy_times_start']) && StringUtil::isNotBlank($searchData['buy_times_start'])) {
            $buy_times_start = $searchData['buy_times_start'];
            unset($searchData['buy_times_start']);
        }

        if (isset($searchData['buy_times_end']) && StringUtil::isNotBlank($searchData['buy_times_end'])) {
            $buy_times_end = $searchData['buy_times_end'];
            unset($searchData['buy_times_end']);
        }

        if (isset($searchData['buy_product_name']) && StringUtil::isNotBlank($searchData['buy_product_name'])) {
            $buy_product_name = $searchData['buy_product_name'];
            unset($searchData['buy_product_name']);
        }

        if (!empty($searchData['last_buy_start']) && $searchData['last_buy_start']) {
            $last_buy_start = $searchData['last_buy_start'];
            unset($searchData['last_buy_start']);
        }

        if (!empty($searchData['last_buy_end']) && $searchData['last_buy_end']) {
            $last_buy_end = $searchData['last_buy_end'];
            unset($searchData['last_buy_end']);
        }

        // 都道府県
        // if (!empty($searchData['pref']) && count($searchData['pref']) > 0) {
        //     $pref_orig = $searchData['pref'];
        // }
        // unset($searchData['pref']); // multiple = true に変更しているので必ず消す

        // メルマガを希望しない会員を含める場合は、条件を設定しない
        if (!isset($searchData['ignore_permissions']) || !$searchData['ignore_permissions']) {
            $searchData['plg_postcarrier_flg'] = Constant::ENABLED;
        }

        $qb = parent::getQueryBuilderBySearchData($searchData);

        // 受注サブクエリ
        $qb2 = $this->_em->createQueryBuilder();
        $qb2->select('1')
            ->from('\Eccube\Entity\Order','o2');

        // 購入金額
        if (isset($buy_total_start)) {
            $qb2
                ->andHaving('sum(o2.total) >= :buy_total_start')
                ->setParameter('buy_total_start', $buy_total_start);
        }

        if (isset($buy_total_end)) {
            $qb2
                ->andHaving('sum(o2.total) <= :buy_total_end')
                ->setParameter('buy_total_end', $buy_total_end);
        }

        // 購入回数
        if (isset($buy_times_start)) {
            $qb2
                ->andHaving('count(DISTINCT o2.id) >= :buy_times_start')
                ->setParameter('buy_times_start', $buy_times_start);
        }

        if (isset($buy_times_end)) {
            $qb2
                ->andHaving('count(DISTINCT o2.id) <= :buy_times_end')
                ->setParameter('buy_times_end', $buy_times_end);
        }

        // 購入商品名
        if (isset($buy_product_name)) {
            $qb2
                ->innerJoin('o2.OrderItems', 'oi2')
                ->andWhere('oi2.product_name LIKE :buy_product_name')
                ->setParameter('buy_product_name', '%'.$buy_product_name.'%');
        }

        // 最終購入日
        if (isset($last_buy_start)) {
            $qb2
                ->andHaving('max(o2.order_date) >= :last_buy_start')
                ->setParameter('last_buy_start', $last_buy_start);
        }

        if (isset($last_buy_end)) {
            $last_buy_end_1 = (clone $last_buy_end)->setTime(0, 0)->modify('+1 day');

            $qb2
                ->andHaving('max(o2.order_date) < :last_buy_end')
                ->setParameter('last_buy_end', $last_buy_end_1);
        }

        // 都道府県
        // if (isset($pref_orig) && count($pref_orig) > 0) {
        //     $prefs = [];
        //     foreach ($pref_orig as $pref) {
        //         $prefs[] = $pref->getId();
        //     }
        //
        //     $qb
        //         ->andWhere($qb->expr()->in('c.Pref', ':prefs'))
        //         ->setParameter('prefs', $prefs);
        // }

        $DQLParts = $qb2->getDQLParts();
        if ($DQLParts['where'] || $DQLParts['having'] || $DQLParts['join'] || $DQLParts['groupBy']) {
            $qb2->andWhere('o2.Customer = c')
                ->andWhere($qb2->expr()->notIn('o2.OrderStatus', ':status'))
                ->setParameter('status', $excludeOrderStatus);

            // 受注に関するサブクエリを追加する。
            $qb
                ->andWhere($qb->expr()->exists($qb2->getDQL()))
                ->setParameters(new ArrayCollection(array_merge($qb->getParameters()->toArray(),
                                                                $qb2->getParameters()->toArray())));
        }

        if ($is_event_on && isset($searchData['b__event'])) {
            $eventColumnMap = [
                'memberRegistrationDate' => 'c.create_date',
                'birthday' => 'c.birth',
                'paymentDate' => 'o3.payment_date',
                'orderDate' => 'o3.create_date',
                'latestOrderDate' => 'o3.create_date',
                'commitDate' => 's.shipping_date',
                'latestCommitDate' => 's.shipping_date',
            ];

            $eventColumn = $eventColumnMap[$searchData['b__event']];
            $offsetSign = $searchData['b__eventDaySelect'] === 'front' ? '+' : '-';
            $offsetDays = $searchData['b__eventDay'];

            if ($searchData['b__event'] == 'memberRegistrationDate') {
                $step_begin = (new \DateTime("-${offsetDays} day"))->setTime(0, 0);
                $step_end = (clone $step_begin)->modify('+1 day');

                $qb
                    ->andWhere(":step_begin <= $eventColumn")
                    ->andWhere("$eventColumn < :step_end")
                    ->setParameter('step_begin', $step_begin)
                    ->setParameter('step_end', $step_end);
            } elseif ($searchData['b__event'] == 'birthday') {
                $step_birth = new \DateTime("${offsetSign}${offsetDays} day");

                $qb
                    ->andWhere('EXTRACT(MONTH FROM c.birth) = :step_birth_month')
                    ->andWhere('EXTRACT(DAY FROM c.birth) = :step_birth_day')
                    ->setParameter('step_birth_month', (int)$step_birth->format('n'))
                    ->setParameter('step_birth_day', (int)$step_birth->format('j'));
            } else {
                // 購入ステップメール
                $step_begin = (new \DateTime("-${offsetDays} day"))->setTime(0, 0);
                $step_end = (clone $step_begin)->modify('+1 day');

                $qb3 = $this->_em->createQueryBuilder();
                $qb3->select('1')
                    ->from('\Eccube\Entity\Order','o3')
                    ->andWhere('o3.Customer = c')
                    ->andWhere($qb3->expr()->notIn('o3.OrderStatus', ':status_exclude'))
                    ->setParameter('status_exclude', $excludeOrderStatus)
                    ->setParameter('step_begin', $step_begin)
                    ->setParameter('step_end', $step_end);

                if ($searchData['b__event'] == 'commitDate' || $searchData['b__event'] == 'latestCommitDate') {
                    $qb3->innerJoin('o3.Shippings', 's'); // s.shipping_date 発送日
                }

                if (isset($searchData['OrderItems']) && count($searchData['OrderItems']) > 0) {
                    // 送料を購入回数指定として利用
                    if (count($searchData['OrderItems']) == 1 && current($searchData['OrderItems'])->getOrderItemType()->getId() == OrderItemTypeMaster::DELIVERY_FEE) {
                        // 購入回数指定 商品指定なし
                        $qb3->andHaving("COUNT(DISTINCT o3.id) = :count AND :step_begin <= MAX($eventColumn) AND MAX($eventColumn) < :step_end")
                            ->setParameter('count', current($searchData['OrderItems'])->getQuantity());
                    } else {
                        // 商品指定あり
                        if ($searchData['b__event'] == 'commitDate' || $searchData['b__event'] == 'latestCommitDate') {
                            $qb3->innerJoin('s.OrderItems', 'oi');
                        } else {
                            $qb3->innerJoin('o3.OrderItems', 'oi');
                        }

                        $subexps = [];
                        $products = [];
                        $i = 0;
                        if ($searchData['b__event'] == 'commitDate' || $searchData['b__event'] == 'orderDate' || $searchData['b__event'] == 'paymentDate') {
                            foreach ($searchData['OrderItems'] as $OrderItem) {
                                $subexp = [];

                                // 商品指定
                                $product_id = $OrderItem->getProduct()->getId();
                                $products[] = $product_id;
                                $subexp[] = "SUM(CASE WHEN oi.Product = :step_product$i AND :step_begin <= $eventColumn AND $eventColumn < :step_end THEN 1 ELSE 0 END) > 0";
                                $qb3->setParameter("step_product$i", $product_id);

                                $count = $OrderItem->getQuantity();
                                if ($count != 0) {
                                    // 回数指定
                                    $subexp[] = "SUM(CASE WHEN oi.Product = :step_product$i THEN 1 ELSE 0 END) = :step_count$i";
                                    $qb3->setParameter("step_count$i", $count);
                                }

                                $subexps[] = join(' AND ', $subexp);
                                $i++;
                            }
                        } else { // if latestOrderDate or latestCommitDate
                            foreach ($searchData['OrderItems'] as $OrderItem) {
                                // 最終受注日は回数指定できない
                                $subexps[] = ":step_begin <= MAX(CASE WHEN oi.Product = :step_p$i THEN $eventColumn END) AND MAX(CASE WHEN oi.Product = :step_p$i THEN $eventColumn END) < :step_end";
                                $products[] = $OrderItem->getProduct()->getId();
                                $qb3->setParameter("step_p$i", $OrderItem->getProduct()->getId());
                                $i++;
                            }
                        }

                        // ステップメール日付条件
                        $qb3->andHaving('('.join(' OR ', $subexps).')');
                        // チューニング: 指定商品で絞り込み
                        $qb3->andWhere($qb3->expr()->in('oi.Product', ':step_products'))
                            ->setParameter('step_products', $products);
                    }
                } else {
                    // 商品指定なし
                    if ($searchData['b__event'] == 'commitDate' || $searchData['b__event'] == 'orderDate' || $searchData['b__event'] == 'paymentDate') {
                        $qb3->andWhere(":step_begin <= $eventColumn")
                            ->andWhere("$eventColumn < :step_end");
                    } else {
                        $qb3->andHaving(":step_begin <= MAX($eventColumn)")
                            ->andHaving("MAX($eventColumn) < :step_end");
                    }
                }

                // 受注に関するサブクエリを追加する。
                $qb
                    ->andWhere($qb->expr()->exists($qb3->getDQL()))
                    ->setParameters(new ArrayCollection(array_merge($qb->getParameters()->toArray(),
                                                                    $qb3->getParameters()->toArray())));
            }

            if (isset($searchData['OrderStopItems']) && count($searchData['OrderStopItems']) > 0) {
                $qb4 = $this->_em->createQueryBuilder();
                $qb4->select('1')
                    ->from('\Eccube\Entity\Order','o4')
                    ->innerJoin('o4.OrderItems', 'stop_oi')
                    ->andWhere('o4.Customer = c')
                    ->andWhere($qb4->expr()->notIn('o4.OrderStatus', ':stop_status'))
                    ->setParameter('stop_status', $excludeOrderStatus);

                $products = [];
                foreach ($searchData['OrderStopItems'] as $OrderItem) {
                    $products[] = $OrderItem->getProduct()->getId();
                }
                $qb4->andWhere($qb4->expr()->in('stop_oi.Product', ':stop_products'))
                    ->setParameter('stop_products', $products);

                // 受注に関するサブクエリを追加する。
                $qb
                    ->andWhere($qb->expr()->not($qb->expr()->exists($qb4->getDQL()))) // NOT EXISTS
                    ->setParameters(new ArrayCollection(array_merge($qb->getParameters()->toArray(),
                                                                    $qb4->getParameters()->toArray())));
            }
        }

        return $qb;
    }
}
