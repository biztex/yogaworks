<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/30
 */

namespace Plugin\QuantityDiscount\Repository;


use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Eccube\Repository\AbstractRepository;
use Plugin\QuantityDiscount\Entity\QdConfig;

class QdConfigRepository extends AbstractRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QdConfig::class);
    }

    public function findAllOrderGroup()
    {
        return $this->findBy([], ['groupId' => 'asc', 'id' => 'asc']);
    }

    /**
     * @param $configType
     * @param $key
     * @param $name
     * @param null $textValue
     * @param null $intValue
     * @param bool $boolValue
     * @param $groupId
     * @return QdConfig
     */
    private function newConfig($configType, $key, $name, $textValue, $intValue, $boolValue, $groupId)
    {
        $Config = new QdConfig();

        $Config
            ->setConfigType($configType)
            ->setConfigKey($key)
            ->setName($name)
            ->setTextValue($textValue)
            ->setIntValue($intValue)
            ->setBoolValue($boolValue)
            ->setGroupId($groupId);

        return $Config;
    }

    /**
     * @param array $setData [TYPE, KEY, NAME, VALUE]
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveNewConfigs(array $setData)
    {
        foreach ($setData as $setDatum) {

            $QdConfig = null;
            $type = $setDatum[0];
            $key = $setDatum[1];
            $name = $setDatum[2];
            $value = $setDatum[3];
            $gourpId = $setDatum[4];

            switch ($type) {
                case QdConfig::TYPE_STRING:
                    $QdConfig = $this->getTextConfig($key, $name, $value, $gourpId);
                    break;
                case QdConfig::TYPE_CHOICE:
                    $QdConfig = $this->getIntegerConfig($key, $name, $value, $gourpId);
                    break;
                case QdConfig::TYPE_BOOL:
                    $QdConfig = $this->getBoolConfig($key, $name, $value, $gourpId);
                    break;
            }

            $this->getEntityManager()->persist($QdConfig);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @param $key
     * @param $name
     * @param $value
     * @param $groupId
     * @return QdConfig
     */
    public function getTextConfig($key, $name, $value, $groupId)
    {
        return $this->newConfig(QdConfig::TYPE_STRING, $key, $name, $value, null, false, $groupId);
    }

    /**
     * @param $key
     * @param $name
     * @param $value
     * @param $groupId
     * @return QdConfig
     */
    public function getIntegerConfig($key, $name, $value, $groupId)
    {
        return $this->newConfig(QdConfig::TYPE_CHOICE, $key, $name, null, (string)$value, false, $groupId);
    }

    /**
     * @param $key
     * @param $name
     * @param $value
     * @param $groupId
     * @return QdConfig
     */
    public function getBoolConfig($key, $name, $value, $groupId)
    {
        return $this->newConfig(QdConfig::TYPE_BOOL, $key, $name, null, null, $value, $groupId);
    }
}
