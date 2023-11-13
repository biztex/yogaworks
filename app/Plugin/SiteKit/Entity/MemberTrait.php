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

namespace Plugin\SiteKit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
 * @EntityExtension("Eccube\Entity\Member")
 */
trait MemberTrait
{
    /**
     * @ORM\OneToOne(targetEntity="Plugin\SiteKit\Entity\IdToken", mappedBy="Member")
     */
    private $IdToken;

    /**
     * @return IdToken
     */
    public function getIdToken()
    {
        return $this->IdToken;
    }
}
