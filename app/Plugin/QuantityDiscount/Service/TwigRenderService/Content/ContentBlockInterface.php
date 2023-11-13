<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/21
 */

namespace Plugin\QuantityDiscount\Service\TwigRenderService\Content;


/**
 * Interface ContentBlockInterface
 */
interface ContentBlockInterface
{
    /**
     * コード挿入用スクリプト生成
     *
     * @param array $options
     * @return string
     */
    public function renderScript($options = null);

    /**
     * テンプレート情報
     *
     * @return string
     */
    public function getTemplate();

    /**
     * @return string
     */
    public function getTargetId();

    /**
     * テンプレート読み込み方式
     *
     * @return bool true:include, false:直接表示
     */
    public function isInclude();

    /**
     * スクリプト情報
     *
     * @return string
     */
    public function getJavaScript();
}
