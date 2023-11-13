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

namespace Plugin\MailMagazine4\Test\Util;

use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\Paginator;
use Plugin\MailMagazine4\Tests\AbstractMailMagazineTestCase;
use Plugin\MailMagazine4\Service\MailMagazineService;
use Plugin\MailMagazine4\Event\MailMagazineHistoryFilePaginationSubscriber;

class MailMagazineHistoryFilePaginationSubscriberTest extends AbstractMailMagazineTestCase
{
    private $rootDir;

    public function setUp()
    {
        parent::setUp();
        $this->rootDir = sys_get_temp_dir().'/MailMagazineHistoryFilePaginationSubscriberTest';
        if (!file_exists($this->rootDir)) {
            mkdir($this->rootDir);
        }
        self::$container->get(MailMagazineService::class)->setMailMagazineDir($this->rootDir);
    }

    public function tearDown()
    {
        foreach (glob($this->rootDir.'/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($this->rootDir);
        parent::tearDown();
    }

    public function test_ファイルがないときは0件()
    {
        $file = $this->file();
        self::assertEquals(false, file_exists($file));

        $actual = $this->newPagination($file, 1, 10, 10);
        self::assertEquals(0, $actual->getTotalItemCount());
    }

    public function test_1ページ目()
    {
        $file = $this->file();
        file_put_contents($file,
            '1,0,0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
            '1,1,1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
            '1,2,2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
            '1,3,3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
            '1,4,4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL.
            '1,5,5_create_mail_magazine_history@example.com,name01_5 name02_5'.PHP_EOL.
            '1,6,6_create_mail_magazine_history@example.com,name01_6 name02_6'.PHP_EOL.
            '1,7,7_create_mail_magazine_history@example.com,name01_7 name02_7'.PHP_EOL.
            '1,8,8_create_mail_magazine_history@example.com,name01_8 name02_8'.PHP_EOL.
            '1,9,9_create_mail_magazine_history@example.com,name01_9 name02_9'.PHP_EOL
        );

        $actual = $this->newPagination($file, 1, 4, 10);
        self::assertEquals(10, $actual->getTotalItemCount());
        self::assertEquals(
            [
                ['status' => '1', 'customerId' => '0', 'email' => '0_create_mail_magazine_history@example.com', 'name' => 'name01_0 name02_0'],
                ['status' => '1', 'customerId' => '1', 'email' => '1_create_mail_magazine_history@example.com', 'name' => 'name01_1 name02_1'],
                ['status' => '1', 'customerId' => '2', 'email' => '2_create_mail_magazine_history@example.com', 'name' => 'name01_2 name02_2'],
                ['status' => '1', 'customerId' => '3', 'email' => '3_create_mail_magazine_history@example.com', 'name' => 'name01_3 name02_3'],
            ],
            $actual->getItems()
        );
    }

    public function test_2ページ目()
    {
        $file = $this->file();
        file_put_contents($file,
            '1,0,0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
            '1,1,1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
            '1,2,2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
            '1,3,3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
            '1,4,4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL.
            '1,5,5_create_mail_magazine_history@example.com,name01_5 name02_5'.PHP_EOL.
            '1,6,6_create_mail_magazine_history@example.com,name01_6 name02_6'.PHP_EOL.
            '1,7,7_create_mail_magazine_history@example.com,name01_7 name02_7'.PHP_EOL.
            '1,8,8_create_mail_magazine_history@example.com,name01_8 name02_8'.PHP_EOL.
            '1,9,9_create_mail_magazine_history@example.com,name01_9 name02_9'.PHP_EOL
        );

        $actual = $this->newPagination($file, 2, 4, 10);
        self::assertEquals(10, $actual->getTotalItemCount());
        self::assertEquals(
            [
                ['status' => '1', 'customerId' => '4', 'email' => '4_create_mail_magazine_history@example.com', 'name' => 'name01_4 name02_4'],
                ['status' => '1', 'customerId' => '5', 'email' => '5_create_mail_magazine_history@example.com', 'name' => 'name01_5 name02_5'],
                ['status' => '1', 'customerId' => '6', 'email' => '6_create_mail_magazine_history@example.com', 'name' => 'name01_6 name02_6'],
                ['status' => '1', 'customerId' => '7', 'email' => '7_create_mail_magazine_history@example.com', 'name' => 'name01_7 name02_7'],
            ],
            $actual->getItems()
        );
    }

    public function test_最終ページ()
    {
        $file = $this->file();
        file_put_contents($file,
            '1,0,0_create_mail_magazine_history@example.com,name01_0 name02_0'.PHP_EOL.
            '1,1,1_create_mail_magazine_history@example.com,name01_1 name02_1'.PHP_EOL.
            '1,2,2_create_mail_magazine_history@example.com,name01_2 name02_2'.PHP_EOL.
            '1,3,3_create_mail_magazine_history@example.com,name01_3 name02_3'.PHP_EOL.
            '1,4,4_create_mail_magazine_history@example.com,name01_4 name02_4'.PHP_EOL.
            '1,5,5_create_mail_magazine_history@example.com,name01_5 name02_5'.PHP_EOL.
            '1,6,6_create_mail_magazine_history@example.com,name01_6 name02_6'.PHP_EOL.
            '1,7,7_create_mail_magazine_history@example.com,name01_7 name02_7'.PHP_EOL.
            '1,8,8_create_mail_magazine_history@example.com,name01_8 name02_8'.PHP_EOL.
            '1,9,9_create_mail_magazine_history@example.com,name01_9 name02_9'.PHP_EOL
        );

        $actual = $this->newPagination($file, 3, 4, 10);
        self::assertEquals(10, $actual->getTotalItemCount());
        self::assertEquals(
            [
                ['status' => '1', 'customerId' => '8', 'email' => '8_create_mail_magazine_history@example.com', 'name' => 'name01_8 name02_8'],
                ['status' => '1', 'customerId' => '9', 'email' => '9_create_mail_magazine_history@example.com', 'name' => 'name01_9 name02_9'],
            ],
            $actual->getItems()
        );
    }

    /**
     * @param $file
     * @param $page
     * @param $limit
     * @param $total
     *
     * @return AbstractPagination
     */
    private function newPagination($file, $page, $limit, $total)
    {
        $paginator = new Paginator();
        $paginator->subscribe(self::$container->get(MailMagazineHistoryFilePaginationSubscriber::class));

        return $paginator->paginate($file, $page, $limit, ['total' => $total]);
    }

    private function file($name = 'out.txt')
    {
        return $this->rootDir.'/'.$name;
    }
}
