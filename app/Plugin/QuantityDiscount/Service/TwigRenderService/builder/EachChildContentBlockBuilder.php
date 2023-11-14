<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/23
 */

namespace Plugin\QuantityDiscount\Service\TwigRenderService\builder;


use Plugin\QuantityDiscount\Service\TwigRenderService\builder\base\EachContentBlockBuilderBase;
use Plugin\QuantityDiscount\Service\TwigRenderService\Content\ContentBlock;
use Plugin\QuantityDiscount\Service\TwigRenderService\Content\ContentBlockInterface;

class EachChildContentBlockBuilder extends EachContentBlockBuilderBase
{

    public function __construct()
    {
        parent::__construct();

        $subContentBlock = new ContentBlock();
        $subContentBlock->setInsertMode(ContentBlock::INSERT_DIRECT);
        $this->contentBlock->setSubContentBlock($subContentBlock);
    }

    /**
     * data属性から取得したkeyを利用したfind
     *
     * let dataTargetId = $(this).data('{$dataKey}');
     * $('{$find}' + dataTargetId)
     * or
     * .find('{$find}' + dataTargetId)
     *
     * @param $find
     * @param $dataKey
     * @return $this
     */
    public function findAndDataKey($find, $dataKey)
    {
        $this->contentBlock
            ->addFirstSearch([
                'script' => sprintf("let dataTargetId = $(this).data('%s');", $dataKey)
            ]);

        $this->contentBlock->addFindDataKey($find);

        return $this;
    }

    /**
     * each
     *
     * @param ContentBlockInterface|array $contentBlocks
     * @return $this|EachContentBlockBuilderBase
     */
    public function each($contentBlocks)
    {
        parent::each($contentBlocks);
        // eachが設定された場合はmodeをeachに設定
        $this->contentBlock->setInsertMode(ContentBlock::INSERT_EACH);

        return $this;
    }

    /**
     * $(this) 利用
     *
     * @return $this
     */
    public function findThis()
    {
        $this->contentBlock->addSearch('first_find', '$(this)');
        return $this;
    }

    /**
     * 挿入ターゲットの抽出
     *
     * @return $this
     */
    public function targetFindThis()
    {
        $this->contentBlock->getSubContentBlock()->addSearch('first_find', "$(this)");
        return $this;
    }

    /**
     * 挿入ターゲットなし（クリア用）
     *
     * @return $this
     */
    public function targetFindNone()
    {
        $this->contentBlock->getSubContentBlock()->addSearch('first_find', "''");
        return $this;
    }

    /**
     * ループ値を用いた挿入ターゲットの抽出
     *
     * @param $find
     * @param $indexKey
     * @return $this
     */
    public function targetFindAndIndexKey($find, $indexKey)
    {
        $this->contentBlock->getSubContentBlock()->addFindIndexKey($find, $indexKey);
        return $this;
    }

    /**
     * 挿入ターゲットfind
     *
     * @param $subFind
     * @return $this
     */
    public function targetFind($subFind)
    {
        $this->contentBlock->getSubContentBlock()->addFind($subFind);
        return $this;
    }

    /**
     * 挿入ターゲットeq
     *
     * @param $subIndex
     * @return $this
     */
    public function targetEq($subIndex)
    {
        $this->contentBlock->getSubContentBlock()->addEq($subIndex);
        return $this;
    }


    /**
     * @return $this jQuery after()
     */
    public function setInsertModeAfter()
    {
        $this->contentBlock->setInsertMode(ContentBlock::INSERT_AFTER);
        return $this;
    }

    /**
     * @return $this jQuery append()
     */
    public function setInsertModeAppend()
    {
        $this->contentBlock->setInsertMode(ContentBlock::INSERT_APPEND);
        return $this;
    }

    /**
     * @return $this jQuery wrap()
     */
    public function setInsertModeWrap()
    {
        $this->contentBlock->setInsertMode(ContentBlock::INSERT_WRAP);
        return $this;
    }

    /**
     * @return $this jQuery replaceWith()
     */
    public function setInsertModeReplaceWith()
    {
        $this->contentBlock->setInsertMode(ContentBlock::INSERT_REPLACE);
        return $this;
    }

    /**
     * @return $this jQuery remove()
     */
    public function setInsertModeRemove()
    {
        $this->contentBlock->setInsertMode(ContentBlock::INSERT_REMOVE);
        return $this;
    }
}
