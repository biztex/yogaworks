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
use Eccube\Entity\AbstractEntity;

/**
 * PostCarrierGroup
 *
 * @ORM\Table(name="plg_post_carrier_group")
 * @ORM\Entity(repositoryClass="Plugin\PostCarrier4\Repository\PostCarrierGroupRepository")
 */
class PostCarrierGroup extends AbstractEntity
{
	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getGroupName();
	}

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string")
     */
    private $group_name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetimetz")
     */
    private $create_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetimetz")
     */
    private $update_date;

    /**
     * Get id
     *
     * @param int $id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set group name
     *
     * @param string $groupName
     *
     * @return $this
     */
    public function setGroupName($groupName)
    {
        $this->group_name = $groupName;

        return $this;
    }

    /**
     * Get group name
     *
     * @return int
     */
    public function getGroupName()
    {
        return $this->group_name;
    }

    /**
     * Set create_date
     *
     * @param  \DateTime $createDate
     *
     * @return $this
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get create_date
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date
     *
     * @param  \DateTime $updateDate
     *
     * @return $this
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
