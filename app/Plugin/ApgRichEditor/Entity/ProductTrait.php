<?php

namespace Plugin\ApgRichEditor\Entity;


use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
 * @EntityExtension("Eccube\Entity\Product")
 */
trait ProductTrait
{

    /**
     * 商品説明(Markdown)
     * @var string
     * @ORM\Column(name="plg_markdown_description_detail", type="string", length=4000, nullable=true)
     */
    private $plg_markdown_description_detail;


    /**
     * フリーエリア(Markdown)
     * @var string
     * @ORM\Column(name="plg_markdown_free_area", type="text", nullable=true)
     */
    private $plg_markdown_free_area;

    /**
     * @return string
     */
    public function getPlgMarkdownDescriptionDetail(): ?string
    {
        return $this->plg_markdown_description_detail;
    }

    /**
     * @param string $plg_markdown_description_detail
     * @return ProductTrait
     */
    public function setPlgMarkdownDescriptionDetail(?string $plg_markdown_description_detail)
    {
        $this->plg_markdown_description_detail = $plg_markdown_description_detail;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlgMarkdownFreeArea(): ?string
    {
        return $this->plg_markdown_free_area;
    }

    /**
     * @param string $plg_markdown_free_area
     * @return ProductTrait
     */
    public function setPlgMarkdownFreeArea(?string $plg_markdown_free_area)
    {
        $this->plg_markdown_free_area = $plg_markdown_free_area;
        return $this;
    }


}