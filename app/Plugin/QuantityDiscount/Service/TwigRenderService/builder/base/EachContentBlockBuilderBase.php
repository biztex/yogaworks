<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/26
 */

namespace Plugin\QuantityDiscount\Service\TwigRenderService\builder\base;


use Plugin\QuantityDiscount\Service\TwigRenderService\Content\ContentBlock;
use Plugin\QuantityDiscount\Service\TwigRenderService\Content\ContentBlockInterface;

class EachContentBlockBuilderBase extends ContentBlockBuilder
{

    public function __construct()
    {
        $this->contentBlock = new ContentBlock();
    }

    /**
     * @param ContentBlockInterface|array $contentBlocks
     * @return $this
     */
    public function each($contentBlocks)
    {
        $this->contentBlock->addEach($contentBlocks);
        return $this;
    }

    /**
     * @param $indexKey
     * @return $this
     */
    public function setEachIndexKey($indexKey)
    {
        $this->contentBlock->setIndexKey($indexKey);

        $this->contentBlock->addFirstSearch([
            'script' => sprintf('let %s = 0;', $indexKey)
        ]);

        return $this;
    }
}
