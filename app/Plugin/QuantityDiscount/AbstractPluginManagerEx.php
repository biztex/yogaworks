<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/30
 */

namespace Plugin\QuantityDiscount;


use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Migration;
use Doctrine\DBAL\Migrations\MigrationException;
use Doctrine\DBAL\Migrations\Version;
use Eccube\Plugin\AbstractPluginManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractPluginManagerEx extends AbstractPluginManager
{

    /**
     * @param array $meta
     * @param ContainerInterface $container
     * @param null $version
     * @throws MigrationException
     */
    protected function pluginMigration(array $meta, ContainerInterface $container, $version = null)
    {

        $migrationFilePath = __DIR__ . '/DoctrineMigrations';
        $connection = $container->get('database_connection');

        $pluginCode = $meta['code'];

        $config = new Configuration($connection);
        $config->setMigrationsNamespace('\Plugin\\' . $pluginCode . '\DoctrineMigrations');
        $config->setMigrationsDirectory($migrationFilePath);
        $config->registerMigrationsFromDirectory($migrationFilePath);
        $config->setMigrationsTableName(self::MIGRATION_TABLE_PREFIX . $pluginCode);

        /** @var Version $objVersion */
        foreach ($config->getMigrations() as $objVersion) {
            $versionMigration = $objVersion->getMigration();

            if ($versionMigration instanceof ContainerAwareInterface) {
                $versionMigration->setContainer($container);
            }
        }

        $migration = new Migration($config);
        $migration->migrate($version, false);
    }
}
