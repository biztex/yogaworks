<?php

/*
 * This file is part of the ApgRichEditor
 *
 * Copyright (C) 2018 ARCHIPELAGO Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Plugin\ApgRichEditor\Domain;


class RichEditorTargetType
{
    const PRODUCT_DESCRIPTION_DETAIL = 11;
    const PRODUCT_FREE_AREA = 12;
    const NEWS_COMMENT = 21;

    static protected $names = array(
        self::PRODUCT_DESCRIPTION_DETAIL => '商品説明(商品管理)',
        self::PRODUCT_FREE_AREA => 'フリーエリア(商品管理)',
        self::NEWS_COMMENT => '本文(新着情報管理)',
    );

    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    static public function getName($type = null)
    {
        $names = array(
            self::PRODUCT_DESCRIPTION_DETAIL => new RichEditorTargetType(self::PRODUCT_DESCRIPTION_DETAIL),
            self::PRODUCT_FREE_AREA => new RichEditorTargetType(self::PRODUCT_FREE_AREA),
            self::NEWS_COMMENT => new RichEditorTargetType(self::NEWS_COMMENT),
        );
        return is_null($type) ? $names : $type[$type];
    }

    static public function getDisplayName($type)
    {
        return self::$names[$type];
    }

}