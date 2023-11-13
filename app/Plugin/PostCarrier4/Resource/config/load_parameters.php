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

$postcarrier_parameters = [
    'post_carrier_dir' => '%kernel.project_dir%/var/post_carrier',
    'post_carrier_config_url' => 'https://www.postcarrier.jp/webservice1/api/v1/config',
    'post_carrier_account_free_user' => 'free',
    'post_carrier_account_free_pass' => 'free',
];

$override_file = __DIR__ . '/override_parameters.php';
if (file_exists($override_file)) {
    include_once($override_file);
}

foreach ($postcarrier_parameters as $key => $val) {
    $container->setParameter($key, $val);
}
