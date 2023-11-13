<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\GMC\GraphQL;

use Eccube\Entity\Delivery;
use Eccube\Repository\DeliveryRepository;
use GraphQL\Type\Definition\Type;
use Plugin\Api\GraphQL\Query;
use Plugin\Api\GraphQL\Types;

class DeliveryQuery implements Query
{
    /**
     * @var Types
     */
    private $types;

    /**
     * @var DeliveryRepository
     */
    private $deliveryRepository;

    /**
     * DeliveryQuery constructor.
     */
    public function __construct(Types $types, DeliveryRepository $deliveryRepository)
    {
        $this->types = $types;
        $this->deliveryRepository = $deliveryRepository;
    }

    public function getName()
    {
        return 'gmc_deliveries';
    }

    public function getQuery()
    {
        return [
            'type' => Type::listOf($this->types->get(Delivery::class)),
            'resolve' => function ($root, $args) {
                return $this->deliveryRepository->createQueryBuilder('d')
                    ->addSelect('df', 'p')
                    ->innerJoin('d.DeliveryFees', 'df')
                    ->innerJoin('df.Pref', 'p')
                    ->getQuery()->getResult();
            },
        ];
    }
}
