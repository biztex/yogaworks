<?php
/**
 * Copyright(c) 2019 SYSTEM_KD
 * Date: 2019/03/31
 */

namespace Plugin\QuantityDiscount\Service;


use Eccube\Entity\Master\RoundingType;
use Plugin\QuantityDiscount\Entity\QdConfig;
use Plugin\QuantityDiscount\Repository\QdConfigRepository;

class ConfigService
{

    /* 設定種類 */
    // 値引方式
    const SETTING_KEY_MODE = 'DISCOUNT_MODE';

    // 送料無料方式
    const SETTING_KEY_DELIVERY_FEE_MODE = 'DELIVERY_FEE_MOD';

    // 割引率 端数処理
    const SETTING_KEY_RATE_TYPE = 'DISCOUNT_RATE_TYPE';

    // 割引レコード課税設定
    const SETTING_KEY_DISCOUNT_TAX = 'DISCOUNT_TAX';

    // まとめ買い適用表示
    const SETTING_KEY_CART_VIEW = 'DISCOUNT_CART_VIEW';

    // まとめ買い適用表示
    const SETTING_KEY_SHOPPING_VIEW = 'DISCOUNT_SHOPPING_VIEW';

    // まとめ買い適用表示
    const SETTING_KEY_CONFIRM_VIEW = 'DISCOUNT_CONFIRM_VIEW';

    // まとめ買い適用表示
    const SETTING_KEY_HISTORY_VIEW = 'DISCOUNT_HISTORY_VIEW';

    // まとめ買い価格一覧表示
    const SETTING_KEY_DETAIL_LIST_VIEW = 'DISCOUNT_DETAIL_LIST_VIEW';

    // まとめ買い価格一覧表示位置
    const SETTING_KEY_DETAIL_LIST_POSITION = 'DISCOUNT_DETAIL_LIST_POSITION';

    /* グループ */
    // 共通
    const SETTING_GROUP_COMMON = 1;

    // 商品詳細
    const SETTING_GROUP_PRODUCT_DETAIL = 2;

    // カート
    const SETTING_GROUP_CART = 3;

    // 購入
    const SETTING_GROUP_SHOPPING = 4;

    // 注文確認
    const SETTING_GROUP_CONFIRM = 5;

    // 購入履歴
    const SETTING_GROUP_HISTORY = 6;

    // グループ名称
    const SETTING_GROUPS = [
        self::SETTING_GROUP_COMMON => 'quantity_discount.admin.config_group_common',
        self::SETTING_GROUP_PRODUCT_DETAIL => 'quantity_discount.admin.config_product_detail',
        self::SETTING_GROUP_CART => 'quantity_discount.admin.config_group_cart',
        self::SETTING_GROUP_SHOPPING => 'quantity_discount.admin.config_group_shopping',
        self::SETTING_GROUP_CONFIRM => 'quantity_discount.admin.config_group_confirm',
        self::SETTING_GROUP_HISTORY => 'quantity_discount.admin.config_group_history',
    ];

    /* 値引方式 */
    // 値引方式
    const DISCOUNT_MODE_NORMAL = 1;

    // 値引方式
    const DISCOUNT_MODE_DIRECT = 2;

    /* 送料無料判定金額 */
    // 値引後の金額
    const DISCOUNT_AFTER_PRICE = 1;

    // 値引前の金額
    const DISCOUNT_BEFORE_PRICE = 2;

    /* 割引率 端数 */
    const DISCOUNT_RATE_TYPE_ROUND = RoundingType::ROUND;

    const DISCOUNT_RATE_TYPE_ROUND_DOWN = RoundingType::FLOOR;

    const DISCOUNT_RATE_TYPE_ROUND_UP = RoundingType::CEIL;

    /* まとめ買い価格一覧表示位置 */
    const DISCOUNT_POSITION_DETAIL = 1;

    const DISCOUNT_POSITION_QUANTITY = 2;

    protected $configRepository;

    public function __construct(QdConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function isKeyBool($key)
    {
        /** @var QdConfig $config */
        $config = $this->configRepository->findOneBy(['configKey' => $key]);
        return $config->isBoolValue();
    }

    public function getKeyInteger($key)
    {
        /** @var QdConfig $config */
        $config = $this->configRepository->findOneBy(['configKey' => $key]);
        return $config->getIntValue();
    }

    public function getKeyString($key)
    {
        /** @var QdConfig $config */
        $config = $this->configRepository->findOneBy(['configKey' => $key]);
        return $config->getTextValue();
    }
}
