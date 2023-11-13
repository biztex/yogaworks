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
 * PostCarrierGroupCustomer
 *
 * @ORM\Table(name="plg_post_carrier_group_customer", indexes={
 *     @ORM\Index(name="plg_post_carrier_group_customer_group_id_idx", columns={"group_id"}),
 *     @ORM\Index(name="plg_post_carrier_group_customer_email_idx", columns={"email"}),
 *     @ORM\Index(name="plg_post_carrier_group_customer_secret_key_idx", columns={"secret_key"}),
 *     @ORM\Index(name="plg_post_carrier_group_customer_create_date_idx", columns={"create_date"}),
 *  })
 *
 * @ORM\Entity(repositoryClass="Plugin\PostCarrier4\Repository\PostCarrierGroupCustomerRepository")
 */
class PostCarrierGroupCustomer extends AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer")
     */
    private $group_id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="memo01", type="text", nullable=true)
     */
    private $memo01 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo02", type="text", nullable=true)
     */
    private $memo02 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo03", type="text", nullable=true)
     */
    private $memo03 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo04", type="text", nullable=true)
     */
    private $memo04 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo05", type="text", nullable=true)
     */
    private $memo05 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo06", type="text", nullable=true)
     */
    private $memo06 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo07", type="text", nullable=true)
     */
    private $memo07 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo08", type="text", nullable=true)
     */
    private $memo08 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo09", type="text", nullable=true)
     */
    private $memo09 = "";

    /**
     * @var string
     *
     * @ORM\Column(name="memo10", type="text", nullable=true)
     */
    private $memo10 = "";

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", options={"default": 2})
     */
    private $status = 2; // XXX 何とかならんの?

    /**
     * @var string
     *
     * @ORM\Column(name="secret_key", type="string", length=255, nullable=true)
     */
    private $secret_key;

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
     * Set group
     *
     * @param integer $group_id
     *
     * @return $this
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;

        return $this;
    }

    /**
     * Get group
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Set email
     *
     * @param  string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set memo01
     *
     * @param string $memo01
     *
     * @return $this
     */
    public function setMemo01($memo01)
    {
        $this->memo01 = $memo01;

        return $this;
    }

    /**
     * Get memo01
     *
     * @return string
     */
    public function getMemo01()
    {
        return $this->memo01;
    }

    /**
     * Set memo02
     *
     * @param string $memo02
     *
     * @return $this
     */
    public function setMemo02($memo02)
    {
        $this->memo02 = $memo02;

        return $this;
    }

    /**
     * Get memo02
     *
     * @return string
     */
    public function getMemo02()
    {
        return $this->memo02;
    }

    /**
     * Set memo03
     *
     * @param string $memo03
     *
     * @return $this
     */
    public function setMemo03($memo03)
    {
        $this->memo03 = $memo03;

        return $this;
    }

    /**
     * Get memo03
     *
     * @return string
     */
    public function getMemo03()
    {
        return $this->memo03;
    }

    /**
     * Set memo04
     *
     * @param string $memo04
     *
     * @return $this
     */
    public function setMemo04($memo04)
    {
        $this->memo04 = $memo04;

        return $this;
    }

    /**
     * Get memo04
     *
     * @return string
     */
    public function getMemo04()
    {
        return $this->memo04;
    }

    /**
     * Set memo05
     *
     * @param string $memo05
     *
     * @return $this
     */
    public function setMemo05($memo05)
    {
        $this->memo05 = $memo05;

        return $this;
    }

    /**
     * Get memo05
     *
     * @return string
     */
    public function getMemo05()
    {
        return $this->memo05;
    }

    /**
     * Set memo06
     *
     * @param string $memo06
     *
     * @return $this
     */
    public function setMemo06($memo06)
    {
        $this->memo06 = $memo06;

        return $this;
    }

    /**
     * Get memo06
     *
     * @return string
     */
    public function getMemo06()
    {
        return $this->memo06;
    }

    /**
     * Set memo07
     *
     * @param string $memo07
     *
     * @return $this
     */
    public function setMemo07($memo07)
    {
        $this->memo07 = $memo07;

        return $this;
    }

    /**
     * Get memo07
     *
     * @return string
     */
    public function getMemo07()
    {
        return $this->memo07;
    }

    /**
     * Set memo08
     *
     * @param string $memo08
     *
     * @return $this
     */
    public function setMemo08($memo08)
    {
        $this->memo08 = $memo08;

        return $this;
    }

    /**
     * Get memo08
     *
     * @return string
     */
    public function getMemo08()
    {
        return $this->memo08;
    }

    /**
     * Set memo09
     *
     * @param string $memo09
     *
     * @return $this
     */
    public function setMemo09($memo09)
    {
        $this->memo09 = $memo09;

        return $this;
    }

    /**
     * Get memo09
     *
     * @return string
     */
    public function getMemo09()
    {
        return $this->memo09;
    }

    /**
     * Set memo10
     *
     * @param string $memo10
     *
     * @return $this
     */
    public function setMemo10($memo10)
    {
        $this->memo10 = $memo10;

        return $this;
    }

    /**
     * Get memo10
     *
     * @return string
     */
    public function getMemo10()
    {
        return $this->memo10;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set secretKey
     *
     * @param string $secretKey
     *
     * @return $this
     */
    public function setSecretKey($secretKey)
    {
        $this->secret_key = $secretKey;

        return $this;
    }

    /**
     * Get secretKey
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secret_key;
    }

    /**
     * Set create_date
     *
     * @param \DateTime $createDate
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
     * @param \DateTime $updateDate
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
