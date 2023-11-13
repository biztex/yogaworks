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

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation as Eccube;

/**
 * @Eccube\EntityExtension("Eccube\Entity\Customer")
 */
trait CustomerTrait
{
    /**
     * @ORM\Column(name="plg_postcarrier_flg", type="smallint", length=1, nullable=true, options={"default":0, "unsigned": true})
     *
     * @var int
     */
    protected $postcarrier_flg;

    /**
     * Set postcarrier_flg
     *
     * @param $postcarrierFlg
     *
     * @return $this
     */
    public function setPostcarrierFlg($postcarrierFlg)
    {
        $this->postcarrier_flg = $postcarrierFlg;

        return $this;
    }

    /**
     * Get postcarrier_flg
     *
     * @return int
     */
    public function getPostcarrierFlg()
    {
        return $this->postcarrier_flg;
    }
}
