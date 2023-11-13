<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/21
 */

namespace Plugin\QuantityDiscount\Service\TwigRenderService\Content;


use Plugin\QuantityDiscount\Service\TwigRenderService\builder\base\ContentBlockBuilderInterface;

/**
 * Class InsertContentBlock
 */
class ContentBlock extends ContentBlockBase implements ContentBlockInterface
{

    /** @var string */
    private $insertTemplate = "";

    /** @var bool */
    private $insertInclude = false;

    /** @var string */
    private $targetId = "";

    /** @var string */
    private $insertScript = "";

    /** @var null|ContentBlock */
    private $subContentBlock = null;

    private $indexKey = "";

    /** @var integer */
    private $insertMode = 1;

    /** @var int after() */
    const INSERT_AFTER = 1;

    /** @var int append() */
    const INSERT_APPEND = 2;

    /** @var int wrap() */
    const INSERT_WRAP = 3;

    /** @var int replaceWith() */
    const INSERT_REPLACE = 4;

    /** @var int remove() */
    const INSERT_REMOVE = 5;

    /** @var int each(function () { }) */
    const INSERT_EACH = 9;

    /** @var int */
    const INSERT_DIRECT = 99;

    private $INSERT_KEYS = [
        self::INSERT_AFTER => 'after',
        self::INSERT_APPEND => 'append',
        self::INSERT_WRAP => 'wrap',
        self::INSERT_REPLACE => 'replaceWith',
        self::INSERT_REMOVE => 'remove',
    ];

    private $DIRECT_KEYS = [
        self::INSERT_DIRECT => '',
    ];

    /**
     * @return mixed
     */
    public function getInsertTemplate()
    {
        return $this->insertTemplate;
    }

    /**
     * @param mixed $insertTemplatePath
     * @param bool $include
     * @return ContentBlock
     */
    public function setInsertTemplate($insertTemplatePath, $include)
    {
        $this->insertTemplate = $insertTemplatePath;
        $this->insertInclude = $include;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * @param mixed $targetId
     * @return ContentBlock
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsertScript(): string
    {
        return $this->insertScript;
    }

    /**
     * @param string $insertScript
     * @return ContentBlock
     */
    public function setInsertScript(string $insertScript): ContentBlock
    {
        $this->insertScript = $insertScript;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInsertMode()
    {
        return $this->insertMode;
    }

    /**
     * @param mixed $insertMode
     * @return ContentBlock
     */
    public function setInsertMode($insertMode)
    {
        $this->insertMode = $insertMode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->getInsertTemplate();
    }

    /**
     * @return bool
     */
    public function isInclude()
    {
        return $this->insertInclude;
    }

    /**
     * @return ContentBlock|null
     */
    public function getSubContentBlock(): ?ContentBlock
    {
        return $this->subContentBlock;
    }

    /**
     * @param ContentBlock|null $subContentBlock
     * @return ContentBlock
     */
    public function setSubContentBlock(?ContentBlock $subContentBlock): ContentBlock
    {
        $this->subContentBlock = $subContentBlock;
        return $this;
    }

    /**
     * @return string
     */
    public function getIndexKey(): string
    {
        return $this->indexKey;
    }

    /**
     * @param string $indexKey
     * @return ContentBlock
     */
    public function setIndexKey(string $indexKey): ContentBlock
    {
        $this->indexKey = $indexKey;
        return $this;
    }

    /**
     * @param $options
     * @return string
     */
    public function renderScript($options = null)
    {

        $render = $this->getSearchRender();

        if (isset($this->INSERT_KEYS[$this->getInsertMode()])) {

            if (empty($this->getTargetId())) {
                if (is_null($this->getSubContentBlock())) {
                    $target = "";
                } else {
                    $target = $this->getSubContentBlock()->renderScript();
                }
            } else {
                $target = sprintf("$('#%s')", $this->getTargetId());
            }

            $render .= sprintf(".%s(%s);",
                $this->INSERT_KEYS[$this->getInsertMode()], $target);

            if (!empty($target)) {
                // 差し込み情報が存在する場合のみ
                $render = sprintf('if(%s.length) { %s }', $target, $render);
            }

        } elseif (isset($this->DIRECT_KEYS[$this->getInsertMode()])) {
            // 直接セット
            return $render;

        } else {
            $render .= ";";

        }

        return $render;
    }

    /**
     * @param ContentBlock[] $eachChildContentBlocks
     * @return string
     */
    public function eachRender(array $eachChildContentBlocks)
    {

        $results = [];

        foreach ($eachChildContentBlocks as $eachChildContentBlock) {
            // build漏れ考慮
            if ($eachChildContentBlock instanceof ContentBlockBuilderInterface) {
                $eachChildContentBlock = $eachChildContentBlock->build();
            }
            $results[] = $eachChildContentBlock->renderScript();
        }

        $result = implode(' ', $results);

        if (!empty($this->indexKey)) {
            $result .= sprintf('%s += 1;', $this->indexKey);
        }

        $render = ".each(function() { {$result} })";

        return $render;
    }

    /**
     * スクリプト情報
     *
     * @return string
     */
    public function getJavaScript()
    {
        return $this->getInsertScript();
    }
}
