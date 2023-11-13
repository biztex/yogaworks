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

namespace Plugin\GMC\Tests\GraphQL;


use Eccube\Tests\EccubeTestCase;
use Plugin\GMC\GraphQL\SiteVerifyMutation;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class SiteVerifyMutationTest extends EccubeTestCase
{
    private $verificationFile;
    private $routeFile;
    private $fs;

    public function setUp()
    {
        parent::setUp();

        $this->verificationFile = $this->eccubeConfig['plugin_data_realdir'] . '/GMC/google-site-verification.txt';
        $this->routeFile = $this->eccubeConfig['plugin_data_realdir'] . '/GMC/routes.yaml';

        $this->fs = new Filesystem();
        $this->fs->remove($this->verificationFile);
        $this->fs->dumpFile($this->routeFile, '');
    }

    public function tearDown()
    {
        $this->fs->remove($this->verificationFile);
        $this->fs->dumpFile($this->routeFile, '');

        parent::tearDown();
    }

    public function testSaveToken()
    {
        $token = 'google9hd23l8fmpwee7f7.html';

        $root = '';
        $args = ['token' => $token];

        $mutation = new SiteVerifyMutation($this->eccubeConfig);
        $mutation->saveToken($root, $args);

        self::assertTrue($this->fs->exists($this->verificationFile));
        $actualToken = file_get_contents($this->verificationFile);
        $actualToken = str_replace('google-site-verification: ', '', $actualToken);
        self::assertSame($token, $actualToken);

        $route = Yaml::parse(file_get_contents($this->routeFile));
        self::assertSame([
            'gmc_site_verification' => [
                'path' => '/'.$token,
                'controller' => 'Plugin\GMC\Controller\SiteVerificationController::verifyUrl'
            ]
        ], $route);
    }
}
