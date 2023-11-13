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

use Eccube\Entity\Master\OrderStatus as Status;
use Eccube\Service\OrderStateMachineContext;

$container->loadFromExtension('framework', [
    'workflows' => [
        'order' => [
            'type' => 'state_machine',
            'marking_store' => [
                'type' => 'single_state',
                'arguments' => 'status',
            ],
            'supports' => [
                OrderStateMachineContext::class,
            ],
            'initial_place' => (string) Status::NEW,
            'places' => [
                (string) Status::NEW,
                (string) Status::CANCEL,
                (string) Status::IN_PROGRESS,
                (string) Status::DELIVERED,
                (string) Status::PAID,
                (string) Status::PENDING,
                (string) Status::PROCESSING,
                (string) Status::RETURNED,
				100,
				101,
            ],
            'transitions' => [
                'init' => [
                    'from' => [(string) Status::PAID, (string) Status::IN_PROGRESS, (string) Status::CANCEL, (string) Status::DELIVERED, (string) Status::RETURNED, 100, 101],
                    'to' => (string) Status::NEW,
                ],
                'pay' => [
                    'from' => [(string) Status::NEW, (string) Status::IN_PROGRESS, (string) Status::CANCEL, (string) Status::DELIVERED, (string) Status::RETURNED, 100, 101],
                    'to' => (string) Status::PAID,
                ],
                'packing' => [
                    'from' => [(string) Status::NEW, (string) Status::PAID, (string) Status::IN_PROGRESS, (string) Status::CANCEL, (string) Status::DELIVERED, (string) Status::RETURNED, 100, 101],
                    'to' => (string) Status::IN_PROGRESS,
                ],
                'cancel' => [
                    'from' => [(string) Status::NEW, (string) Status::PAID, (string) Status::IN_PROGRESS, (string) Status::DELIVERED, (string) Status::RETURNED, 100, 101],
                    'to' => (string) Status::CANCEL,
                ],
                'back_to_in_progress' => [
                    'from' => [(string) Status::NEW, (string) Status::PAID,  (string) Status::CANCEL, (string) Status::DELIVERED, (string) Status::RETURNED, 100, 101],
                    'to' => (string) Status::IN_PROGRESS,
                ],
                'ship' => [
                    'from' => [(string) Status::NEW, (string) Status::PAID, (string) Status::IN_PROGRESS, (string) Status::CANCEL, (string) Status::RETURNED, 100, 101],
                    'to' => [(string) Status::DELIVERED],
                ],
                'return' => [
                    'from' => [(string) Status::NEW, (string) Status::PAID, (string) Status::IN_PROGRESS, (string) Status::DELIVERED, (string) Status::CANCEL, 100, 101],
                    'to' => (string) Status::RETURNED,
                ],
                'cancel_return' => [
                    'from' => [(string) Status::NEW, (string) Status::PAID, (string) Status::IN_PROGRESS, (string) Status::RETURNED, (string) Status::CANCEL, (string) Status::DELIVERED, 100, 101],
                    'to' => (string) Status::DELIVERED,
                ],
				'shipping_wait' => [
                    'from' => [(string) Status::NEW, (string) Status::PAID, (string) Status::IN_PROGRESS, (string) Status::CANCEL, (string) Status::DELIVERED, (string) Status::RETURNED, 101],
                    'to' => [100],
				],
				'reserve_reject' => [
                    'from' => [(string) Status::NEW, (string) Status::PAID, (string) Status::IN_PROGRESS, (string) Status::CANCEL, (string) Status::DELIVERED, (string) Status::RETURNED, 100],
                    'to' => [101],
				]
            ],
        ],
    ],
]);
