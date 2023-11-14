<?php

/*
 * This file is part of the ApgRichEditor
 *
 * Copyright (C) 2018 ARCHIPELAGO Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ApgRichEditor\Util;


use Eccube\Common\EccubeConfig;

/**
 * プラグインで必要なパス情報をまとめたクラス
 * Class Paths
 * @package Plugin\ApgRichEditor\Util
 */
class Paths
{

    private $eccubeConfig;

    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }


    /**
     * プラグインで利用する画像を保存するベースとなる物理パスを返す
     * @param null $app
     * @return string
     */
    public function editorImageBasePath()
    {
        $baseFilePath = $this->eccubeConfig->get('eccube_save_image_dir');
        return rtrim($baseFilePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

    }

    /**
     * 画像を保存する物理パスを返す
     * @param $prefix
     * @param bool $temporary 一時保存のバスを設定する場合は、trueを指定
     * @return string
     */
    public function editorImagesRealPath($prefix, $temporary = false)
    {
        if ($temporary) {
            return 'rich_editor' . DIRECTORY_SEPARATOR . $prefix . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
        } else {
            return 'rich_editor' . DIRECTORY_SEPARATOR . $prefix . DIRECTORY_SEPARATOR;
        }
    }


    /**
     * 画像を保存するURLを返す
     * @param $prefix
     * @param bool $temporary 一時保存のバスを設定する場合は、trueを指定
     * @return string
     */
    public function editorImagesUrl($prefix, $fileName, $temporary = false)
    {
        if ($temporary) {
            return '/rich_editor/' . $prefix . '/temp/' . $fileName;
        } else {
            return '/rich_editor/' . $prefix . '/' . $fileName;
        }
    }

}