<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/21
 */

namespace Plugin\QuantityDiscount\Service\TwigRenderService\builder\base;


use Plugin\QuantityDiscount\Service\TwigRenderService\Content\ContentBlock;

/**
 * Class ContentBlockBuilderBase
 */
abstract class ContentBlockBuilder implements ContentBlockBuilderInterface
{

    /** @var ContentBlock */
    protected $contentBlock;

    /**
     * @param string $find
     * @return $this
     */
    public function find($find)
    {
        $this->contentBlock->addFind($find);
        return $this;
    }

    /**
     * @param integer $index
     * @return $this
     */
    public function eq($index)
    {
        $this->contentBlock->addEq($index);
        return $this;
    }

    /**
     * @return ContentBlock
     */
    public function build()
    {
        return $this->contentBlock;
    }
}
