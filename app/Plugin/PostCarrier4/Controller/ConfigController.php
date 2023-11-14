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

namespace Plugin\PostCarrier4\Controller;

use Eccube\Common\EccubeConfig;
use Eccube\Controller\AbstractController;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Util\CacheUtil;
use Plugin\PostCarrier4\Entity\PostCarrierConfig;
use Plugin\PostCarrier4\Form\Type\PostCarrierConfigType;
use Plugin\PostCarrier4\Repository\PostCarrierConfigRepository;
use Plugin\PostCarrier4\Service\PostCarrierService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ConfigController.
 */
class ConfigController extends AbstractController
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * @var BaseInfo
     */
    protected $BaseInfo;

    /**
     * @var PostCarrierService
     */
    protected $postCarrierService;

    /**
     * @var CacheUtil
     */
    protected $cacheUtil;

    /**
     * ConfigController constructor.
     *
     * @param EccubeConfig $eccubeConfig
     * @param BaseInfoRepository $baseInfoRepository
     * @param PostCarrierService $postCarrierService
     * @param CacheUtil $cacheUtil
     */
    public function __construct(
        EccubeConfig $eccubeConfig,
        BaseInfoRepository $baseInfoRepository,
        PostCarrierService $postCarrierService,
        CacheUtil $cacheUtil
    ) {
        $this->eccubeConfig = $eccubeConfig;
        $this->BaseInfo = $baseInfoRepository->get();
        $this->postCarrierService = $postCarrierService;
        $this->cacheUtil = $cacheUtil;
    }

    /**
     * @Route("/%eccube_admin_route%/post_carrier/config", name="post_carrier4_admin_config")
     * @Template("@PostCarrier4/admin/config.twig")
     *
     * @param Request $request
     * @param PostCarrierConfigRepository $configRepository
     *
     * @return array
     */
    public function index(Request $request, PostCarrierConfigRepository $configRepository)
    {
        $postCarrierService = $this->postCarrierService;

        $last_registration_date = null;
        $last_registration_mode = null;

        $Config = $configRepository->get();
        if ($Config === null) {
            $Config = $this->initConfig();
        } else {
            $last_registration_date = $Config->getUpdateDate();
            $last_registration_mode = $Config->getDisableCheck();
        }

        $form = $this->createForm(PostCarrierConfigType::class, $Config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Config = $form->getData();
            $info = [
                'shop_url' => $this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ];
            $apiData = $postCarrierService->configure($isError, $Config, $info);
            if (!$isError) {
                $Config = $this->updateConfig($Config, $apiData);

                $Config->setUpdateDate(new \DateTime()); // 強制的に更新する
                $this->entityManager->persist($Config);
                $this->entityManager->flush($Config);

                $this->addSuccess('postcarrier.admin.save.complete', 'admin');

                // 最新のデータを表示する
                return $this->redirectToRoute('post_carrier4_admin_config');
            } else {
                $this->addError('postcarrier.admin.save.error', 'admin');

                if ($isError == 1 || ($isError == 2 && $apiData['message'] == 'MALFORMED_RESPONSE')) {
                    $form->get('server_url')->addError(new FormError('接続できませんでした。弊社指定のURLをご指定ください。'));
                } else if ($isError == 2 && strpos($apiData['message'], "指定されたショップは登録されていません") !== false) {
                    $form->get('shop_id')->addError(new FormError($apiData['message']));
                    $form->get('shop_pass')->addError(new FormError($apiData['message']));
                } else {
                    //$app['monolog.PostCarrier']->info("config error: ".$apiData['message']);
                }

                if (array_key_exists('detail', $apiData) && is_object($apiData['detail']) && property_exists($apiData['detail'], 'detail')) {
                    $errorDetails = get_object_vars($apiData['detail']->detail);
                    foreach ($errorDetails as $key => $val) {
                        //$app['monolog.PostCarrier']->info("config error: $key=".$errorDetails[$key]);
                        if ($form->has($key)) {
                            $f = $form->get($key);
                            $f->addError(new FormError($errorDetails[$key]));
                        }
                    }
                }
            }
        }

        $enc_data = $Config->getData();
        if ($enc_data === null) {
            $address_count = null;
            $address_count_update_date = null;
        } else {
            $data = unserialize(base64_decode($enc_data));
            $address_count = $data['address_count'];
            $address_count_update_date = $data['address_count_update_date'];
        }

        return [
            'form' => $form->createView(),
            'last_registration_date' => $last_registration_date,
            'last_registration_mode' => $last_registration_mode,
            'address_count' => $address_count,
            'address_count_update_date' => $address_count_update_date,
        ];
    }

    /**
     * @Route("/%eccube_admin_route%/post_carrier/config/address_count_update", name="post_carrier_config_update_address_count", methods={"POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAddressCount(Request $request, PostCarrierConfigRepository $configRepository)
    {
        $Config = $configRepository->get();
        $enc_data = $Config->getData();
        $data = $enc_data ? unserialize(base64_decode($enc_data)) : [];

        $data['address_count'] = $this->postCarrierService->getEffectiveAddressCount($this->eccubeConfig['post_carrier_effective_address_count_key']);
        $data['address_count_update_date'] = new \DateTime();

        $Config->setData(base64_encode(serialize($data)));
        $this->entityManager->persist($Config);
        $this->entityManager->flush($Config);

        return $this->json([
            'address_count' => $data['address_count'],
            'address_count_update_date' => $data['address_count_update_date']->format('Y/m/d H:i'),
        ]);
    }

    private function initConfig()
    {
        $config_url = $this->eccubeConfig['post_carrier_config_url'];
        $shop_user = $this->eccubeConfig['post_carrier_account_free_user'];
        $shop_pass = $this->eccubeConfig['post_carrier_account_free_pass'];

        $Config = new PostCarrierConfig();
        $Config->setServerUrl($config_url);
        $Config->setShopId($shop_user);
        $Config->setShopPass($shop_pass);
        $Config->setClickSslUrl($this->generateUrl('post_carrier_receive', [], UrlGeneratorInterface::ABSOLUTE_URL));
        $Config->setClickSslUrlPath('postcarrier');
        $Config->setRequestDataUrl($this->generateUrl('post_carrier_receive', [], UrlGeneratorInterface::ABSOLUTE_URL));
        $Config->setModuleDataUrl($this->generateUrl('homepage', [], UrlGeneratorInterface::ABSOLUTE_URL) . 'html/plugin/PostCarrier4/assets/');
        $Config->setErrorsTo($this->BaseInfo->getEmail04());

        return $Config;
    }

    private function updateConfig($Config, $apiData)
    {
        $Config->setApiUrl($apiData->apiUrl);
        $Config->setClickUrl($apiData->clickUrl);

        if ($Config->getShopId() === 'free') {
            $Config->setShopId($apiData->shopName);
            $Config->setShopPass($apiData->apikey);
        }

        // ssl_click_urlからclick_pathを認識
        // '/shop' なそプレフィックスが付く場合を考慮して、パス中の最後のディレクトリコンポーネントをclick_pathとする。
        $url_path = parse_url($Config->getClickSslUrl(), PHP_URL_PATH);
        $click_path = basename($url_path);
        if (strlen($click_path) <= 2 || $click_path === '//') {
            // XXX ERROR
            return false;
        }
        if ($Config->getClickSslUrlPath() != $click_path) {
            $Config->setClickSslUrlPath($click_path);
            $this->cacheUtil->clearCache();
        }

        return $Config;
    }
}
