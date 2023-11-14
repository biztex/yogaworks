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


class ViewHelper
{

    static public function insertJs($source, $insertSource)
    {
        if (strpos($source, '{% block javascript %}') !== false) {
            $startPos = strpos($source, '{% block javascript %}') + strlen('{% block javascript %}');
            $prefixSource = substr($source, 0, $startPos);
            $suffixSource = substr($source, $startPos);
            return $prefixSource . $insertSource . $suffixSource;
        } else {
            $insertSource = PHP_EOL . '{% block javascript %}' . PHP_EOL . $insertSource . PHP_EOL . '{% endblock javascript %}';
            return $source . $insertSource;
        }
    }

    static public function insertCss($source, $insertSource)
    {
        if (strpos($source, '{% block stylesheet %}') !== false) {
            $startPos = strpos($source, '{% block stylesheet %}') + strlen('{% block stylesheet %}');
            $prefixSource = substr($source, 0, $startPos);
            $suffixSource = substr($source, $startPos);
            return $prefixSource . $insertSource . $suffixSource;
        } else {
            $insertSource = PHP_EOL . '{% block stylesheet %}' . PHP_EOL . $insertSource . PHP_EOL . '{% endblock stylesheet %}';
            return $source . $insertSource;
        }
    }
}