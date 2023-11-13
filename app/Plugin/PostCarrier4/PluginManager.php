<?php

/*
 * This file is part of PostCarrier for EC-CUBE
 *
 * Copyright(c) IPLOGIC CO.,LTD. All Rights Reserved.
 *
 * http://www.iplogic.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\PostCarrier4;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\Constant;
use Eccube\Entity\Block;
use Eccube\Entity\BlockPosition;
use Eccube\Entity\Layout;
use Eccube\Entity\Master\DeviceType;
use Eccube\Entity\Page;
use Eccube\Entity\PageLayout;
use Eccube\Plugin\AbstractPluginManager;
use Eccube\Repository\BlockPositionRepository;
use Eccube\Repository\BlockRepository;
use Eccube\Repository\LayoutRepository;
use Eccube\Repository\Master\DeviceTypeRepository;
use Eccube\Repository\PageRepository;
use Plugin\PostCarrier4\Entity\PostCarrierConfig;
use Plugin\PostCarrier4\Entity\PostCarrierGroup;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

class PluginManager extends AbstractPluginManager
{
    /**
     * @var array 追加ページ
     */
    private $urls = [
        'postcarrier_subscribe_complete' => '[ポストキャリア]メルマガ会員登録完了ページ',
        'postcarrier_unsubscribe_complete' => '[ポストキャリア]メルマガ会員解除完了ページ',
        'postcarrier_unsubscribe' => '[ポストキャリア]メール配信停止',
    ];

    /**
     * @var string コピー元ブロックファイル
     */
    private $originBlock;

    /**
     * @var string ブロック名
     */
    private $blockName = '[ポストキャリア]メルマガ会員登録解除';

    /**
     * @var string ブロックファイル名
     */
    private $blockFileName = 'postcarrier_mailmaga_block';

    /**
     * PluginManager constructor.
     */
    public function __construct()
    {
        $this->srcRoutesFile = __DIR__ . '/Resource/config/routes.yaml_';
        $this->dstRoutesFile = '/app/config/eccube/routes/postcarrier_routes.yaml';

        $this->originBlock = __DIR__.'/Resource/template/Block/'.$this->blockFileName.'.twig';
    }

    public function enable(array $meta, ContainerInterface $container)
    {
        $projectDir = $container->getParameter('kernel.project_dir');
        $em = $container->get('doctrine')->getManager();

        // メルマガ会員グループを作成
        $this->createMailmagaGroup($em);

        $this->copyBlock($container);
        $Block = $em->getRepository(Block::class)->findOneBy(['file_name' => $this->blockFileName]);
        if (is_null($Block)) {
            // pagelayoutの作成
            $this->createDataBlock($container);
        }

        // ページを追加
        foreach ($this->urls as $url => $name) {
            $Page = $em->getRepository(Page::class)->findOneBy(['url' => $url]);
            if (null === $Page) {
                $this->createPage($em, $name, $url);
            }
        }

        // routes.yaml をコピー
        if (strncmp(Constant::VERSION, "4.0", 3) === 0) {
            $fs = new Filesystem();
            $fs->copy($this->srcRoutesFile, $projectDir.$this->dstRoutesFile);
        }
    }

    public function disable(array $meta, ContainerInterface $container)
    {
        $projectDir = $container->getParameter('kernel.project_dir');

        // routes.yaml を削除
        $fs = new Filesystem();
        $r = $fs->remove($projectDir.$this->dstRoutesFile);
    }

    public function uninstall(array $meta, ContainerInterface $container)
    {
        $em = $container->get('doctrine.orm.entity_manager');

        // ブロックの削除
        $this->removeDataBlock($container); // DB
        $this->removeBlock($container);     // filesystem

        // ページを削除
        foreach ($this->urls as $url => $name) {
            $this->removePage($em, $url);
        }
    }

    protected function createMailmagaGroup(EntityManagerInterface $em)
    {
        $Group = $em->find(PostCarrierGroup::class, 1);
        if ($Group) {
            return;
        }
        $Group = new PostCarrierGroup();
        $Group->setGroupName('メールアドレスのみ会員グループ');
        $Group->setUpdateDate(new \DateTime());
        $em->persist($Group);
        $em->flush($Group);
    }

    protected function createPage(EntityManagerInterface $em, $name, $url)
    {
        $Page = new Page();
        $Page->setEditType(Page::EDIT_TYPE_DEFAULT);
        $Page->setName($name);
        $Page->setUrl($url);
        $Page->setFileName('PostCarrier4/Resource/template/Mailmaga/'.$url);

        // DB登録
        $em->persist($Page);
        $em->flush($Page);
        $Layout = $em->find(Layout::class, Layout::DEFAULT_LAYOUT_UNDERLAYER_PAGE);
        $PageLayout = new PageLayout();
        $PageLayout->setPage($Page)
            ->setPageId($Page->getId())
            ->setLayout($Layout)
            ->setLayoutId($Layout->getId())
            ->setSortNo(0);
        $em->persist($PageLayout);
        $em->flush($PageLayout);
    }

    protected function removePage(EntityManagerInterface $em, $url)
    {
        $Page = $em->getRepository(Page::class)->findOneBy(['url' => $url]);

        if (!$Page) {
            return;
        }
        foreach ($Page->getPageLayouts() as $PageLayout) {
            $em->remove($PageLayout);
            $em->flush($PageLayout);
        }

        $em->remove($Page);
        $em->flush($Page);
    }

    /**
     * ブロックを登録.
     *
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    private function createDataBlock(ContainerInterface $container)
    {
        $em = $container->get('doctrine')->getManager();
        $DeviceType = $em->getRepository(DeviceType::class)->find(DeviceType::DEVICE_TYPE_PC);

        try {
            /** @var Block $Block */
            $Block = $em->getRepository(Block::class)->newBlock($DeviceType);

            // Blockの登録
            $Block->setName($this->blockName)
                ->setFileName($this->blockFileName)
                ->setUseController(true)
                ->setDeletable(false);
            $em->persist($Block);
            $em->flush($Block);

            // // check exists block position
            // $blockPos = $container->get(BlockPositionRepository::class)->findOneBy(['Block' => $Block]);
            // if ($blockPos) {
            //     return;
            // }

            // // BlockPositionの登録
            // $blockPos = $container->get(BlockPositionRepository::class)->findOneBy(
            //     ['section' => Layout::TARGET_ID_MAIN_BOTTOM, 'layout_id' => Layout::DEFAULT_LAYOUT_UNDERLAYER_PAGE],
            //     ['block_row' => 'DESC']
            // );

            // $BlockPosition = new BlockPosition();

            // // ブロックの順序を変更
            // $BlockPosition->setBlockRow(1);
            // if ($blockPos) {
            //     $blockRow = $blockPos->getBlockRow() + 1;
            //     $BlockPosition->setBlockRow($blockRow);
            // }

            // $LayoutDefault = $container->get(LayoutRepository::class)->find(Layout::DEFAULT_LAYOUT_UNDERLAYER_PAGE);

            // $BlockPosition->setLayout($LayoutDefault)
            //     ->setLayoutId($LayoutDefault->getId())
            //     ->setSection(Layout::TARGET_ID_MAIN_BOTTOM)
            //     ->setBlock($Block)
            //     ->setBlockId($Block->getId());

            // $em->persist($BlockPosition);
            // $em->flush($BlockPosition);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * ブロックを削除.
     *
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    private function removeDataBlock(ContainerInterface $container)
    {
        $em = $container->get('doctrine')->getManager();

        // Blockの取得(file_nameはアプリケーションの仕組み上必ずユニーク)
        /** @var \Eccube\Entity\Block $Block */
        $Block = $em->getRepository(Block::class)->findOneBy(['file_name' => $this->blockFileName]);

        if (!$Block) {
            return;
        }

        try {
            // BlockPositionの削除
            $blockPositions = $Block->getBlockPositions();
            /** @var \Eccube\Entity\BlockPosition $BlockPosition */
            foreach ($blockPositions as $BlockPosition) {
                $Block->removeBlockPosition($BlockPosition);
                $em->remove($BlockPosition);
            }

            // Blockの削除
            $em->remove($Block);
            $em->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Copy block template.
     *
     * @param ContainerInterface $container
     */
    private function copyBlock(ContainerInterface $container)
    {
        $templateDir = $container->getParameter('eccube_theme_front_dir');
        // ファイルコピー
        $file = new Filesystem();

        if (!$file->exists($templateDir.'/Block/'.$this->blockFileName.'.twig')) {
            // ブロックファイルをコピー
            $file->copy($this->originBlock, $templateDir.'/Block/'.$this->blockFileName.'.twig');
        }
    }

    /**
     * Remove block template.
     *
     * @param ContainerInterface $container
     */
    private function removeBlock(ContainerInterface $container)
    {
        $templateDir = $container->getParameter('eccube_theme_front_dir');
        $file = new Filesystem();
        $file->remove($templateDir.'/Block/'.$this->blockFileName.'.twig');
    }
}
