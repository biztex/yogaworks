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

namespace Plugin\Securitychecker4\Controller;

use DateTime;
use Eccube\Common\Constant;
use Eccube\Common\EccubeConfig;
use Eccube\Controller\AbstractController;
use Eccube\Entity\Customer;
use Eccube\Entity\CustomerAddress;
use Eccube\Entity\Order;
use Eccube\Entity\Shipping;
use Eccube\Repository\BaseInfoRepository;
use Eccube\Service\SystemService;
use Plugin\Securitychecker4\Form\Type\Securitychecker4ConfigType;
use Plugin\Securitychecker4\Repository\ConfigRepository;
use Plugin\Securitychecker4\Entity\Config;
use Plugin\Securitychecker4\Service\Securitychecker4Service;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    /** @var EccubeConfig */
    protected $eccubeConfig;

    /** @var BaseInfoRepository */
    protected $baseInfoRepository;

    /** @var ConfigRepository */
    protected $configRepository;

    /** @var Securitychecker4Service */
    protected $securitychecker4Service;

    /** @var SystemService */
    protected $systemService;

    /**
     * @param EccubeConfig $eccubeConfig
     * @param BaseInfoRepository $baseInfoRepository
     * @param ConfigRepository $configRepository
     * @param Securitychecker4Service $securitychecker4Service
     * @param SystemService $systemService
     */
    public function __construct(
        EccubeConfig $eccubeConfig,
        BaseInfoRepository $baseInfoRepository,
        ConfigRepository $configRepository,
        Securitychecker4Service $securitychecker4Service,
        SystemService $systemService
    ) {
        $this->eccubeConfig = $eccubeConfig;
        $this->baseInfoRepository = $baseInfoRepository;
        $this->configRepository = $configRepository;
        $this->securitychecker4Service = $securitychecker4Service;
        $this->systemService = $systemService;
    }

    /**
     * 設定画面
     *
     * @Route("/%eccube_admin_route%/store/plugin/Securitychecker4/config", name="securitychecker4_admin_config")
     * @Template("@Securitychecker4/admin/config.twig")
     *
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        $target = $this->configRepository->getCheckResult();

        $form = $this->formFactory->createBuilder(Securitychecker4ConfigType::class)->getForm();
        if (is_array($target) && array_key_exists('eccube_share', $target)) {
            $form->get('eccube_share')->setData($target['eccube_share']);
        } else {
            $form->get('eccube_share')->setData(1);
        }

        return [
            'target' => $target,
            'form' => $form->createView(),
        ];
    }

    /**
     * チェック実行
     *
     * @Route("/%eccube_admin_route%/store/plugin/Securitychecker4/config/check", name="securitychecker4_admin_config_check", methods={"POST"})
     * @Template("@Securitychecker4/admin/config.twig")
     *
     * @param Request $request
     * @param SessionInterface $session
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function check(Request $request, SessionInterface $session)
    {
        $target = $this->configRepository->getCheckResult();
        $form = $this->formFactory->createBuilder(Securitychecker4ConfigType::class)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $now = new DateTime();
            $target['check_date'] = $now->format('Y-m-d H:i:s');
            $target['php_version'] = phpversion();
            $target['eccube_version'] = Constant::VERSION;
            $target['db_version'] = $this->systemService->getDbversion();
            $target['site_url'] = [$this->securitychecker4Service->getSiteUrl()];
            $kernel_project_dir = $this->container->getParameter('kernel.project_dir');
            $target['var'] = [];
            $vars = realpath($kernel_project_dir.'/var');

            if ($vars) {
                $var_files = $this->securitychecker4Service->getFiles($vars);
                foreach ($var_files as $file) {
                    $target['var'][] = $this->securitychecker4Service->checkResources($file);
                    break;
                }
            }
            $target['var'] = array_filter($target['var']);

            $target['vendor'] = [];
            $vendor_autoload = realpath($kernel_project_dir.'/vendor/autoload.php');
            if ($vendor_autoload) {
                $target['vendor'][] = $this->securitychecker4Service->checkResources($vendor_autoload);
            }
            $vendor_composer = realpath($kernel_project_dir.'/vendor/composer/autoload_classmap.php');
            if ($vendor_composer) {
                $target['vendor'][] = $this->securitychecker4Service->checkResources($vendor_composer);
            }
            $target['vendor'] = array_filter($target['vendor']); // false を除去

            $target['codeception'] = realpath($kernel_project_dir.'/codeception');

            $target['dotenv'] = $this->securitychecker4Service->searchResources('.env');
            $target['debug_mode'] = env('APP_ENV') === 'dev';

            if (strpos($this->securitychecker4Service->getSiteUrl(), 'http://') !== false) {
                $target['ssl'] = true;
            } else {
                $target['ssl'] = false;
            }
            $target['force_ssl'] = $this->eccubeConfig['eccube_force_ssl'] !== true;

            $target['plugins'] = $this->securitychecker4Service->parsePluginConfigs();
            $target['ostore_url'] = $this->eccubeConfig['eccube_owners_store_url'];
            $BaseInfo = $this->baseInfoRepository->get();
            $target['public_key'] = $BaseInfo->getAuthenticationKey();

            $target['tools_agreement'] = [$data['tools_agreement'] ? '1' : '0'];
            $target['eccube_share'] = (string) $data['eccube_share'];

            $target['unsafe_customers'] = count($this->securitychecker4Service->getQueryBuilderForUnsafeData(Customer::class)->getQuery()->getArrayResult());
            $target['unsafe_customers_address'] = count($this->securitychecker4Service->getQueryBuilderForUnsafeData(CustomerAddress::class)->getQuery()->getArrayResult());
            $target['unsafe_orders'] = count($this->securitychecker4Service->getQueryBuilderForUnsafeData(Order::class)->getQuery()->getArrayResult());
            $target['unsafe_shippings'] = count($this->securitychecker4Service->getQueryBuilderForUnsafeData(Shipping::class)->getQuery()->getArrayResult());

            $check_result = json_encode($target);
            if ($check_result !== false) {
                $this->configRepository->saveCheckResult($check_result);
                $this->securitychecker4Service->sendResults($check_result);
                $this->addSuccess('セキュリティチェックが完了しました。', 'admin');
                $this->session->getFlashBag()->add('eccube.admin.securitychecker3.warning', '1');

                return $this->redirectToRoute('securitychecker4_admin_config');
            }
            $this->addError('セキュリティチェック結果の保存に失敗しました。', 'admin');
        }

        return [
            'target' => $target,
            'form' => $form->createView(),
        ];
    }

    /**
     * 不正データCSVダウンロード
     *
     * @Route("/%eccube_admin_route%/store/plugin/Securitychecker4/config/{type}/download", name="securitychecker4_admin_config_download", methods={"GET"}, requirements={"type":"customer|customer_address|order|shipping"})
     */
    public function download(Request $request, $type)
    {
        set_time_limit(0);
        $this->entityManager->getConfiguration()->setSQLLogger(null);

        $entityClass = [
            'customer' => Customer::class,
            'customer_address' => CustomerAddress::class,
            'order' => Order::class,
            'shipping' => Shipping::class
        ][$type];

        $qb = $this->securitychecker4Service->getQueryBuilderForUnsafeData($entityClass);

        $response = new StreamedResponse();
        $response->setCallback(function () use ($request, $qb) {
            $fp = fopen('php://output', 'w');
            $header = false;
            foreach ($qb->getQuery()->getArrayResult() as $data) {
                if ($header === false) {
                    fputcsv($fp, array_keys($data));
                    $header = true;
                }
                fputcsv($fp, array_values($data));
            }
            fclose($fp);
        });

        $now = new DateTime();
        $filename = $type.'_'.$now->format('YmdHis').'.csv';
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
        $response->send();

        return $response;
    }

}
