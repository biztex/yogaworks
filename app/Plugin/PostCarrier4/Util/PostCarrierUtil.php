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

namespace Plugin\PostCarrier4\Util;

use Doctrine\ORM\Query\Parser;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\Master\CustomerStatusRepository;
use Eccube\Service\PluginService;

/**
 * Class PostCarrierUtil
 */
class PostCarrierUtil
{
    /**
     * @var BaseInfo
     */
    public $BaseInfo;

    /**
     * @var PluginService
     */
    protected $pluginService;

    /**
     * @var CustomerStatusRepository
     */
    protected $customerStatusRepository;

    public function __construct(
        BaseInfoRepository $baseInfoRepository,
        PluginService $pluginService,
        CustomerStatusRepository $customerStatusRepository
    ) {
        $this->BaseInfo = $baseInfoRepository->get();
        $this->pluginService = $pluginService;
        $this->customerStatusRepository = $customerStatusRepository;
    }

    public static function getRawSQLFromQB($qb)
    {
        $sql = $params = $types = null;

        $query = $qb->getQuery();
        $em = $qb->getEntityManager();

        // SQL取得
        $sqlPeeker = new SqlPeekingLogger();
        $connConfig= $em->getConnection()->getConfiguration();

        $origLogger = $connConfig->getSQLLogger();
        $connConfig->setSQLLogger($sqlPeeker);
        try {
            // このクエリのSQLを実行せずに横取りする
            $dummy = $query->getResult();
        } catch (\RuntimeException $e) {
            list($sql, $params, $types) = $sqlPeeker->getRawSQL();
        } finally {
            $connConfig->setSQLLogger($origLogger);
        }

        // リザルトセットのカラムの対応はこれでわかる
        $parser = new Parser($query);
        $rsm = $parser->parse()->getResultSetMapping();

        // SQL中のエイリアス -> <DQLエイリアス>_<カラム名> の対応表を作る
        // 例 name01_1 -> c_name01
        $columnNameMap = [];
        $fields = array_merge($rsm->fieldMappings, $rsm->metaMappings);
        foreach ($fields as $sqlColAlias => $colName) {
            $DQLAlias = $rsm->columnOwnerMap[$sqlColAlias];
            $columnNameMap[$sqlColAlias] = $DQLAlias."_".$colName;
        }

        return [$sql, $params, $types, $columnNameMap];
    }

    public function getEmail02() {
        return $this->BaseInfo->getEmail02();
    }

    public function getPluginVersion() {
        $config = $this->pluginService->readConfig(__DIR__.'/..');
        return $config['version'];
    }

    public function createSearchDefaults() {
        $defaults = [
            'customer_status' => $this->customerStatusRepository->findBy([
                'id' => [
                    //CustomerStatus::PROVISIONAL,
                    CustomerStatus::REGULAR,
                ],
            ]),
        ];

        return $defaults;
    }

    public function createTemplateDefaults() {
        $defaults = [
            'd__mail_method' => 1, // HTML
            'd__fromAddr' => $this->BaseInfo->getEmail01(),
            'd__kind' => 1, // EC会員向け
        ];

        return $defaults;
    }

    public static function escapeCsvData($data)
    {
        // 文字列へ変換
        $str = strval($data);

        // ダブルクォートは二重にする。
        $str = preg_replace('/(")/u', '"$1', $str);

        // データ中にカンマ、ダブルクォートまたは改行が存在する ->
        // 両端にダブルクォートを追加する。
        if (preg_match('/[,"\n\r]/u', $str)) {
            $str = '"'.$str.'"';
        }

        return $str;
    }

    public static function getStepmailString($memo)
    {
        $eventstr = [
            'memberRegistrationDate' => '会員登録日',
            'birthday' => '誕生日',
            'paymentDate' => '入金日',
            'orderDate' => '受注日',
            'latestOrderDate' => '最終受注日',
            'commitDate' => '発送日',
            'latestCommitDate' => '最終発送日',
        ];
        $eventstr2 = [
            'back' => '後',
            'front' => '前',
        ];

        return sprintf('%sの%d日%s', $eventstr[$memo['b__event']], $memo['b__eventDay'], $eventstr2[$memo['b__eventDaySelect']]);
    }

    public function detectLink($formData)
    {
        if (defined('POSTCARRIER_ENABLE_CLICK_COUNT_FLG') && POSTCARRIER_ENABLE_CLICK_COUNT_FLG === false) {
            return $formData;
        }

        $linkArrays = [];
        if ($formData['d__mail_method'] == 1) {
            $parser = new HtmlParser($formData['d__htmlBody']);
            while ($parser->parse()) {
                if ($parser->iNodeType == HtmlParser::NODE_TYPE_ELEMENT
                    && ($parser->iNodeName === "a" || $parser->iNodeName === "A"))
                {
                    $subject = $parser->iNodeAttributes["href"];
                    $parser->parse();	//text部まで進める
                    $pattern = "{s?https?://[-_.!~*'()a-zA-Z0-9;/?:@&=+$,%#]+}";

                    if (preg_match($pattern, $subject)) {
                        $linkArrays[] = array($subject, $parser->iNodeValue);
                    }
                }
            }

            $tmpBody = $formData['d__htmlBody'];
            $tmpCount = 1;
            foreach ($linkArrays as $linkArray) {
                $pattern = "(<a(\s.*?)href( |)=( |)('|\")".preg_quote($linkArray[0])."('|\"))i";
                $replacement = '<a${1}href="${リンク#'.$tmpCount.'}"';
                $tmpBody = preg_replace($pattern, $replacement, $tmpBody, 1);
                $tmpCount++;
            }

            $formData['d__htmlBody'] = $tmpBody;
        }else if ($formData['d__mail_method'] == "2") {
            $tmpBody = $formData['d__body'];
            $tmpCount = 1;
            $pattern = "{s?https?://[-_.!~*'()a-zA-Z0-9;/?:@&=+$,%#]+}";
            while (preg_match($pattern, $tmpBody, $matches)) {
                $replacement = '${リンク#'.$tmpCount.'}';
                $tmpBody = preg_replace($pattern, $replacement, $tmpBody, 1);

                $tmpArray = explode('/',$matches[0]);
                $linkArrays[] = [$matches[0], substr($matches[0], strlen($tmpArray[0].'/'.$tmpArray[1].'/'.$tmpArray[2]))];
                $tmpCount++;
            }

            $formData['d__body'] = $tmpBody;
        }

        $formData['link_count'] = count($linkArrays);
        for ($i=0; $i < count($linkArrays); $i++) {
            $formData['linkUrl'.($i+1)] = $linkArrays[$i][0];
            $formData['linkValue'.($i+1)] = $linkArrays[$i][1];
        }

        return $formData;
    }

    public static function decodeTemplateKind($templ) {
        $name = $templ['name'];

        if (strlen($name) < 2 || substr($name, 0, 1) != "\034")
            return 1;
        else
            return substr($name, 1, 1);
    }

    public static function templateKindToString($kind) {
        switch ($kind) {
        case 1:
            return 'EC会員';
        case 2:
            return 'メルマガ専用会員';
        case 3:
            return '両方';
        default:
            assert(false);
        }
    }

    public static function checkInsertItem($text, $items) {
        $errors = [];
        preg_match_all('/\{(\w+)\}/', $text, $matches);
        $matches = $matches[1];
        foreach ($matches as $item) {
            if (!in_array($item, $items)) {
                $errors[] = '利用できない差し込み項目 {'.$item.'} が含まれています。';
            }
        }
        return $errors;
    }
}
