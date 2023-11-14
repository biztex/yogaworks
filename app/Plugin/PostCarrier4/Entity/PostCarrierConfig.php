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
 * PostCarrierConfig
 *
 * @ORM\Table(name="plg_post_carrier_config")
 * @ORM\Entity(repositoryClass="Plugin\PostCarrierConfig4\Repository\PostCarrierConfigRepository")
 */
class PostCarrierConfig extends AbstractEntity
{
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
     * @ORM\Column(name="server_url", type="string")
     */
    private $server_url;

    /**
     * @var string
     *
     * @ORM\Column(name="shop_id", type="string")
     */
    private $shop_id;

    /**
     * @var string
     *
     * @ORM\Column(name="shop_pass", type="string")
     */
    private $shop_pass;

    /**
     * @var string
     *
     * @ORM\Column(name="click_ssl_url", type="string")
     */
    private $click_ssl_url;

    /**
     * @var string
     *
     * @ORM\Column(name="click_ssl_url_path", type="string", options={"default":"postcarrier"})
     */
    private $click_ssl_url_path;

    /**
     * @var string
     *
     * @ORM\Column(name="request_data_url", type="string")
     */
    private $request_data_url;

    /**
     * @var string
     *
     * @ORM\Column(name="module_data_url", type="string")
     */
    private $module_data_url;

    /**
     * @var string
     *
     * @ORM\Column(name="errors_to", type="string")
     */
    private $errors_to;

    /**
     * @var string
     *
     * @ORM\Column(name="basic_auth_user", type="string", nullable=true)
     */
    private $basic_auth_user;

    /**
     * @var string
     *
     * @ORM\Column(name="basic_auth_pass", type="string", nullable=true)
     */
    private $basic_auth_pass;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disable_check", type="boolean", options={"default":false})
     */
    private $disable_check = false;

    /**
     * @var string
     *
     * @ORM\Column(name="api_url", type="string")
     */
    private $api_url;

    /**
     * @var string
     *
     * @ORM\Column(name="click_url", type="string")
     */
    private $click_url;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", nullable=true)
     */
    private $data;

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
     * Set post_carrier config id.
     *
     * @param string $id
     *
     * @return PostCarrierConfig
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Get server_url.
     *
     * @return string
     */
    public function getServerUrl()
    {
        return $this->server_url;
    }

    /**
     * Set server_url.
     *
     * @param string $server_url
     *
     * @return PostCarrierConfig
     */
    public function setServerUrl($server_url)
    {
        $this->server_url = $server_url;

        return $this;
    }

    /**
     * Get shop_id.
     *
     * @return string
     */
    public function getShopId()
    {
        return $this->shop_id;
    }

    /**
     * Set shop_id.
     *
     * @param string $shop_id
     *
     * @return PostCarrierConfig
     */
    public function setShopId($shop_id)
    {
        $this->shop_id = $shop_id;

        return $this;
    }

    /**
     * Get shop_pass.
     *
     * @return string
     */
    public function getShopPass()
    {
        return $this->shop_pass;
    }

    /**
     * Set shop_pass.
     *
     * @param string $shop_pass
     *
     * @return PostCarrierConfig
     */
    public function setShopPass($shop_pass)
    {
        $this->shop_pass = $shop_pass;

        return $this;
    }

    /**
     * Get click_ssl_url.
     *
     * @return string
     */
    public function getClickSslUrl()
    {
        return $this->click_ssl_url;
    }

    /**
     * Set click_ssl_url.
     *
     * @param string $click_ssl_url
     *
     * @return PostCarrierConfig
     */
    public function setClickSslUrl($click_ssl_url)
    {
        $this->click_ssl_url = $click_ssl_url;

        return $this;
    }

    /**
     * Get click_ssl_url_path.
     *
     * @return string
     */
    public function getClickSslUrlPath()
    {
        return $this->click_ssl_url_path;
    }

    /**
     * Set click_ssl_url_path.
     *
     * @param string $click_ssl_url_path
     *
     * @return PostCarrierConfig
     */
    public function setClickSslUrlPath($click_ssl_url_path)
    {
        $this->click_ssl_url_path = $click_ssl_url_path;

        return $this;
    }

    /**
     * Get request_data_url.
     *
     * @return string
     */
    public function getRequestDataUrl()
    {
        return $this->request_data_url;
    }

    /**
     * Set request_data_url.
     *
     * @param string $request_data_url
     *
     * @return PostCarrierConfig
     */
    public function setRequestDataUrl($request_data_url)
    {
        $this->request_data_url = $request_data_url;

        return $this;
    }

    /**
     * Get module_data_url.
     *
     * @return string
     */
    public function getModuleDataUrl()
    {
        return $this->module_data_url;
    }

    /**
     * Set module_data_url.
     *
     * @param string $module_data_url
     *
     * @return PostCarrierConfig
     */
    public function setModuleDataUrl($module_data_url)
    {
        $this->module_data_url = $module_data_url;

        return $this;
    }

    /**
     * Get errors_to.
     *
     * @return string
     */
    public function getErrorsTo()
    {
        return $this->errors_to;
    }

    /**
     * Set errors_to.
     *
     * @param string $errors_to
     *
     * @return PostCarrierConfig
     */
    public function setErrorsTo($errors_to)
    {
        $this->errors_to = $errors_to;

        return $this;
    }

    /**
     * Get basic_auth_user.
     *
     * @return string
     */
    public function getBasicAuthUser()
    {
        return $this->basic_auth_user;
    }

    /**
     * Set basic_auth_user.
     *
     * @param string $basic_auth_user
     *
     * @return PostCarrierConfig
     */
    public function setBasicAuthUser($basic_auth_user)
    {
        $this->basic_auth_user = $basic_auth_user;

        return $this;
    }

    /**
     * Get basic_auth_pass.
     *
     * @return string
     */
    public function getBasicAuthPass()
    {
        return $this->basic_auth_pass;
    }

    /**
     * Set basic_auth_pass.
     *
     * @param string $basic_auth_pass
     *
     * @return PostCarrierConfig
     */
    public function setBasicAuthPass($basic_auth_pass)
    {
        $this->basic_auth_pass = $basic_auth_pass;

        return $this;
    }

    /**
     * Set data.
     *
     * @param string $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data.
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set disable_check.
     *
     * @param boolean $disable_check
     *
     * @return $this
     */
    public function setDisableCheck($disable_check)
    {
        $this->disable_check = $disable_check;

        return $this;
    }

    /**
     * Get disable_check.
     *
     * @return boolean
     */
    public function getDisableCheck()
    {
        return $this->disable_check;
    }

    /**
     * Set api_url.
     *
     * @param string $apiUrl
     *
     * @return $this
     */
    public function setApiUrl($api_url)
    {
        $this->api_url = $api_url;

        return $this;
    }

    /**
     * Get api_url.
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * Set click_url.
     *
     * @param string $clickUrl
     *
     * @return $this
     */
    public function setClickUrl($click_url)
    {
        $this->click_url = $click_url;

        return $this;
    }

    /**
     * Get click_url.
     *
     * @return string
     */
    public function getClickUrl()
    {
        return $this->click_url;
    }

    /**
     * Set create_date.
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
     * Get create_date.
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set update_date.
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
     * Get update_date.
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }
}
