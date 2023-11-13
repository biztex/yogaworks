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

namespace Plugin\PostCarrier4\Util;

use Doctrine\DBAL\Logging\SQLLogger;
//use Doctrine\DBAL\Types\Type;

/**
 *
 */
class SqlPeekingLogger implements SQLLogger
{
    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->sql = $sql;
        $this->params = $params;
        $this->types = $types;

        if (preg_match('/^SELECT /i', $sql)) {
            throw new \RuntimeException('stop sql exection!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        // do nothing.
    }

    /**
     * {@inheritdoc}
     */
    public function getRawSQL() {
        return [$this->sql, $this->params, $this->types];
    }
}
