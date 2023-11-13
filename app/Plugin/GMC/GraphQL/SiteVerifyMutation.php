<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\GMC\GraphQL;

use Eccube\Common\EccubeConfig;
use GraphQL\Type\Definition\Type;
use Plugin\Api\GraphQL\Mutation;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class SiteVerifyMutation implements Mutation
{
    /**
     * @var EccubeConfig
     */
    private $eccubeConfig;

    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    public function getName()
    {
        return 'gmc_save_verification_token';
    }

    public function getMutation()
    {
        return [
            'type' => Type::string(),
            'args' => [
                'token' => [
                    'type' => Type::nonNull(Type::string()),
                ],
            ],
            'resolve' => [$this, 'saveToken'],
        ];
    }

    public function saveToken($root, $args)
    {
        $content = 'google-site-verification: '.$args['token'];

        $fs = new Filesystem();
        $fs->dumpFile(
            $this->eccubeConfig['plugin_data_realdir'].'/GMC/google-site-verification.txt',
            $content
        );

        $yaml = Yaml::dump([
            'gmc_site_verification' => [
                'path' => '/'.$args['token'],
                'controller' => 'Plugin\GMC\Controller\SiteVerificationController::verifyUrl',
            ]
        ]);
        $fs->dumpFile(
            $this->eccubeConfig['plugin_data_realdir'].'/GMC/routes.yaml',
            $yaml);

        // キャッシュを全削除すると後続のAPI通信でシステムエラーが発生するため、ルーティングのみクリアする
        $this->clearRouting();

        return $content;
    }

    private function clearRouting()
    {
        if (env('APP_ENV') === 'prod') {
            $cacheDir = $this->eccubeConfig->get('kernel.cache_dir');
            $fs = new Filesystem();
            $fs->remove([
                // 4.1
                $cacheDir.'/UrlGenerator.php',
                $cacheDir.'/UrlGenerator.php.meta',
                $cacheDir.'/UrlMatcher.php',
                $cacheDir.'/UrlMatcher.php.meta',
                // 4.0
                $cacheDir.'/EccubeProdProjectContainerUrlGenerator.php',
                $cacheDir.'/EccubeProdProjectContainerUrlGenerator.php.meta',
                $cacheDir.'/EccubeProdProjectContainerUrlMatcher.php',
                $cacheDir.'/EccubeProdProjectContainerUrlMatcher.php.meta',
            ]);
        }
    }
}
