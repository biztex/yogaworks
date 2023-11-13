<?php

/*
 * Plugin Name: JoolenPromotionModal4
 *
 * Copyright(c) joolen inc. All Rights Reserved.
 *
 * https://www.joolen.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\JoolenPromotionModal4\Entity;

use Doctrine\ORM\Mapping as ORM;

if (!class_exists('\Plugin\JoolenPromotionModal4\Entity\PromotionModal', false)) {
    /**
     * Config
     *
     * @ORM\Table(name="plg_joolen_promotion_modal4_config")
     * @ORM\Entity(repositoryClass="Plugin\JoolenPromotionModal4\Repository\PromotionModalRepository")
     */
    class PromotionModal
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
         * @var string|null
         *
         * @ORM\Column(name="image", type="string", length=255, nullable=true)
         */
        private $image;

        /**
         * @var string|null
         *
         * @ORM\Column(name="description", type="text", nullable=true)
         */
        private $description;

        /**
         * @var string|null
         *
         * @ORM\Column(name="button_name", type="string", length=255, nullable=true)
         */
        private $button_name;

        /**
         * @var string|null
         *
         * @ORM\Column(name="url", type="string", length=4000, nullable=true)
         */
        private $url;

        /**
         * @var int|null
         *
         * @ORM\Column(name="interval_date", type="smallint", nullable=true, options={"unsigned":true})
         */
        private $interval_date;

        /**
         * @var boolean
         *
         * @ORM\Column(name="interval_unlimited", type="boolean", options={"default":false})
         */
        private $interval_unlimited = false;


        /**
         * @var boolean
         *
         * @ORM\Column(name="login_user_display", type="boolean", options={"default":false})
         */
        private $login_user_display = false;


        /**
         * @var boolean
         *
         * @ORM\Column(name="non_member_display", type="boolean", options={"default":false})
         */
        private $non_member_display = false;

        /**
         * @var boolean
         *
         * @ORM\Column(name="visible", type="boolean", options={"default":true})
         */
        private $visible;

        /**
         * @var \DateTime
         *
         * @ORM\Column(name="update_date", type="datetimetz")
         */
        private $update_date;

        /**
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set image.
         *
         * @param string|null $image
         *
         * @return $this;
         */
        public function setImage($image = null)
        {
            $this->image = $image;

            return $this;
        }

        /**
         * Get image.
         *
         * @return string|null
         */
        public function getImage()
        {
            return $this->image;
        }

        /**
         * Set description.
         *
         * @param string|null $description
         *
         * @return $this;
         */
        public function setDescription($description = null)
        {
            $this->description = $description;

            return $this;
        }

        /**
         * Get description.
         *
         * @return string|null
         */
        public function getDescription()
        {
            return $this->description;
        }

        /**
         * Set buttonName.
         *
         * @param string|null $buttonName
         *
         * @return $this;
         */
        public function setButtonName($buttonName = null)
        {
            $this->button_name = $buttonName;

            return $this;
        }

        /**
         * Get buttonName.
         *
         * @return string|null
         */
        public function getButtonName()
        {
            return $this->button_name;
        }

        /**
         * Set url.
         *
         * @param string|null $url
         *
         * @return $this;
         */
        public function setUrl($url = null)
        {
            $this->url = $url;

            return $this;
        }

        /**
         * Get url.
         *
         * @return string|null
         */
        public function getUrl()
        {
            return $this->url;
        }
        /**
         * Set intervalDate.
         *
         * @param int|null $intervalDate
         *
         * @return $this;
         */
        public function setIntervalDate($intervalDate = null)
        {
            $this->interval_date = $intervalDate;

            return $this;
        }

        /**
         * Get intervalDate.
         *
         * @return int|null
         */
        public function getIntervalDate()
        {
            return $this->interval_date;
        }

        /**
         * Set intervalUnlimited.
         *
         * @param boolean $intervalUnlimited
         *
         * @return $this
         */
        public function setIntervalUnlimited($intervalUnlimited)
        {
            $this->interval_unlimited = $intervalUnlimited;

            return $this;
        }

        /**
         * Get intervalUnlimited.
         *
         * @return boolean
         */
        public function isIntervalUnlimited()
        {
            return $this->interval_unlimited;
        }

        /**
         * Set loginUserDisplay.
         *
         * @param integer $loginUserDisplay
         *
         * @return $this;
         */
        public function setLoginUserDisplay($loginUserDisplay)
        {
            $this->login_user_display = $loginUserDisplay;

            return $this;
        }

        /**
         * Get loginUserDisplay.
         *
         * @return boolean
         */
        public function isLoginUserDisplay()
        {
            return $this->login_user_display;
        }

        /**
         * Set nonMemberDisplay.
         *
         * @param integer $nonMemberDisplay
         *
         * @return $this;
         */
        public function setNonMemberDisplay($nonMemberDisplay)
        {
            $this->non_member_display = $nonMemberDisplay;

            return $this;
        }

        /**
         * Get nonMemberDisplay.
         *
         * @return boolean
         */
        public function isNonMemberDisplay()
        {
            return $this->non_member_display;
        }

        /**
         * @return integer
         */
        public function isVisible()
        {
            return $this->visible;
        }

        /**
         * @param boolean $visible
         *
         * @return $this;
         */
        public function setVisible($visible)
        {
            $this->visible = $visible;

            return $this;
        }

        /**
         * Set updateDate.
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
         * Get updateDate.
         *
         * @return \DateTime
         */
        public function getUpdateDate()
        {
            return $this->update_date;
        }
    }
}
