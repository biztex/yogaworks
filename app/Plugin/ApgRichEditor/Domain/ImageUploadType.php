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


class ImageUploadType
{
    const NORMAL = 0;
    const EL_FINDER = 1;

    static protected $names = array(
        self::NORMAL => '簡易版',
        self::EL_FINDER => 'elFinder',
    );

    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    static public function getName($type = null)
    {
        $names = array(
            self::NORMAL => new RichEditorType(self::NORMAL),
            self::EL_FINDER => new RichEditorType(self::EL_FINDER),
        );
        return is_null($type) ? $names : $type[$type];
    }

    static public function getSelectBox($type = null)
    {
        return [
            self::$names[ImageUploadType::NORMAL] => ImageUploadType::NORMAL,
            self::$names[ImageUploadType::EL_FINDER] => ImageUploadType::EL_FINDER,
        ];
    }

    static public function getDisplayName($type)
    {
        return self::$names[$type];
    }

}