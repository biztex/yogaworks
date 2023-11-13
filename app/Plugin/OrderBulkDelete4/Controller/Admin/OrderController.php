<?php

/*
 * This file is part of OrderBulkDelete4
 *
 * Copyright(c) U-Mebius Inc. All Rights Reserved.
 *
 * https://umebius.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\OrderBulkDelete4\Controller\Admin;

use Eccube\Common\Constant;
use Eccube\Controller\AbstractController;
use Eccube\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(
        OrderRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/order/bulk_delete", name="admin_order_bulk_delete", methods={"POST"})
     */
    public function bulkDelete(Request $request)
    {
        $this->isTokenValid();
        $ids = $request->get('ids');
        foreach ($ids as $order_id) {
            $Shipping = $this->entityManager->getRepository('Eccube\Entity\Shipping')
                ->find($order_id);
            if ($Shipping) {
                $Order = $Shipping->getOrder();
                $this->entityManager->remove($Order);
                $this->entityManager->flush();
                log_info('受注削除', [$Order->getId()]);

                // 会員の場合、購入回数、購入金額などを更新
                if ($Customer = $Order->getCustomer()) {
                    $this->orderRepository->updateOrderSummary($Customer);
                    $this->entityManager->flush();
                    log_info('受注削除後の会員情報更新', [$Order->getId()]);
                }
            }
        }

        $this->addSuccess('admin.common.delete_complete', 'admin');

        return $this->redirect($this->generateUrl('admin_order', ['resume' => Constant::ENABLED]));
    }
}
