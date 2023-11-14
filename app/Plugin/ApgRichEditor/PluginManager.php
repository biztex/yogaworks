<?php

/*
 * Copyright(c) 2018 GMO Payment Gateway, Inc. All rights reserved.
 * http://www.gmo-pg.com/
 */

namespace Plugin\ApgRichEditor;

use Eccube\Plugin\AbstractPluginManager;
use Eccube\Service\PluginService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PluginManager extends AbstractPluginManager
{

    /**
     * {@inheritdoc}
     */
    public function install(array $meta, ContainerInterface $container)
    {
        /** @var PluginService $pluginService */
        $pluginService = $container->get(PluginService::class);
        $pluginService->copyAssets('ApgRichEditor');
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(array $meta, ContainerInterface $container)
    {
        /** @var PluginService $pluginService */
        $pluginService = $container->get(PluginService::class);
        $pluginService->removeAssets('ApgRichEditor');
    }


    /**
     * Update the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function update(array $meta, ContainerInterface $container)
    {
        /** @var PluginService $pluginService */
        $pluginService = $container->get(PluginService::class);
        $pluginService->removeAssets('ApgRichEditor');
        $pluginService->copyAssets('ApgRichEditor');
    }
}
