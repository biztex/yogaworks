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

namespace Plugin\PostCarrier4\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Eccube\Common\Constant;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\BaseInfo;
use Eccube\Entity\Master\CustomerStatus;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Repository\PluginRepository;
use Plugin\PostCarrier4\Repository\PostCarrierConfigRepository;
use Plugin\PostCarrier4\Repository\PostCarrierCustomerRepository;
use Plugin\PostCarrier4\Repository\PostCarrierGroupCustomerRepository;
use Plugin\PostCarrier4\Util\PostCarrierUtil;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

use Eccube\Entity\Master\OrderItemType as OrderItemTypeMaster;

/**
 * ポストキャリアAPI処理のサービスクラス.
 */
class PostCarrierService
{
    /**
     * @var string
     */
    private $postCarrierDir;

    /**
     * @var PostCarrierConfigRepository
     */
    protected $configRepository;

    /**
     * @var BaseInfo
     */
    public $BaseInfo;

    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * @var PostCarrierCustomerRepository
     */
    protected $customerRepository;

    /**
     * @var PostCarrierGroupCustomerRepository
     */
    protected $groupCustomerRepository;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * PostCarrierService constructor.
     *
     * @param PostCarrierConfigRepository $configRepository
     * @param BaseInfoRepository $baseInfoRepository
     * @param EccubeConfig $eccubeConfig
     * @param PostCarrierCustomerRepository $customerRepository
     * @param EntityManagerInterface $entityManager
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __construct(
        PostCarrierConfigRepository $configRepository,
        BaseInfoRepository $baseInfoRepository,
        EccubeConfig $eccubeConfig,
        PostCarrierCustomerRepository $customerRepository,
        PostCarrierGroupCustomerRepository $groupCustomerRepository,
        EntityManagerInterface $entityManager,
        PluginRepository $pluginRepository
  ) {
        $this->configRepository = $configRepository;
        $this->BaseInfo = $baseInfoRepository->get();
        $this->eccubeConfig = $eccubeConfig;
        $this->customerRepository = $customerRepository;
        $this->groupCustomerRepository = $groupCustomerRepository;
        $this->entityManager = $entityManager;
        $this->pluginRepository = $pluginRepository;

        $this->postCarrierDir = $this->eccubeConfig['post_carrier_dir'];
        if (!file_exists($this->postCarrierDir)) {
            mkdir($this->postCarrierDir);
        }

        $Config = $configRepository->get();
        if ($Config) {
            $this->apiUrl = $Config->getApiUrl();
            $this->clickUrl = $Config->getClickUrl();
            $this->shopName = $Config->getShopId();
            $this->apikey = $Config->getShopPass();
        }
    }

    public function isNotConfigured() {
        return $this->configRepository->get() === null;
    }

    public function configure(&$isError, $Config, $info = [])
    {
        $BaseInfo = $this->BaseInfo;
        $Plugin = $this->pluginRepository->findOneBy(['code' => 'PostCarrier4']);

        $params = [
            'shopName' => $Config->getShopId(),
            'apikey' => $Config->getShopPass(),
            'proxyUrl' => $Config->getClickSslUrl(),
            'sslProxyUrl' => $Config->getClickSslUrl(),
            'requestDataUrl' => $Config->getRequestDataUrl(),
            'moduleDataUrl' => $Config->getModuleDataUrl(),
            'protocolVersion' => $Plugin->getVersion(),
            'checkEccube' => $Config->getDisableCheck() ? 0 : 1,
            'eccubeVersion' => Constant::VERSION,
            'eccubeHttpUrl' => $info['shop_url'],
            'eccubeHttpsUrl' => $info['shop_url'],
            'eccubeShopName' => $BaseInfo->getShopName(),
            'eccubeEmail04' => $BaseInfo->getEmail04(),
            'eccubeCompanyName' => $BaseInfo->getCompanyName(),
            'eccubeEmail02' => $BaseInfo->getEmail02(),
            'eccubeZip' => $BaseInfo->getPostalCode(),
            'eccubeAddr01' => ($BaseInfo->getPref() ? $BaseInfo->getPref()->getName() : "") . $BaseInfo->getAddr01(),
            'eccubeAddr02' => $BaseInfo->getAddr02(),
            'eccubeTel' => $BaseInfo->getPhoneNumber(),
            'eccubeFax' => '',
            'basic_auth_user' => $Config->getBasicAuthUser(),
            'basic_auth_pass' => $Config->getBasicAuthPass(),
        ];

        $result = $this->doApiRequest($isError, $Config->getServerUrl(), 'POST', $params);
        return $result;
    }

    /**
     * 配信登録。
     *
     * @param array $formData
     *
     * @return int 採番されたsend_id
     *             エラー時はfalseを返す
     */
    public function delivery(&$isError, $formData, $customerCount, $demoAddress = null)
    {
        logs('postcarrier')->info('start.', [$formData, $customerCount]);

        list($message, $subject) = $this->createMessageParam($formData);

        $isWebCustomer = $formData['discriminator_type'] === 'customer';

        $attrh = $isWebCustomer
               ? ['_id','_customer_kind','_address','name','point','birth','sex']
               : ['_id','_customer_kind','_address','birth','sex','memo01','memo02','memo03','memo04','memo05','memo06','memo07','memo08','memo09','memo10'];

        $trigger='immediate';
        if ($formData['d__trigger'] == 'schedule') {
            $trigger = $formData['d__sch_date']->format('YmdHi');
        } else if ($formData['d__trigger'] == 'event') {
            $trigger = 'EVENT:'.$formData['d__stepmail_time']->format('Hi');
        } else if ($formData['d__trigger'] == 'periodic') {
            $trigger = sprintf('EVENT:%s %02d',
                               $formData['d__periodic_time']->format('i H'),
                               $formData['d__periodic_day']
            );
        }

        $params = array(
            'sendFor' => 'PC',
            'templSendFor' => 'PC',
            'fromAddr' => $formData['d__fromAddr'],
            'fromDisp' => $formData['d__fromDisp'],
            'subject' => $subject,
            'attrh' => json_encode($attrh),
            'message' => json_encode($message),
            'trigger' => $trigger,
            'addrColumn' => '_address',
            'keyColumn' => json_encode(array('_id','_customer_kind')),
            'memo' => base64_encode(serialize($this->createMemoArray($formData, $formData['d__trigger']))),
            'replytoAddr' => $this->BaseInfo->getEmail03(),
            'replytoDisp' => $this->BaseInfo->getShopName(),
            'customerCount' => $customerCount,
            'responseCondition' => json_encode(null),
            'name' => "\034".$formData['d__kind'], // XXX kind
            'note' => '',
        );

        if (isset($formData['d__id'])) {
            $params['deliveryId'] = $formData['d__id'];
        }

        if ($demoAddress !== null) {
            $params['testAddress'] = $demoAddress;
        }

        $features = [];
        // スケジュール配信: 配信時にリスト取得
        $features['gettingListOnScheduleDelivery'] = $formData['d__trigger'] === 'schedule' ? 'true' : 'false';
        $params['features'] = json_encode($features);

        logs('postcarrier')->info('params.', [$params]);

        $params['shopName'] = $this->shopName;
        $params['apikey'] = $this->apikey;

        $deliveryId = null;
        $apiData = $this->doApiRequest($isError, $this->apiUrl . 'delivery', 'POST', $params);
        if (!$isError) {
            $deliveryId = $apiData->deliveryId;
            logs('postcarrier')->info('end.', [$deliveryId]);
        } else {
            logs('postcarrier')->error('error.', [$deliveryId, $apiData]);
        }

        return $deliveryId;
    }

    /**
     * 配信先リストをアップロードする.
     *
     * @param $sendId
     * @param int $offset
     * @param int $max
     *
     * @return int
     */
    public function upload($deliveryId)
    {
        logs('postcarrier')->info('start.', [$deliveryId]);

        $apiData = $this->getDelivery($deliveryId);
        if ($apiData === false) {
            // 配信条件の取得に失敗したので処理を打ち切る
            logs('postcarrier')->error('get delivery info failed.', [$deliveryId]);
            return null;
        }

        $formData = $this->decodeMemo($apiData['memo']);
        if ($formData === null) {
            // 4系モジュールで投入した配信でなければ誤動作するので処理を打ち切る
            logs('postcarrier')->error('memo version mismatch.', [$deliveryId]);
            return null;
        }

        //$formData['plg_postcarrier_flg'] = Constant::ENABLED;
        $is_event_on = $apiData['triggerType'] == 'EVENT';
        if ($formData['discriminator_type'] === 'customer') {
            $qb = $this->customerRepository->getQueryBuilderBySearchData($formData, $is_event_on);
        } else {
            $qb = $this->groupCustomerRepository->getQueryBuilderBySearchData($formData, $is_event_on);
        }
        list($sql, $params, $types, $columnNameMap) = PostCarrierUtil::getRawSQLFromQB($qb);

        $csvFilePath = $this->getCsvFileName($deliveryId);
        $fp = fopen($csvFilePath, 'w');
        if ($fp === null) {
            logs('postcarrier')->error('fopen failed.', [$deliveryId, $csvFilePath]);
            return null;
        }
        // 横取りしたSQLを実行する
        $em = $this->entityManager;
        $stmt = $em->getConnection()->executeQuery($sql, $params, $types);
        $n = 0;
        if ($formData['discriminator_type'] === 'customer') {
            while ($row = $stmt->fetch()) {
                // <DQLエイリアス>_<カラム名>の形式に変換する
                foreach ($columnNameMap as $sqlColAlias => $key) {
                    $data[$key] = $row[$sqlColAlias];
                }
                $customerData = [$data['c_id'], 'web', $data['c_email'], $data['c_name01']." ".$data['c_name02'], $data['c_point'], $data['c_birth'], $data['c_sex_id']];
                $csvData = implode(',', array_map([PostCarrierUtil::class, 'escapeCsvData'], $customerData));
                fwrite($fp, $csvData."\n");
                $n++;
            }
        } else {
            while ($row = $stmt->fetch()) {
                // <DQLエイリアス>_<カラム名>の形式に変換する
                foreach ($columnNameMap as $sqlColAlias => $key) {
                    $data[$key] = $row[$sqlColAlias];
                }
                $customerData = [$data['c_id'], 'mail', $data['c_email'], null, null, $data['c_memo01'], $data['c_memo02'], $data['c_memo03'], $data['c_memo04'], $data['c_memo05'], $data['c_memo06'], $data['c_memo07'], $data['c_memo08'], $data['c_memo09'], $data['c_memo10']];
                //$customerData = [$data['c_id'], 'mail', $data['c_email']];
                $csvData = implode(',', array_map([PostCarrierUtil::class, 'escapeCsvData'], $customerData));
                fwrite($fp, $csvData."\n");
                $n++;
            }
        }
        fclose($fp);
        logs('postcarrier')->info('customer_count', [$deliveryId, $n]);

        $uploadurl = $this->apiUrl . "deliveryData/" . $deliveryId;
        $params = $this->createRequestParam();
        $params['csvData'] = new \CURLFile($csvFilePath);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uploadurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $resText = curl_exec($ch);

        if (curl_errno($ch)) {
            $n = null;
            logs('postcarrier')->error('curl failed.', [$deliveryId, $resText, curl_errno($ch), curl_error($ch)]);
        }
        curl_close($ch);

        unlink($csvFilePath);

        logs('postcarrier')->info('end.', [$deliveryId]);

        return $n;
    }

    /**
     * テストメール送信
     */
    public function sendTestMail(&$isError, $formData, $customerData, $testAddress)
    {
        list($message, $subject) = $this->createMessageParam($formData);

        $isWebCustomer = $formData['discriminator_type'] === 'customer';

        $attrh = $isWebCustomer
               ? ['_id','_customer_kind','_address','name','point']
               : ['_id','_customer_kind','_address','memo01','memo02','memo03','memo04','memo05','memo06','memo07','memo08','memo09','memo10'];

        $csvData = implode(',', array_map([PostCarrierUtil::class, 'escapeCsvData'], $customerData));

        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'addresses' => json_encode(array($testAddress)),
            'sendFor' => 'PC',
            'fromAddr' => $formData['d__fromAddr'],
            'fromDisp' => $formData['d__fromDisp'],
            'replytoAddr' => $this->BaseInfo->getEmail03(),
            'replytoDisp' => $this->BaseInfo->getShopName(),
            'subject' => $subject,
            'attrh' => json_encode($attrh),
            'csvData' => $csvData,
            'message' => json_encode($message)
        );

        return $this->doApiRequest($isError, $this->apiUrl . 'testmail', 'POST', $params);
    }

    public function getAdminEmail()
    {
        return $this->BaseInfo->getEmail03();
    }

    /**
     * Get csv file name
     *
     * @param $deliveryId
     *
     * @return string
     */
    public function getCsvFileName($deliveryId)
    {
        return $this->postCarrierDir.'/customer_'.$deliveryId.'.csv';
    }

    public function getTemplateList(&$isError, &$total, $max = -1, $offset = -1) {
        $params = $this->createRequestPagerParam($max, $offset);
        $result = $this->doApiRequest($isError, $this->apiUrl . 'template', 'GET', $params);
        if (!$isError) {
            $total = $result->total;
            $arr = $this->convertObjectToArray($result);
            if ($total == 0) $arr['templates'] = [];
            return $arr;
        } else {
            $total = -1;
            return $result;
        }
    }

    public function getTemplate(&$isError, $template_id)
    {
        $params = $this->createRequestParam();
        $params['template_id'] = $template_id;
        $result = $this->doApiRequest($isError, $this->apiUrl . 'template', 'GET', $params);
        if (!$isError) {
            return $this->convertObjectToArray($result);
        } else {
            return $result;
        }
    }

    public function saveTemplate(&$isError, $formData)
    {
        list($message, $subject) = $this->createMessageParam($formData, false);

        $attrh = []; // TODO:

        $formData['adm_name'] = "\034".$formData['d__kind'].$formData['adm_name']; // XXX kind

        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'sendFor' => $formData['sendFor'],
            'fromAddr' => $formData['d__fromAddr'],
            'fromDisp' => array_key_exists('d__fromDisp', $formData) ? $formData['d__fromDisp'] : '',
            'subject' => $subject,
            'replytoAddr' => array_key_exists('replytoAddr', $formData) ? $formData['replytoAddr'] : '',
            'replytoDisp' => array_key_exists('replytoDisp', $formData) ? $formData['replytoDisp'] : '',
            'message' => json_encode($message),
            'attrh' => json_encode($attrh),
            'name' => array_key_exists('adm_name', $formData) ? $formData['adm_name'] : '',
            'note' => array_key_exists('adm_note', $formData) ? $formData['adm_note'] : '',
        );

        if(array_key_exists('id', $formData) && $formData['id']!=""){
            $params['template_id'] = $formData['id'];
        }

        $result = $this->doApiRequest($isError, $this->apiUrl . 'template', 'POST', $params);
        return $result;
    }

    public function getMailLogList(&$isError, &$total, $max = -1, $offset = -1) {
        $params = $this->createRequestPagerParam($max, $offset);
        $result = $this->doApiRequest($isError, $this->apiUrl . 'maillog', 'GET', $params);

        if (!$isError) {
            $objArray = $result->logs;
            $total = $result->total;
            if ($total == 0) {
                return [];
            } else {
                $apiData = $this->convertObjectToArray($objArray);

                foreach ($apiData as &$item) {
                    $item['subject'] = $this->decodeAttributes($item['subject']);
                }
                unset($item);

                return $apiData;
            }
        } else {
            $total = -1;
            return $result;
        }
    }

    function getMarketing($deliveryId, $generationFlg = false) {
        $params = $this->createRequestParam();
        $params['deliveryId'] = $deliveryId;

        if ($generationFlg) {
            $params['domain'] = 'generation_gender';
        }

        $result = $this->doApiRequest($isError, $this->apiUrl . 'marketing', 'GET', $params);
        if (!$isError) {
            return $this->convertObjectToArray($result);
        } else {
            return $result;
        }
    }

    private function doApiRequest(&$isError, $apiUrl, $method, $params, $not_json = false)
    {
        $options = [CURLOPT_RETURNTRANSFER => true,];

        switch ($method) {
        case 'GET':
            $options[CURLOPT_HTTPGET] = true;
            $apiUrl .= '?'.http_build_query($params);
            break;
        case 'DELETE':
            $options[CURLOPT_CUSTOMREQUEST] = "DELETE";
            $apiUrl .= '?'.http_build_query($params);
            break;
        case 'POST':
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = $params;
            break;
        case 'PUT':
            $options[CURLOPT_CUSTOMREQUEST] = "PUT";
            $options[CURLOPT_POSTFIELDS] = $params;
            break;
        }

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, $options);
        $http_response = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($errno !== CURLE_OK) {
            $isError = 1;
            return ['message' => $error];
        } else {
            if ($not_json) {
                $apiData = $http_response;
            } else {
                $apiData = json_decode($http_response);
            }

            $code = $info['http_code'];
            if (floor($code/100) != 2) {
                if ($not_json) {
                    $apiData = json_decode($http_response);
                }
                $isError = 2;
                $message = $apiData !== null ? $apiData->error : 'MALFORMED_RESPONSE';
                return ['message' => $message, 'code' => $code, 'detail' => $apiData];
            }

            $isError = 0;
            return $apiData;
        }
    }

    public function deleteTemplate(&$isError, $template_id)
    {
        logs('postcarrier')->info('start.', [$template_id]);

        $params = $this->createRequestParam();
        $params['template_id'] = $template_id;

        return $this->doApiRequest($isError, $this->apiUrl . 'template', 'DELETE', $params);
    }

    function getMailLog(&$isError, $deliveryId, &$total, $max = -1, $offset = -1){
        $params = $this->createRequestPagerParam($max, $offset);
        $params['deliveryId'] = $deliveryId;

        $result = $this->doApiRequest($isError, $this->apiUrl . 'maillog', 'GET', $params);
        if (!$isError) {
            $total = $result->total;
            return $this->convertObjectToArray($result);
        } else {
            $total = -1;
            return $result;
        }
    }

    public function downloadMaillog(&$isError, $deliveryId)
    {
        $params = $this->createRequestParam();
        $params['deliveryId'] = $deliveryId;

        $result = $this->doApiRequest($isError, $this->apiUrl . 'maillog/download', 'GET', $params, true);
        return $result;
    }

    public function getDelivery($deliveryId) {
        $params = $this->createRequestParam();
        $params['deliveryId'] = $deliveryId;

        $result = $this->doApiRequest($isError, $this->apiUrl . 'delivery', 'GET', $params);
        if (!$isError) {
            $arr = $this->convertObjectToArray($result);
            return $arr;
        } else {
            return $result;
        }
    }

    public function previewTemplate(&$isError, $template_id){
        $params = $this->createRequestParam();
        $params['template_id'] = $template_id;

        $apiData = $this->doApiRequest($isError, $this->apiUrl . 'preview', 'POST', $params);
        if (!$isError) {
            return $this->convertObjectToArray($apiData);
        } else {
            return $apiData;
        }
    }

    public function previewDelivery(&$isError, $deliveryId){
        $params = $this->createRequestParam();
        $params['deliveryId'] = $deliveryId;

        $apiResult = $this->doApiRequest($isError, $this->apiUrl . 'preview', 'POST', $params);
        if (!$isError) {
            $apiData = $this->convertObjectToArray($apiResult);
            // ${name} -> {name}
            $apiData['subject'] = $this->decodeAttributes($apiData['subject']);
            $apiData['body'] = $this->decodeAttributes($apiData['body']);
            return $apiData;
        } else {
            return $apiResult;
        }
    }

    public function getScheduleList(&$isError, $triggerType, &$total, $max = -1, $offset = -1){
        $params = $this->createRequestPagerParam($max, $offset);
        $params['triggerType'] = $triggerType;
        $result = $this->doApiRequest($isError, $this->apiUrl . 'scheduler', 'GET', $params);
        if (!$isError) {
            $objArray = $result->jobList;
            $total = $result->total;
            return $total == 0 ? [] : $this->convertObjectToArray($objArray);
        } else {
            $total = -1;
            return $result;
        }
    }

    public function schedulerExecute($deliveryId)
    {
        logs('postcarrier')->info('start.', [$deliveryId]);

        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'deliveryId' => $deliveryId
        );

        $result = $this->doApiRequest($isError, $this->apiUrl . 'scheduler', 'POST', $params);
        return $result;
    }

    public function schedulerDelete($deliveryId)
    {
        logs('postcarrier')->info('start.', [$deliveryId]);

        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'deliveryId' => $deliveryId
        );

        $result = $this->doApiRequest($isError, $this->apiUrl . 'scheduler', 'DELETE', $params);
        return $result;
    }

    public function schedulerPause($deliveryId)
    {
        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'mode' => 'pause',
            'deliveryId' => $deliveryId
        );

        $result = $this->doApiRequest($isError, $this->apiUrl . 'scheduler/ctrl', 'POST', $params);
        return $result;
    }

    public function schedulerResume($deliveryId)
    {
        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'mode' => 'resume',
            'deliveryId' => $deliveryId
        );

        $result = $this->doApiRequest($isError, $this->apiUrl . 'scheduler/ctrl', 'POST', $params);
        return $result;
    }

    public function schedulerCopy(&$isError, $deliveryId)
    {
        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'mode' => 'copy',
            'deliveryId' => $deliveryId
        );

        $result = $this->doApiRequest($isError, $this->apiUrl . 'scheduler/ctrl', 'POST', $params);
        return $result;
    }

    public function getDiscardList(&$isError, &$total, $max = -1, $offset = -1)
    {
        $params = $this->createRequestPagerParam($max, $offset);
        $result = $this->doApiRequest($isError, $this->apiUrl . 'discard', 'GET', $params);
        if (!$isError) {
            $objArray = $result->discards;
            $total = $result->total;
            return $total == 0 ? [] : $this->convertObjectToArray($objArray);
        } else {
            $total = -1;
            return $result;
        }
    }

    public function saveDiscard(&$isError, $address)
    {
        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'address' => $address
        );

        $result = $this->doApiRequest($isError, $this->apiUrl . 'discard', 'POST', $params);
        return $result;
    }

    public function saveDiscardFile($csvFilePath)
    {
        $uploadurl = $this->apiUrl . "discard";
        $postfields = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uploadurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $postfields = $this->setupCurlUpload($ch, $postfields, array('csvData' => $csvFilePath));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);

        $resText = curl_exec($ch);

        if (curl_errno($ch)) {
            logs('postcarrier')->error('curl failed.', [$deliveryId, $resText, curl_errno($ch), curl_error($ch)]);
        }

        curl_close($ch);

        unlink($csvFilePath);
    }

    public function deleteDiscard(&$isError, $address)
    {
        logs('postcarrier')->info('start.', [$address]);

        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'address' => $address
        );

        $result = $this->doApiRequest($isError, $this->apiUrl . 'discard', 'DELETE', $params);
        return $result;
    }

    public function searchDiscard(&$isError, $address)
    {
        $params = array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey,
            'address' => $address
        );

        $result = $this->doApiRequest($isError, $this->apiUrl . 'discard', 'GET', $params);
        if (!$isError) {
            $objArray = $result->discards;
            $total = $result->total;
            return $total == 0 ? [] : $this->convertObjectToArray($objArray);
        } else {
            $total = -1;
            return $result;
        }
    }

    public function downloadDiscardList(&$isError)
    {
        $params = $this->createRequestParam();

        $result = $this->doApiRequest($isError, $this->apiUrl . 'discard/download', 'GET', $params, true);
        return $result;
    }

    public function getEffectiveAddressCount($key)
    {
        if (!empty($key) && $key !== $this->eccubeConfig['post_carrier_effective_address_count_key']) {
            return '';
        }

        // 本会員アドレスリストを取得する
        $customer_file1 = $this->postCarrierDir.'/count_customer.txt';
        $cond1 = [];
        //$cond1['plg_postcarrier_flg'] = Constant::ENABLED;
        //$cond1['customer_status'] = [CustomerStatus::REGULAR, CustomerStatus::PROVISIONAL];
        $qb1 = $this->customerRepository->getQueryBuilderBySearchData($cond1);
        $qb1->select("c.id, c.email, '' as email_mobile, '' as email_sphone")
            // 本会員のみカウントする
            ->andWhere($qb1->expr()->eq('c.Status', ':status'))
            ->setParameter('status', CustomerStatus::REGULAR);
        $customer_file1 = $this->createCustomerDataFile($customer_file1, $qb1);

        // メルマガ会員アドレスリストを取得する
        $customer_file2 = $this->postCarrierDir.'/count_csv_customer.txt';
        // TODO: 未実装なので空ファイルを送信する
        touch($customer_file2);
        // $sql = "SELECT customer_id,group_id,email,'' as email_sphone FROM plg_postcarrier_csv_customer WHERE status = 2";
        // $qb2 =
        // $customer_file2 = $this->createCustomerDataFile($customer_file2, $qb2);

        // 本会員・メルマガ会員アドレスリストをサーバーにアップロードして件数を取得する。
        $uploadurl = $this->apiUrl . "address/calculate";
        $params = $this->createRequestParam();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uploadurl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $params = $this->setupCurlUpload($ch, $params, ['customers' => $customer_file1, 'csv_customers' => $customer_file2]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $res = curl_exec($ch);
        curl_close($ch);
        $cnt = $res;

        unlink($customer_file1);
        unlink($customer_file2);

        return $cnt;
    }

    public function getMonthlyReport(&$isError, &$total, $max = -1, $offset = -1){
        $params = $this->createRequestPagerParam($max, $offset);
        $result = $this->doApiRequest($isError, $this->apiUrl . 'sendCounter', 'GET', $params);
        if (!$isError) {
            $objArray = $result->counts;
            $total = $result->total;
            return $total == 0 ? [] : $this->convertObjectToArray($objArray);
        } else {
            $total = -1;
            return $result;
        }
    }

    /*
     * PostCarrier API 関連
     */
    public function extractTemplate($apiData)
    {
        $formData = [];

        $formData['d__subject'] = $apiData['subject'];
        $formData['d__fromDisp'] = $apiData['fromDisp'];
        $formData['d__fromAddr'] = $apiData['fromAddr'];
        if (empty($formData['d__fromAddr'])) {
            // デフォルト値を設定する
            $formData['d__fromAddr'] = $this->BaseInfo->getEmail01();
        }
        $formData['replytoDisp'] = $apiData['replytoDisp'];
        $formData['replytoAddr'] = $apiData['replytoAddr'];

        $type = $apiData['message'][0]['type'];
        if ($type == 'text') {
            $formData['d__mail_method'] = 2;
            $formData['d__body'] = $apiData['message'][0]['body'];
        } else {
            $formData['d__mail_method'] = 1;
            $formData['d__body'] = $apiData['message'][1]['body'];
            $formData['d__htmlBody'] = $apiData['message'][0]['body'];
        }

        // 差し込み置換
        $formData['d__subject'] = $this->decodeAttributes($formData['d__subject']);
        $formData['d__body'] = $this->decodeAttributes($formData['d__body']);
        if (isset($formData['d__htmlBody'])) {
            $formData['d__htmlBody'] = $this->decodeAttributes($formData['d__htmlBody']);
        }

        if ($apiData['sendFor'] == "PCSP") {
            $memo_data = unserialize($apiData['memo']);
            if ($memo_data['templSendFor'] == "PC" || $memo_data['templSendFor'] == "MOBILE") {
                $formData['sendFor'] = $memo_data['templSendFor'];
            } else {
                $formData['sendFor'] = "PC";
            }
        } else {
            $formData['sendFor'] = $apiData['sendFor'];
        }

        // リンク抽出状態を復元
        if (array_key_exists('link', $apiData['message'][0]) && $apiData['message'][0]['link'] != null) {
            $linkPats = [];
            $linkUrls = [];
            foreach( $apiData['message'][0]['link'] as $key=>$val ){
                $linkPats[] = '${リンク#'.$key.'}';
                $linkUrls[] = $val['url'];
            }
            if ($type == 'text') {
                $formData['d__body'] = str_replace($linkPats, $linkUrls, $formData['d__body']);
            } else {
                $formData['d__htmlBody'] = str_replace($linkPats, $linkUrls, $formData['d__htmlBody']);
            }
        }

        if (array_key_exists('name', $apiData)) {
            // 4系ポストキャリアはテンプレート種別をnameにエンコードする。
            if (substr($apiData['name'], 0, 1) === "\034") {
                $formData['adm_name'] = substr($apiData['name'], 2);
                $formData['d__kind'] = substr($apiData['name'], 1, 1);
            } else {
                $formData['adm_name'] = $apiData['name'];
                $formData['d__kind'] = 1; // デフォルト値
            }
        }
        if (array_key_exists('note', $apiData))
            $formData['adm_note'] = $apiData['note'];

        return $formData;
    }

    /*
     * 内部メソッド
     */

    protected function createRequestParam()
    {
        return array(
            'shopName' => $this->shopName,
            'apikey' => $this->apikey
        );
    }

    protected function setPagerParam(&$params, $max, $offset)
    {
        if ($max >= 0) {
            $params['max'] = $max;
        }
        if ($offset >= 0) {
            $params['offset'] = $offset;
        }
        return $params;
    }

    protected function createRequestPagerParam($max, $offset)
    {
        $params = $this->createRequestParam();
        $this->setPagerParam($params, $max, $offset);
        return $params;
    }

    protected function convertObjectToArray($targetArray)
    {
        if(!is_object($targetArray) && !is_array($targetArray)) return null;

        $returnArray = [];
        foreach($targetArray as $key => $val){
            if(is_object($val)){
                $val = get_object_vars($val);
            }
            if(is_array($val)){
                $returnArray[$key] = $this->convertObjectToArray($val);
            }else{
                $returnArray[$key] = $val;
            }
        }
        return $returnArray;
    }

    public function decodeMemo($enc_memo)
    {
        $memo = unserialize(base64_decode($enc_memo));
        if (isset($memo['version']) && $memo['version'] === '4.0.0') {
            return $memo;
        } else {
            return null;
        }
    }

    protected function createMemoArray($formData, $trigger)
    {
        // Formから検索条件を取得し、シリアライズする(array)
        foreach (array_keys($formData) as $key) {
            // 命名規約に従い不要な項目を除外
            if (substr($key, 0, 3) === 'd__') {
                unset($formData[$key]);
            }

            // リンク抽出関連のパラメータを削除する
            // link_count, linkUrl\d+, linkValue\d+
            if (isset($formData['link_count'])) {
                $link_count = $formData['link_count'];
                for ($i = 1; $i <= $link_count; $i++) {
                    unset($formData['linkUrl'.$i]);
                    unset($formData['linkValue'.$i]);
                }
                unset($formData['link_count']);
            }
        }

        // 互換性確認に備えてバージョン情報を含めておく
        $formData['version'] = '4.0.0';

        if (isset($formData['sex']) && $formData['sex'] instanceof ArrayCollection) {
            $formData['sex'] = $formData['sex']->toArray();
        }
        if (isset($formData['customer_status']) && $formData['customer_status'] instanceof ArrayCollection) {
            $formData['customer_status'] = $formData['customer_status']->toArray();
        }
        if (isset($formData['OrderItems'])) {
            if ($formData['OrderItems'] instanceof ArrayCollection) {
                $formData['OrderItems'] = $formData['OrderItems']->toArray();
            }
            // 無条件を表現するItemを削除
            if (count($formData['OrderItems']) == 1 && current($formData['OrderItems'])->getOrderItemType()->getId() == OrderItemTypeMaster::CHARGE) {
                unset($formData['OrderItems'][0]);
            }
        }
        if (isset($formData['OrderStopItems'])) {
            if ($formData['OrderStopItems'] instanceof ArrayCollection) {
                $formData['OrderStopItems'] = $formData['OrderStopItems']->toArray();
            }
            // 無条件を表現するItemを削除
            if (count($formData['OrderStopItems']) == 1 && current($formData['OrderStopItems'])->getOrderItemType()->getId() == OrderItemTypeMaster::CHARGE) {
                unset($formData['OrderStopItems'][0]);
            }
        }

        // PCSP対応: sendFor == PCSPになるので、テンプレートの種別を保存しておく。
        $formData['templSendFor'] = 'PC'; // PCで固定

        return $formData;
    }

    protected function createMessageParam($formData, $encode = true)
    {
        // 差し込み置換
        if ($encode) {
            $formData['d__subject'] = $this->encodeAttributes($formData['d__subject']);
            $formData['d__body'] = $this->encodeAttributes($formData['d__body']);
            if (isset($formData['d__htmlBody'])) {
                $formData['d__htmlBody'] = $this->encodeAttributes($formData['d__htmlBody']);
            }
        }

        $message = [];

        $type = $formData['d__mail_method'] == 1 ? 'html' : 'text';
        if ($type == 'html') {
            $message[] = [
                'type' => $type,
                'body' => $formData['d__htmlBody'],
            ];

            // htmlメールのテキストパートを設定
            $textpart = $formData['d__body'];
            if ($textpart != '') {
                $message[] = [
                    'type' => 'text',
                    'body' => $textpart,
                ];
            }
        } else {
            $message[] = [
                'type' => $type,
                'body' => $formData['d__body'],
            ];
        }

        // リンク情報を設定
        $linkArray = [];
        if (array_key_exists('link_count', $formData)) {
            $linkCount = $formData['link_count'];

            if ($linkCount > 0) {
                for ($i = 1; $i < $linkCount + 1; $i++) {
                    if ($formData['linkUrl'.$i] != "") {
                        $linkArray[$i] = [
                            'url' => $formData['linkUrl'.$i],
                            'name' => $formData['linkValue'.$i],
                        ];
                    }
                }
                $message[0]['link'] = $linkArray;
            }
        }

        return [$message, $formData['d__subject']];
    }

    protected function encodeAttributes($str)
    {
        $str = str_replace(['{id}','{email}'], ['${_id}','${_address}'], $str);
        $str = preg_replace('/\{(name|point)\}/', '${\1}', $str);

        // メルマガ会員
        $str = preg_replace('/\{(memo\d+)\}/', '${\1}', $str);

        return $str;
    }

    protected function decodeAttributes($str)
    {
        $str = str_replace(['${_id}','${_address}'], ['{id}','{email}'], $str);
        $str = preg_replace('/\$\{(name|point)\}/', '{\1}', $str);

        // メルマガ会員
        $str = preg_replace('/\$\{(memo\d+)\}/', '{\1}', $str);

        return $str;
    }

    protected function setupCurlUpload($ch, $params, $files)
    {
        foreach ($files as $key => $file) {
            $params[$key] = new \CURLFile($file);
        }
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);

        return $params;
    }

    protected function createCustomerDataFile($filename, $qb)
    {
        $em = $this->entityManager;
        list($sql, $params, $types, $columnNameMap) = PostCarrierUtil::getRawSQLFromQB($qb);

        if (extension_loaded('zlib')) {
            $filename .= '.gz';
            $this->customer_file = gzopen($filename, 'wb');
            $stmt = $em->getConnection()->executeQuery($sql, $params, $types);
            while ($row = $stmt->fetch()) {
                $line = implode("\t", $row);
                gzwrite($this->customer_file, $line."\n");
            }
            gzclose($this->customer_file);
        } else {
            $this->customer_file = fopen($filename, 'wb');
            $stmt = $em->getConnection()->executeQuery($sql, $params, $types);
            while ($row = $stmt->fetch()) {
                $line = implode("\t", $row);
                fwrite($this->customer_file, $line."\n");
            }
            fclose($this->customer_file);
        }

        return $filename;
    }

    /**
     * クリックURLのRouteを動的に登録.
     *
     * 有効にするには下記ファイルを作成する必要がある。
     * app/config/eccube/routes/postcarrier_routes.yaml:
     * postcarrier_routes:
     *     resource: 'Plugin\PostCarrier4\Service\PostCarrierService:loadRoutes'
     *     type: service
     */
    public function loadRoutes() {
        $routes = new RouteCollection();

        $Config = $this->configRepository->get();
        $click_path = $Config ? $Config->getClickSslUrlPath() : '';
        if (strlen($click_path) == 0) {
            // 不正なパスの場合は初期化
            $click_path = 'postcarrier';
        }

        $path = '/'.$click_path;
        $defaults = [
            '_controller' => 'Plugin\PostCarrier4\Controller\ReceiveController::receive',
        ];
        $requirements = [];
        $options = [];
        $host = '';
        $schemes = [];
        $methods = ['GET', 'POST'];
        $route = new Route($path, $defaults, $requirements, $options, $host, $schemes, $methods);

        $routeName = 'post_carrier_receive_custom';
        $routes->add($routeName, $route);

        return $routes;
    }
}
