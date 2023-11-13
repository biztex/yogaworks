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

use Silex\Application as BaseApplication;

/**
 * Trait ApgRichEditorTrait
 * @package Plugin\ApgRichEditor\Traits
 *
 * プラグインの共通処理
 */
class PluginUtil
{

    static public function pluginName()
    {
        $name = "apg_rich_editor";
        return $name;
    }

    static public function logicName($logicName)
    {
        return self::pluginName() . '.logic.' . $logicName;
    }

    static public function serviceName($serviceName)
    {
        return self::pluginName() . '.service.' . $serviceName;
    }

    static public function repositoryName($entityName)
    {
        return self::pluginName() . '.repository.' . $entityName;
    }

    static public function getPluginRepository(BaseApplication $app, $repositoryName)
    {
        $repositoryName = self::repositoryName($repositoryName);
        return $app[$repositoryName];
    }

}