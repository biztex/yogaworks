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

namespace Plugin\PostCarrier4;

use Eccube\Common\EccubeNav;

class PostCarrierNav implements EccubeNav
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getNav()
    {
        return [
            'postcarrier' => [
                'id' => 'postcarrier',
                'name' => 'postcarrier.title',
                'icon' => 'fa-envelope',
                'children' => [
                    'postcarrier' => [
                        'id' => 'postcarrier',
                        'name' => 'postcarrier.index.title',
                        'url' => 'plugin_post_carrier',
                    ],
                    'postcarrier_template' => [
                        'id' => 'postcarrier_template',
                        'name' => 'postcarrier.template.title',
                        'url' => 'plugin_post_carrier_template',
                    ],
                    'postcarrier_history' => [
                        'id' => 'postcarrier_history',
                        'name' => 'postcarrier.history.title',
                        'url' => 'plugin_post_carrier_history',
                    ],
                    'postcarrier_schedule' => [
                        'id' => 'postcarrier_schedule',
                        'name' => 'postcarrier.schedule.title',
                        'url' => 'plugin_post_carrier_schedule',
                    ],
                    'postcarrier_stepmail' => [
                        'id' => 'postcarrier_stepmail',
                        'name' => 'postcarrier.stepmail.title',
                        'url' => 'plugin_post_carrier_stepmail',
                    ],
                    'postcarrier_mail_customer' => [
                        'id' => 'postcarrier_mail_customer',
                        'name' => 'postcarrier.mail_customer.title',
                        'url' => 'plugin_post_carrier_mail_customer',
                    ],
                    'postcarrier_discard' => [
                        'id' => 'postcarrier_discard',
                        'name' => 'postcarrier.discard.title',
                        'url' => 'plugin_post_carrier_discard',
                    ],
                    'postcarrier_monthly_report' => [
                        'id' => 'postcarrier_monthly_report',
                        'name' => 'postcarrier.monthly_report.title',
                        'url' => 'plugin_post_carrier_monthly_report',
                    ],
                ],
            ],
        ];
    }
}
