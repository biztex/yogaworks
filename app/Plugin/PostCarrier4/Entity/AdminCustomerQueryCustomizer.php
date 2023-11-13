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

namespace Plugin\PostCarrier4\Entity;

use Eccube\Doctrine\Query\WhereClause;
use Eccube\Doctrine\Query\WhereCustomizer;
use Eccube\Repository\QueryKey;

class AdminCustomerQueryCustomizer extends WhereCustomizer
{
    /**
     * {@inheritdoc}
     *
     * @param array $params
     * @param $queryKey
     *
     * @return WhereClause[]
     */
    protected function createStatements($params, $queryKey)
    {
        if (!isset($params['plg_postcarrier_flg'])) {
            return [];
        }

        return [WhereClause::eq('c.postcarrier_flg', ':postcarrier_flg', [
            'postcarrier_flg' => $params['plg_postcarrier_flg'],
        ])];
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getQueryKey()
    {
        return QueryKey::CUSTOMER_SEARCH;
    }
}
