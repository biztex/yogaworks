<?php

namespace Plugin\ZeusPayment4\Repository;

use Eccube\Repository\AbstractRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Plugin\ZeusPayment4\Entity\Config;

/*
 * 設定情報リポジトリ
 */
class ConfigRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Config::class);
    }

    public function get($id = 1)
    {
        return $this->find($id);
    }
}
