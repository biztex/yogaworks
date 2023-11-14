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


class RichEditorType
{
    const NONE = 0;
    const EDITOR = 1;
    const WYSIWYG = 2;
    const MARKDOWN = 3;

    static protected $names = array(
        self::NONE => '通常(デフォルト)',
        self::EDITOR => '簡易エディタ',
        self::WYSIWYG => 'WYSIWYG',
        self::MARKDOWN => 'Markdown'
    );

    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    static public function getName($type = null)
    {
        $names = array(
            self::NONE => new RichEditorType(self::NONE),
            self::EDITOR => new RichEditorType(self::EDITOR),
            self::WYSIWYG => new RichEditorType(self::WYSIWYG),
            self::MARKDOWN => new RichEditorType(self::MARKDOWN),
        );
        return is_null($type) ? $names : $type[$type];
    }

    static public function getSelectBox($type = null)
    {
        return [
            self::$names[RichEditorType::NONE] => RichEditorType::NONE,
            self::$names[RichEditorType::EDITOR] => RichEditorType::EDITOR,
            self::$names[RichEditorType::WYSIWYG] => RichEditorType::WYSIWYG,
            self::$names[RichEditorType::MARKDOWN] => RichEditorType::MARKDOWN,
        ];
    }

    static public function getDisplayName($type)
    {
        return self::$names[$type];
    }

}