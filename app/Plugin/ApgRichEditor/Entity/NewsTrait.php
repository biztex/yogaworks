<?php

namespace Plugin\ApgRichEditor\Entity;


use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;

/**
 * @EntityExtension("Eccube\Entity\News")
 */
trait NewsTrait
{

    /**
     * 本文(Markdown)
     * @var string
     * @ORM\Column(name="plg_markdown_description", type="text", nullable=true)
     */
    private $plg_markdown_description;

    /**
     * @return string
     */
    public function getPlgMarkdownDescription(): ?string
    {
        return $this->plg_markdown_description;
    }

    /**
     * @param string $plg_markdown_description
     * @return NewsTrait
     */
    public function setPlgMarkdownDescription(?string $plg_markdown_description)
    {
        $this->plg_markdown_description = $plg_markdown_description;
        return $this;
    }


}