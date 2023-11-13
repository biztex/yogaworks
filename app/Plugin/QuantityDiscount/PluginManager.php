<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/30
 */

namespace Plugin\QuantityDiscount;


use Doctrine\DBAL\Migrations\MigrationException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PluginManager extends AbstractPluginManagerEx
{

    /**
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function install(array $meta, ContainerInterface $container)
    {

    }

    /**
     * @param array $meta
     * @param ContainerInterface $container
     * @throws MigrationException
     */
    public function uninstall(array $meta, ContainerInterface $container)
    {
        $this->pluginMigration($meta, $container, 0);
    }

    /**
     *
     * @param array $meta
     * @param ContainerInterface $container
     * @throws MigrationException
     */
    public function enable(array $meta, ContainerInterface $container)
    {
        $this->pluginMigration($meta, $container);
    }

//    /**
//     * TODO: デバッグ用
//     *
//     * @param array $meta
//     * @param ContainerInterface $container
//     * @throws MigrationException
//     */
//    public function disable(array $meta, ContainerInterface $container)
//    {
//        $this->pluginMigration($meta, $container, 0);
//    }
}
