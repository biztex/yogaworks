<?php

namespace Plugin\QuantityDiscount\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlgQdConfig
 *
 * @ORM\Table(name="plg_qd_config")
 * @ORM\Entity(repositoryClass="Plugin\QuantityDiscount\Repository\QdConfigRepository")
 */
class QdConfig extends \Eccube\Entity\AbstractEntity
{

    const TYPE_STRING = 1;

    const TYPE_CHOICE = 2;

    const TYPE_BOOL = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="smallint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="config_key", type="string", length=255, nullable=false)
     */
    private $configKey;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="config_type", type="integer", nullable=false)
     */
    private $configType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="text_value", type="string", length=255, nullable=true)
     */
    private $textValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="int_value", type="integer", nullable=true)
     */
    private $intValue;

    /**
     * @var bool
     *
     * @ORM\Column(name="bool_value", type="boolean", options={"default":false})
     */
    private $boolValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer", nullable=true)
     */
    private $groupId;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set configKey.
     *
     * @param string $configKey
     *
     * @return QdConfig
     */
    public function setConfigKey($configKey)
    {
        $this->configKey = $configKey;

        return $this;
    }

    /**
     * Get configKey.
     *
     * @return string
     */
    public function getConfigKey()
    {
        return $this->configKey;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return QdConfig
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set configType.
     *
     * @param int $configType
     *
     * @return QdConfig
     */
    public function setConfigType($configType)
    {
        $this->configType = $configType;

        return $this;
    }

    /**
     * Get configType.
     *
     * @return int
     */
    public function getConfigType()
    {
        return $this->configType;
    }

    /**
     * Set textValue.
     *
     * @param string|null $textValue
     *
     * @return QdConfig
     */
    public function setTextValue($textValue = null)
    {
        $this->textValue = $textValue;

        return $this;
    }

    /**
     * Get textValue.
     *
     * @return string|null
     */
    public function getTextValue()
    {
        return $this->textValue;
    }

    /**
     * Set intValue.
     *
     * @param int|null $intValue
     *
     * @return QdConfig
     */
    public function setIntValue($intValue = null)
    {
        $this->intValue = $intValue;

        return $this;
    }

    /**
     * Get intValue.
     *
     * @return int|null
     */
    public function getIntValue()
    {
        return $this->intValue;
    }

    /**
     * Set boolValue.
     *
     * @param bool $boolValue
     *
     * @return QdConfig
     */
    public function setBoolValue($boolValue)
    {
        $this->boolValue = $boolValue;

        return $this;
    }

    /**
     * Get boolValue.
     *
     * @return bool
     */
    public function getBoolValue()
    {
        return $this->boolValue;
    }

    /**
     * @return bool
     */
    public function isBoolValue()
    {
        return $this->boolValue;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     * @return QdConfig
     */
    public function setGroupId(int $groupId)
    {
        $this->groupId = $groupId;
        return $this;
    }

}
