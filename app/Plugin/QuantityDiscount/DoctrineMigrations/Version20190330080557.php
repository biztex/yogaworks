<?php declare(strict_types=1);

namespace Plugin\QuantityDiscount\DoctrineMigrations;

use Composer\Config;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Eccube\Entity\Master\TaxType;
use Plugin\QuantityDiscount\Entity\QdConfig;
use Plugin\QuantityDiscount\Repository\QdConfigRepository;
use Plugin\QuantityDiscount\Service\ConfigService;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190330080557 extends AbstractMigration implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    // TYPE, KEY, NAME, VALUE, GROUP
    private $defaultData = [
        [QdConfig::TYPE_CHOICE, ConfigService::SETTING_KEY_MODE, "値引き方式", 1, ConfigService::SETTING_GROUP_COMMON],
        [QdConfig::TYPE_CHOICE, ConfigService::SETTING_KEY_DELIVERY_FEE_MODE, "送料無料判定金額", 1, ConfigService::SETTING_GROUP_COMMON],
        [QdConfig::TYPE_CHOICE, ConfigService::SETTING_KEY_RATE_TYPE, "割引率端数処理", 1, ConfigService::SETTING_GROUP_COMMON],
        [QdConfig::TYPE_CHOICE, ConfigService::SETTING_KEY_DISCOUNT_TAX, "値引レコード課税区分", TaxType::TAXATION, ConfigService::SETTING_GROUP_COMMON],
        [QdConfig::TYPE_BOOL, ConfigService::SETTING_KEY_DETAIL_LIST_VIEW, 'まとめ買い価格一覧表示', true, ConfigService::SETTING_GROUP_PRODUCT_DETAIL],
        [QdConfig::TYPE_CHOICE, ConfigService::SETTING_KEY_DETAIL_LIST_POSITION, 'まとめ買い価格一覧表示位置', 1, ConfigService::SETTING_GROUP_PRODUCT_DETAIL],
        [QdConfig::TYPE_BOOL, ConfigService::SETTING_KEY_CART_VIEW, "まとめ買い適用表示", true, ConfigService::SETTING_GROUP_CART],
        [QdConfig::TYPE_BOOL, ConfigService::SETTING_KEY_SHOPPING_VIEW, "まとめ買い適用表示", true, ConfigService::SETTING_GROUP_SHOPPING],
        [QdConfig::TYPE_BOOL, ConfigService::SETTING_KEY_CONFIRM_VIEW, "まとめ買い適用表示", true, ConfigService::SETTING_GROUP_CONFIRM],
        [QdConfig::TYPE_BOOL, ConfigService::SETTING_KEY_HISTORY_VIEW, "まとめ買い適用表示", true, ConfigService::SETTING_GROUP_HISTORY],
    ];

    /**
     * @param Schema $schema
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function up(Schema $schema): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        /** @var QdConfigRepository $QdConfigRepository */
        $QdConfigRepository = $entityManager->getRepository(QdConfig::class);
        $QdConfigRepository->saveNewConfigs($this->defaultData);
    }

    public function down(Schema $schema): void
    {

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->container->get('doctrine.orm.entity_manager');

        /** @var QdConfigRepository $QdConfigRepository */
        $QdConfigRepository = $entityManager->getRepository(QdConfig::class);

        foreach ($this->defaultData as $defaultDatum) {
            $key = $defaultDatum[1];
            $QdConfig = $QdConfigRepository->findOneBy(['configKey' => $key]);

            if (is_null($QdConfig)) continue;

            $entityManager->remove($QdConfig);
        }
    }
}
