<?php

namespace Plugin\ZeusPayment4;

use Eccube\Common\EccubeNav;

/*
 * ナビゲーションメニュー登録
 */
class ZeusPaymentNav implements EccubeNav
{
    public static function getNav()
    {
        return [
            'order' => [
                'children' => [
                    'zeus_order_list' => [
                        'name' => 'ゼウス受注管理',
                        'url' => 'zeus_order_list',
                    ],                    
                    'zeus_order_csv' => [
                        'name' => 'ゼウス売上CSV',
                        'url' => 'zeus_order_csv',
                    ],
                    'zeus_cancel_csv' => [
                        'name' => 'ゼウス取消CSV',
                        'url' => 'zeus_cancel_csv',
                    ],
                ],
            ],
        ];
    }
}
