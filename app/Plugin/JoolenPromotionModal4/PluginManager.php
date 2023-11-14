<?php

/*
 * Plugin Name: JoolenPromotionModal4
 *
 * Copyright(c) joolen inc. All Rights Reserved.
 *
 * https://www.joolen.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\JoolenPromotionModal4;

use Eccube\Entity\Block;
use Eccube\Entity\BlockPosition;
use Eccube\Entity\Master\DeviceType;
use Eccube\Plugin\AbstractPluginManager;
use Eccube\Repository\BlockRepository;
use Eccube\Repository\Master\DeviceTypeRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;

/**
 * Class PluginManager.
 */
class PluginManager extends AbstractPluginManager
{
    const VERSION = '1.0.2';

    /** @var string コピー元ブロックファイル */
    private $promotionModalBlock;

    /** @var string block_name */
    private $blockName = 'プロモーション用モーダル';

    /** @var string ブロックファイル名 */
    private $blockFileName = 'plg_promotion_modal';

    /**
     * @param array|null $meta
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    public function enable(array $meta = null, ContainerInterface $container)
    {
        $file = new Filesystem();
        $distFile = $this->getDistBlockFilePath($container);
        $this->promotionModalBlock = __DIR__ . '/Resource/template/default/Block/' . $this->blockFileName . '.twig';
        if (! $file->exists($distFile)) {
            $file->copy($this->promotionModalBlock, $distFile);
        }
        $entityManager = $container->get('doctrine')->getManager();
        $BlockRepository = $entityManager->getRepository(Block::class);
        $Block = $BlockRepository->findOneBy([
            'file_name' => $this->blockFileName
        ]);
        if (is_null($Block)) {
            $this->createDataBlock($container);
        }
    }

    /**
     * @param array|null $meta
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    public function disable(array $meta = null, ContainerInterface $container)
    {
        $this->removeDataBlock($container);
    }

    /**
     * @param array|null $meta
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    public function uninstall(array $meta = null, ContainerInterface $container)
    {
        // ブロックの削除
        $this->removeDataBlock($container);
        $this->removeBlock($container);
    }

    /**
     * ブロック作成
     *
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    protected function createDataBlock(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        $DeviceTypeRepository = $entityManager->getRepository(DeviceType::class);
        $DeviceType = $DeviceTypeRepository ->find(DeviceType::DEVICE_TYPE_PC);
        try {
            /** @var Block $Block */
            $BlockRepository = $entityManager->getRepository(Block::class);
            $Block = $BlockRepository->newBlock($DeviceType);
            $Block->setFileName($this->blockFileName)
                ->setName($this->blockName)
                ->setUseController(true)
                ->setDeletable(false);
            $entityManager->persist($Block);
            $entityManager->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * dtb_block, dtb_block_position のレコード削除処理
     *
     * @param ContainerInterface $container
     *
     * @throws \Exception
     */
    private function removeDataBlock(ContainerInterface $container)
    {
        $entityManager = $container->get('doctrine')->getManager();
        $BlockRepository = $entityManager->getRepository(Block::class);
        /** @var Block $Block */
        $Block = $BlockRepository->findOneBy([
            'file_name' => $this->blockFileName
        ]);

        if (! $Block) {
            return;
        }

        $em = $container->get('doctrine.orm.entity_manager');
        try {
            // BlockPositionの削除
            $blockPositions = $Block->getBlockPositions();
            /** @var BlockPosition $BlockPosition */
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
     * ブロックファイルを削除
     *
     * @param ContainerInterface $container
     */
    private function removeBlock(ContainerInterface $container)
    {
        $file = new Filesystem();
        $file->remove($this->getDistBlockFilePath($container));
    }

    /**
     * コピー先ファイルパスを返却
     *
     * @param ContainerInterface $container
     * @return string コピー先のファイルパス
     */
    private function getDistBlockFilePath(ContainerInterface $container)
    {
        $templateDir = $container->getParameter('eccube_theme_front_dir');
        return $templateDir . '/Block/' . $this->blockFileName . '.twig';
    }
}
