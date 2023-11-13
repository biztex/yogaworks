<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/21
 */

namespace Plugin\QuantityDiscount\Service\TwigRenderService\Content;


/**
 * Class ContentBlockBase
 */
abstract class ContentBlockBase
{
    protected $contentSearches;

    public function __construct()
    {
        $this->contentSearches = [];
    }

    /**
     * 探索条件チェック
     *
     * @return bool true:有り
     */
    public function hasContentSearch()
    {
        return (count($this->contentSearches) > 0);
    }

    /**
     * 探索条件クリア
     *
     * @param null $index
     */
    public function clearContentSearches($index = null)
    {
        if(is_null($index)) {
            $this->contentSearches = [];
        } else {
            unset($this->contentSearches[$index]);
        }
    }

    /**
     * @param $firstSearch
     */
    public function addFirstSearch($firstSearch)
    {
        array_unshift($this->contentSearches, $firstSearch);
    }

    /**
     * @param $key
     * @param $value
     */
    public function addSearch($key, $value)
    {
        $this->contentSearches[][$key] = $value;
    }

    /**
     * @param $find
     */
    public function addFind($find)
    {
        $this->contentSearches[]['find'] = $find;
    }

    /**
     * @param $index
     */
    public function addEq($index)
    {
        $this->contentSearches[]['index'] = $index;
    }

    /**
     * @param ContentBlockInterface|array $contentBlocks
     */
    public function addEach($contentBlocks)
    {
        if(is_array($contentBlocks)) {
            $this->contentSearches[]['each'] = $contentBlocks;
        } else {
            $contentBlock = $contentBlocks;
            $this->contentSearches[]['each'] = [$contentBlock];
        }
    }

    /**
     * @param $findDataKey
     */
    public function addFindDataKey($findDataKey)
    {
        $this->contentSearches[]['find_data_key'] = $findDataKey;
    }

    /**
     * @param $find
     * @param $indexKey
     */
    public function addFindIndexKey($find, $indexKey)
    {
        $this->contentSearches[]['find_data_index'] = [
            'find' => $find,
            'indexKey' => $indexKey
        ];
    }

    /**
     * @return string
     */
    protected function getSearchRender()
    {
        $render = "";

        $firstFind = true;

        foreach ($this->contentSearches as $key => $contentSearch) {

            $key = array_keys($contentSearch)[0];

            switch ($key) {
                case 'find':
                    $find = $contentSearch[$key];
                    if($firstFind) {
                        $render .= sprintf("$('%s')", $find);
                        $firstFind = false;
                    } else {
                        $render .= sprintf(".find('%s')", $find);
                    }
                    break;
                case 'first_find':
                    $render .= $contentSearch[$key];
                    $firstFind = false;
                    break;
                case 'index':
                    $render .= sprintf(".eq(%d)", $contentSearch[$key]);
                    break;
                case 'each':
                    $render .= $this->eachRender($contentSearch[$key]);
                    break;
                case 'find_data_key':
                    $find = $contentSearch[$key];
                    if($firstFind) {
                        $render .= sprintf("$('%s' + dataTargetId)", $find);
                        $firstFind = false;
                    } else {
                        $render .= sprintf(".find('%s' + dataTargetId)", $find);
                    }
                    break;
                case 'find_data_index':
                    $find = $contentSearch[$key]['find'];
                    $indexKey = $contentSearch[$key]['indexKey'];
                    if($firstFind) {
                        $render .= sprintf("$('%s' + %s)", $find, $indexKey);
                        $firstFind = false;
                    } else {
                        $render .= sprintf(".find('%s' + %s)", $find, $indexKey);
                    }
                    break;
                default:
                    $render .= $contentSearch[$key];
                    break;
            }

        }

        return $render;
    }

    abstract protected function eachRender(array $eachChildContentBlocks);

}
