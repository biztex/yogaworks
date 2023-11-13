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

namespace Plugin\SiteKit\Repository;


use Eccube\Entity\Member;
use Eccube\Repository\AbstractRepository;
use Plugin\SiteKit\Entity\IdToken;
use Symfony\Bridge\Doctrine\RegistryInterface;

class IdTokenRepository extends AbstractRepository
{
    /**
     * IdTokenRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IdToken::class);
    }

    public function findByMember(Member $Member)
    {
        return $this->findOneBy(['Member' => $Member]);
    }
}
