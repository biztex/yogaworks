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

namespace Plugin\Securitychecker4\Tests;

use Eccube\Common\Constant;
use Eccube\Tests\EccubeTestCase;
use Plugin\Securitychecker4\Controller\ConfigController;
use Plugin\Securitychecker4\Entity\Config;
use Plugin\Securitychecker4\Repository\ConfigRepository;
use Plugin\Securitychecker4\Service\Securitychecker4Service;

class Securitychecker4Test extends EccubeTestCase
{
    /** @var ConfigController */
    protected $ConfigController;

    /** @var ConfigRepository */
    protected $ConfigRepository;

    /** @var Securitychecker4Service */
    protected $Securitychecker4Service;

    public function setUp()
    {
        parent::setUp();
        $this->ConfigController = self::$container->get(ConfigController::class);
        $this->ConfigRepository = $this->entityManager->getRepository(Config::class);
        $this->Securitychecker4Service = self::$container->get(Securitychecker4Service::class);
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('\Plugin\Securitychecker4\Repository\ConfigRepository', $this->ConfigRepository);
        $this->assertInstanceOf('\Plugin\Securitychecker4\Service\Securitychecker4Service', $this->Securitychecker4Service);
    }

    public function testSaveCheckResult()
    {
        $CheckResult = json_encode(['eccube_version' => Constant::VERSION]);
        $this->ConfigRepository->saveCheckResult($CheckResult);
    }

    public function testGetCheckResult()
    {
        $expected = ['eccube_version' => Constant::VERSION];
        $CheckResult = json_encode($expected);
        $this->ConfigRepository->saveCheckResult($CheckResult);

        $actual = $this->ConfigRepository->getCheckResult();

        $this->assertEquals($expected, $actual);
    }

    public function testGetSiteUrl()
    {
        $expected = 'http://localhost/';
        $actual = $this->Securitychecker4Service->getSiteUrl();

        $this->assertEquals($expected, $actual);
    }

    public function testCheckResources()
    {
        // 外部から閲覧可能な robots.txt を指定する
        $file = realpath(self::$container->getParameter('kernel.project_dir').'/robots.txt');

        $expected = '/robots.txt';
        $actual = $this->Securitychecker4Service->checkResources($file);

        $this->assertContains($expected, $actual);
    }

    public function testSearchResources()
    {
        // 外部から閲覧可能なパスを指定する
        $path = 'html';
        $expected = ['/html/template/admin/assets/js/function.js'];
        $actual = $this->Securitychecker4Service->searchResources($path);

        $this->assertEquals($expected, $actual);
    }

    public function testSearchResourcesWithFile()
    {
        // 外部から閲覧可能なファイルを指定する
        $path = '/html/template/admin/assets/js/file_manager.js';
        $expected = ['/html/template/admin/assets/js/file_manager.js'];
        $actual = $this->Securitychecker4Service->searchResources($path);

        $this->assertEquals($expected, $actual);
    }

    public function testPluginConfigs()
    {
        $actual = $this->Securitychecker4Service->parsePluginConfigs();
        $this->assertNotEmpty($actual);
    }
}
