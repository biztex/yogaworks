<?php

namespace Plugin\tbsMailTemplate\Common;

use Eccube\Common\EccubeNav;

class MailNav implements EccubeNav
{
    public static function getNav()
    {
        return [
            'setting' => [
                'children' => [
                    'shop' => [
                        'children' => [
                            'tbs_mail_template' => [
                                'name' => 'tbs_mail_template.admin.mail_template.title',
                                'url' => 'tbs_mail_template_admin_config',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
