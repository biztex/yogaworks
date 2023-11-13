<?php

namespace Plugin\ApgRichEditor\Entity;

use Doctrine\ORM\Mapping as ORM;
use Plugin\ApgRichEditor\Domain\RichEditorType;

/**
 * Config
 *
 * @ORM\Table(name="plg_apg_rich_editor_config")
 * @ORM\Entity(repositoryClass="Plugin\ApgRichEditor\Repository\ConfigRepository")
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
     * @var integer
     *
     * @ORM\Column(name="product_description_detail", type="integer", nullable=false, options={"default":0})
     */
    private $product_description_detail;
    /**
     * @var integer
     *
     * @ORM\Column(name="product_free_area", type="integer", nullable=false, options={"default":0})
     */
    private $product_free_area;
    /**
     * @var integer
     *
     * @ORM\Column(name="news_description", type="integer", nullable=false, options={"default":0})
     */
    private $news_description;
    /**
     * @var integer
     *
     * @ORM\Column(name="image_upload_type", type="integer", nullable=false, options={"default":0})
     */
    private $image_upload_type;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getProductDescriptionDetail(): ?int
    {
        return $this->product_description_detail;
    }

    /**
     * @param int $product_description_detail
     * @return Config
     */
    public function setProductDescriptionDetail(int $product_description_detail): Config
    {
        $this->product_description_detail = $product_description_detail;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductFreeArea(): ?int
    {
        return $this->product_free_area;
    }

    /**
     * @param int $product_free_area
     * @return Config
     */
    public function setProductFreeArea(int $product_free_area): Config
    {
        $this->product_free_area = $product_free_area;
        return $this;
    }

    /**
     * @return int
     */
    public function getNewsDescription(): ?int
    {
        return $this->news_description;
    }

    /**
     * @param int $news_description
     * @return Config
     */
    public function setNewsDescription(int $news_description): Config
    {
        $this->news_description = $news_description;
        return $this;
    }

    /**
     * @return int
     */
    public function getImageUploadType(): ?int
    {
        return $this->image_upload_type;
    }

    /**
     * @param int $image_upload_type
     * @return Config
     */
    public function setImageUploadType(int $image_upload_type): Config
    {
        $this->image_upload_type = $image_upload_type;
        return $this;
    }


    public function isEnableProductEditor()
    {
        return $this->product_description_detail === RichEditorType::EDITOR || $this->product_free_area === RichEditorType::EDITOR;
    }

    public function isEnableProductWysiwyg()
    {
        return $this->product_description_detail === RichEditorType::WYSIWYG || $this->product_free_area === RichEditorType::WYSIWYG;
    }

    public function isEnableProductMarkdown()
    {
        return $this->product_description_detail === RichEditorType::MARKDOWN || $this->product_free_area === RichEditorType::MARKDOWN;
    }

    public function isEnableNewsEditor()
    {
        return $this->news_description === RichEditorType::EDITOR;
    }

    public function isEnableNewsWysiwyg()
    {
        return $this->news_description === RichEditorType::WYSIWYG;
    }

    public function isEnableNewsMarkdown()
    {
        return $this->news_description === RichEditorType::MARKDOWN;
    }

}
