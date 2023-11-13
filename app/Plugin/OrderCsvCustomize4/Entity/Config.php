<?php

namespace Plugin\OrderCsvCustomize4\Entity;

use Doctrine\ORM\Mapping as ORM;

if (!class_exists('\Plugin\OrderCsvCustomize4\Entity\Config', false)) {
    /**
     * Config
     *
     * @ORM\Table(name="plg_order_csv_customize4_config")
     * @ORM\Entity(repositoryClass="Plugin\OrderCsvCustomize4\Repository\ConfigRepository")
     */
    class Config
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
         * @ORM\Column(name="name", type="string", length=255)
         */
        private $name;

        /**
         * @var string
         *
         * @ORM\Column(name="date_format", type="string", length=20, nullable=true)
         */
        private $date_format;

        /**
         * @var boolean
         *
         * @ORM\Column(name="is_integer", type="boolean", options={"default":true})
         */
        private $is_integer;

        /**
         * @return int
         */
        public function getId()
        {
            return $this->id;
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
         *
         * @return $this;
         */
        public function setName($name)
        {
            $this->name = $name;

            return $this;
        }

        public function setDateFormat($date_format){ $this->date_format = $date_format; return $this; }

        public function getDateFormat(){ return $this->date_format; }

        public function setIsInteger($is_integer){ $this->is_integer = $is_integer; return $this; }

        public function isIsInteger(){ return $this->is_integer; }
    }
}
