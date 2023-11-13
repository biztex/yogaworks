<?php

namespace ContainerEl0l1iq;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/*
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final
 */
class EccubeEccube_KernelProdContainer extends Container
{
    private $buildParameters;
    private $containerDir;
    private $targetDir;
    private $parameters = [];
    private $getService;

    public function __construct(array $buildParameters = [], $containerDir = __DIR__)
    {
        $this->getService = \Closure::fromCallable([$this, 'getService']);
        $this->buildParameters = $buildParameters;
        $this->containerDir = $containerDir;
        $this->targetDir = \dirname($containerDir);
        $this->parameters = $this->getDefaultParameters();

        $this->services = $this->privates = [];
        $this->syntheticIds = [
            'kernel' => true,
        ];
        $this->methodMap = [
            'Eccube\\Common\\EccubeConfig' => 'getEccubeConfigService',
            'SunCat\\MobileDetectBundle\\DeviceDetector\\MobileDetector' => 'getMobileDetectorService',
            'doctrine' => 'getDoctrineService',
            'doctrine.dbal.default_connection' => 'getDoctrine_Dbal_DefaultConnectionService',
            'doctrine.orm.default_entity_manager' => 'getDoctrine_Orm_DefaultEntityManagerService',
            'event_dispatcher' => 'getEventDispatcherService',
            'http_kernel' => 'getHttpKernelService',
            'request_stack' => 'getRequestStackService',
            'router' => 'getRouterService',
            'security.authorization_checker' => 'getSecurity_AuthorizationCheckerService',
            'security.csrf.token_manager' => 'getSecurity_Csrf_TokenManagerService',
            'security.token_storage' => 'getSecurity_TokenStorageService',
            'session' => 'getSessionService',
            'state_machine.order' => 'getStateMachine_OrderService',
            'translator' => 'getTranslatorService',
            'twig' => 'getTwigService',
        ];
        $this->fileMap = [
            'Eccube\\Controller\\AbstractController' => 'getAbstractControllerService.php',
            'Eccube\\Controller\\AbstractShoppingController' => 'getAbstractShoppingControllerService.php',
            'Eccube\\Controller\\Admin\\AbstractCsvImportController' => 'getAbstractCsvImportControllerService.php',
            'Eccube\\Controller\\Admin\\AdminController' => 'getAdminControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\BlockController' => 'getBlockControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\CacheController' => 'getCacheControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\CssController' => 'getCssControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\FileController' => 'getFileControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\JsController' => 'getJsControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\LayoutController' => 'getLayoutControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\MaintenanceController' => 'getMaintenanceControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\NewsController' => 'getNewsControllerService.php',
            'Eccube\\Controller\\Admin\\Content\\PageController' => 'getPageControllerService.php',
            'Eccube\\Controller\\Admin\\Customer\\CustomerController' => 'getCustomerControllerService.php',
            'Eccube\\Controller\\Admin\\Customer\\CustomerDeliveryEditController' => 'getCustomerDeliveryEditControllerService.php',
            'Eccube\\Controller\\Admin\\Customer\\CustomerEditController' => 'getCustomerEditControllerService.php',
            'Eccube\\Controller\\Admin\\Order\\CsvImportController' => 'getCsvImportControllerService.php',
            'Eccube\\Controller\\Admin\\Order\\EditController' => 'getEditControllerService.php',
            'Eccube\\Controller\\Admin\\Order\\MailController' => 'getMailControllerService.php',
            'Eccube\\Controller\\Admin\\Order\\OrderController' => 'getOrderControllerService.php',
            'Eccube\\Controller\\Admin\\Order\\ShippingController' => 'getShippingControllerService.php',
            'Eccube\\Controller\\Admin\\Product\\CategoryController' => 'getCategoryControllerService.php',
            'Eccube\\Controller\\Admin\\Product\\ClassCategoryController' => 'getClassCategoryControllerService.php',
            'Eccube\\Controller\\Admin\\Product\\ClassNameController' => 'getClassNameControllerService.php',
            'Eccube\\Controller\\Admin\\Product\\CsvImportController' => 'getCsvImportController2Service.php',
            'Eccube\\Controller\\Admin\\Product\\ProductClassController' => 'getProductClassControllerService.php',
            'Eccube\\Controller\\Admin\\Product\\ProductController' => 'getProductControllerService.php',
            'Eccube\\Controller\\Admin\\Product\\TagController' => 'getTagControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\Shop\\CsvController' => 'getCsvControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\Shop\\DeliveryController' => 'getDeliveryControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\Shop\\MailController' => 'getMailController2Service.php',
            'Eccube\\Controller\\Admin\\Setting\\Shop\\OrderStatusController' => 'getOrderStatusControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\Shop\\PaymentController' => 'getPaymentControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\Shop\\ShopController' => 'getShopControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\Shop\\TaxRuleController' => 'getTaxRuleControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\System\\AuthorityController' => 'getAuthorityControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\System\\LogController' => 'getLogControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\System\\LoginHistoryController' => 'getLoginHistoryControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\System\\MasterdataController' => 'getMasterdataControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\System\\MemberController' => 'getMemberControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\System\\SecurityController' => 'getSecurityControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\System\\SystemController' => 'getSystemControllerService.php',
            'Eccube\\Controller\\Admin\\Setting\\System\\TwoFactorAuthController' => 'getTwoFactorAuthControllerService.php',
            'Eccube\\Controller\\Admin\\Store\\OwnerStoreController' => 'getOwnerStoreControllerService.php',
            'Eccube\\Controller\\Admin\\Store\\PluginController' => 'getPluginControllerService.php',
            'Eccube\\Controller\\Admin\\Store\\TemplateController' => 'getTemplateControllerService.php',
            'Eccube\\Controller\\Block\\CartController' => 'getCartControllerService.php',
            'Eccube\\Controller\\Block\\SearchProductController' => 'getSearchProductControllerService.php',
            'Eccube\\Controller\\CartController' => 'getCartController2Service.php',
            'Eccube\\Controller\\ContactController' => 'getContactControllerService.php',
            'Eccube\\Controller\\EntryController' => 'getEntryControllerService.php',
            'Eccube\\Controller\\ForgotController' => 'getForgotControllerService.php',
            'Eccube\\Controller\\HelpController' => 'getHelpControllerService.php',
            'Eccube\\Controller\\InstallPluginController' => 'getInstallPluginControllerService.php',
            'Eccube\\Controller\\Install\\InstallController' => 'getInstallControllerService.php',
            'Eccube\\Controller\\Mypage\\ChangeController' => 'getChangeControllerService.php',
            'Eccube\\Controller\\Mypage\\DeliveryController' => 'getDeliveryController2Service.php',
            'Eccube\\Controller\\Mypage\\MypageController' => 'getMypageControllerService.php',
            'Eccube\\Controller\\Mypage\\WithdrawController' => 'getWithdrawControllerService.php',
            'Eccube\\Controller\\NonMemberShoppingController' => 'getNonMemberShoppingControllerService.php',
            'Eccube\\Controller\\ProductController' => 'getProductController2Service.php',
            'Eccube\\Controller\\ShippingMultipleController' => 'getShippingMultipleControllerService.php',
            'Eccube\\Controller\\ShoppingController' => 'getShoppingControllerService.php',
            'Eccube\\Controller\\SitemapController' => 'getSitemapControllerService.php',
            'Eccube\\Controller\\TopController' => 'getTopControllerService.php',
            'Eccube\\Controller\\UserDataController' => 'getUserDataControllerService.php',
            'Eccube\\DependencyInjection\\Facade\\AnnotationReaderFacade' => 'getAnnotationReaderFacadeService.php',
            'Eccube\\Repository\\PluginRepository' => 'getPluginRepositoryService.php',
            'Eccube\\Service\\Composer\\ComposerApiService' => 'getComposerApiServiceService.php',
            'Eccube\\Service\\Payment\\Method\\Cash' => 'getCashService.php',
            'Eccube\\Service\\PluginService' => 'getPluginServiceService.php',
            'Eccube\\Service\\SystemService' => 'getSystemServiceService.php',
            'Eccube\\Service\\TaxRuleService' => 'getTaxRuleServiceService.php',
            'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController' => 'getRedirectControllerService.php',
            'Symfony\\Bundle\\FrameworkBundle\\Controller\\TemplateController' => 'getTemplateController2Service.php',
            'Trikoder\\Bundle\\OAuth2Bundle\\Controller\\AuthorizationController' => 'getAuthorizationControllerService.php',
            'Trikoder\\Bundle\\OAuth2Bundle\\Controller\\TokenController' => 'getTokenControllerService.php',
            'Trikoder\\Bundle\\OAuth2Bundle\\Manager\\ClientManagerInterface' => 'getClientManagerInterfaceService.php',
            'cache.app' => 'getCache_AppService.php',
            'cache.app_clearer' => 'getCache_AppClearerService.php',
            'cache.global_clearer' => 'getCache_GlobalClearerService.php',
            'cache.system' => 'getCache_SystemService.php',
            'cache.system_clearer' => 'getCache_SystemClearerService.php',
            'cache_clearer' => 'getCacheClearerService.php',
            'cache_warmer' => 'getCacheWarmerService.php',
            'console.command.public_alias.Eccube\\Command\\UpdateSchemaDoctrineCommand' => 'getUpdateSchemaDoctrineCommandService.php',
            'console.command.public_alias.doctrine_cache.contains_command' => 'getConsole_Command_PublicAlias_DoctrineCache_ContainsCommandService.php',
            'console.command.public_alias.doctrine_cache.delete_command' => 'getConsole_Command_PublicAlias_DoctrineCache_DeleteCommandService.php',
            'console.command.public_alias.doctrine_cache.flush_command' => 'getConsole_Command_PublicAlias_DoctrineCache_FlushCommandService.php',
            'console.command.public_alias.doctrine_cache.stats_command' => 'getConsole_Command_PublicAlias_DoctrineCache_StatsCommandService.php',
            'console.command.public_alias.doctrine_migrations.diff_command' => 'getConsole_Command_PublicAlias_DoctrineMigrations_DiffCommandService.php',
            'console.command.public_alias.doctrine_migrations.execute_command' => 'getConsole_Command_PublicAlias_DoctrineMigrations_ExecuteCommandService.php',
            'console.command.public_alias.doctrine_migrations.generate_command' => 'getConsole_Command_PublicAlias_DoctrineMigrations_GenerateCommandService.php',
            'console.command.public_alias.doctrine_migrations.latest_command' => 'getConsole_Command_PublicAlias_DoctrineMigrations_LatestCommandService.php',
            'console.command.public_alias.doctrine_migrations.migrate_command' => 'getConsole_Command_PublicAlias_DoctrineMigrations_MigrateCommandService.php',
            'console.command.public_alias.doctrine_migrations.status_command' => 'getConsole_Command_PublicAlias_DoctrineMigrations_StatusCommandService.php',
            'console.command.public_alias.doctrine_migrations.version_command' => 'getConsole_Command_PublicAlias_DoctrineMigrations_VersionCommandService.php',
            'console.command_loader' => 'getConsole_CommandLoaderService.php',
            'container.env_var_processors_locator' => 'getContainer_EnvVarProcessorsLocatorService.php',
            'eccube.logger' => 'getEccube_LoggerService.php',
            'error_controller' => 'getErrorControllerService.php',
            'filesystem' => 'getFilesystemService.php',
            'form.factory' => 'getForm_FactoryService.php',
            'form.type.file' => 'getForm_Type_FileService.php',
            'knp_paginator' => 'getKnpPaginatorService.php',
            'monolog.logger.admin' => 'getMonolog_Logger_AdminService.php',
            'monolog.logger.front' => 'getMonolog_Logger_FrontService.php',
            'routing.loader' => 'getRouting_LoaderService.php',
            'security.authentication_utils' => 'getSecurity_AuthenticationUtilsService.php',
            'security.password_encoder' => 'getSecurity_PasswordEncoderService.php',
            'serializer' => 'getSerializerService.php',
            'services_resetter' => 'getServicesResetterService.php',
            'swiftmailer.mailer.default' => 'getSwiftmailer_Mailer_DefaultService.php',
            'swiftmailer.mailer.default.transport.real' => 'getSwiftmailer_Mailer_Default_Transport_RealService.php',
            'swiftmailer.transport' => 'getSwiftmailer_TransportService.php',
            'templating' => 'getTemplatingService.php',
            'templating.loader' => 'getTemplating_LoaderService.php',
            'twig.controller.exception' => 'getTwig_Controller_ExceptionService.php',
            'twig.controller.preview_error' => 'getTwig_Controller_PreviewErrorService.php',
            'validator' => 'getValidatorService.php',
        ];
        $this->aliases = [
            'database_connection' => 'doctrine.dbal.default_connection',
            'doctrine.orm.entity_manager' => 'doctrine.orm.default_entity_manager',
            'mailer' => 'swiftmailer.mailer.default',
        ];

        $this->privates['service_container'] = function () {
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/HttpKernelInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/KernelInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/RebootableInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/TerminableInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Kernel.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Kernel/MicroKernelTrait.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Kernel.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/event-dispatcher-contracts/EventDispatcherInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/event-dispatcher/EventDispatcherInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/event-dispatcher/EventDispatcher.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Event/EventDispatcherWrapper.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Doctrine/Query/Queries.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/event-dispatcher/EventSubscriberInterface.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/EventListener/ForwardOnlyListener.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/EventListener/IpAddrListener.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/EventListener/LogListener.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/EventListener/MobileTemplatePathListener.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/EventListener/TransactionListener.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/EventListener/TwigInitializeListener.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/EventListener/TwoFactorAuthListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectRepository.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/collections/lib/Doctrine/Common/Collections/Selectable.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityRepository.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Repository/ServiceEntityRepositoryInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Repository/ServiceEntityRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/AbstractRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/AuthorityRoleRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/BaseInfoRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/BlockPositionRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/BlockRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/CartRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/LayoutRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/Master/DeviceTypeRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/OrderRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/PageLayoutRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/PageRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/ProductClassRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/ProductRepository.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Request/Context.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Encoder/PasswordEncoderInterface.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Security/Core/Encoder/PasswordEncoder.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Service/TwoFactorAuthService.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/Extension/ExtensionInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/Extension/AbstractExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/EccubeExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/TaxExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Common/EccubeConfig.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Formatter/FormatterInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Formatter/NormalizerFormatter.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Formatter/LineFormatter.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Log/Processor/SessionProcessor.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Log/Processor/TokenProcessor.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Processor/ProcessorInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/ResettableInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Processor/UidProcessor.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Processor/IntrospectionProcessor.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Processor/WebProcessor.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/monolog-bridge/Processor/WebProcessor.php';
            include_once \dirname(__DIR__, 4).'/vendor/mobiledetect/mobiledetectlib/Mobile_Detect.php';
            include_once \dirname(__DIR__, 4).'/vendor/mobiledetect/mobiledetectlib/namespaced/Detection/MobileDetect.php';
            include_once \dirname(__DIR__, 4).'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/DeviceDetector/MobileDetector.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/ControllerNameParser.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/ControllerMetadata/ArgumentMetadataFactoryInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/ControllerMetadata/ArgumentMetadataFactory.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/ResponseListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/StreamedResponseListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/LocaleListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/ValidateRequestListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/EventListener/ResolveControllerNameSubscriber.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/ErrorListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/HttpKernel.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Controller/ControllerResolverInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Controller/ControllerResolver.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Controller/ContainerControllerResolver.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/ControllerResolver.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Controller/ArgumentResolverInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Controller/ArgumentResolver.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestStack.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/UriSigner.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/config/ConfigCacheFactoryInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/config/ResourceCheckerConfigCacheFactory.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/LocaleAwareListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/psr/cache/src/CacheItemPoolInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/AdapterInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache-contracts/CacheInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/psr/log/Psr/Log/LoggerAwareInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/service-contracts/ResetInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/ResettableInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/psr/log/Psr/Log/LoggerAwareTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/AbstractTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/AbstractAdapterTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache-contracts/CacheTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/ContractsTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/AbstractAdapter.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Marshaller/MarshallerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Marshaller/DefaultMarshaller.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/PruneableInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/FilesystemCommonTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/FilesystemTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/FilesystemAdapter.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/SessionInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/Session.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/Storage/SessionStorageInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/Storage/NativeSessionStorage.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/Storage/Handler/AbstractSessionHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/Storage/Handler/StrictSessionHandler.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Session/Storage/Handler/SameSiteNoneCompatSessionHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/Storage/Handler/NativeFileSessionHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/SessionBagInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/Storage/MetadataBag.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/AbstractSessionListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/SessionListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/psr/container/src/ContainerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/service-contracts/ServiceProviderInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/service-contracts/ServiceLocatorTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/dependency-injection/ServiceLocator.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Csrf/TokenStorage/TokenStorageInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Csrf/TokenStorage/ClearableTokenStorageInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Csrf/TokenStorage/SessionTokenStorage.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Csrf/CsrfTokenManagerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Csrf/CsrfTokenManager.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Csrf/TokenGenerator/TokenGeneratorInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Csrf/TokenGenerator/UriSafeTokenGenerator.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/HttpCache/SurrogateInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/HttpCache/AbstractSurrogate.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/HttpCache/Esi.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/SurrogateListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/FragmentListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/WorkflowInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/Workflow.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/StateMachine.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/Definition.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/Transition.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/Metadata/MetadataStoreInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/Metadata/GetMetadataTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/Metadata/InMemoryMetadataStore.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/MarkingStore/MarkingStoreInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/MarkingStore/SingleStateMarkingStore.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/DebugHandlersListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/psr/log/Psr/Log/LoggerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Logger.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Log/DebugLoggerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/monolog-bridge/Logger.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Debug/FileLinkFormatter.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/stopwatch/Stopwatch.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/routing/RequestContext.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/EventListener/RouterListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/annotations/lib/Doctrine/Common/Annotations/Reader.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/annotations/lib/Doctrine/Common/Annotations/AnnotationReader.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/annotations/lib/Doctrine/Common/Annotations/AnnotationRegistry.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/ProxyTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Traits/PhpArrayTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/Adapter/PhpArrayAdapter.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authorization/AuthorizationCheckerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authorization/AuthorizationChecker.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authentication/Token/Storage/TokenStorageInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/service-contracts/ServiceSubscriberInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authentication/Token/Storage/UsageTrackingTokenStorage.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authentication/Token/Storage/TokenStorage.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authentication/AuthenticationManagerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authentication/AuthenticationProviderManager.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authentication/AuthenticationTrustResolverInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authentication/AuthenticationTrustResolver.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Encoder/EncoderFactoryInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Encoder/EncoderFactory.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authorization/AccessDecisionManagerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authorization/AccessDecisionManager.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Role/RoleHierarchyInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Role/RoleHierarchy.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Http/Firewall.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security-bundle/EventListener/FirewallListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Http/FirewallMapInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security-bundle/Security/FirewallMap.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Http/Logout/LogoutUrlGenerator.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Http/RememberMe/ResponseListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ConnectionRegistry.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ManagerRegistry.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/AbstractManagerRegistry.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/doctrine-bridge/ManagerRegistry.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/doctrine-bridge/RegistryInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Registry.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/dbal/lib/Doctrine/DBAL/Driver/Connection.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/dbal/lib/Doctrine/DBAL/Connection.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/ConnectionFactory.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/dbal/lib/Doctrine/DBAL/Configuration.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/event-manager/lib/Doctrine/Common/EventManager.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/doctrine-bridge/ContainerAwareEventManager.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/EventListener/ControllerListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/EventListener/ParamConverterListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/Request/ParamConverter/ParamConverterManager.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/Request/ParamConverter/ParamConverterInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/Request/ParamConverter/DoctrineParamConverter.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/expression-language/ExpressionLanguage.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/Request/ParamConverter/DateTimeParamConverter.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/EventListener/TemplateListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/Templating/TemplateGuesser.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/EventListener/HttpCacheListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/EventListener/SecurityListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/security/Core/Authorization/ExpressionLanguage.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/Security/ExpressionLanguage.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/EventListener/IsGrantedListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/Request/ArgumentNameConverter.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Handler/HandlerInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Handler/AbstractHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Handler/FingersCrossedHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Handler/AbstractProcessingHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Handler/StreamHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Handler/RotatingFileHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/monolog/monolog/src/Monolog/Processor/PsrLogMessageProcessor.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/monolog-bridge/Handler/ConsoleHandler.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/Environment.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/Loader/LoaderInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/Loader/ExistsLoaderInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/Loader/SourceContextLoaderInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/Loader/FilesystemLoader.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bundle/Loader/FilesystemLoader.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/CsrfExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/LogoutUrlExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/SecurityExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/TranslationExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/AssetExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/asset/Packages.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/asset/PackageInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/asset/Package.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/asset/PathPackage.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/asset/VersionStrategy/VersionStrategyInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/asset/VersionStrategy/EmptyVersionStrategy.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/asset/Context/ContextInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/asset/Context/RequestStackContext.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/CodeExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/RoutingExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/YamlExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/StopwatchExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/ExpressionExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/HttpKernelExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/HttpFoundationExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/UrlHelper.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/WorkflowExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/Registry.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/SupportStrategy/WorkflowSupportStrategyInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/SupportStrategy/InstanceOfSupportStrategy.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Extension/FormExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/CartServiceExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/CsrfExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/EccubeBlockExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/IntlExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/RepositoryExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/SafeTextmailEscaperExtension.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/TwigIncludeExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/Extension/StringLoaderExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/extensions/lib/Twig/Extensions/Extension/Intl.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Twig/DoctrineExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/Twig/Extension/MobileDetectExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Twig/Extension/PaginationExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Helper/Processor.php';
            include_once \dirname(__DIR__, 4).'/vendor/exercise/htmlpurifier-bundle/src/Twig/HTMLPurifierExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/AppVariable.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/RuntimeLoader/RuntimeLoaderInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/twig/twig/src/RuntimeLoader/ContainerRuntimeLoader.php';
            include_once \dirname(__DIR__, 4).'/src/Eccube/Twig/Extension/IgnoreRoutingNotFoundExtension.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/twig-bundle/DependencyInjection/Configurator/EnvironmentConfigurator.php';
            include_once \dirname(__DIR__, 4).'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/Helper/DeviceView.php';
            include_once \dirname(__DIR__, 4).'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/EventListener/RequestResponseListener.php';
            include_once \dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Subscriber/SlidingPaginationSubscriber.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation-contracts/LocaleAwareInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation/TranslatorInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation-contracts/TranslatorInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation/TranslatorBagInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation/Translator.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/CacheWarmer/WarmableInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Translation/Translator.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation/Formatter/MessageFormatterInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation/Formatter/IntlFormatterInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation/Formatter/ChoiceMessageFormatterInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation/Formatter/MessageFormatter.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation-contracts/TranslatorTrait.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/translation/IdentityTranslator.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/routing/RequestContextAwareInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/routing/Matcher/UrlMatcherInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/routing/Generator/UrlGeneratorInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/routing/RouterInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/routing/Matcher/RequestMatcherInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/routing/Router.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/dependency-injection/ServiceSubscriberInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/DependencyInjection/CompatibilityServiceSubscriberInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Routing/Router.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/dependency-injection/ParameterBag/ParameterBagInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/dependency-injection/ParameterBag/ParameterBag.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/dependency-injection/ParameterBag/FrozenParameterBag.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/dependency-injection/ParameterBag/ContainerBagInterface.php';
            include_once \dirname(__DIR__, 4).'/vendor/symfony/dependency-injection/ParameterBag/ContainerBag.php';
            include_once \dirname(__DIR__, 4).'/vendor/doctrine/annotations/lib/Doctrine/Common/Annotations/PsrCachedReader.php';
        };
    }

    public function compile(): void
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled(): bool
    {
        return true;
    }

    public function getRemovedIds(): array
    {
        return require $this->containerDir.\DIRECTORY_SEPARATOR.'removed-ids.php';
    }

    protected function load($file, $lazyLoad = true)
    {
        return require $this->containerDir.\DIRECTORY_SEPARATOR.$file;
    }

    protected function createProxy($class, \Closure $factory)
    {
        class_exists($class, false) || $this->load("{$class}.php");

        return $factory();
    }

    /*
     * Gets the public 'Eccube\Common\EccubeConfig' shared autowired service.
     *
     * @return \Eccube\Common\EccubeConfig
     */
    protected function getEccubeConfigService()
    {
        return $this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this);
    }

    /*
     * Gets the public 'SunCat\MobileDetectBundle\DeviceDetector\MobileDetector' shared autowired service.
     *
     * @return \SunCat\MobileDetectBundle\DeviceDetector\MobileDetector
     */
    protected function getMobileDetectorService()
    {
        return $this->services['SunCat\\MobileDetectBundle\\DeviceDetector\\MobileDetector'] = new \SunCat\MobileDetectBundle\DeviceDetector\MobileDetector();
    }

    /*
     * Gets the public 'doctrine' shared service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected function getDoctrineService()
    {
        return $this->services['doctrine'] = new \Doctrine\Bundle\DoctrineBundle\Registry($this, $this->parameters['doctrine.connections'], $this->parameters['doctrine.entity_managers'], 'default', 'default');
    }

    /*
     * Gets the public 'doctrine.dbal.default_connection' shared service.
     *
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDoctrine_Dbal_DefaultConnectionService()
    {
        $a = new \Symfony\Bridge\Doctrine\ContainerAwareEventManager(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'Eccube\\Doctrine\\EventSubscriber\\InitSubscriber' => ['privates', 'Eccube\\Doctrine\\EventSubscriber\\InitSubscriber', 'getInitSubscriberService.php', true],
            'Eccube\\Doctrine\\EventSubscriber\\SaveEventSubscriber' => ['privates', 'Eccube\\Doctrine\\EventSubscriber\\SaveEventSubscriber', 'getSaveEventSubscriberService.php', true],
            'Eccube\\Doctrine\\EventSubscriber\\TaxRuleEventSubscriber' => ['privates', 'Eccube\\Doctrine\\EventSubscriber\\TaxRuleEventSubscriber', 'getTaxRuleEventSubscriberService.php', true],
            'doctrine.orm.default_listeners.attach_entity_listeners' => ['privates', 'doctrine.orm.default_listeners.attach_entity_listeners', 'getDoctrine_Orm_DefaultListeners_AttachEntityListenersService.php', true],
        ], [
            'Eccube\\Doctrine\\EventSubscriber\\InitSubscriber' => '?',
            'Eccube\\Doctrine\\EventSubscriber\\SaveEventSubscriber' => '?',
            'Eccube\\Doctrine\\EventSubscriber\\TaxRuleEventSubscriber' => '?',
            'doctrine.orm.default_listeners.attach_entity_listeners' => '?',
        ]), [0 => 'Eccube\\Doctrine\\EventSubscriber\\InitSubscriber', 1 => 'Eccube\\Doctrine\\EventSubscriber\\SaveEventSubscriber', 2 => 'Eccube\\Doctrine\\EventSubscriber\\TaxRuleEventSubscriber']);
        $a->addEventListener([0 => 'loadClassMetadata'], 'doctrine.orm.default_listeners.attach_entity_listeners');

        return $this->services['doctrine.dbal.default_connection'] = (new \Doctrine\Bundle\DoctrineBundle\ConnectionFactory($this->parameters['doctrine.dbal.connection_factory.types']))->createConnection(['driver' => 'pdo_sqlite', 'charset' => 'utf8', 'url' => $this->getEnv('DATABASE_URL'), 'host' => 'localhost', 'port' => NULL, 'user' => 'root', 'password' => NULL, 'driverOptions' => [], 'serverVersion' => $this->getEnv('DATABASE_SERVER_VERSION'), 'defaultTableOptions' => ['collate' => 'utf8_general_ci']], new \Doctrine\DBAL\Configuration(), $a, []);
    }

    /*
     * Gets the public 'doctrine.orm.default_entity_manager' shared service.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getDoctrine_Orm_DefaultEntityManagerService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->services['doctrine.orm.default_entity_manager'] = $this->createProxy('EntityManager_9a5be93', function () {
                return \EntityManager_9a5be93::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getDoctrine_Orm_DefaultEntityManagerService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Configuration.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Cache/CacheConfiguration.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Cache/CacheFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Cache/DefaultCacheFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Cache/RegionsConfiguration.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/cache/lib/Doctrine/Common/Cache/Cache.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/cache/lib/Doctrine/Common/Cache/FlushableCache.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/cache/lib/Doctrine/Common/Cache/ClearableCache.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/cache/lib/Doctrine/Common/Cache/MultiGetCache.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/cache/lib/Doctrine/Common/Cache/MultiDeleteCache.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/cache/lib/Doctrine/Common/Cache/MultiPutCache.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/cache/lib/Doctrine/Common/Cache/MultiOperationCache.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/cache/lib/Doctrine/Common/Cache/CacheProvider.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/cache/DoctrineProvider.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/Mapping/Driver/MappingDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/Mapping/Driver/MappingDriverChain.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/Mapping/Driver/FileDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/XmlDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/Mapping/Driver/FileLocator.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/Mapping/Driver/SymfonyFileLocator.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/Mapping/Driver/AnnotationDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/AnnotationDriver.php';
        include_once \dirname(__DIR__, 4).'/src/Eccube/Doctrine/ORM/Mapping/Driver/AnnotationDriver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/NamingStrategy.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/UnderscoreNamingStrategy.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/QuoteStrategy.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/DefaultQuoteStrategy.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/EntityListenerResolver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Mapping/EntityListenerServiceResolver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Mapping/ContainerEntityListenerResolver.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/Repository/RepositoryFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Repository/ContainerRepositoryFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/ManagerConfigurator.php';

        $a = new \Doctrine\ORM\Configuration();

        $b = new \Doctrine\ORM\Cache\CacheConfiguration();

        $c = new \Doctrine\ORM\Cache\RegionsConfiguration(3600, 60);
        $d = new \Symfony\Component\Cache\DoctrineProvider(($this->privates['doctrine.app_cache_pool'] ?? $this->getDoctrine_AppCachePoolService()));

        $b->setCacheFactory(new \Doctrine\ORM\Cache\DefaultCacheFactory($c, $d));
        $b->setRegionsConfiguration($c);
        $e = new \Doctrine\Persistence\Mapping\Driver\MappingDriverChain();

        $f = ($this->privates['annotations.cached_reader'] ?? $this->getAnnotations_CachedReaderService());

        $g = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/src/Eccube/Entity')]);
        $g->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));
        $h = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Plugin/Api/Entity')]);
        $h->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));
        $i = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Plugin/Coupon4/Entity')]);
        $i->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));
        $j = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Plugin/MailMagazine4/Entity')]);
        $j->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));
        $k = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Plugin/ProductReview4/Entity')]);
        $k->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));
        $l = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Plugin/Recommend4/Entity')]);
        $l->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));
        $m = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Plugin/RelatedProduct4/Entity')]);
        $m->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));
        $n = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Plugin/Securitychecker4/Entity')]);
        $n->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));
        $o = new \Eccube\Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Plugin/SiteKit/Entity')]);
        $o->setTraitProxiesDirectory((\dirname(__DIR__, 4).'/app/proxy/entity'));

        $e->addDriver(new \Doctrine\ORM\Mapping\Driver\XmlDriver(new \Doctrine\Common\Persistence\Mapping\Driver\SymfonyFileLocator([(\dirname(__DIR__, 4).'/vendor/trikoder/oauth2-bundle/Resources/config/doctrine/model') => 'Trikoder\\Bundle\\OAuth2Bundle\\Model'], '.orm.xml')), 'Trikoder\\Bundle\\OAuth2Bundle\\Model');
        $e->addDriver($g, 'Eccube\\Entity');
        $e->addDriver(new \Doctrine\ORM\Mapping\Driver\AnnotationDriver($f, [0 => (\dirname(__DIR__, 4).'/app/Customize/Entity')]), 'Customize\\Entity');
        $e->addDriver($h, 'Plugin\\Api\\Entity');
        $e->addDriver($i, 'Plugin\\Coupon4\\Entity');
        $e->addDriver($j, 'Plugin\\MailMagazine4\\Entity');
        $e->addDriver($k, 'Plugin\\ProductReview4\\Entity');
        $e->addDriver($l, 'Plugin\\Recommend4\\Entity');
        $e->addDriver($m, 'Plugin\\RelatedProduct4\\Entity');
        $e->addDriver($n, 'Plugin\\Securitychecker4\\Entity');
        $e->addDriver($o, 'Plugin\\SiteKit\\Entity');

        $a->setEntityNamespaces([]);
        $a->setSecondLevelCacheEnabled(true);
        $a->setSecondLevelCacheConfiguration($b);
        $a->setMetadataCacheImpl($d);
        $a->setQueryCacheImpl($d);
        $a->setResultCacheImpl($d);
        $a->setMetadataDriverImpl($e);
        $a->setProxyDir(($this->targetDir.''.'/doctrine/orm/Proxies'));
        $a->setProxyNamespace('Proxies');
        $a->setAutoGenerateProxyClasses(false);
        $a->setClassMetadataFactoryName('Doctrine\\ORM\\Mapping\\ClassMetadataFactory');
        $a->setDefaultRepositoryClassName('Doctrine\\ORM\\EntityRepository');
        $a->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy(0, true));
        $a->setQuoteStrategy(new \Doctrine\ORM\Mapping\DefaultQuoteStrategy());
        $a->setEntityListenerResolver(new \Doctrine\Bundle\DoctrineBundle\Mapping\ContainerEntityListenerResolver($this));
        $a->setRepositoryFactory(new \Doctrine\Bundle\DoctrineBundle\Repository\ContainerRepositoryFactory(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'Eccube\\Repository\\AuthorityRoleRepository' => ['privates', 'Eccube\\Repository\\AuthorityRoleRepository', 'getAuthorityRoleRepositoryService', false],
            'Eccube\\Repository\\BaseInfoRepository' => ['privates', 'Eccube\\Repository\\BaseInfoRepository', 'getBaseInfoRepositoryService', false],
            'Eccube\\Repository\\BlockPositionRepository' => ['privates', 'Eccube\\Repository\\BlockPositionRepository', 'getBlockPositionRepositoryService', false],
            'Eccube\\Repository\\BlockRepository' => ['privates', 'Eccube\\Repository\\BlockRepository', 'getBlockRepositoryService', false],
            'Eccube\\Repository\\CartItemRepository' => ['privates', 'Eccube\\Repository\\CartItemRepository', 'getCartItemRepositoryService.php', true],
            'Eccube\\Repository\\CartRepository' => ['privates', 'Eccube\\Repository\\CartRepository', 'getCartRepositoryService', false],
            'Eccube\\Repository\\CategoryRepository' => ['privates', 'Eccube\\Repository\\CategoryRepository', 'getCategoryRepositoryService.php', true],
            'Eccube\\Repository\\ClassCategoryRepository' => ['privates', 'Eccube\\Repository\\ClassCategoryRepository', 'getClassCategoryRepositoryService.php', true],
            'Eccube\\Repository\\ClassNameRepository' => ['privates', 'Eccube\\Repository\\ClassNameRepository', 'getClassNameRepositoryService.php', true],
            'Eccube\\Repository\\CsvRepository' => ['privates', 'Eccube\\Repository\\CsvRepository', 'getCsvRepositoryService.php', true],
            'Eccube\\Repository\\CustomerAddressRepository' => ['privates', 'Eccube\\Repository\\CustomerAddressRepository', 'getCustomerAddressRepositoryService.php', true],
            'Eccube\\Repository\\CustomerFavoriteProductRepository' => ['privates', 'Eccube\\Repository\\CustomerFavoriteProductRepository', 'getCustomerFavoriteProductRepositoryService.php', true],
            'Eccube\\Repository\\CustomerRepository' => ['privates', 'Eccube\\Repository\\CustomerRepository', 'getCustomerRepositoryService.php', true],
            'Eccube\\Repository\\DeliveryDurationRepository' => ['privates', 'Eccube\\Repository\\DeliveryDurationRepository', 'getDeliveryDurationRepositoryService.php', true],
            'Eccube\\Repository\\DeliveryFeeRepository' => ['privates', 'Eccube\\Repository\\DeliveryFeeRepository', 'getDeliveryFeeRepositoryService.php', true],
            'Eccube\\Repository\\DeliveryRepository' => ['privates', 'Eccube\\Repository\\DeliveryRepository', 'getDeliveryRepositoryService.php', true],
            'Eccube\\Repository\\DeliveryTimeRepository' => ['privates', 'Eccube\\Repository\\DeliveryTimeRepository', 'getDeliveryTimeRepositoryService.php', true],
            'Eccube\\Repository\\LayoutRepository' => ['privates', 'Eccube\\Repository\\LayoutRepository', 'getLayoutRepositoryService', false],
            'Eccube\\Repository\\LoginHistoryRepository' => ['privates', 'Eccube\\Repository\\LoginHistoryRepository', 'getLoginHistoryRepositoryService.php', true],
            'Eccube\\Repository\\MailHistoryRepository' => ['privates', 'Eccube\\Repository\\MailHistoryRepository', 'getMailHistoryRepositoryService.php', true],
            'Eccube\\Repository\\MailTemplateRepository' => ['privates', 'Eccube\\Repository\\MailTemplateRepository', 'getMailTemplateRepositoryService.php', true],
            'Eccube\\Repository\\Master\\AuthorityRepository' => ['privates', 'Eccube\\Repository\\Master\\AuthorityRepository', 'getAuthorityRepositoryService.php', true],
            'Eccube\\Repository\\Master\\CountryRepository' => ['privates', 'Eccube\\Repository\\Master\\CountryRepository', 'getCountryRepositoryService.php', true],
            'Eccube\\Repository\\Master\\CsvTypeRepository' => ['privates', 'Eccube\\Repository\\Master\\CsvTypeRepository', 'getCsvTypeRepositoryService.php', true],
            'Eccube\\Repository\\Master\\CustomerOrderStatusRepository' => ['privates', 'Eccube\\Repository\\Master\\CustomerOrderStatusRepository', 'getCustomerOrderStatusRepositoryService.php', true],
            'Eccube\\Repository\\Master\\CustomerStatusRepository' => ['privates', 'Eccube\\Repository\\Master\\CustomerStatusRepository', 'getCustomerStatusRepositoryService.php', true],
            'Eccube\\Repository\\Master\\DeviceTypeRepository' => ['privates', 'Eccube\\Repository\\Master\\DeviceTypeRepository', 'getDeviceTypeRepositoryService', false],
            'Eccube\\Repository\\Master\\JobRepository' => ['privates', 'Eccube\\Repository\\Master\\JobRepository', 'getJobRepositoryService.php', true],
            'Eccube\\Repository\\Master\\LoginHistoryStatusRepository' => ['privates', 'Eccube\\Repository\\Master\\LoginHistoryStatusRepository', 'getLoginHistoryStatusRepositoryService.php', true],
            'Eccube\\Repository\\Master\\OrderItemTypeRepository' => ['privates', 'Eccube\\Repository\\Master\\OrderItemTypeRepository', 'getOrderItemTypeRepositoryService.php', true],
            'Eccube\\Repository\\Master\\OrderStatusColorRepository' => ['privates', 'Eccube\\Repository\\Master\\OrderStatusColorRepository', 'getOrderStatusColorRepositoryService.php', true],
            'Eccube\\Repository\\Master\\OrderStatusRepository' => ['privates', 'Eccube\\Repository\\Master\\OrderStatusRepository', 'getOrderStatusRepositoryService.php', true],
            'Eccube\\Repository\\Master\\PageMaxRepository' => ['privates', 'Eccube\\Repository\\Master\\PageMaxRepository', 'getPageMaxRepositoryService.php', true],
            'Eccube\\Repository\\Master\\PrefRepository' => ['privates', 'Eccube\\Repository\\Master\\PrefRepository', 'getPrefRepositoryService.php', true],
            'Eccube\\Repository\\Master\\ProductListMaxRepository' => ['privates', 'Eccube\\Repository\\Master\\ProductListMaxRepository', 'getProductListMaxRepositoryService.php', true],
            'Eccube\\Repository\\Master\\ProductListOrderByRepository' => ['privates', 'Eccube\\Repository\\Master\\ProductListOrderByRepository', 'getProductListOrderByRepositoryService.php', true],
            'Eccube\\Repository\\Master\\ProductStatusRepository' => ['privates', 'Eccube\\Repository\\Master\\ProductStatusRepository', 'getProductStatusRepositoryService.php', true],
            'Eccube\\Repository\\Master\\RoundingTypeRepository' => ['privates', 'Eccube\\Repository\\Master\\RoundingTypeRepository', 'getRoundingTypeRepositoryService.php', true],
            'Eccube\\Repository\\Master\\SaleTypeRepository' => ['privates', 'Eccube\\Repository\\Master\\SaleTypeRepository', 'getSaleTypeRepositoryService.php', true],
            'Eccube\\Repository\\Master\\SexRepository' => ['privates', 'Eccube\\Repository\\Master\\SexRepository', 'getSexRepositoryService.php', true],
            'Eccube\\Repository\\Master\\TaxDisplayTypeRepository' => ['privates', 'Eccube\\Repository\\Master\\TaxDisplayTypeRepository', 'getTaxDisplayTypeRepositoryService.php', true],
            'Eccube\\Repository\\Master\\TaxTypeRepository' => ['privates', 'Eccube\\Repository\\Master\\TaxTypeRepository', 'getTaxTypeRepositoryService.php', true],
            'Eccube\\Repository\\Master\\WorkRepository' => ['privates', 'Eccube\\Repository\\Master\\WorkRepository', 'getWorkRepositoryService.php', true],
            'Eccube\\Repository\\MemberRepository' => ['privates', 'Eccube\\Repository\\MemberRepository', 'getMemberRepositoryService.php', true],
            'Eccube\\Repository\\NewsRepository' => ['privates', 'Eccube\\Repository\\NewsRepository', 'getNewsRepositoryService.php', true],
            'Eccube\\Repository\\OrderItemRepository' => ['privates', 'Eccube\\Repository\\OrderItemRepository', 'getOrderItemRepositoryService.php', true],
            'Eccube\\Repository\\OrderPdfRepository' => ['privates', 'Eccube\\Repository\\OrderPdfRepository', 'getOrderPdfRepositoryService.php', true],
            'Eccube\\Repository\\OrderRepository' => ['privates', 'Eccube\\Repository\\OrderRepository', 'getOrderRepositoryService', false],
            'Eccube\\Repository\\PageLayoutRepository' => ['privates', 'Eccube\\Repository\\PageLayoutRepository', 'getPageLayoutRepositoryService', false],
            'Eccube\\Repository\\PageRepository' => ['privates', 'Eccube\\Repository\\PageRepository', 'getPageRepositoryService', false],
            'Eccube\\Repository\\PaymentOptionRepository' => ['privates', 'Eccube\\Repository\\PaymentOptionRepository', 'getPaymentOptionRepositoryService.php', true],
            'Eccube\\Repository\\PaymentRepository' => ['privates', 'Eccube\\Repository\\PaymentRepository', 'getPaymentRepositoryService.php', true],
            'Eccube\\Repository\\PluginRepository' => ['services', 'Eccube\\Repository\\PluginRepository', 'getPluginRepositoryService.php', true],
            'Eccube\\Repository\\ProductCategoryRepository' => ['privates', 'Eccube\\Repository\\ProductCategoryRepository', 'getProductCategoryRepositoryService.php', true],
            'Eccube\\Repository\\ProductClassRepository' => ['privates', 'Eccube\\Repository\\ProductClassRepository', 'getProductClassRepositoryService', false],
            'Eccube\\Repository\\ProductImageRepository' => ['privates', 'Eccube\\Repository\\ProductImageRepository', 'getProductImageRepositoryService.php', true],
            'Eccube\\Repository\\ProductRepository' => ['privates', 'Eccube\\Repository\\ProductRepository', 'getProductRepositoryService', false],
            'Eccube\\Repository\\ProductStockRepository' => ['privates', 'Eccube\\Repository\\ProductStockRepository', 'getProductStockRepositoryService.php', true],
            'Eccube\\Repository\\ProductTagRepository' => ['privates', 'Eccube\\Repository\\ProductTagRepository', 'getProductTagRepositoryService.php', true],
            'Eccube\\Repository\\ShippingRepository' => ['privates', 'Eccube\\Repository\\ShippingRepository', 'getShippingRepositoryService.php', true],
            'Eccube\\Repository\\TagRepository' => ['privates', 'Eccube\\Repository\\TagRepository', 'getTagRepositoryService.php', true],
            'Eccube\\Repository\\TaxRuleRepository' => ['privates', 'Eccube\\Repository\\TaxRuleRepository', 'getTaxRuleRepositoryService', false],
            'Eccube\\Repository\\TemplateRepository' => ['privates', 'Eccube\\Repository\\TemplateRepository', 'getTemplateRepositoryService.php', true],
            'Plugin\\Api\\Repository\\WebHookRepository' => ['privates', 'Plugin\\Api\\Repository\\WebHookRepository', 'getWebHookRepositoryService.php', true],
            'Plugin\\Coupon4\\Repository\\CouponDetailRepository' => ['privates', 'Plugin\\Coupon4\\Repository\\CouponDetailRepository', 'getCouponDetailRepositoryService.php', true],
            'Plugin\\Coupon4\\Repository\\CouponOrderRepository' => ['privates', 'Plugin\\Coupon4\\Repository\\CouponOrderRepository', 'getCouponOrderRepositoryService.php', true],
            'Plugin\\Coupon4\\Repository\\CouponRepository' => ['privates', 'Plugin\\Coupon4\\Repository\\CouponRepository', 'getCouponRepositoryService.php', true],
            'Plugin\\MailMagazine4\\Repository\\MailMagazineSendHistoryRepository' => ['privates', 'Plugin\\MailMagazine4\\Repository\\MailMagazineSendHistoryRepository', 'getMailMagazineSendHistoryRepositoryService.php', true],
            'Plugin\\MailMagazine4\\Repository\\MailMagazineTemplateRepository' => ['privates', 'Plugin\\MailMagazine4\\Repository\\MailMagazineTemplateRepository', 'getMailMagazineTemplateRepositoryService.php', true],
            'Plugin\\ProductReview4\\Repository\\ProductReviewConfigRepository' => ['privates', 'Plugin\\ProductReview4\\Repository\\ProductReviewConfigRepository', 'getProductReviewConfigRepositoryService.php', true],
            'Plugin\\ProductReview4\\Repository\\ProductReviewRepository' => ['privates', 'Plugin\\ProductReview4\\Repository\\ProductReviewRepository', 'getProductReviewRepositoryService.php', true],
            'Plugin\\ProductReview4\\Repository\\ProductReviewStatusRepository' => ['privates', 'Plugin\\ProductReview4\\Repository\\ProductReviewStatusRepository', 'getProductReviewStatusRepositoryService.php', true],
            'Plugin\\Recommend4\\Repository\\RecommendProductRepository' => ['privates', 'Plugin\\Recommend4\\Repository\\RecommendProductRepository', 'getRecommendProductRepositoryService.php', true],
            'Plugin\\RelatedProduct4\\Repository\\RelatedProductRepository' => ['privates', 'Plugin\\RelatedProduct4\\Repository\\RelatedProductRepository', 'getRelatedProductRepositoryService.php', true],
            'Plugin\\Securitychecker4\\Repository\\ConfigRepository' => ['privates', 'Plugin\\Securitychecker4\\Repository\\ConfigRepository', 'getConfigRepositoryService.php', true],
            'Plugin\\SiteKit\\Repository\\IdTokenRepository' => ['privates', 'Plugin\\SiteKit\\Repository\\IdTokenRepository', 'getIdTokenRepositoryService.php', true],
        ], [
            'Eccube\\Repository\\AuthorityRoleRepository' => '?',
            'Eccube\\Repository\\BaseInfoRepository' => '?',
            'Eccube\\Repository\\BlockPositionRepository' => '?',
            'Eccube\\Repository\\BlockRepository' => '?',
            'Eccube\\Repository\\CartItemRepository' => '?',
            'Eccube\\Repository\\CartRepository' => '?',
            'Eccube\\Repository\\CategoryRepository' => '?',
            'Eccube\\Repository\\ClassCategoryRepository' => '?',
            'Eccube\\Repository\\ClassNameRepository' => '?',
            'Eccube\\Repository\\CsvRepository' => '?',
            'Eccube\\Repository\\CustomerAddressRepository' => '?',
            'Eccube\\Repository\\CustomerFavoriteProductRepository' => '?',
            'Eccube\\Repository\\CustomerRepository' => '?',
            'Eccube\\Repository\\DeliveryDurationRepository' => '?',
            'Eccube\\Repository\\DeliveryFeeRepository' => '?',
            'Eccube\\Repository\\DeliveryRepository' => '?',
            'Eccube\\Repository\\DeliveryTimeRepository' => '?',
            'Eccube\\Repository\\LayoutRepository' => '?',
            'Eccube\\Repository\\LoginHistoryRepository' => '?',
            'Eccube\\Repository\\MailHistoryRepository' => '?',
            'Eccube\\Repository\\MailTemplateRepository' => '?',
            'Eccube\\Repository\\Master\\AuthorityRepository' => '?',
            'Eccube\\Repository\\Master\\CountryRepository' => '?',
            'Eccube\\Repository\\Master\\CsvTypeRepository' => '?',
            'Eccube\\Repository\\Master\\CustomerOrderStatusRepository' => '?',
            'Eccube\\Repository\\Master\\CustomerStatusRepository' => '?',
            'Eccube\\Repository\\Master\\DeviceTypeRepository' => '?',
            'Eccube\\Repository\\Master\\JobRepository' => '?',
            'Eccube\\Repository\\Master\\LoginHistoryStatusRepository' => '?',
            'Eccube\\Repository\\Master\\OrderItemTypeRepository' => '?',
            'Eccube\\Repository\\Master\\OrderStatusColorRepository' => '?',
            'Eccube\\Repository\\Master\\OrderStatusRepository' => '?',
            'Eccube\\Repository\\Master\\PageMaxRepository' => '?',
            'Eccube\\Repository\\Master\\PrefRepository' => '?',
            'Eccube\\Repository\\Master\\ProductListMaxRepository' => '?',
            'Eccube\\Repository\\Master\\ProductListOrderByRepository' => '?',
            'Eccube\\Repository\\Master\\ProductStatusRepository' => '?',
            'Eccube\\Repository\\Master\\RoundingTypeRepository' => '?',
            'Eccube\\Repository\\Master\\SaleTypeRepository' => '?',
            'Eccube\\Repository\\Master\\SexRepository' => '?',
            'Eccube\\Repository\\Master\\TaxDisplayTypeRepository' => '?',
            'Eccube\\Repository\\Master\\TaxTypeRepository' => '?',
            'Eccube\\Repository\\Master\\WorkRepository' => '?',
            'Eccube\\Repository\\MemberRepository' => '?',
            'Eccube\\Repository\\NewsRepository' => '?',
            'Eccube\\Repository\\OrderItemRepository' => '?',
            'Eccube\\Repository\\OrderPdfRepository' => '?',
            'Eccube\\Repository\\OrderRepository' => '?',
            'Eccube\\Repository\\PageLayoutRepository' => '?',
            'Eccube\\Repository\\PageRepository' => '?',
            'Eccube\\Repository\\PaymentOptionRepository' => '?',
            'Eccube\\Repository\\PaymentRepository' => '?',
            'Eccube\\Repository\\PluginRepository' => '?',
            'Eccube\\Repository\\ProductCategoryRepository' => '?',
            'Eccube\\Repository\\ProductClassRepository' => '?',
            'Eccube\\Repository\\ProductImageRepository' => '?',
            'Eccube\\Repository\\ProductRepository' => '?',
            'Eccube\\Repository\\ProductStockRepository' => '?',
            'Eccube\\Repository\\ProductTagRepository' => '?',
            'Eccube\\Repository\\ShippingRepository' => '?',
            'Eccube\\Repository\\TagRepository' => '?',
            'Eccube\\Repository\\TaxRuleRepository' => '?',
            'Eccube\\Repository\\TemplateRepository' => '?',
            'Plugin\\Api\\Repository\\WebHookRepository' => '?',
            'Plugin\\Coupon4\\Repository\\CouponDetailRepository' => '?',
            'Plugin\\Coupon4\\Repository\\CouponOrderRepository' => '?',
            'Plugin\\Coupon4\\Repository\\CouponRepository' => '?',
            'Plugin\\MailMagazine4\\Repository\\MailMagazineSendHistoryRepository' => '?',
            'Plugin\\MailMagazine4\\Repository\\MailMagazineTemplateRepository' => '?',
            'Plugin\\ProductReview4\\Repository\\ProductReviewConfigRepository' => '?',
            'Plugin\\ProductReview4\\Repository\\ProductReviewRepository' => '?',
            'Plugin\\ProductReview4\\Repository\\ProductReviewStatusRepository' => '?',
            'Plugin\\Recommend4\\Repository\\RecommendProductRepository' => '?',
            'Plugin\\RelatedProduct4\\Repository\\RelatedProductRepository' => '?',
            'Plugin\\Securitychecker4\\Repository\\ConfigRepository' => '?',
            'Plugin\\SiteKit\\Repository\\IdTokenRepository' => '?',
        ])));
        $a->addCustomStringFunction('NORMALIZE', 'Eccube\\Doctrine\\ORM\\Query\\Normalize');
        $a->addCustomNumericFunction('EXTRACT', 'Eccube\\Doctrine\\ORM\\Query\\Extract');
        $a->addFilter('option_nostock_hidden', 'Eccube\\Doctrine\\Filter\\NoStockHiddenFilter');
        $a->addFilter('incomplete_order_status_hidden', 'Eccube\\Doctrine\\Filter\\OrderStatusFilter');
        $a->addEntityNamespace('TrikoderOAuth2Bundle', 'Trikoder\\Bundle\\OAuth2Bundle\\Model');

        $instance = \Doctrine\ORM\EntityManager::create(($this->services['doctrine.dbal.default_connection'] ?? $this->getDoctrine_Dbal_DefaultConnectionService()), $a);

        (new \Doctrine\Bundle\DoctrineBundle\ManagerConfigurator([], []))->configure($instance);

        return $instance;
    }

    /*
     * Gets the public 'event_dispatcher' shared autowired service.
     *
     * @return \Eccube\Event\EventDispatcherWrapper
     */
    protected function getEventDispatcherService()
    {
        $this->services['event_dispatcher'] = $instance = new \Eccube\Event\EventDispatcherWrapper();

        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['Symfony\\Bridge\\Monolog\\Processor\\WebProcessor'] ?? $this->getWebProcessorService());
        }, 1 => 'onKernelRequest'], 1024);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['mobile_detect.request_listener'] ?? $this->getMobileDetect_RequestListenerService());
        }, 1 => 'handleRequest'], 1);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['mobile_detect.request_listener'] ?? $this->getMobileDetect_RequestListenerService());
        }, 1 => 'handleResponse'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['knp_paginator.subscriber.sliding_pagination'] ?? $this->getKnpPaginator_Subscriber_SlidingPaginationService());
        }, 1 => 'onKernelRequest'], 0);
        $instance->addListener('trikoder.oauth2.authorization_request_resolve', [0 => function () {
            return ($this->privates['Trikoder\\Bundle\\OAuth2Bundle\\EventListener\\AuthorizationRequestUserResolvingListener'] ?? $this->load('getAuthorizationRequestUserResolvingListenerService.php'));
        }, 1 => 'onAuthorizationRequest'], 1024);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\ExceptionListener'] ?? $this->load('getExceptionListenerService.php'));
        }, 1 => 'onKernelException'], 0);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\ForwardOnlyListener'] ?? ($this->privates['Eccube\\EventListener\\ForwardOnlyListener'] = new \Eccube\EventListener\ForwardOnlyListener()));
        }, 1 => 'onController'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\IpAddrListener'] ?? $this->getIpAddrListenerService());
        }, 1 => 'onKernelRequest'], 512);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\LogListener'] ?? $this->getLogListenerService());
        }, 1 => 'onKernelRequestEarly'], 500);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\LogListener'] ?? $this->getLogListenerService());
        }, 1 => 'onKernelRequest'], 6);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\LogListener'] ?? $this->getLogListenerService());
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\LogListener'] ?? $this->getLogListenerService());
        }, 1 => 'onKernelController'], 0);
        $instance->addListener('kernel.terminate', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\LogListener'] ?? $this->getLogListenerService());
        }, 1 => 'onKernelTerminate'], 0);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\LogListener'] ?? $this->getLogListenerService());
        }, 1 => 'onKernelException'], -4);
        $instance->addListener('security.interactive_login', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\LoginHistoryListener'] ?? $this->load('getLoginHistoryListenerService.php'));
        }, 1 => 'onInteractiveLogin'], 0);
        $instance->addListener('security.authentication.failure', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\LoginHistoryListener'] ?? $this->load('getLoginHistoryListenerService.php'));
        }, 1 => 'onAuthenticationFailure'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\MobileTemplatePathListener'] ?? $this->getMobileTemplatePathListenerService());
        }, 1 => 'onKernelRequest'], 512);
        $instance->addListener('security.interactive_login', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\SecurityListener'] ?? $this->load('getSecurityListenerService.php'));
        }, 1 => 'onInteractiveLogin'], 0);
        $instance->addListener('security.authentication.failure', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\SecurityListener'] ?? $this->load('getSecurityListenerService.php'));
        }, 1 => 'onAuthenticationFailure'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\TransactionListener'] ?? $this->getTransactionListenerService());
        }, 1 => 'onKernelRequest'], 0);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\TransactionListener'] ?? $this->getTransactionListenerService());
        }, 1 => 'onKernelException'], 0);
        $instance->addListener('kernel.terminate', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\TransactionListener'] ?? $this->getTransactionListenerService());
        }, 1 => 'onKernelTerminate'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\TwigInitializeListener'] ?? $this->getTwigInitializeListenerService());
        }, 1 => 'onKernelRequest'], 6);
        $instance->addListener('kernel.controller_arguments', [0 => function () {
            return ($this->privates['Eccube\\EventListener\\TwoFactorAuthListener'] ?? $this->getTwoFactorAuthListenerService());
        }, 1 => 'onKernelController'], 7);
        $instance->addListener('form.pre_submit', [0 => function () {
            return ($this->privates['Eccube\\Form\\EventListener\\ConvertKanaListener'] ?? ($this->privates['Eccube\\Form\\EventListener\\ConvertKanaListener'] = new \Eccube\Form\EventListener\ConvertKanaListener()));
        }, 1 => 'onPreSubmit'], 0);
        $instance->addListener('form.pre_submit', [0 => function () {
            return ($this->privates['Eccube\\Form\\EventListener\\HTMLPurifierListener'] ?? ($this->privates['Eccube\\Form\\EventListener\\HTMLPurifierListener'] = new \Eccube\Form\EventListener\HTMLPurifierListener()));
        }, 1 => 'purifySubmittedData'], 1000001);
        $instance->addListener('form.pre_submit', [0 => function () {
            return ($this->privates['Eccube\\Form\\EventListener\\TruncateHyphenListener'] ?? ($this->privates['Eccube\\Form\\EventListener\\TruncateHyphenListener'] = new \Eccube\Form\EventListener\TruncateHyphenListener()));
        }, 1 => 'onPreSubmit'], 0);
        $instance->addListener('workflow.order.completed', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'onCompleted'], 0);
        $instance->addListener('workflow.order.transition.pay', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'updatePaymentDate'], 0);
        $instance->addListener('workflow.order.transition.cancel', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'rollbackStock'], 0);
        $instance->addListener('workflow.order.transition.cancel', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'rollbackUsePoint'], 0);
        $instance->addListener('workflow.order.transition.back_to_in_progress', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'commitStock'], 0);
        $instance->addListener('workflow.order.transition.back_to_in_progress', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'commitUsePoint'], 0);
        $instance->addListener('workflow.order.transition.ship', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'commitAddPoint'], 0);
        $instance->addListener('workflow.order.transition.return', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'rollbackUsePoint'], 0);
        $instance->addListener('workflow.order.transition.return', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'rollbackAddPoint'], 0);
        $instance->addListener('workflow.order.transition.cancel_return', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'commitUsePoint'], 0);
        $instance->addListener('workflow.order.transition.cancel_return', [0 => function () {
            return ($this->privates['Eccube\\Service\\OrderStateMachine'] ?? $this->load('getOrderStateMachineService.php'));
        }, 1 => 'commitAddPoint'], 0);
        $instance->addListener('kernel.terminate', [0 => function () {
            return ($this->services['Eccube\\Service\\SystemService'] ?? $this->load('getSystemServiceService.php'));
        }, 1 => 'disableMaintenanceEvent'], 0);
        $instance->addListener('kernel.terminate', [0 => function () {
            return ($this->privates['Eccube\\Util\\CacheUtil'] ?? ($this->privates['Eccube\\Util\\CacheUtil'] = new \Eccube\Util\CacheUtil(($this->services['kernel'] ?? $this->get('kernel', 1)), $this)));
        }, 1 => 'forceClearCache'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['Symfony\\Bridge\\Monolog\\Processor\\WebProcessor'] ?? $this->getWebProcessorService());
        }, 1 => 'onKernelRequest'], 4096);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['response_listener'] ?? ($this->privates['response_listener'] = new \Symfony\Component\HttpKernel\EventListener\ResponseListener('UTF-8')));
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['streamed_response_listener'] ?? ($this->privates['streamed_response_listener'] = new \Symfony\Component\HttpKernel\EventListener\StreamedResponseListener()));
        }, 1 => 'onKernelResponse'], -1024);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['locale_listener'] ?? $this->getLocaleListenerService());
        }, 1 => 'setDefaultLocale'], 100);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['locale_listener'] ?? $this->getLocaleListenerService());
        }, 1 => 'onKernelRequest'], 16);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['locale_listener'] ?? $this->getLocaleListenerService());
        }, 1 => 'onKernelFinishRequest'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['validate_request_listener'] ?? ($this->privates['validate_request_listener'] = new \Symfony\Component\HttpKernel\EventListener\ValidateRequestListener()));
        }, 1 => 'onKernelRequest'], 256);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['.legacy_resolve_controller_name_subscriber'] ?? $this->get_LegacyResolveControllerNameSubscriberService());
        }, 1 => 'resolveControllerName'], 24);
        $instance->addListener('kernel.controller_arguments', [0 => function () {
            return ($this->privates['exception_listener'] ?? $this->getExceptionListener2Service());
        }, 1 => 'onControllerArguments'], 0);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['exception_listener'] ?? $this->getExceptionListener2Service());
        }, 1 => 'logKernelException'], 0);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['exception_listener'] ?? $this->getExceptionListener2Service());
        }, 1 => 'onKernelException'], -128);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['locale_aware_listener'] ?? $this->getLocaleAwareListenerService());
        }, 1 => 'onKernelRequest'], 15);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['locale_aware_listener'] ?? $this->getLocaleAwareListenerService());
        }, 1 => 'onKernelFinishRequest'], -15);
        $instance->addListener('console.error', [0 => function () {
            return ($this->privates['console.error_listener'] ?? $this->load('getConsole_ErrorListenerService.php'));
        }, 1 => 'onConsoleError'], -128);
        $instance->addListener('console.terminate', [0 => function () {
            return ($this->privates['console.error_listener'] ?? $this->load('getConsole_ErrorListenerService.php'));
        }, 1 => 'onConsoleTerminate'], -128);
        $instance->addListener('console.error', [0 => function () {
            return ($this->privates['console.suggest_missing_package_subscriber'] ?? ($this->privates['console.suggest_missing_package_subscriber'] = new \Symfony\Bundle\FrameworkBundle\EventListener\SuggestMissingPackageSubscriber()));
        }, 1 => 'onConsoleError'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['session_listener'] ?? $this->getSessionListenerService());
        }, 1 => 'onKernelRequest'], 128);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['session_listener'] ?? $this->getSessionListenerService());
        }, 1 => 'onKernelResponse'], -1000);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['session_listener'] ?? $this->getSessionListenerService());
        }, 1 => 'onFinishRequest'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['esi_listener'] ?? $this->getEsiListenerService());
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['fragment.listener'] ?? $this->getFragment_ListenerService());
        }, 1 => 'onKernelRequest'], 48);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['debug.debug_handlers_listener'] ?? $this->getDebug_DebugHandlersListenerService());
        }, 1 => 'configure'], 2048);
        $instance->addListener('console.command', [0 => function () {
            return ($this->privates['debug.debug_handlers_listener'] ?? $this->getDebug_DebugHandlersListenerService());
        }, 1 => 'configure'], 2048);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['router_listener'] ?? $this->getRouterListenerService());
        }, 1 => 'onKernelRequest'], 32);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['router_listener'] ?? $this->getRouterListenerService());
        }, 1 => 'onKernelFinishRequest'], 0);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['router_listener'] ?? $this->getRouterListenerService());
        }, 1 => 'onKernelException'], -64);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['security.firewall'] ?? $this->getSecurity_FirewallService());
        }, 1 => 'configureLogoutUrlGenerator'], 8);
        $instance->addListener('kernel.request', [0 => function () {
            return ($this->privates['security.firewall'] ?? $this->getSecurity_FirewallService());
        }, 1 => 'onKernelRequest'], 8);
        $instance->addListener('kernel.finish_request', [0 => function () {
            return ($this->privates['security.firewall'] ?? $this->getSecurity_FirewallService());
        }, 1 => 'onKernelFinishRequest'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['security.rememberme.response_listener'] ?? ($this->privates['security.rememberme.response_listener'] = new \Symfony\Component\Security\Http\RememberMe\ResponseListener()));
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['sensio_framework_extra.controller.listener'] ?? $this->getSensioFrameworkExtra_Controller_ListenerService());
        }, 1 => 'onKernelController'], 0);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['sensio_framework_extra.converter.listener'] ?? $this->getSensioFrameworkExtra_Converter_ListenerService());
        }, 1 => 'onKernelController'], 0);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['sensio_framework_extra.view.listener'] ?? $this->getSensioFrameworkExtra_View_ListenerService());
        }, 1 => 'onKernelController'], -128);
        $instance->addListener('kernel.view', [0 => function () {
            return ($this->privates['sensio_framework_extra.view.listener'] ?? $this->getSensioFrameworkExtra_View_ListenerService());
        }, 1 => 'onKernelView'], 0);
        $instance->addListener('kernel.controller', [0 => function () {
            return ($this->privates['sensio_framework_extra.cache.listener'] ?? ($this->privates['sensio_framework_extra.cache.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\HttpCacheListener()));
        }, 1 => 'onKernelController'], 0);
        $instance->addListener('kernel.response', [0 => function () {
            return ($this->privates['sensio_framework_extra.cache.listener'] ?? ($this->privates['sensio_framework_extra.cache.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\HttpCacheListener()));
        }, 1 => 'onKernelResponse'], 0);
        $instance->addListener('kernel.controller_arguments', [0 => function () {
            return ($this->privates['sensio_framework_extra.security.listener'] ?? $this->getSensioFrameworkExtra_Security_ListenerService());
        }, 1 => 'onKernelControllerArguments'], 0);
        $instance->addListener('kernel.controller_arguments', [0 => function () {
            return ($this->privates['framework_extra_bundle.event.is_granted'] ?? $this->getFrameworkExtraBundle_Event_IsGrantedService());
        }, 1 => 'onKernelControllerArguments'], 0);
        $instance->addListener('kernel.view', [0 => function () {
            return ($this->privates['sensio_framework_extra.psr7.listener.response'] ?? $this->load('getSensioFrameworkExtra_Psr7_Listener_ResponseService.php'));
        }, 1 => 'onKernelView'], 0);
        $instance->addListener('console.command', [0 => function () {
            return ($this->privates['monolog.handler.console'] ?? $this->getMonolog_Handler_ConsoleService());
        }, 1 => 'onCommand'], 255);
        $instance->addListener('console.terminate', [0 => function () {
            return ($this->privates['monolog.handler.console'] ?? $this->getMonolog_Handler_ConsoleService());
        }, 1 => 'onTerminate'], -255);
        $instance->addListener('kernel.exception', [0 => function () {
            return ($this->privates['swiftmailer.email_sender.listener'] ?? $this->load('getSwiftmailer_EmailSender_ListenerService.php'));
        }, 1 => 'onException'], 0);
        $instance->addListener('kernel.terminate', [0 => function () {
            return ($this->privates['swiftmailer.email_sender.listener'] ?? $this->load('getSwiftmailer_EmailSender_ListenerService.php'));
        }, 1 => 'onTerminate'], 0);
        $instance->addListener('console.error', [0 => function () {
            return ($this->privates['swiftmailer.email_sender.listener'] ?? $this->load('getSwiftmailer_EmailSender_ListenerService.php'));
        }, 1 => 'onException'], 0);
        $instance->addListener('console.terminate', [0 => function () {
            return ($this->privates['swiftmailer.email_sender.listener'] ?? $this->load('getSwiftmailer_EmailSender_ListenerService.php'));
        }, 1 => 'onTerminate'], 0);
        $instance->addListener('knp_pager.before', [0 => function () {
            return ($this->privates['knp_paginator.subscriber.paginate'] ?? ($this->privates['knp_paginator.subscriber.paginate'] = new \Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber()));
        }, 1 => 'before'], 0);
        $instance->addListener('knp_pager.pagination', [0 => function () {
            return ($this->privates['knp_paginator.subscriber.paginate'] ?? ($this->privates['knp_paginator.subscriber.paginate'] = new \Knp\Component\Pager\Event\Subscriber\Paginate\PaginationSubscriber()));
        }, 1 => 'pagination'], 0);
        $instance->addListener('knp_pager.before', [0 => function () {
            return ($this->privates['knp_paginator.subscriber.sortable'] ?? ($this->privates['knp_paginator.subscriber.sortable'] = new \Knp\Component\Pager\Event\Subscriber\Sortable\SortableSubscriber()));
        }, 1 => 'before'], 1);
        $instance->addListener('knp_pager.before', [0 => function () {
            return ($this->privates['knp_paginator.subscriber.filtration'] ?? ($this->privates['knp_paginator.subscriber.filtration'] = new \Knp\Component\Pager\Event\Subscriber\Filtration\FiltrationSubscriber()));
        }, 1 => 'before'], 1);
        $instance->addListener('knp_pager.pagination', [0 => function () {
            return ($this->privates['knp_paginator.subscriber.sliding_pagination'] ?? $this->getKnpPaginator_Subscriber_SlidingPaginationService());
        }, 1 => 'pagination'], 1);

        return $instance;
    }

    /*
     * Gets the public 'http_kernel' shared service.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernel
     */
    protected function getHttpKernelService()
    {
        return $this->services['http_kernel'] = new \Symfony\Component\HttpKernel\HttpKernel(($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), new \Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver($this, ($this->privates['monolog.logger.request'] ?? $this->getMonolog_Logger_RequestService()), ($this->privates['.legacy_controller_name_converter'] ?? ($this->privates['.legacy_controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser(($this->services['kernel'] ?? $this->get('kernel', 1)), false)))), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), new \Symfony\Component\HttpKernel\Controller\ArgumentResolver(($this->privates['argument_metadata_factory'] ?? ($this->privates['argument_metadata_factory'] = new \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory())), new RewindableGenerator(function () {
            yield 0 => ($this->privates['argument_resolver.request_attribute'] ?? ($this->privates['argument_resolver.request_attribute'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver()));
            yield 1 => ($this->privates['argument_resolver.request'] ?? ($this->privates['argument_resolver.request'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver()));
            yield 2 => ($this->privates['argument_resolver.session'] ?? ($this->privates['argument_resolver.session'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver()));
            yield 3 => ($this->privates['security.user_value_resolver'] ?? $this->load('getSecurity_UserValueResolverService.php'));
            yield 4 => ($this->privates['sensio_framework_extra.psr7.argument_value_resolver.server_request'] ?? $this->load('getSensioFrameworkExtra_Psr7_ArgumentValueResolver_ServerRequestService.php'));
            yield 5 => ($this->privates['argument_resolver.service'] ?? $this->load('getArgumentResolver_ServiceService.php'));
            yield 6 => ($this->privates['argument_resolver.default'] ?? ($this->privates['argument_resolver.default'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver()));
            yield 7 => ($this->privates['argument_resolver.variadic'] ?? ($this->privates['argument_resolver.variadic'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver()));
        }, 8)));
    }

    /*
     * Gets the public 'request_stack' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    protected function getRequestStackService()
    {
        return $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack();
    }

    /*
     * Gets the public 'router' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected function getRouterService()
    {
        $a = new \Symfony\Bridge\Monolog\Logger('router');
        $a->pushProcessor(($this->privates['Eccube\\Log\\Processor\\SessionProcessor'] ?? $this->getSessionProcessorService()));
        $a->pushProcessor(($this->privates['Eccube\\Log\\Processor\\TokenProcessor'] ?? $this->getTokenProcessorService()));
        $a->pushProcessor(($this->privates['Monolog\\Processor\\UidProcessor'] ?? ($this->privates['Monolog\\Processor\\UidProcessor'] = new \Monolog\Processor\UidProcessor())));
        $a->pushProcessor(($this->privates['Monolog\\Processor\\IntrospectionProcessor'] ?? ($this->privates['Monolog\\Processor\\IntrospectionProcessor'] = new \Monolog\Processor\IntrospectionProcessor('!php/const:Monolog\\Logger::DEBUG', [0 => 'Eccube\\\\Log', 1 => 'Psr\\\\Log']))));
        $a->pushProcessor(($this->privates['Symfony\\Bridge\\Monolog\\Processor\\WebProcessor'] ?? $this->getWebProcessorService()));
        $a->pushHandler(($this->privates['monolog.handler.console'] ?? $this->getMonolog_Handler_ConsoleService()));
        $a->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));

        $this->services['router'] = $instance = new \Symfony\Bundle\FrameworkBundle\Routing\Router((new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'routing.loader' => ['services', 'routing.loader', 'getRouting_LoaderService.php', true],
        ], [
            'routing.loader' => 'Symfony\\Component\\Config\\Loader\\LoaderInterface',
        ]))->withContext('router.default', $this), 'kernel::loadRoutes', ['cache_dir' => $this->targetDir.'', 'debug' => false, 'generator_class' => 'Symfony\\Component\\Routing\\Generator\\CompiledUrlGenerator', 'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\CompiledUrlGeneratorDumper', 'matcher_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableCompiledUrlMatcher', 'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\CompiledUrlMatcherDumper', 'strict_requirements' => NULL, 'resource_type' => 'service'], ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()), new \Symfony\Component\DependencyInjection\ParameterBag\ContainerBag($this), $a, $this->getEnv('ECCUBE_LOCALE'));

        $instance->setConfigCacheFactory(($this->privates['config_cache_factory'] ?? ($this->privates['config_cache_factory'] = new \Symfony\Component\Config\ResourceCheckerConfigCacheFactory())));

        return $instance;
    }

    /*
     * Gets the public 'security.authorization_checker' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    protected function getSecurity_AuthorizationCheckerService()
    {
        return $this->services['security.authorization_checker'] = new \Symfony\Component\Security\Core\Authorization\AuthorizationChecker(($this->services['security.token_storage'] ?? $this->getSecurity_TokenStorageService()), ($this->privates['security.authentication.manager'] ?? $this->getSecurity_Authentication_ManagerService()), ($this->privates['security.access.decision_manager'] ?? $this->getSecurity_Access_DecisionManagerService()), false);
    }

    /*
     * Gets the public 'security.csrf.token_manager' shared service.
     *
     * @return \Symfony\Component\Security\Csrf\CsrfTokenManager
     */
    protected function getSecurity_Csrf_TokenManagerService()
    {
        return $this->services['security.csrf.token_manager'] = new \Symfony\Component\Security\Csrf\CsrfTokenManager(new \Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator(), ($this->privates['security.csrf.token_storage'] ?? $this->getSecurity_Csrf_TokenStorageService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /*
     * Gets the public 'security.token_storage' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage
     */
    protected function getSecurity_TokenStorageService()
    {
        return $this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage(($this->privates['security.untracked_token_storage'] ?? ($this->privates['security.untracked_token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'session' => ['services', 'session', 'getSessionService', false],
        ], [
            'session' => '?',
        ]));
    }

    /*
     * Gets the public 'session' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    protected function getSessionService()
    {
        return $this->services['session'] = new \Symfony\Component\HttpFoundation\Session\Session(new \Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage($this->getParameter('session.storage.options'), new \Eccube\Session\Storage\Handler\SameSiteNoneCompatSessionHandler(new \Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler((\dirname(__DIR__, 3).'/sessions/prod'))), new \Symfony\Component\HttpFoundation\Session\Storage\MetadataBag('_sf2_meta', 0)));
    }

    /*
     * Gets the public 'state_machine.order' shared service.
     *
     * @return \Symfony\Component\Workflow\StateMachine
     */
    protected function getStateMachine_OrderService()
    {
        return $this->services['state_machine.order'] = new \Symfony\Component\Workflow\StateMachine(new \Symfony\Component\Workflow\Definition([0 => '1', 1 => '3', 2 => '4', 3 => '5', 4 => '6', 5 => '7', 6 => '8', 7 => '9'], [0 => new \Symfony\Component\Workflow\Transition('pay', '1', '6'), 1 => new \Symfony\Component\Workflow\Transition('packing', '1', '4'), 2 => new \Symfony\Component\Workflow\Transition('packing', '6', '4'), 3 => new \Symfony\Component\Workflow\Transition('cancel', '1', '3'), 4 => new \Symfony\Component\Workflow\Transition('cancel', '4', '3'), 5 => new \Symfony\Component\Workflow\Transition('cancel', '6', '3'), 6 => new \Symfony\Component\Workflow\Transition('back_to_in_progress', '3', '4'), 7 => new \Symfony\Component\Workflow\Transition('ship', '1', '5'), 8 => new \Symfony\Component\Workflow\Transition('ship', '6', '5'), 9 => new \Symfony\Component\Workflow\Transition('ship', '4', '5'), 10 => new \Symfony\Component\Workflow\Transition('return', '5', '9'), 11 => new \Symfony\Component\Workflow\Transition('cancel_return', '9', '5')], [0 => '1'], new \Symfony\Component\Workflow\Metadata\InMemoryMetadataStore([], [], new \SplObjectStorage())), new \Symfony\Component\Workflow\MarkingStore\SingleStateMarkingStore('status'), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), 'order');
    }

    /*
     * Gets the public 'translator' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected function getTranslatorService()
    {
        $this->services['translator'] = $instance = new \Symfony\Bundle\FrameworkBundle\Translation\Translator(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'translation.loader.csv' => ['privates', 'translation.loader.csv', 'getTranslation_Loader_CsvService.php', true],
            'translation.loader.dat' => ['privates', 'translation.loader.dat', 'getTranslation_Loader_DatService.php', true],
            'translation.loader.ini' => ['privates', 'translation.loader.ini', 'getTranslation_Loader_IniService.php', true],
            'translation.loader.json' => ['privates', 'translation.loader.json', 'getTranslation_Loader_JsonService.php', true],
            'translation.loader.mo' => ['privates', 'translation.loader.mo', 'getTranslation_Loader_MoService.php', true],
            'translation.loader.php' => ['privates', 'translation.loader.php', 'getTranslation_Loader_PhpService.php', true],
            'translation.loader.po' => ['privates', 'translation.loader.po', 'getTranslation_Loader_PoService.php', true],
            'translation.loader.qt' => ['privates', 'translation.loader.qt', 'getTranslation_Loader_QtService.php', true],
            'translation.loader.res' => ['privates', 'translation.loader.res', 'getTranslation_Loader_ResService.php', true],
            'translation.loader.xliff' => ['privates', 'translation.loader.xliff', 'getTranslation_Loader_XliffService.php', true],
            'translation.loader.yml' => ['privates', 'translation.loader.yml', 'getTranslation_Loader_YmlService.php', true],
        ], [
            'translation.loader.csv' => '?',
            'translation.loader.dat' => '?',
            'translation.loader.ini' => '?',
            'translation.loader.json' => '?',
            'translation.loader.mo' => '?',
            'translation.loader.php' => '?',
            'translation.loader.po' => '?',
            'translation.loader.qt' => '?',
            'translation.loader.res' => '?',
            'translation.loader.xliff' => '?',
            'translation.loader.yml' => '?',
        ]), new \Symfony\Component\Translation\Formatter\MessageFormatter(new \Symfony\Component\Translation\IdentityTranslator()), $this->getEnv('ECCUBE_LOCALE'), ['translation.loader.php' => [0 => 'php'], 'translation.loader.yml' => [0 => 'yaml', 1 => 'yml'], 'translation.loader.xliff' => [0 => 'xlf', 1 => 'xliff'], 'translation.loader.po' => [0 => 'po'], 'translation.loader.mo' => [0 => 'mo'], 'translation.loader.qt' => [0 => 'ts'], 'translation.loader.csv' => [0 => 'csv'], 'translation.loader.res' => [0 => 'res'], 'translation.loader.dat' => [0 => 'dat'], 'translation.loader.ini' => [0 => 'ini'], 'translation.loader.json' => [0 => 'json']], ['cache_dir' => ($this->targetDir.''.'/translations'), 'debug' => false, 'resource_files' => ['af' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.af.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.af.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.af.xlf')], 'ar' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.ar.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.ar.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.ar.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.ar.xliff')], 'az' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.az.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.az.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.az.xlf')], 'be' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.be.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.be.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.be.xlf')], 'bg' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.bg.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.bg.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.bg.xlf')], 'bs' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.bs.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.bs.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.bs.xlf')], 'ca' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.ca.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.ca.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.ca.xlf')], 'cs' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.cs.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.cs.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.cs.xlf')], 'cy' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.cy.xlf')], 'da' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.da.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.da.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.da.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.da.xliff')], 'de' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.de.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.de.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.de.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.de.xliff')], 'el' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.el.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.el.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.el.xlf')], 'en' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.en.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.en.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.en.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.en.xliff'), 4 => (\dirname(__DIR__, 4).'/src/Eccube/Resource/locale/messages.en.yaml'), 5 => (\dirname(__DIR__, 4).'/src/Eccube/Resource/locale/validators.en.yaml')], 'es' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.es.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.es.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.es.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.es.xliff')], 'et' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.et.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.et.xlf')], 'eu' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.eu.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.eu.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.eu.xlf')], 'fa' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.fa.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.fa.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.fa.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.fa.xliff')], 'fi' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.fi.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.fi.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.fi.xlf')], 'fr' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.fr.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.fr.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.fr.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.fr.xliff')], 'gl' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.gl.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.gl.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.gl.xlf')], 'he' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.he.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.he.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.he.xlf')], 'hr' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.hr.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.hr.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.hr.xlf')], 'hu' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.hu.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.hu.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.hu.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.hu.xliff')], 'hy' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.hy.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.hy.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.hy.xlf')], 'id' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.id.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.id.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.id.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.id.xliff')], 'it' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.it.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.it.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.it.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.it.xliff')], 'ja' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.ja.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.ja.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.ja.xlf'), 3 => (\dirname(__DIR__, 4).'/src/Eccube/Resource/locale/messages.ja.yaml'), 4 => (\dirname(__DIR__, 4).'/src/Eccube/Resource/locale/validators.ja.yaml')], 'lb' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.lb.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.lb.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.lb.xlf')], 'lt' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.lt.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.lt.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.lt.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.lt.xliff')], 'lv' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.lv.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.lv.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.lv.xlf')], 'mn' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.mn.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.mn.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.mn.xlf')], 'nb' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.nb.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.nb.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.nb.xlf')], 'nl' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.nl.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.nl.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.nl.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.nl.xliff')], 'nn' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.nn.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.nn.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.nn.xlf')], 'no' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.no.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.no.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.no.xlf')], 'pl' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.pl.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.pl.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.pl.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.pl.xliff')], 'pt' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.pt.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.pt.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.pt.xlf')], 'pt_BR' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.pt_BR.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.pt_BR.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.pt_BR.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.pt_BR.xliff')], 'ro' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.ro.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.ro.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.ro.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.ro.xliff')], 'ru' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.ru.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.ru.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.ru.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.ru.xliff')], 'sk' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.sk.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.sk.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.sk.xlf')], 'sl' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.sl.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.sl.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.sl.xlf')], 'sq' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.sq.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.sq.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.sq.xlf')], 'sr_Cyrl' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.sr_Cyrl.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.sr_Cyrl.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.sr_Cyrl.xlf')], 'sr_Latn' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.sr_Latn.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.sr_Latn.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.sr_Latn.xlf')], 'sv' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.sv.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.sv.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.sv.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.sv.xliff')], 'th' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.th.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.th.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.th.xlf')], 'tl' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.tl.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.tl.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.tl.xlf')], 'tr' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.tr.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.tr.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.tr.xlf')], 'uk' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.uk.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.uk.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.uk.xlf'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.uk.xliff')], 'uz' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.uz.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.uz.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.uz.xlf')], 'vi' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.vi.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.vi.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.vi.xlf')], 'zh_CN' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.zh_CN.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.zh_CN.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.zh_CN.xlf')], 'zh_TW' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations/validators.zh_TW.xlf'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations/validators.zh_TW.xlf'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations/security.zh_TW.xlf')], 'ky' => [0 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.ky.xliff')], 'sw' => [0 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations/KnpPaginatorBundle.sw.xliff')]], 'scanned_directories' => [0 => (\dirname(__DIR__, 4).'/vendor/symfony/validator/Resources/translations'), 1 => (\dirname(__DIR__, 4).'/vendor/symfony/form/Resources/translations'), 2 => (\dirname(__DIR__, 4).'/vendor/symfony/security/Core/Resources/translations'), 3 => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/translations'), 4 => (\dirname(__DIR__, 4).'/src/Eccube/Resource/locale/'), 5 => (\dirname(__DIR__, 4).'/app/Customize/Resource/locale/'), 6 => (\dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/translations'), 7 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/FrameworkBundle/translations'), 8 => (\dirname(__DIR__, 4).'/vendor/symfony/security-bundle/translations'), 9 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/SecurityBundle/translations'), 10 => (\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-cache-bundle/translations'), 11 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/DoctrineCacheBundle/translations'), 12 => (\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/translations'), 13 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/DoctrineBundle/translations'), 14 => (\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-migrations-bundle/translations'), 15 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/DoctrineMigrationsBundle/translations'), 16 => (\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-fixtures-bundle/translations'), 17 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/DoctrineFixturesBundle/translations'), 18 => (\dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src/translations'), 19 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/SensioFrameworkExtraBundle/translations'), 20 => (\dirname(__DIR__, 4).'/vendor/symfony/monolog-bundle/translations'), 21 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/MonologBundle/translations'), 22 => (\dirname(__DIR__, 4).'/vendor/symfony/swiftmailer-bundle/translations'), 23 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/SwiftmailerBundle/translations'), 24 => (\dirname(__DIR__, 4).'/vendor/symfony/twig-bundle/translations'), 25 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/TwigBundle/translations'), 26 => (\dirname(__DIR__, 4).'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/translations'), 27 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/MobileDetectBundle/translations'), 28 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/KnpPaginatorBundle/translations'), 29 => (\dirname(__DIR__, 4).'/vendor/exercise/htmlpurifier-bundle/src/translations'), 30 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/ExerciseHTMLPurifierBundle/translations'), 31 => (\dirname(__DIR__, 4).'/app/Plugin/Api/Bundle/translations'), 32 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/ApiBundle/translations'), 33 => (\dirname(__DIR__, 4).'/vendor/trikoder/oauth2-bundle/translations'), 34 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/TrikoderOAuth2Bundle/translations'), 35 => (\dirname(__DIR__, 4).'/translations'), 36 => (\dirname(__DIR__, 4).'/src/Eccube/Resources/translations')], 'cache_vary' => ['scanned_directories' => [0 => 'vendor/symfony/validator/Resources/translations', 1 => 'vendor/symfony/form/Resources/translations', 2 => 'vendor/symfony/security/Core/Resources/translations', 3 => 'vendor/knplabs/knp-paginator-bundle/Resources/translations', 4 => 'src/Eccube/Resource/locale/', 5 => 'app/Customize/Resource/locale/', 6 => 'vendor/symfony/framework-bundle/translations', 7 => 'src/Eccube/Resources/FrameworkBundle/translations', 8 => 'vendor/symfony/security-bundle/translations', 9 => 'src/Eccube/Resources/SecurityBundle/translations', 10 => 'vendor/doctrine/doctrine-cache-bundle/translations', 11 => 'src/Eccube/Resources/DoctrineCacheBundle/translations', 12 => 'vendor/doctrine/doctrine-bundle/translations', 13 => 'src/Eccube/Resources/DoctrineBundle/translations', 14 => 'vendor/doctrine/doctrine-migrations-bundle/translations', 15 => 'src/Eccube/Resources/DoctrineMigrationsBundle/translations', 16 => 'vendor/doctrine/doctrine-fixtures-bundle/translations', 17 => 'src/Eccube/Resources/DoctrineFixturesBundle/translations', 18 => 'vendor/sensio/framework-extra-bundle/src/translations', 19 => 'src/Eccube/Resources/SensioFrameworkExtraBundle/translations', 20 => 'vendor/symfony/monolog-bundle/translations', 21 => 'src/Eccube/Resources/MonologBundle/translations', 22 => 'vendor/symfony/swiftmailer-bundle/translations', 23 => 'src/Eccube/Resources/SwiftmailerBundle/translations', 24 => 'vendor/symfony/twig-bundle/translations', 25 => 'src/Eccube/Resources/TwigBundle/translations', 26 => 'vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/translations', 27 => 'src/Eccube/Resources/MobileDetectBundle/translations', 28 => 'src/Eccube/Resources/KnpPaginatorBundle/translations', 29 => 'vendor/exercise/htmlpurifier-bundle/src/translations', 30 => 'src/Eccube/Resources/ExerciseHTMLPurifierBundle/translations', 31 => 'app/Plugin/Api/Bundle/translations', 32 => 'src/Eccube/Resources/ApiBundle/translations', 33 => 'vendor/trikoder/oauth2-bundle/translations', 34 => 'src/Eccube/Resources/TrikoderOAuth2Bundle/translations', 35 => 'translations', 36 => 'src/Eccube/Resources/translations']]]);

        $instance->setConfigCacheFactory(($this->privates['config_cache_factory'] ?? ($this->privates['config_cache_factory'] = new \Symfony\Component\Config\ResourceCheckerConfigCacheFactory())));
        $instance->setFallbackLocales([0 => $this->getEnv('ECCUBE_LOCALE'), 1 => $this->getEnv('ECCUBE_LOCALE')]);

        return $instance;
    }

    /*
     * Gets the public 'twig' shared service.
     *
     * @return \Twig\Environment
     */
    protected function getTwigService()
    {
        $a = new \Symfony\Bundle\TwigBundle\Loader\FilesystemLoader(($this->privates['templating.locator'] ?? $this->load('getTemplating_LocatorService.php')), ($this->privates['templating.name_parser'] ?? $this->load('getTemplating_NameParserService.php')), \dirname(__DIR__, 4));
        $a->addPath((\dirname(__DIR__, 4).'/app/template/'.$this->getEnv('string:ECCUBE_TEMPLATE_CODE')));
        $a->addPath((\dirname(__DIR__, 4).'/src/Eccube/Resource/template/default'));
        $a->addPath((\dirname(__DIR__, 4).'/app/Plugin'));
        $a->addPath((\dirname(__DIR__, 4).'/app/template/admin'), 'admin');
        $a->addPath((\dirname(__DIR__, 4).'/src/Eccube/Resource/template/admin'), 'admin');
        $a->addPath((\dirname(__DIR__, 4).'/app/template/user_data'), 'user_data');
        $a->addPath((\dirname(__DIR__, 4).'/src/Eccube/Resource/template/toolbar'), 'toolbar');
        $a->addPath((\dirname(__DIR__, 4).'/src/Eccube/Resource/template/common'), 'common');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Resources/views'), 'Framework');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Resources/views'), '!Framework');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/security-bundle/Resources/views'), 'Security');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/security-bundle/Resources/views'), '!Security');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Resources/views'), 'Doctrine');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Resources/views'), '!Doctrine');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/swiftmailer-bundle/Resources/views'), 'Swiftmailer');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/swiftmailer-bundle/Resources/views'), '!Swiftmailer');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/twig-bundle/Resources/views'), 'Twig');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/twig-bundle/Resources/views'), '!Twig');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/Resources/views'), 'MobileDetect');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle/Resources/views'), '!MobileDetect');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/views'), 'KnpPaginator');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle/Resources/views'), '!KnpPaginator');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Resources/views/Email'), 'email');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Resources/views/Email'), '!email');
        $a->addPath((\dirname(__DIR__, 4).'/vendor/symfony/twig-bridge/Resources/views/Form'));

        $this->services['twig'] = $instance = new \Twig\Environment($a, ['debug' => false, 'strict_variables' => false, 'base_template_class' => 'Eccube\\Twig\\Template', 'autoescape' => 'name', 'cache' => ($this->targetDir.''.'/twig'), 'charset' => 'UTF-8']);

        $b = ($this->services['translator'] ?? $this->getTranslatorService());
        $c = new \Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy();
        $d = ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack()));

        $e = new \Symfony\Component\Asset\Context\RequestStackContext($d, '', false);
        $f = ($this->services['router'] ?? $this->getRouterService());
        $g = new \Symfony\Component\Workflow\Registry();
        $g->addWorkflow(($this->services['state_machine.order'] ?? $this->getStateMachine_OrderService()), new \Symfony\Component\Workflow\SupportStrategy\InstanceOfSupportStrategy('Eccube\\Service\\OrderStateMachineContext'));
        $h = new \SunCat\MobileDetectBundle\Twig\Extension\MobileDetectExtension(($this->privates['mobile_detect.mobile_detector.default'] ?? ($this->privates['mobile_detect.mobile_detector.default'] = new \SunCat\MobileDetectBundle\DeviceDetector\MobileDetector())), ($this->privates['mobile_detect.device_view'] ?? $this->getMobileDetect_DeviceViewService()), $this->parameters['mobile_detect.redirect']);
        $h->setRequestByRequestStack($d);
        $i = new \Symfony\Bridge\Twig\AppVariable();
        $i->setEnvironment('prod');
        $i->setDebug(false);
        if ($this->has('security.token_storage')) {
            $i->setTokenStorage(($this->services['security.token_storage'] ?? $this->getSecurity_TokenStorageService()));
        }
        if ($this->has('request_stack')) {
            $i->setRequestStack($d);
        }

        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\CsrfExtension());
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\LogoutUrlExtension(($this->privates['security.logout_url_generator'] ?? $this->getSecurity_LogoutUrlGeneratorService())));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\SecurityExtension(($this->services['security.authorization_checker'] ?? $this->getSecurity_AuthorizationCheckerService())));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension($b));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\AssetExtension(new \Symfony\Component\Asset\Packages(new \Symfony\Component\Asset\PathPackage('/html/template/'.$this->getEnv('string:ECCUBE_TEMPLATE_CODE'), $c, $e), ['admin' => new \Symfony\Component\Asset\PathPackage('/html/template/admin', $c, $e), 'save_image' => new \Symfony\Component\Asset\PathPackage('/html/upload/save_image', $c, $e), 'plugin' => new \Symfony\Component\Asset\PathPackage('/html/plugin', $c, $e), 'install' => new \Symfony\Component\Asset\PathPackage('/html/template/install', $c, $e), 'temp_image' => new \Symfony\Component\Asset\PathPackage('/html/upload/temp_image', $c, $e), 'user_data' => new \Symfony\Component\Asset\PathPackage('/html/user_data', $c, $e)])));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\CodeExtension(($this->privates['debug.file_link_formatter'] ?? ($this->privates['debug.file_link_formatter'] = new \Symfony\Component\HttpKernel\Debug\FileLinkFormatter(NULL))), \dirname(__DIR__, 4), 'UTF-8'));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\RoutingExtension($f));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\YamlExtension());
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\StopwatchExtension(($this->privates['debug.stopwatch'] ?? ($this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true))), false));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\ExpressionExtension());
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\HttpKernelExtension());
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\HttpFoundationExtension(new \Symfony\Component\HttpFoundation\UrlHelper($d, ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()))));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\WorkflowExtension($g));
        $instance->addExtension(new \Symfony\Bridge\Twig\Extension\FormExtension());
        $instance->addExtension(new \Eccube\Twig\Extension\CartServiceExtension(($this->privates['Eccube\\Service\\CartService'] ?? $this->getCartServiceService())));
        $instance->addExtension(new \Eccube\Twig\Extension\CsrfExtension(($this->services['security.csrf.token_manager'] ?? $this->getSecurity_Csrf_TokenManagerService())));
        $instance->addExtension(new \Eccube\Twig\Extension\EccubeBlockExtension($instance, []));
        $instance->addExtension(($this->privates['Eccube\\Twig\\Extension\\EccubeExtension'] ?? $this->getEccubeExtensionService()));
        $instance->addExtension(new \Eccube\Twig\Extension\IntlExtension());
        $instance->addExtension(new \Eccube\Twig\Extension\RepositoryExtension(($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService())));
        $instance->addExtension(new \Eccube\Twig\Extension\SafeTextmailEscaperExtension($instance));
        $instance->addExtension(($this->privates['Eccube\\Twig\\Extension\\TaxExtension'] ?? $this->getTaxExtensionService()));
        $instance->addExtension(new \Eccube\Twig\Extension\TwigIncludeExtension($instance));
        $instance->addExtension(new \Twig_Extension_StringLoader());
        $instance->addExtension(new \Twig\Extensions\IntlExtension());
        $instance->addExtension(new \Doctrine\Bundle\DoctrineBundle\Twig\DoctrineExtension());
        $instance->addExtension($h);
        $instance->addExtension(new \Knp\Bundle\PaginatorBundle\Twig\Extension\PaginationExtension(new \Knp\Bundle\PaginatorBundle\Helper\Processor($f, $b)));
        $instance->addExtension(new \Exercise\HTMLPurifierBundle\Twig\HTMLPurifierExtension());
        $instance->addGlobal('app', $i);
        $instance->addRuntimeLoader(new \Twig\RuntimeLoader\ContainerRuntimeLoader(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'Exercise\\HTMLPurifierBundle\\Twig\\HTMLPurifierRuntime' => ['privates', 'exercise_html_purifier.twig.runtime', 'getExerciseHtmlPurifier_Twig_RuntimeService.php', true],
            'Symfony\\Bridge\\Twig\\Extension\\CsrfRuntime' => ['privates', 'twig.runtime.security_csrf', 'getTwig_Runtime_SecurityCsrfService.php', true],
            'Symfony\\Bridge\\Twig\\Extension\\HttpKernelRuntime' => ['privates', 'twig.runtime.httpkernel', 'getTwig_Runtime_HttpkernelService.php', true],
            'Symfony\\Component\\Form\\FormRenderer' => ['privates', 'twig.form.renderer', 'getTwig_Form_RendererService.php', true],
        ], [
            'Exercise\\HTMLPurifierBundle\\Twig\\HTMLPurifierRuntime' => '?',
            'Symfony\\Bridge\\Twig\\Extension\\CsrfRuntime' => '?',
            'Symfony\\Bridge\\Twig\\Extension\\HttpKernelRuntime' => '?',
            'Symfony\\Component\\Form\\FormRenderer' => '?',
        ])));
        $instance->addGlobal('BaseInfo', NULL);
        $instance->addGlobal('eccube_config', ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))));
        $instance->addGlobal('event_dispatcher', ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()));
        $instance->addExtension(new \Eccube\Twig\Extension\IgnoreRoutingNotFoundExtension($f));
        (new \Symfony\Bundle\TwigBundle\DependencyInjection\Configurator\EnvironmentConfigurator('F j, Y H:i', '%d days', $this->getEnv('ECCUBE_TIMEZONE'), 0, '.', ','))->configure($instance);

        return $instance;
    }

    /*
     * Gets the private '.legacy_resolve_controller_name_subscriber' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\EventListener\ResolveControllerNameSubscriber
     */
    protected function get_LegacyResolveControllerNameSubscriberService()
    {
        return $this->privates['.legacy_resolve_controller_name_subscriber'] = new \Symfony\Bundle\FrameworkBundle\EventListener\ResolveControllerNameSubscriber(($this->privates['.legacy_controller_name_converter'] ?? ($this->privates['.legacy_controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser(($this->services['kernel'] ?? $this->get('kernel', 1)), false))), false);
    }

    /*
     * Gets the private 'Eccube\EventListener\IpAddrListener' shared autowired service.
     *
     * @return \Eccube\EventListener\IpAddrListener
     */
    protected function getIpAddrListenerService()
    {
        return $this->privates['Eccube\\EventListener\\IpAddrListener'] = new \Eccube\EventListener\IpAddrListener(($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))), ($this->privates['Eccube\\Request\\Context'] ?? $this->getContextService()));
    }

    /*
     * Gets the private 'Eccube\EventListener\LogListener' shared autowired service.
     *
     * @return \Eccube\EventListener\LogListener
     */
    protected function getLogListenerService()
    {
        return $this->privates['Eccube\\EventListener\\LogListener'] = new \Eccube\EventListener\LogListener(($this->privates['monolog.logger'] ?? $this->getMonolog_LoggerService()));
    }

    /*
     * Gets the private 'Eccube\EventListener\MobileTemplatePathListener' shared autowired service.
     *
     * @return \Eccube\EventListener\MobileTemplatePathListener
     */
    protected function getMobileTemplatePathListenerService()
    {
        return $this->privates['Eccube\\EventListener\\MobileTemplatePathListener'] = new \Eccube\EventListener\MobileTemplatePathListener(($this->privates['Eccube\\Request\\Context'] ?? $this->getContextService()), ($this->services['twig'] ?? $this->getTwigService()), ($this->services['SunCat\\MobileDetectBundle\\DeviceDetector\\MobileDetector'] ?? ($this->services['SunCat\\MobileDetectBundle\\DeviceDetector\\MobileDetector'] = new \SunCat\MobileDetectBundle\DeviceDetector\MobileDetector())), ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))));
    }

    /*
     * Gets the private 'Eccube\EventListener\TransactionListener' shared autowired service.
     *
     * @return \Eccube\EventListener\TransactionListener
     */
    protected function getTransactionListenerService()
    {
        return $this->privates['Eccube\\EventListener\\TransactionListener'] = new \Eccube\EventListener\TransactionListener(($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()));
    }

    /*
     * Gets the private 'Eccube\EventListener\TwigInitializeListener' shared autowired service.
     *
     * @return \Eccube\EventListener\TwigInitializeListener
     */
    protected function getTwigInitializeListenerService()
    {
        return $this->privates['Eccube\\EventListener\\TwigInitializeListener'] = new \Eccube\EventListener\TwigInitializeListener(($this->services['twig'] ?? $this->getTwigService()), ($this->privates['Eccube\\Repository\\BaseInfoRepository'] ?? $this->getBaseInfoRepositoryService()), ($this->privates['Eccube\\Repository\\PageRepository'] ?? $this->getPageRepositoryService()), ($this->privates['Eccube\\Repository\\PageLayoutRepository'] ?? $this->getPageLayoutRepositoryService()), ($this->privates['Eccube\\Repository\\BlockPositionRepository'] ?? $this->getBlockPositionRepositoryService()), ($this->privates['Eccube\\Repository\\Master\\DeviceTypeRepository'] ?? $this->getDeviceTypeRepositoryService()), ($this->privates['Eccube\\Repository\\AuthorityRoleRepository'] ?? $this->getAuthorityRoleRepositoryService()), ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))), ($this->privates['Eccube\\Request\\Context'] ?? $this->getContextService()), ($this->services['SunCat\\MobileDetectBundle\\DeviceDetector\\MobileDetector'] ?? ($this->services['SunCat\\MobileDetectBundle\\DeviceDetector\\MobileDetector'] = new \SunCat\MobileDetectBundle\DeviceDetector\MobileDetector())), ($this->services['router'] ?? $this->getRouterService()), ($this->privates['Eccube\\Repository\\LayoutRepository'] ?? $this->getLayoutRepositoryService()));
    }

    /*
     * Gets the private 'Eccube\EventListener\TwoFactorAuthListener' shared autowired service.
     *
     * @return \Eccube\EventListener\TwoFactorAuthListener
     */
    protected function getTwoFactorAuthListenerService()
    {
        return $this->privates['Eccube\\EventListener\\TwoFactorAuthListener'] = new \Eccube\EventListener\TwoFactorAuthListener(($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))), ($this->privates['Eccube\\Request\\Context'] ?? $this->getContextService()), ($this->services['router'] ?? $this->getRouterService()), ($this->privates['Eccube\\Service\\TwoFactorAuthService'] ?? $this->getTwoFactorAuthServiceService()));
    }

    /*
     * Gets the private 'Eccube\Log\Processor\SessionProcessor' shared autowired service.
     *
     * @return \Eccube\Log\Processor\SessionProcessor
     */
    protected function getSessionProcessorService()
    {
        return $this->privates['Eccube\\Log\\Processor\\SessionProcessor'] = new \Eccube\Log\Processor\SessionProcessor(($this->services['session'] ?? $this->getSessionService()));
    }

    /*
     * Gets the private 'Eccube\Log\Processor\TokenProcessor' shared autowired service.
     *
     * @return \Eccube\Log\Processor\TokenProcessor
     */
    protected function getTokenProcessorService()
    {
        return $this->privates['Eccube\\Log\\Processor\\TokenProcessor'] = new \Eccube\Log\Processor\TokenProcessor(($this->services['security.token_storage'] ?? $this->getSecurity_TokenStorageService()));
    }

    /*
     * Gets the private 'Eccube\Repository\AuthorityRoleRepository' shared autowired service.
     *
     * @return \Eccube\Repository\AuthorityRoleRepository
     */
    protected function getAuthorityRoleRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\AuthorityRoleRepository'] = new \Eccube\Repository\AuthorityRoleRepository(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /*
     * Gets the private 'Eccube\Repository\BaseInfoRepository' shared autowired service.
     *
     * @return \Eccube\Repository\BaseInfoRepository
     */
    protected function getBaseInfoRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\BaseInfoRepository'] = new \Eccube\Repository\BaseInfoRepository(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /*
     * Gets the private 'Eccube\Repository\BlockPositionRepository' shared autowired service.
     *
     * @return \Eccube\Repository\BlockPositionRepository
     */
    protected function getBlockPositionRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\BlockPositionRepository'] = new \Eccube\Repository\BlockPositionRepository(($this->privates['Eccube\\Repository\\BlockRepository'] ?? $this->getBlockRepositoryService()), ($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /*
     * Gets the private 'Eccube\Repository\BlockRepository' shared autowired service.
     *
     * @return \Eccube\Repository\BlockRepository
     */
    protected function getBlockRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\BlockRepository'] = new \Eccube\Repository\BlockRepository(($this->services['doctrine'] ?? $this->getDoctrineService()), ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))));
    }

    /*
     * Gets the private 'Eccube\Repository\CartRepository' shared autowired service.
     *
     * @return \Eccube\Repository\CartRepository
     */
    protected function getCartRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\CartRepository'] = new \Eccube\Repository\CartRepository(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /*
     * Gets the private 'Eccube\Repository\LayoutRepository' shared autowired service.
     *
     * @return \Eccube\Repository\LayoutRepository
     */
    protected function getLayoutRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\LayoutRepository'] = new \Eccube\Repository\LayoutRepository(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /*
     * Gets the private 'Eccube\Repository\Master\DeviceTypeRepository' shared autowired service.
     *
     * @return \Eccube\Repository\Master\DeviceTypeRepository
     */
    protected function getDeviceTypeRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\Master\\DeviceTypeRepository'] = new \Eccube\Repository\Master\DeviceTypeRepository(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /*
     * Gets the private 'Eccube\Repository\OrderRepository' shared autowired service.
     *
     * @return \Eccube\Repository\OrderRepository
     */
    protected function getOrderRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\OrderRepository'] = new \Eccube\Repository\OrderRepository(($this->services['doctrine'] ?? $this->getDoctrineService()), ($this->privates['Eccube\\Doctrine\\Query\\Queries'] ?? ($this->privates['Eccube\\Doctrine\\Query\\Queries'] = new \Eccube\Doctrine\Query\Queries())));
    }

    /*
     * Gets the private 'Eccube\Repository\PageLayoutRepository' shared autowired service.
     *
     * @return \Eccube\Repository\PageLayoutRepository
     */
    protected function getPageLayoutRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\PageLayoutRepository'] = new \Eccube\Repository\PageLayoutRepository(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /*
     * Gets the private 'Eccube\Repository\PageRepository' shared autowired service.
     *
     * @return \Eccube\Repository\PageRepository
     */
    protected function getPageRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\PageRepository'] = new \Eccube\Repository\PageRepository(($this->services['doctrine'] ?? $this->getDoctrineService()), ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))), $this);
    }

    /*
     * Gets the private 'Eccube\Repository\ProductClassRepository' shared autowired service.
     *
     * @return \Eccube\Repository\ProductClassRepository
     */
    protected function getProductClassRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\ProductClassRepository'] = new \Eccube\Repository\ProductClassRepository(($this->services['doctrine'] ?? $this->getDoctrineService()));
    }

    /*
     * Gets the private 'Eccube\Repository\ProductRepository' shared autowired service.
     *
     * @return \Eccube\Repository\ProductRepository
     */
    protected function getProductRepositoryService()
    {
        return $this->privates['Eccube\\Repository\\ProductRepository'] = new \Eccube\Repository\ProductRepository(($this->services['doctrine'] ?? $this->getDoctrineService()), ($this->privates['Eccube\\Doctrine\\Query\\Queries'] ?? ($this->privates['Eccube\\Doctrine\\Query\\Queries'] = new \Eccube\Doctrine\Query\Queries())), ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))));
    }

    /*
     * Gets the private 'Eccube\Repository\TaxRuleRepository' shared autowired service.
     *
     * @return \Eccube\Repository\TaxRuleRepository
     */
    protected function getTaxRuleRepositoryService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->privates['Eccube\\Repository\\TaxRuleRepository'] = $this->createProxy('TaxRuleRepository_f7111db', function () {
                return \TaxRuleRepository_f7111db::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getTaxRuleRepositoryService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/TaxRuleRepository.php';

        return new \Eccube\Repository\TaxRuleRepository(($this->services['doctrine'] ?? $this->getDoctrineService()), ($this->services['security.token_storage'] ?? $this->getSecurity_TokenStorageService()), ($this->services['security.authorization_checker'] ?? $this->getSecurity_AuthorizationCheckerService()), ($this->privates['Eccube\\Repository\\BaseInfoRepository'] ?? $this->getBaseInfoRepositoryService()), ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))));
    }

    /*
     * Gets the private 'Eccube\Request\Context' shared autowired service.
     *
     * @return \Eccube\Request\Context
     */
    protected function getContextService()
    {
        return $this->privates['Eccube\\Request\\Context'] = new \Eccube\Request\Context(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))), ($this->services['security.token_storage'] ?? $this->getSecurity_TokenStorageService()));
    }

    /*
     * Gets the private 'Eccube\Security\Core\Encoder\PasswordEncoder' shared autowired service.
     *
     * @return \Eccube\Security\Core\Encoder\PasswordEncoder
     */
    protected function getPasswordEncoderService()
    {
        return $this->privates['Eccube\\Security\\Core\\Encoder\\PasswordEncoder'] = new \Eccube\Security\Core\Encoder\PasswordEncoder(($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))));
    }

    /*
     * Gets the private 'Eccube\Service\CartService' shared autowired service.
     *
     * @return \Eccube\Service\CartService
     */
    protected function getCartServiceService($lazyLoad = true)
    {
        if ($lazyLoad) {
            return $this->privates['Eccube\\Service\\CartService'] = $this->createProxy('CartService_9dde17f', function () {
                return \CartService_9dde17f::staticProxyConstructor(function (&$wrappedInstance, \ProxyManager\Proxy\LazyLoadingInterface $proxy) {
                    $wrappedInstance = $this->getCartServiceService(false);

                    $proxy->setProxyInitializer(null);

                    return true;
                });
            });
        }

        include_once \dirname(__DIR__, 4).'/src/Eccube/Service/CartService.php';
        include_once \dirname(__DIR__, 4).'/src/Eccube/Service/Cart/CartItemComparator.php';
        include_once \dirname(__DIR__, 4).'/src/Eccube/Service/Cart/ProductClassComparator.php';
        include_once \dirname(__DIR__, 4).'/src/Eccube/Service/Cart/CartItemAllocator.php';
        include_once \dirname(__DIR__, 4).'/src/Eccube/Service/Cart/SaleTypeCartAllocator.php';

        return new \Eccube\Service\CartService(($this->services['session'] ?? $this->getSessionService()), ($this->services['doctrine.orm.default_entity_manager'] ?? $this->getDoctrine_Orm_DefaultEntityManagerService()), ($this->privates['Eccube\\Repository\\ProductClassRepository'] ?? $this->getProductClassRepositoryService()), ($this->privates['Eccube\\Repository\\CartRepository'] ?? $this->getCartRepositoryService()), new \Eccube\Service\Cart\ProductClassComparator(), new \Eccube\Service\Cart\SaleTypeCartAllocator(), ($this->privates['Eccube\\Repository\\OrderRepository'] ?? $this->getOrderRepositoryService()), ($this->services['security.token_storage'] ?? $this->getSecurity_TokenStorageService()), ($this->services['security.authorization_checker'] ?? $this->getSecurity_AuthorizationCheckerService()));
    }

    /*
     * Gets the private 'Eccube\Service\TwoFactorAuthService' shared autowired service.
     *
     * @return \Eccube\Service\TwoFactorAuthService
     */
    protected function getTwoFactorAuthServiceService()
    {
        return $this->privates['Eccube\\Service\\TwoFactorAuthService'] = new \Eccube\Service\TwoFactorAuthService($this, ($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))), ($this->privates['security.encoder_factory.generic'] ?? $this->getSecurity_EncoderFactory_GenericService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /*
     * Gets the private 'Eccube\Twig\Extension\EccubeExtension' shared autowired service.
     *
     * @return \Eccube\Twig\Extension\EccubeExtension
     */
    protected function getEccubeExtensionService()
    {
        return $this->privates['Eccube\\Twig\\Extension\\EccubeExtension'] = new \Eccube\Twig\Extension\EccubeExtension(($this->services['Eccube\\Common\\EccubeConfig'] ?? ($this->services['Eccube\\Common\\EccubeConfig'] = new \Eccube\Common\EccubeConfig($this))), ($this->privates['Eccube\\Repository\\ProductRepository'] ?? $this->getProductRepositoryService()));
    }

    /*
     * Gets the private 'Eccube\Twig\Extension\TaxExtension' shared autowired service.
     *
     * @return \Eccube\Twig\Extension\TaxExtension
     */
    protected function getTaxExtensionService()
    {
        return $this->privates['Eccube\\Twig\\Extension\\TaxExtension'] = new \Eccube\Twig\Extension\TaxExtension(($this->privates['Eccube\\Repository\\TaxRuleRepository'] ?? $this->getTaxRuleRepositoryService()));
    }

    /*
     * Gets the private 'Symfony\Bridge\Monolog\Processor\WebProcessor' shared autowired service.
     *
     * @return \Symfony\Bridge\Monolog\Processor\WebProcessor
     */
    protected function getWebProcessorService()
    {
        return $this->privates['Symfony\\Bridge\\Monolog\\Processor\\WebProcessor'] = new \Symfony\Bridge\Monolog\Processor\WebProcessor(['url' => 'REQUEST_URI', 'ip' => 'REMOTE_ADDR', 'http_method' => 'REQUEST_METHOD', 'server' => 'SERVER_NAME', 'referrer' => 'HTTP_REFERER', 'user_agent' => 'HTTP_USER_AGENT']);
    }

    /*
     * Gets the private 'annotations.cache_adapter' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\PhpArrayAdapter
     */
    protected function getAnnotations_CacheAdapterService()
    {
        return \Symfony\Component\Cache\Adapter\PhpArrayAdapter::create(($this->targetDir.''.'/annotations.php'), ($this->privates['cache.annotations'] ?? $this->getCache_AnnotationsService()));
    }

    /*
     * Gets the private 'annotations.cached_reader' shared service.
     *
     * @return \Doctrine\Common\Annotations\PsrCachedReader
     */
    protected function getAnnotations_CachedReaderService()
    {
        return $this->privates['annotations.cached_reader'] = new \Doctrine\Common\Annotations\PsrCachedReader(($this->privates['annotations.reader'] ?? $this->getAnnotations_ReaderService()), $this->getAnnotations_CacheAdapterService(), false);
    }

    /*
     * Gets the private 'annotations.reader' shared service.
     *
     * @return \Doctrine\Common\Annotations\AnnotationReader
     */
    protected function getAnnotations_ReaderService()
    {
        $this->privates['annotations.reader'] = $instance = new \Doctrine\Common\Annotations\AnnotationReader();

        $a = new \Doctrine\Common\Annotations\AnnotationRegistry();
        $a->registerUniqueLoader('class_exists');

        $instance->addGlobalIgnoredName('required', $a);

        return $instance;
    }

    /*
     * Gets the private 'cache.annotations' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    protected function getCache_AnnotationsService()
    {
        return $this->privates['cache.annotations'] = \Symfony\Component\Cache\Adapter\AbstractAdapter::createSystemCache('nGvfLT3t8+', 0, $this->getParameter('container.build_id'), ($this->targetDir.''.'/pools'), ($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));
    }

    /*
     * Gets the private 'debug.debug_handlers_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\DebugHandlersListener
     */
    protected function getDebug_DebugHandlersListenerService()
    {
        $a = new \Symfony\Bridge\Monolog\Logger('php');
        $a->pushProcessor(($this->privates['Eccube\\Log\\Processor\\SessionProcessor'] ?? $this->getSessionProcessorService()));
        $a->pushProcessor(($this->privates['Eccube\\Log\\Processor\\TokenProcessor'] ?? $this->getTokenProcessorService()));
        $a->pushProcessor(($this->privates['Monolog\\Processor\\UidProcessor'] ?? ($this->privates['Monolog\\Processor\\UidProcessor'] = new \Monolog\Processor\UidProcessor())));
        $a->pushProcessor(($this->privates['Monolog\\Processor\\IntrospectionProcessor'] ?? ($this->privates['Monolog\\Processor\\IntrospectionProcessor'] = new \Monolog\Processor\IntrospectionProcessor('!php/const:Monolog\\Logger::DEBUG', [0 => 'Eccube\\\\Log', 1 => 'Psr\\\\Log']))));
        $a->pushProcessor(($this->privates['Symfony\\Bridge\\Monolog\\Processor\\WebProcessor'] ?? $this->getWebProcessorService()));
        $a->pushHandler(($this->privates['monolog.handler.console'] ?? $this->getMonolog_Handler_ConsoleService()));
        $a->pushHandler(($this->privates['monolog.handler.admin'] ?? $this->getMonolog_Handler_AdminService()));
        $a->pushHandler(($this->privates['monolog.handler.front'] ?? $this->getMonolog_Handler_FrontService()));
        $a->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));

        return $this->privates['debug.debug_handlers_listener'] = new \Symfony\Component\HttpKernel\EventListener\DebugHandlersListener(NULL, $a, NULL, 0, false, ($this->privates['debug.file_link_formatter'] ?? ($this->privates['debug.file_link_formatter'] = new \Symfony\Component\HttpKernel\Debug\FileLinkFormatter(NULL))), false);
    }

    /*
     * Gets the private 'doctrine.app_cache_pool' shared service.
     *
     * @return \Symfony\Component\Cache\Adapter\FilesystemAdapter
     */
    protected function getDoctrine_AppCachePoolService()
    {
        $this->privates['doctrine.app_cache_pool'] = $instance = new \Symfony\Component\Cache\Adapter\FilesystemAdapter('mueBCHVSek', 0, ($this->targetDir.''.'/pools'), ($this->privates['cache.default_marshaller'] ?? ($this->privates['cache.default_marshaller'] = new \Symfony\Component\Cache\Marshaller\DefaultMarshaller(NULL))));

        $instance->setLogger(($this->privates['monolog.logger.cache'] ?? $this->getMonolog_Logger_CacheService()));

        return $instance;
    }

    /*
     * Gets the private 'eccube.log.formatter.line' shared autowired service.
     *
     * @return \Monolog\Formatter\LineFormatter
     */
    protected function getEccube_Log_Formatter_LineService()
    {
        return $this->privates['eccube.log.formatter.line'] = new \Monolog\Formatter\LineFormatter('[%datetime%] %channel%.%level_name% [%extra.session_id%] [%extra.uid%] [%extra.user_id%] [%extra.class%:%extra.function%:%extra.line%] - %message% %context% [%extra.http_method%, %extra.url%, %extra.ip%, %extra.referrer%, %extra.user_agent%]'."\n".'');
    }

    /*
     * Gets the private 'esi_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\SurrogateListener
     */
    protected function getEsiListenerService()
    {
        return $this->privates['esi_listener'] = new \Symfony\Component\HttpKernel\EventListener\SurrogateListener(($this->privates['esi'] ?? ($this->privates['esi'] = new \Symfony\Component\HttpKernel\HttpCache\Esi())));
    }

    /*
     * Gets the private 'exception_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\ErrorListener
     */
    protected function getExceptionListener2Service()
    {
        return $this->privates['exception_listener'] = new \Symfony\Component\HttpKernel\EventListener\ErrorListener('error_controller', ($this->privates['monolog.logger.request'] ?? $this->getMonolog_Logger_RequestService()), false);
    }

    /*
     * Gets the private 'fragment.listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\FragmentListener
     */
    protected function getFragment_ListenerService()
    {
        return $this->privates['fragment.listener'] = new \Symfony\Component\HttpKernel\EventListener\FragmentListener(($this->privates['uri_signer'] ?? ($this->privates['uri_signer'] = new \Symfony\Component\HttpKernel\UriSigner($this->getEnv('ECCUBE_AUTH_MAGIC')))), '/_fragment');
    }

    /*
     * Gets the private 'framework_extra_bundle.argument_name_convertor' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentNameConverter
     */
    protected function getFrameworkExtraBundle_ArgumentNameConvertorService()
    {
        return $this->privates['framework_extra_bundle.argument_name_convertor'] = new \Sensio\Bundle\FrameworkExtraBundle\Request\ArgumentNameConverter(($this->privates['argument_metadata_factory'] ?? ($this->privates['argument_metadata_factory'] = new \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory())));
    }

    /*
     * Gets the private 'framework_extra_bundle.event.is_granted' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\IsGrantedListener
     */
    protected function getFrameworkExtraBundle_Event_IsGrantedService()
    {
        return $this->privates['framework_extra_bundle.event.is_granted'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\IsGrantedListener(($this->privates['framework_extra_bundle.argument_name_convertor'] ?? $this->getFrameworkExtraBundle_ArgumentNameConvertorService()), ($this->services['security.authorization_checker'] ?? $this->getSecurity_AuthorizationCheckerService()));
    }

    /*
     * Gets the private 'knp_paginator.subscriber.sliding_pagination' shared service.
     *
     * @return \Knp\Bundle\PaginatorBundle\Subscriber\SlidingPaginationSubscriber
     */
    protected function getKnpPaginator_Subscriber_SlidingPaginationService()
    {
        return $this->privates['knp_paginator.subscriber.sliding_pagination'] = new \Knp\Bundle\PaginatorBundle\Subscriber\SlidingPaginationSubscriber(['defaultPaginationTemplate' => '@KnpPaginator/Pagination/sliding.html.twig', 'defaultSortableTemplate' => '@KnpPaginator/Pagination/sortable_link.html.twig', 'defaultFiltrationTemplate' => '@KnpPaginator/Pagination/filtration.html.twig', 'defaultPageRange' => 5]);
    }

    /*
     * Gets the private 'locale_aware_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\LocaleAwareListener
     */
    protected function getLocaleAwareListenerService()
    {
        return $this->privates['locale_aware_listener'] = new \Symfony\Component\HttpKernel\EventListener\LocaleAwareListener(new RewindableGenerator(function () {
            yield 0 => ($this->services['translator'] ?? $this->getTranslatorService());
        }, 1), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));
    }

    /*
     * Gets the private 'locale_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\LocaleListener
     */
    protected function getLocaleListenerService()
    {
        return $this->privates['locale_listener'] = new \Symfony\Component\HttpKernel\EventListener\LocaleListener(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), $this->getEnv('ECCUBE_LOCALE'), ($this->services['router'] ?? $this->getRouterService()));
    }

    /*
     * Gets the private 'mobile_detect.device_view' shared service.
     *
     * @return \SunCat\MobileDetectBundle\Helper\DeviceView
     */
    protected function getMobileDetect_DeviceViewService()
    {
        $this->privates['mobile_detect.device_view'] = $instance = new \SunCat\MobileDetectBundle\Helper\DeviceView(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));

        $instance->setCookieKey('device_view');
        $instance->setCookiePath('/');
        $instance->setCookieDomain('');
        $instance->setCookieSecure(false);
        $instance->setCookieHttpOnly(true);
        $instance->setSwitchParam('device_view');
        $instance->setCookieExpireDatetimeModifier('1 month');
        $instance->setRedirectConfig($this->parameters['mobile_detect.redirect']);

        return $instance;
    }

    /*
     * Gets the private 'mobile_detect.request_listener' shared service.
     *
     * @return \SunCat\MobileDetectBundle\EventListener\RequestResponseListener
     */
    protected function getMobileDetect_RequestListenerService()
    {
        return $this->privates['mobile_detect.request_listener'] = new \SunCat\MobileDetectBundle\EventListener\RequestResponseListener(($this->privates['mobile_detect.mobile_detector.default'] ?? ($this->privates['mobile_detect.mobile_detector.default'] = new \SunCat\MobileDetectBundle\DeviceDetector\MobileDetector())), ($this->privates['mobile_detect.device_view'] ?? $this->getMobileDetect_DeviceViewService()), ($this->services['router'] ?? $this->getRouterService()), $this->parameters['mobile_detect.redirect'], true);
    }

    /*
     * Gets the private 'monolog.handler.admin' shared service.
     *
     * @return \Monolog\Handler\FingersCrossedHandler
     */
    protected function getMonolog_Handler_AdminService()
    {
        $a = new \Monolog\Handler\RotatingFileHandler((\dirname(__DIR__, 3).'/log/prod/admin.log'), 60, 100, true, NULL, false);
        $a->pushProcessor(($this->privates['monolog.processor.psr_log_message'] ?? ($this->privates['monolog.processor.psr_log_message'] = new \Monolog\Processor\PsrLogMessageProcessor())));
        $a->setFilenameFormat('{filename}-{date}', 'Y-m-d');
        $a->setFormatter(($this->privates['eccube.log.formatter.line'] ?? $this->getEccube_Log_Formatter_LineService()));

        return $this->privates['monolog.handler.admin'] = new \Monolog\Handler\FingersCrossedHandler($a, 400, 0, true, true, 200);
    }

    /*
     * Gets the private 'monolog.handler.console' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Handler\ConsoleHandler
     */
    protected function getMonolog_Handler_ConsoleService()
    {
        return $this->privates['monolog.handler.console'] = new \Symfony\Bridge\Monolog\Handler\ConsoleHandler(NULL, true, [], []);
    }

    /*
     * Gets the private 'monolog.handler.front' shared service.
     *
     * @return \Monolog\Handler\FingersCrossedHandler
     */
    protected function getMonolog_Handler_FrontService()
    {
        $a = new \Monolog\Handler\RotatingFileHandler((\dirname(__DIR__, 3).'/log/prod/front.log'), 60, 100, true, NULL, false);
        $a->pushProcessor(($this->privates['monolog.processor.psr_log_message'] ?? ($this->privates['monolog.processor.psr_log_message'] = new \Monolog\Processor\PsrLogMessageProcessor())));
        $a->setFilenameFormat('{filename}-{date}', 'Y-m-d');
        $a->setFormatter(($this->privates['eccube.log.formatter.line'] ?? $this->getEccube_Log_Formatter_LineService()));

        return $this->privates['monolog.handler.front'] = new \Monolog\Handler\FingersCrossedHandler($a, 400, 0, true, true, 200);
    }

    /*
     * Gets the private 'monolog.handler.main' shared service.
     *
     * @return \Monolog\Handler\FingersCrossedHandler
     */
    protected function getMonolog_Handler_MainService()
    {
        $a = new \Monolog\Handler\RotatingFileHandler((\dirname(__DIR__, 3).'/log/prod/site.log'), 60, 100, true, NULL, false);
        $a->pushProcessor(($this->privates['monolog.processor.psr_log_message'] ?? ($this->privates['monolog.processor.psr_log_message'] = new \Monolog\Processor\PsrLogMessageProcessor())));
        $a->setFilenameFormat('{filename}-{date}', 'Y-m-d');
        $a->setFormatter(($this->privates['eccube.log.formatter.line'] ?? $this->getEccube_Log_Formatter_LineService()));

        return $this->privates['monolog.handler.main'] = new \Monolog\Handler\FingersCrossedHandler($a, 400, 0, true, true, 200);
    }

    /*
     * Gets the private 'monolog.logger' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_LoggerService()
    {
        $this->privates['monolog.logger'] = $instance = new \Symfony\Bridge\Monolog\Logger('app');

        $instance->pushProcessor(($this->privates['Eccube\\Log\\Processor\\SessionProcessor'] ?? $this->getSessionProcessorService()));
        $instance->pushProcessor(($this->privates['Eccube\\Log\\Processor\\TokenProcessor'] ?? $this->getTokenProcessorService()));
        $instance->pushProcessor(($this->privates['Monolog\\Processor\\UidProcessor'] ?? ($this->privates['Monolog\\Processor\\UidProcessor'] = new \Monolog\Processor\UidProcessor())));
        $instance->pushProcessor(($this->privates['Monolog\\Processor\\IntrospectionProcessor'] ?? ($this->privates['Monolog\\Processor\\IntrospectionProcessor'] = new \Monolog\Processor\IntrospectionProcessor('!php/const:Monolog\\Logger::DEBUG', [0 => 'Eccube\\\\Log', 1 => 'Psr\\\\Log']))));
        $instance->pushProcessor(($this->privates['Symfony\\Bridge\\Monolog\\Processor\\WebProcessor'] ?? $this->getWebProcessorService()));
        $instance->useMicrosecondTimestamps(true);
        $instance->pushHandler(($this->privates['monolog.handler.console'] ?? $this->getMonolog_Handler_ConsoleService()));
        $instance->pushHandler(($this->privates['monolog.handler.admin'] ?? $this->getMonolog_Handler_AdminService()));
        $instance->pushHandler(($this->privates['monolog.handler.front'] ?? $this->getMonolog_Handler_FrontService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));

        return $instance;
    }

    /*
     * Gets the private 'monolog.logger.cache' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_CacheService()
    {
        $this->privates['monolog.logger.cache'] = $instance = new \Symfony\Bridge\Monolog\Logger('cache');

        $instance->pushProcessor(($this->privates['Eccube\\Log\\Processor\\SessionProcessor'] ?? $this->getSessionProcessorService()));
        $instance->pushProcessor(($this->privates['Eccube\\Log\\Processor\\TokenProcessor'] ?? $this->getTokenProcessorService()));
        $instance->pushProcessor(($this->privates['Monolog\\Processor\\UidProcessor'] ?? ($this->privates['Monolog\\Processor\\UidProcessor'] = new \Monolog\Processor\UidProcessor())));
        $instance->pushProcessor(($this->privates['Monolog\\Processor\\IntrospectionProcessor'] ?? ($this->privates['Monolog\\Processor\\IntrospectionProcessor'] = new \Monolog\Processor\IntrospectionProcessor('!php/const:Monolog\\Logger::DEBUG', [0 => 'Eccube\\\\Log', 1 => 'Psr\\\\Log']))));
        $instance->pushProcessor(($this->privates['Symfony\\Bridge\\Monolog\\Processor\\WebProcessor'] ?? $this->getWebProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.console'] ?? $this->getMonolog_Handler_ConsoleService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));

        return $instance;
    }

    /*
     * Gets the private 'monolog.logger.request' shared service.
     *
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getMonolog_Logger_RequestService()
    {
        $this->privates['monolog.logger.request'] = $instance = new \Symfony\Bridge\Monolog\Logger('request');

        $instance->pushProcessor(($this->privates['Eccube\\Log\\Processor\\SessionProcessor'] ?? $this->getSessionProcessorService()));
        $instance->pushProcessor(($this->privates['Eccube\\Log\\Processor\\TokenProcessor'] ?? $this->getTokenProcessorService()));
        $instance->pushProcessor(($this->privates['Monolog\\Processor\\UidProcessor'] ?? ($this->privates['Monolog\\Processor\\UidProcessor'] = new \Monolog\Processor\UidProcessor())));
        $instance->pushProcessor(($this->privates['Monolog\\Processor\\IntrospectionProcessor'] ?? ($this->privates['Monolog\\Processor\\IntrospectionProcessor'] = new \Monolog\Processor\IntrospectionProcessor('!php/const:Monolog\\Logger::DEBUG', [0 => 'Eccube\\\\Log', 1 => 'Psr\\\\Log']))));
        $instance->pushProcessor(($this->privates['Symfony\\Bridge\\Monolog\\Processor\\WebProcessor'] ?? $this->getWebProcessorService()));
        $instance->pushHandler(($this->privates['monolog.handler.console'] ?? $this->getMonolog_Handler_ConsoleService()));
        $instance->pushHandler(($this->privates['monolog.handler.main'] ?? $this->getMonolog_Handler_MainService()));

        return $instance;
    }

    /*
     * Gets the private 'router.request_context' shared service.
     *
     * @return \Symfony\Component\Routing\RequestContext
     */
    protected function getRouter_RequestContextService()
    {
        return $this->privates['router.request_context'] = new \Symfony\Component\Routing\RequestContext('', 'GET', 'localhost', 'http', 80, 443);
    }

    /*
     * Gets the private 'router_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\RouterListener
     */
    protected function getRouterListenerService()
    {
        return $this->privates['router_listener'] = new \Symfony\Component\HttpKernel\EventListener\RouterListener(($this->services['router'] ?? $this->getRouterService()), ($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()), ($this->privates['monolog.logger.request'] ?? $this->getMonolog_Logger_RequestService()), \dirname(__DIR__, 4), false);
    }

    /*
     * Gets the private 'security.access.decision_manager' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\AccessDecisionManager
     */
    protected function getSecurity_Access_DecisionManagerService()
    {
        return $this->privates['security.access.decision_manager'] = new \Symfony\Component\Security\Core\Authorization\AccessDecisionManager(new RewindableGenerator(function () {
            yield 0 => ($this->privates['security.access.authenticated_voter'] ?? $this->load('getSecurity_Access_AuthenticatedVoterService.php'));
            yield 1 => ($this->privates['security.access.simple_role_voter'] ?? ($this->privates['security.access.simple_role_voter'] = new \Symfony\Component\Security\Core\Authorization\Voter\RoleVoter()));
            yield 2 => ($this->privates['security.access.expression_voter'] ?? $this->load('getSecurity_Access_ExpressionVoterService.php'));
            yield 3 => ($this->privates['Eccube\\Security\\Voter\\AuthorityVoter'] ?? $this->load('getAuthorityVoterService.php'));
        }, 4), 'unanimous', false, true);
    }

    /*
     * Gets the private 'security.authentication.manager' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager
     */
    protected function getSecurity_Authentication_ManagerService()
    {
        $this->privates['security.authentication.manager'] = $instance = new \Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager(new RewindableGenerator(function () {
            yield 0 => ($this->privates['security.authentication.provider.oauth2.api'] ?? $this->load('getSecurity_Authentication_Provider_Oauth2_ApiService.php'));
            yield 1 => ($this->privates['security.authentication.provider.dao.admin'] ?? $this->load('getSecurity_Authentication_Provider_Dao_AdminService.php'));
            yield 2 => ($this->privates['security.authentication.provider.anonymous.admin'] ?? ($this->privates['security.authentication.provider.anonymous.admin'] = new \Symfony\Component\Security\Core\Authentication\Provider\AnonymousAuthenticationProvider($this->getParameter('container.build_hash'))));
            yield 3 => ($this->privates['security.authentication.provider.dao.customer'] ?? $this->load('getSecurity_Authentication_Provider_Dao_CustomerService.php'));
            yield 4 => ($this->privates['security.authentication.provider.rememberme.customer'] ?? $this->load('getSecurity_Authentication_Provider_Rememberme_CustomerService.php'));
            yield 5 => ($this->privates['security.authentication.provider.anonymous.customer'] ?? ($this->privates['security.authentication.provider.anonymous.customer'] = new \Symfony\Component\Security\Core\Authentication\Provider\AnonymousAuthenticationProvider($this->getParameter('container.build_hash'))));
        }, 6), true);

        $instance->setEventDispatcher(($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()));

        return $instance;
    }

    /*
     * Gets the private 'security.csrf.token_storage' shared service.
     *
     * @return \Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage
     */
    protected function getSecurity_Csrf_TokenStorageService()
    {
        return $this->privates['security.csrf.token_storage'] = new \Symfony\Component\Security\Csrf\TokenStorage\SessionTokenStorage(($this->services['session'] ?? $this->getSessionService()));
    }

    /*
     * Gets the private 'security.encoder_factory.generic' shared service.
     *
     * @return \Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    protected function getSecurity_EncoderFactory_GenericService()
    {
        $a = ($this->privates['Eccube\\Security\\Core\\Encoder\\PasswordEncoder'] ?? $this->getPasswordEncoderService());

        return $this->privates['security.encoder_factory.generic'] = new \Symfony\Component\Security\Core\Encoder\EncoderFactory(['Eccube\\Entity\\Member' => $a, 'Eccube\\Entity\\Customer' => $a]);
    }

    /*
     * Gets the private 'security.firewall' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\EventListener\FirewallListener
     */
    protected function getSecurity_FirewallService()
    {
        return $this->privates['security.firewall'] = new \Symfony\Bundle\SecurityBundle\EventListener\FirewallListener(new \Symfony\Bundle\SecurityBundle\Security\FirewallMap(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'security.firewall.map.context.admin' => ['privates', 'security.firewall.map.context.admin', 'getSecurity_Firewall_Map_Context_AdminService.php', true],
            'security.firewall.map.context.api' => ['privates', 'security.firewall.map.context.api', 'getSecurity_Firewall_Map_Context_ApiService.php', true],
            'security.firewall.map.context.customer' => ['privates', 'security.firewall.map.context.customer', 'getSecurity_Firewall_Map_Context_CustomerService.php', true],
            'security.firewall.map.context.dev' => ['privates', 'security.firewall.map.context.dev', 'getSecurity_Firewall_Map_Context_DevService.php', true],
        ], [
            'security.firewall.map.context.admin' => '?',
            'security.firewall.map.context.api' => '?',
            'security.firewall.map.context.customer' => '?',
            'security.firewall.map.context.dev' => '?',
        ]), new RewindableGenerator(function () {
            yield 'security.firewall.map.context.dev' => ($this->privates['.security.request_matcher.Iy.T22O'] ?? ($this->privates['.security.request_matcher.Iy.T22O'] = new \Symfony\Component\HttpFoundation\RequestMatcher('^/(_(profiler|wdt)|css|images|js)/')));
            yield 'security.firewall.map.context.api' => ($this->privates['.security.request_matcher.p4VlLPC'] ?? ($this->privates['.security.request_matcher.p4VlLPC'] = new \Symfony\Component\HttpFoundation\RequestMatcher('^/api')));
            yield 'security.firewall.map.context.admin' => ($this->privates['.security.request_matcher.FOgb8uy'] ?? ($this->privates['.security.request_matcher.FOgb8uy'] = new \Symfony\Component\HttpFoundation\RequestMatcher('^/'.$this->getEnv('string:ECCUBE_ADMIN_ROUTE').'/')));
            yield 'security.firewall.map.context.customer' => ($this->privates['.security.request_matcher.3UEFixr'] ?? ($this->privates['.security.request_matcher.3UEFixr'] = new \Symfony\Component\HttpFoundation\RequestMatcher('^/')));
        }, 4)), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), ($this->privates['security.logout_url_generator'] ?? $this->getSecurity_LogoutUrlGeneratorService()));
    }

    /*
     * Gets the private 'security.logout_url_generator' shared service.
     *
     * @return \Symfony\Component\Security\Http\Logout\LogoutUrlGenerator
     */
    protected function getSecurity_LogoutUrlGeneratorService()
    {
        $this->privates['security.logout_url_generator'] = $instance = new \Symfony\Component\Security\Http\Logout\LogoutUrlGenerator(($this->services['request_stack'] ?? ($this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())), ($this->services['router'] ?? $this->getRouterService()), ($this->services['security.token_storage'] ?? $this->getSecurity_TokenStorageService()));

        $instance->registerListener('admin', 'admin_logout', 'logout', '_csrf_token', NULL, NULL);
        $instance->registerListener('customer', 'logout', 'logout', '_csrf_token', NULL, NULL);

        return $instance;
    }

    /*
     * Gets the private 'sensio_framework_extra.controller.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\ControllerListener
     */
    protected function getSensioFrameworkExtra_Controller_ListenerService()
    {
        return $this->privates['sensio_framework_extra.controller.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\ControllerListener(($this->privates['annotations.cached_reader'] ?? $this->getAnnotations_CachedReaderService()));
    }

    /*
     * Gets the private 'sensio_framework_extra.converter.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener
     */
    protected function getSensioFrameworkExtra_Converter_ListenerService()
    {
        $a = new \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager();
        $a->add(new \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter(($this->services['doctrine'] ?? $this->getDoctrineService()), new \Symfony\Component\ExpressionLanguage\ExpressionLanguage()), 0, 'doctrine.orm');
        $a->add(new \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DateTimeParamConverter(), 0, 'datetime');

        return $this->privates['sensio_framework_extra.converter.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener($a, true);
    }

    /*
     * Gets the private 'sensio_framework_extra.security.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\SecurityListener
     */
    protected function getSensioFrameworkExtra_Security_ListenerService()
    {
        return $this->privates['sensio_framework_extra.security.listener'] = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\SecurityListener(($this->privates['framework_extra_bundle.argument_name_convertor'] ?? $this->getFrameworkExtraBundle_ArgumentNameConvertorService()), new \Sensio\Bundle\FrameworkExtraBundle\Security\ExpressionLanguage(), ($this->privates['security.authentication.trust_resolver'] ?? ($this->privates['security.authentication.trust_resolver'] = new \Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolver(NULL, NULL))), ($this->privates['security.role_hierarchy'] ?? ($this->privates['security.role_hierarchy'] = new \Symfony\Component\Security\Core\Role\RoleHierarchy([]))), ($this->services['security.token_storage'] ?? $this->getSecurity_TokenStorageService()), ($this->services['security.authorization_checker'] ?? $this->getSecurity_AuthorizationCheckerService()), ($this->privates['monolog.logger'] ?? $this->getMonolog_LoggerService()));
    }

    /*
     * Gets the private 'sensio_framework_extra.view.listener' shared service.
     *
     * @return \Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener
     */
    protected function getSensioFrameworkExtra_View_ListenerService()
    {
        $this->privates['sensio_framework_extra.view.listener'] = $instance = new \Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener(new \Sensio\Bundle\FrameworkExtraBundle\Templating\TemplateGuesser(($this->services['kernel'] ?? $this->get('kernel', 1))));

        $instance->setContainer((new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'twig' => ['services', 'twig', 'getTwigService', false],
        ], [
            'twig' => 'Twig\\Environment',
        ]))->withContext('sensio_framework_extra.view.listener', $this));

        return $instance;
    }

    /*
     * Gets the private 'session_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\SessionListener
     */
    protected function getSessionListenerService()
    {
        return $this->privates['session_listener'] = new \Symfony\Component\HttpKernel\EventListener\SessionListener(new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($this->getService, [
            'initialized_session' => ['services', 'session', NULL, false],
            'session' => ['services', 'session', 'getSessionService', false],
        ], [
            'initialized_session' => '?',
            'session' => '?',
        ]));
    }

    /**
     * @return array|bool|float|int|string|null
     */
    public function getParameter($name)
    {
        $name = (string) $name;
        if (isset($this->buildParameters[$name])) {
            return $this->buildParameters[$name];
        }

        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter($name): bool
    {
        $name = (string) $name;
        if (isset($this->buildParameters[$name])) {
            return true;
        }

        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter($name, $value): void
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    public function getParameterBag(): ParameterBagInterface
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            foreach ($this->buildParameters as $name => $value) {
                $parameters[$name] = $value;
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = [
        'kernel.cache_dir' => false,
        'locale' => false,
        'timezone' => false,
        'currency' => false,
        'eccube_database_url' => false,
        'eccube_mailer_url' => false,
        'eccube_admin_route' => false,
        'eccube_user_data_route' => false,
        'eccube_admin_allow_hosts' => false,
        'eccube_admin_deny_hosts' => false,
        'eccube_force_ssl' => false,
        'eccube.theme' => false,
        'eccube_theme_code' => false,
        'eccube_auth_magic' => false,
        'eccube_theme_front_dir' => false,
        'eccube_html_front_dir' => false,
        'eccube_csv_temp_realdir' => false,
        'eccube_owners_store_url' => false,
        'eccube_package_api_url' => false,
        'eccube_content_maintenance_file_path' => false,
        'eccube_2fa_enabled' => false,
        'eccube_2fa_cookie_name' => false,
        'eccube_2fa_expire' => false,
        'kernel.secret' => false,
        'kernel.default_locale' => false,
        'session.storage.options' => false,
        'validator.mapping.cache.file' => false,
        'serializer.mapping.cache.file' => false,
        'doctrine.orm.proxy_dir' => false,
        'swiftmailer.spool.default.memory.path' => false,
    ];
    private $dynamicParameters = [];

    private function getDynamicParameter(string $name)
    {
        switch ($name) {
            case 'kernel.cache_dir': $value = $this->targetDir.''; break;
            case 'locale': $value = $this->getEnv('ECCUBE_LOCALE'); break;
            case 'timezone': $value = $this->getEnv('ECCUBE_TIMEZONE'); break;
            case 'currency': $value = $this->getEnv('ECCUBE_CURRENCY'); break;
            case 'eccube_database_url': $value = $this->getEnv('DATABASE_URL'); break;
            case 'eccube_mailer_url': $value = $this->getEnv('MAILER_URL'); break;
            case 'eccube_admin_route': $value = $this->getEnv('ECCUBE_ADMIN_ROUTE'); break;
            case 'eccube_user_data_route': $value = $this->getEnv('ECCUBE_USER_DATA_ROUTE'); break;
            case 'eccube_admin_allow_hosts': $value = $this->getEnv('json:ECCUBE_ADMIN_ALLOW_HOSTS'); break;
            case 'eccube_admin_deny_hosts': $value = $this->getEnv('json:ECCUBE_ADMIN_DENY_HOSTS'); break;
            case 'eccube_force_ssl': $value = $this->getEnv('bool:ECCUBE_FORCE_SSL'); break;
            case 'eccube.theme': $value = $this->getEnv('ECCUBE_TEMPLATE_CODE'); break;
            case 'eccube_theme_code': $value = $this->getEnv('ECCUBE_TEMPLATE_CODE'); break;
            case 'eccube_auth_magic': $value = $this->getEnv('ECCUBE_AUTH_MAGIC'); break;
            case 'eccube_theme_front_dir': $value = (\dirname(__DIR__, 4).'/app/template/'.$this->getEnv('string:ECCUBE_TEMPLATE_CODE')); break;
            case 'eccube_html_front_dir': $value = (\dirname(__DIR__, 4).'/html/template/'.$this->getEnv('string:ECCUBE_TEMPLATE_CODE')); break;
            case 'eccube_csv_temp_realdir': $value = ($this->targetDir.''.'/prod/eccube'); break;
            case 'eccube_owners_store_url': $value = $this->getEnv('ECCUBE_OWNERS_STORE_URL'); break;
            case 'eccube_package_api_url': $value = $this->getEnv('ECCUBE_PACKAGE_API_URL'); break;
            case 'eccube_content_maintenance_file_path': $value = $this->getEnv('ECCUBE_MAINTENANCE_FILE_PATH'); break;
            case 'eccube_2fa_enabled': $value = $this->getEnv('ECCUBE_2FA_ENABLED'); break;
            case 'eccube_2fa_cookie_name': $value = $this->getEnv('ECCUBE_2FA_COOKIE_NAME'); break;
            case 'eccube_2fa_expire': $value = $this->getEnv('ECCUBE_2FA_EXPIRE'); break;
            case 'kernel.secret': $value = $this->getEnv('ECCUBE_AUTH_MAGIC'); break;
            case 'kernel.default_locale': $value = $this->getEnv('ECCUBE_LOCALE'); break;
            case 'session.storage.options': $value = [
                'cache_limiter' => '0',
                'name' => $this->getEnv('ECCUBE_COOKIE_NAME'),
                'cookie_lifetime' => $this->getEnv('ECCUBE_COOKIE_LIFETIME'),
                'cookie_httponly' => true,
                'gc_maxlifetime' => $this->getEnv('ECCUBE_GC_MAXLIFETIME'),
                'gc_probability' => 1,
            ]; break;
            case 'validator.mapping.cache.file': $value = ($this->targetDir.''.'/validation.php'); break;
            case 'serializer.mapping.cache.file': $value = ($this->targetDir.''.'/serialization.php'); break;
            case 'doctrine.orm.proxy_dir': $value = ($this->targetDir.''.'/doctrine/orm/Proxies'); break;
            case 'swiftmailer.spool.default.memory.path': $value = ($this->targetDir.''.'/swiftmailer/spool/default'); break;
            default: throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
        }
        $this->loadedDynamicParameters[$name] = true;

        return $this->dynamicParameters[$name] = $value;
    }

    protected function getDefaultParameters(): array
    {
        return [
            'kernel.root_dir' => (\dirname(__DIR__, 4).'/src/Eccube'),
            'kernel.project_dir' => \dirname(__DIR__, 4),
            'kernel.environment' => 'prod',
            'kernel.debug' => false,
            'kernel.name' => 'Eccube',
            'kernel.logs_dir' => (\dirname(__DIR__, 3).'/log'),
            'kernel.bundles' => [
                'FrameworkBundle' => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
                'SecurityBundle' => 'Symfony\\Bundle\\SecurityBundle\\SecurityBundle',
                'DoctrineCacheBundle' => 'Doctrine\\Bundle\\DoctrineCacheBundle\\DoctrineCacheBundle',
                'DoctrineBundle' => 'Doctrine\\Bundle\\DoctrineBundle\\DoctrineBundle',
                'DoctrineMigrationsBundle' => 'Doctrine\\Bundle\\MigrationsBundle\\DoctrineMigrationsBundle',
                'DoctrineFixturesBundle' => 'Doctrine\\Bundle\\FixturesBundle\\DoctrineFixturesBundle',
                'SensioFrameworkExtraBundle' => 'Sensio\\Bundle\\FrameworkExtraBundle\\SensioFrameworkExtraBundle',
                'MonologBundle' => 'Symfony\\Bundle\\MonologBundle\\MonologBundle',
                'SwiftmailerBundle' => 'Symfony\\Bundle\\SwiftmailerBundle\\SwiftmailerBundle',
                'TwigBundle' => 'Symfony\\Bundle\\TwigBundle\\TwigBundle',
                'MobileDetectBundle' => 'SunCat\\MobileDetectBundle\\MobileDetectBundle',
                'KnpPaginatorBundle' => 'Knp\\Bundle\\PaginatorBundle\\KnpPaginatorBundle',
                'ExerciseHTMLPurifierBundle' => 'Exercise\\HTMLPurifierBundle\\ExerciseHTMLPurifierBundle',
                'ApiBundle' => 'Plugin\\Api\\Bundle\\ApiBundle',
                'TrikoderOAuth2Bundle' => 'Trikoder\\Bundle\\OAuth2Bundle\\TrikoderOAuth2Bundle',
            ],
            'kernel.bundles_metadata' => [
                'FrameworkBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/symfony/framework-bundle'),
                    'namespace' => 'Symfony\\Bundle\\FrameworkBundle',
                ],
                'SecurityBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/symfony/security-bundle'),
                    'namespace' => 'Symfony\\Bundle\\SecurityBundle',
                ],
                'DoctrineCacheBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-cache-bundle'),
                    'namespace' => 'Doctrine\\Bundle\\DoctrineCacheBundle',
                ],
                'DoctrineBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle'),
                    'namespace' => 'Doctrine\\Bundle\\DoctrineBundle',
                ],
                'DoctrineMigrationsBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-migrations-bundle'),
                    'namespace' => 'Doctrine\\Bundle\\MigrationsBundle',
                ],
                'DoctrineFixturesBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/doctrine/doctrine-fixtures-bundle'),
                    'namespace' => 'Doctrine\\Bundle\\FixturesBundle',
                ],
                'SensioFrameworkExtraBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/sensio/framework-extra-bundle/src'),
                    'namespace' => 'Sensio\\Bundle\\FrameworkExtraBundle',
                ],
                'MonologBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/symfony/monolog-bundle'),
                    'namespace' => 'Symfony\\Bundle\\MonologBundle',
                ],
                'SwiftmailerBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/symfony/swiftmailer-bundle'),
                    'namespace' => 'Symfony\\Bundle\\SwiftmailerBundle',
                ],
                'TwigBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/symfony/twig-bundle'),
                    'namespace' => 'Symfony\\Bundle\\TwigBundle',
                ],
                'MobileDetectBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/suncat/mobile-detect-bundle/SunCat/MobileDetectBundle'),
                    'namespace' => 'SunCat\\MobileDetectBundle',
                ],
                'KnpPaginatorBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/knplabs/knp-paginator-bundle'),
                    'namespace' => 'Knp\\Bundle\\PaginatorBundle',
                ],
                'ExerciseHTMLPurifierBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/exercise/htmlpurifier-bundle/src'),
                    'namespace' => 'Exercise\\HTMLPurifierBundle',
                ],
                'ApiBundle' => [
                    'path' => (\dirname(__DIR__, 4).'/app/Plugin/Api/Bundle'),
                    'namespace' => 'Plugin\\Api\\Bundle',
                ],
                'TrikoderOAuth2Bundle' => [
                    'path' => (\dirname(__DIR__, 4).'/vendor/trikoder/oauth2-bundle'),
                    'namespace' => 'Trikoder\\Bundle\\OAuth2Bundle',
                ],
            ],
            'kernel.charset' => 'UTF-8',
            'kernel.container_class' => 'EccubeEccube_KernelProdContainer',
            'container.dumper.inline_class_loader' => true,
            'env(ECCUBE_LOCALE)' => 'ja',
            'env(ECCUBE_TIMEZONE)' => 'Asia/Tokyo',
            'env(ECCUBE_CURRENCY)' => 'JPY',
            'env(DATABASE_URL)' => '',
            'env(DATABASE_SERVER_VERSION)' => NULL,
            'env(ECCUBE_ADMIN_ROUTE)' => 'admin',
            'env(ECCUBE_USER_DATA_ROUTE)' => 'user_data',
            'env(ECCUBE_ADMIN_ALLOW_HOSTS)' => '[]',
            'env(ECCUBE_ADMIN_DENY_HOSTS)' => '[]',
            'env(ECCUBE_FORCE_SSL)' => false,
            'env(ECCUBE_TEMPLATE_CODE)' => 'default',
            'env(ECCUBE_AUTH_MAGIC)' => '<change.me>',
            'env(ECCUBE_COOKIE_NAME)' => 'eccube',
            'env(ECCUBE_COOKIE_PATH)' => '/',
            'env(ECCUBE_COOKIE_LIFETIME)' => '0',
            'env(ECCUBE_GC_MAXLIFETIME)' => '1440',
            'env(ECCUBE_PACKAGE_API_URL)' => 'https://package-api-c2.ec-cube.net',
            'env(ECCUBE_OWNERS_STORE_URL)' => 'https://www.ec-cube.net',
            'env(ECCUBE_MAINTENANCE_FILE_PATH)' => (\dirname(__DIR__, 4).'/.maintenance'),
            'env(ECCUBE_2FA_ENABLED)' => true,
            'env(ECCUBE_2FA_COOKIE_NAME)' => 'eccube_2fa',
            'env(ECCUBE_2FA_EXPIRE)' => '14',
            'eccube_auth_type' => 'HMAC',
            'eccube_password_hash_algos' => 'SHA256',
            'eccube_theme_app_dir' => (\dirname(__DIR__, 4).'/app/template'),
            'eccube_theme_src_dir' => (\dirname(__DIR__, 4).'/src/Eccube/Resource/template'),
            'eccube_theme_user_data_dir' => (\dirname(__DIR__, 4).'/app/template/user_data'),
            'eccube_theme_front_default_dir' => (\dirname(__DIR__, 4).'/src/Eccube/Resource/template/default'),
            'eccube_theme_admin_dir' => (\dirname(__DIR__, 4).'/app/template/admin'),
            'eccube_theme_admin_default_dir' => (\dirname(__DIR__, 4).'/src/Eccube/Resource/template/admin'),
            'eccube_html_dir' => (\dirname(__DIR__, 4).'/html'),
            'eccube_html_plugin_dir' => (\dirname(__DIR__, 4).'/html/plugin'),
            'eccube_html_admin_dir' => (\dirname(__DIR__, 4).'/html/template/admin'),
            'eccube_twig_block_templates' => [

            ],
            'eccube_save_image_dir' => (\dirname(__DIR__, 4).'/html/upload/save_image'),
            'eccube_temp_image_dir' => (\dirname(__DIR__, 4).'/html/upload/temp_image'),
            'eccube_csv_size' => 5,
            'eccube_csv_split_lines' => 100,
            'eccube_default_password' => '**********',
            'eccube_deliv_addr_max' => 20,
            'eccube_deliv_date_end_max' => 21,
            'eccube_id_max_len' => 50,
            'eccube_id_min_len' => 4,
            'eccube_int_len' => 9,
            'eccube_category_nest_level' => 5,
            'eccube_lltext_len' => 99999,
            'eccube_ltext_len' => 3000,
            'eccube_max_total_fee' => 9999999999,
            'eccube_mltext_len' => 1000,
            'eccube_mtext_len' => 200,
            'plugin_html_realdir' => (\dirname(__DIR__, 4).'/html/plugin/'),
            'plugin_html_urlpath' => '/plugin/',
            'plugin_realdir' => (\dirname(__DIR__, 4).'/app/Plugin'),
            'plugin_data_realdir' => (\dirname(__DIR__, 4).'/app/PluginData'),
            'plugin_temp_realdir' => '/PATH/TO/WEB_ROOT/src/Eccube/Repository/Master/upload/temp_plugin/',
            'eccube_price_len' => 8,
            'eccube_search_pmax' => 12,
            'eccube_sitemap_products_per_page' => 1000,
            'eccube_stext_len' => 255,
            'eccube_sltext_len' => 500,
            'eccube_smtext_len' => 100,
            'eccube_tax_rule_priority' => [
                0 => 'product_id',
                1 => 'product_class_id',
                2 => 'pref_id',
                3 => 'country_id',
            ],
            'eccube_url_len' => 1024,
            'eccube_default_page_count' => 50,
            'eccube_admin_product_stock_status' => 3,
            'eccube_customer_reset_expire' => 10,
            'eccube_csv_export_separator' => ',',
            'eccube_csv_export_encoding' => 'SJIS-win',
            'eccube_csv_import_encoding' => [
                0 => 'UTF-8',
                1 => 'SJIS-win',
                2 => 'SJIS',
                3 => 'EUC-JP',
                4 => 'ASCII',
                5 => 'JIS',
            ],
            'eccube_csv_export_date_format' => 'Y-m-d H:i:s',
            'eccube_csv_export_multidata_separator' => ',',
            'eccube_csv_import_delimiter' => ',',
            'eccube_csv_import_enclosure' => '"',
            'eccube_csv_import_escape' => '\\',
            'eccube_info_url' => 'https://www.ec-cube.net/info/4/',
            'eccube_official_site_url' => 'https://www.ec-cube.net',
            'eccube_community_site_url' => 'https://xoops.ec-cube.net',
            'eccube_document_url' => 'http://doc4.ec-cube.net',
            'eccube_name_len' => 16,
            'eccube_kana_len' => 25,
            'eccube_address1_len' => 32,
            'eccube_address2_len' => 32,
            'eccube_birth_max' => 110,
            'eccube_product_order_price_lower' => 1,
            'eccube_product_order_newer' => 2,
            'eccube_product_order_price_higher' => 3,
            'eccube_price_max' => 2147483647,
            'eccube_tel_len_max' => 14,
            'eccube_postal_code' => 8,
            'eccube_password_min_len' => 8,
            'eccube_password_max_len' => 32,
            'eccube_composer_memory_limit' => '1536M',
            'eccube_order_mail_template_id' => 1,
            'eccube_entry_confirm_mail_template_id' => 2,
            'eccube_entry_complete_mail_template_id' => 3,
            'eccube_customer_withdraw_mail_template_id' => 4,
            'eccube_contact_mail_template_id' => 5,
            'eccube_forgot_mail_template_id' => 6,
            'eccube_reset_complete_mail_template_id' => 7,
            'eccube_shipping_notify_mail_template_id' => 8,
            'eccube_rfc_email_check' => false,
            'eccube_order_no_format' => '',
            'eccube_order_pdf_message_len' => 30,
            'eccube_news_start_year' => 2000,
            'eccube_result_cache_lifetime' => 3600,
            'eccube_result_cache_lifetime_short' => 10,
            'eccube_nav' => [
                'product' => [
                    'name' => 'admin.product.product_management',
                    'icon' => 'fa-cube',
                    'children' => [
                        'product_master' => [
                            'name' => 'admin.product.product_list',
                            'url' => 'admin_product',
                        ],
                        'product_edit' => [
                            'name' => 'admin.product.product_registration',
                            'url' => 'admin_product_product_new',
                        ],
                        'class_name' => [
                            'name' => 'admin.product.class_management',
                            'url' => 'admin_product_class_name',
                        ],
                        'class_category' => [
                            'name' => 'admin.product.category_management',
                            'url' => 'admin_product_category',
                        ],
                        'product_tag' => [
                            'name' => 'admin.product.tag_management',
                            'url' => 'admin_product_tag',
                        ],
                        'product_csv_import' => [
                            'name' => 'admin.product.product_csv_upload',
                            'url' => 'admin_product_csv_import',
                        ],
                        'category_csv_import' => [
                            'name' => 'admin.product.category_csv_upload',
                            'url' => 'admin_product_category_csv_import',
                        ],
                    ],
                ],
                'order' => [
                    'name' => 'admin.order.order_management',
                    'icon' => 'fa-shopping-cart',
                    'children' => [
                        'order_master' => [
                            'name' => 'admin.order.order_list',
                            'url' => 'admin_order',
                        ],
                        'order_edit' => [
                            'name' => 'admin.order.order_registration',
                            'url' => 'admin_order_new',
                        ],
                        'shipping_csv_import' => [
                            'name' => 'admin.order.shipping_csv_upload',
                            'url' => 'admin_shipping_csv_import',
                        ],
                    ],
                ],
                'customer' => [
                    'name' => 'admin.customer.customer_management',
                    'icon' => 'fa-users',
                    'children' => [
                        'customer_master' => [
                            'name' => 'admin.customer.customer_list',
                            'url' => 'admin_customer',
                        ],
                        'customer_edit' => [
                            'name' => 'admin.customer.customer_registration',
                            'url' => 'admin_customer_new',
                        ],
                    ],
                ],
                'content' => [
                    'name' => 'admin.content.contents_management',
                    'icon' => 'fa-file-text-o',
                    'children' => [
                        'news' => [
                            'name' => 'admin.content.news_management',
                            'url' => 'admin_content_news',
                        ],
                        'file' => [
                            'name' => 'admin.content.file_management',
                            'url' => 'admin_content_file',
                        ],
                        'layout' => [
                            'name' => 'admin.content.layout_management',
                            'url' => 'admin_content_layout',
                        ],
                        'page' => [
                            'name' => 'admin.content.page_management',
                            'url' => 'admin_content_page',
                        ],
                        'css' => [
                            'name' => 'admin.content.css_management',
                            'url' => 'admin_content_css',
                        ],
                        'js' => [
                            'name' => 'admin.content.js_management',
                            'url' => 'admin_content_js',
                        ],
                        'block' => [
                            'name' => 'admin.content.block_management',
                            'url' => 'admin_content_block',
                        ],
                        'cache' => [
                            'name' => 'admin.content.cache_management',
                            'url' => 'admin_content_cache',
                        ],
                        'maintenance' => [
                            'name' => 'admin.content.maintenance_management',
                            'url' => 'admin_content_maintenance',
                        ],
                    ],
                ],
                'setting' => [
                    'name' => 'admin.setting',
                    'icon' => 'fa-cog',
                    'children' => [
                        'shop' => [
                            'name' => 'admin.setting.shop',
                            'children' => [
                                'shop_index' => [
                                    'name' => 'admin.setting.shop.shop_setting',
                                    'url' => 'admin_setting_shop',
                                ],
                                'shop_tradelaw' => [
                                    'name' => 'admin.setting.shop.tradelaw_setting',
                                    'url' => 'admin_content_page_edit',
                                    'param' => [
                                        'id' => 21,
                                        'return' => 'tradelaw',
                                    ],
                                ],
                                'shop_agreement' => [
                                    'name' => 'admin.setting.shop.agreement_setting',
                                    'url' => 'admin_content_page_edit',
                                    'param' => [
                                        'id' => 19,
                                        'return' => 'agreement',
                                    ],
                                ],
                                'shop_payment' => [
                                    'name' => 'admin.setting.shop.payment_setting',
                                    'url' => 'admin_setting_shop_payment',
                                ],
                                'shop_delivery' => [
                                    'name' => 'admin.setting.shop.delivery_setting',
                                    'url' => 'admin_setting_shop_delivery',
                                ],
                                'shop_tax' => [
                                    'name' => 'admin.setting.shop.tax_setting',
                                    'url' => 'admin_setting_shop_tax',
                                ],
                                'shop_mail' => [
                                    'name' => 'admin.setting.shop.mail_setting',
                                    'url' => 'admin_setting_shop_mail',
                                ],
                                'shop_csv' => [
                                    'name' => 'admin.setting.shop.csv_setting',
                                    'url' => 'admin_setting_shop_csv',
                                ],
                                'shop_order_status' => [
                                    'name' => 'admin.setting.shop.order_status_setting',
                                    'url' => 'admin_setting_shop_order_status',
                                ],
                            ],
                        ],
                        'system' => [
                            'name' => 'admin.setting.system',
                            'children' => [
                                'member' => [
                                    'name' => 'admin.setting.system.member_management',
                                    'url' => 'admin_setting_system_member',
                                ],
                                'authority' => [
                                    'name' => 'admin.setting.system.authority_management',
                                    'url' => 'admin_setting_system_authority',
                                ],
                                'security' => [
                                    'name' => 'admin.setting.system.security_management',
                                    'url' => 'admin_setting_system_security',
                                ],
                                'login_history' => [
                                    'name' => 'admin.setting.system.login_history',
                                    'url' => 'admin_setting_system_login_history',
                                ],
                                'log' => [
                                    'name' => 'admin.setting.system.log_display',
                                    'url' => 'admin_setting_system_log',
                                ],
                                'masterdata' => [
                                    'name' => 'admin.setting.system.master_data_management',
                                    'url' => 'admin_setting_system_masterdata',
                                ],
                                'system_index' => [
                                    'name' => 'admin.setting.system.system_info',
                                    'url' => 'admin_setting_system_system',
                                ],
                            ],
                        ],
                    ],
                ],
                'store' => [
                    'name' => 'admin.store',
                    'icon' => 'fa-plug',
                    'children' => [
                        'plugin' => [
                            'name' => 'admin.store.plugin',
                            'children' => [
                                'plugin_owners_search' => [
                                    'name' => 'admin.store.plugin.plugin_owners_install',
                                    'url' => 'admin_store_plugin_owners_search',
                                ],
                                'plugin_list' => [
                                    'name' => 'admin.store.plugin.plugin_list',
                                    'url' => 'admin_store_plugin',
                                ],
                            ],
                        ],
                        'template' => [
                            'name' => 'admin.store.template',
                            'children' => [
                                'template_list' => [
                                    'name' => 'admin.store.template.template_list',
                                    'url' => 'admin_store_template',
                                ],
                                'template_install' => [
                                    'name' => 'admin.store.template.template_install',
                                    'url' => 'admin_store_template_install',
                                ],
                            ],
                        ],
                        'authentication_setting' => [
                            'name' => 'admin.store.setting',
                            'url' => 'admin_store_authentication_setting',
                        ],
                    ],
                ],
            ],
            'env(MAILER_URL)' => '',
            'env(ECCUBE_OAUTH2_AUTHORIZATION_SERVER_PRIVATE_KEY)' => (\dirname(__DIR__, 4).'/app/PluginData/Api/oauth/private.key'),
            'env(ECCUBE_OAUTH2_RESOURCE_SERVER_PUBLIC_KEY)' => (\dirname(__DIR__, 4).'/app/PluginData/Api/oauth/public.key'),
            'env(ECCUBE_OAUTH2_ENCRYPTION_KEY)' => '<change.me>',
            'gmc_proxy_url' => 'https://gmc-proxy.ec-cube.net',
            'mail_magazine_dir' => (\dirname(__DIR__, 4).'/app/mail_magazine'),
            'product_review_display_count_min' => 1,
            'product_review_display_count_max' => 30,
            'plugin_recommend.text_area_len' => 4000,
            'related_product.text_area_len' => 4000,
            'related_product.max_item_count' => 6,
            'sales_report_product_maximum_display' => 20,
            'securitychecker4_receiver' => 'https://www.ec-cube.net/info/security/receiver.php',
            'eccube.plugins.enabled' => [

            ],
            'eccube.plugins.disabled' => [
                0 => 'Api',
                1 => 'Coupon4',
                2 => 'GMC',
                3 => 'MailMagazine4',
                4 => 'ProductReview4',
                5 => 'Recommend4',
                6 => 'RelatedProduct4',
                7 => 'SalesReport4',
                8 => 'Securitychecker4',
                9 => 'SiteKit',
            ],
            'event_dispatcher.event_aliases' => [
                'Symfony\\Component\\Console\\Event\\ConsoleCommandEvent' => 'console.command',
                'Symfony\\Component\\Console\\Event\\ConsoleErrorEvent' => 'console.error',
                'Symfony\\Component\\Console\\Event\\ConsoleTerminateEvent' => 'console.terminate',
                'Symfony\\Component\\Form\\Event\\PreSubmitEvent' => 'form.pre_submit',
                'Symfony\\Component\\Form\\Event\\SubmitEvent' => 'form.submit',
                'Symfony\\Component\\Form\\Event\\PostSubmitEvent' => 'form.post_submit',
                'Symfony\\Component\\Form\\Event\\PreSetDataEvent' => 'form.pre_set_data',
                'Symfony\\Component\\Form\\Event\\PostSetDataEvent' => 'form.post_set_data',
                'Symfony\\Component\\HttpKernel\\Event\\ControllerArgumentsEvent' => 'kernel.controller_arguments',
                'Symfony\\Component\\HttpKernel\\Event\\ControllerEvent' => 'kernel.controller',
                'Symfony\\Component\\HttpKernel\\Event\\ResponseEvent' => 'kernel.response',
                'Symfony\\Component\\HttpKernel\\Event\\FinishRequestEvent' => 'kernel.finish_request',
                'Symfony\\Component\\HttpKernel\\Event\\RequestEvent' => 'kernel.request',
                'Symfony\\Component\\HttpKernel\\Event\\ViewEvent' => 'kernel.view',
                'Symfony\\Component\\HttpKernel\\Event\\ExceptionEvent' => 'kernel.exception',
                'Symfony\\Component\\HttpKernel\\Event\\TerminateEvent' => 'kernel.terminate',
                'Symfony\\Component\\Workflow\\Event\\GuardEvent' => 'workflow.guard',
                'Symfony\\Component\\Workflow\\Event\\LeaveEvent' => 'workflow.leave',
                'Symfony\\Component\\Workflow\\Event\\TransitionEvent' => 'workflow.transition',
                'Symfony\\Component\\Workflow\\Event\\EnterEvent' => 'workflow.enter',
                'Symfony\\Component\\Workflow\\Event\\EnteredEvent' => 'workflow.entered',
                'Symfony\\Component\\Workflow\\Event\\CompletedEvent' => 'workflow.completed',
                'Symfony\\Component\\Workflow\\Event\\AnnounceEvent' => 'workflow.announce',
                'Symfony\\Component\\Security\\Core\\Event\\AuthenticationSuccessEvent' => 'security.authentication.success',
                'Symfony\\Component\\Security\\Core\\Event\\AuthenticationFailureEvent' => 'security.authentication.failure',
                'Symfony\\Component\\Security\\Http\\Event\\InteractiveLoginEvent' => 'security.interactive_login',
                'Symfony\\Component\\Security\\Http\\Event\\SwitchUserEvent' => 'security.switch_user',
            ],
            'fragment.renderer.hinclude.global_template' => NULL,
            'fragment.path' => '/_fragment',
            'kernel.http_method_override' => true,
            'kernel.trusted_hosts' => [

            ],
            'kernel.error_controller' => 'error_controller',
            'templating.helper.code.file_link_format' => NULL,
            'debug.file_link_format' => NULL,
            'session.metadata.storage_key' => '_sf2_meta',
            'session.save_path' => (\dirname(__DIR__, 3).'/sessions/prod'),
            'session.metadata.update_threshold' => 0,
            'form.type_extension.csrf.enabled' => true,
            'form.type_extension.csrf.field_name' => '_token',
            'asset.request_context.base_path' => '',
            'asset.request_context.secure' => false,
            'templating.loader.cache.path' => NULL,
            'templating.engines' => [
                0 => 'twig',
            ],
            'validator.translation_domain' => 'validators',
            'translator.logging' => false,
            'translator.default_path' => (\dirname(__DIR__, 4).'/translations'),
            'data_collector.templates' => [

            ],
            'debug.error_handler.throw_at' => 0,
            'router.request_context.host' => 'localhost',
            'router.request_context.scheme' => 'http',
            'router.request_context.base_url' => '',
            'router.resource' => 'kernel::loadRoutes',
            'router.cache_class_prefix' => 'EccubeEccube_KernelProdContainer',
            'request_listener.http_port' => 80,
            'request_listener.https_port' => 443,
            'security.authentication.trust_resolver.anonymous_class' => NULL,
            'security.authentication.trust_resolver.rememberme_class' => NULL,
            'security.role_hierarchy.roles' => [

            ],
            'security.access.denied_url' => NULL,
            'security.authentication.manager.erase_credentials' => true,
            'security.authentication.session_strategy.strategy' => 'migrate',
            'security.access.always_authenticate_before_granting' => false,
            'security.authentication.hide_user_not_found' => true,
            'doctrine_cache.apc.class' => 'Doctrine\\Common\\Cache\\ApcCache',
            'doctrine_cache.apcu.class' => 'Doctrine\\Common\\Cache\\ApcuCache',
            'doctrine_cache.array.class' => 'Doctrine\\Common\\Cache\\ArrayCache',
            'doctrine_cache.chain.class' => 'Doctrine\\Common\\Cache\\ChainCache',
            'doctrine_cache.couchbase.class' => 'Doctrine\\Common\\Cache\\CouchbaseCache',
            'doctrine_cache.couchbase.connection.class' => 'Couchbase',
            'doctrine_cache.couchbase.hostnames' => 'localhost:8091',
            'doctrine_cache.file_system.class' => 'Doctrine\\Common\\Cache\\FilesystemCache',
            'doctrine_cache.php_file.class' => 'Doctrine\\Common\\Cache\\PhpFileCache',
            'doctrine_cache.memcache.class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
            'doctrine_cache.memcache.connection.class' => 'Memcache',
            'doctrine_cache.memcache.host' => 'localhost',
            'doctrine_cache.memcache.port' => 11211,
            'doctrine_cache.memcached.class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
            'doctrine_cache.memcached.connection.class' => 'Memcached',
            'doctrine_cache.memcached.host' => 'localhost',
            'doctrine_cache.memcached.port' => 11211,
            'doctrine_cache.mongodb.class' => 'Doctrine\\Common\\Cache\\MongoDBCache',
            'doctrine_cache.mongodb.collection.class' => 'MongoCollection',
            'doctrine_cache.mongodb.connection.class' => 'MongoClient',
            'doctrine_cache.mongodb.server' => 'localhost:27017',
            'doctrine_cache.predis.client.class' => 'Predis\\Client',
            'doctrine_cache.predis.scheme' => 'tcp',
            'doctrine_cache.predis.host' => 'localhost',
            'doctrine_cache.predis.port' => 6379,
            'doctrine_cache.redis.class' => 'Doctrine\\Common\\Cache\\RedisCache',
            'doctrine_cache.redis.connection.class' => 'Redis',
            'doctrine_cache.redis.host' => 'localhost',
            'doctrine_cache.redis.port' => 6379,
            'doctrine_cache.riak.class' => 'Doctrine\\Common\\Cache\\RiakCache',
            'doctrine_cache.riak.bucket.class' => 'Riak\\Bucket',
            'doctrine_cache.riak.connection.class' => 'Riak\\Connection',
            'doctrine_cache.riak.bucket_property_list.class' => 'Riak\\BucketPropertyList',
            'doctrine_cache.riak.host' => 'localhost',
            'doctrine_cache.riak.port' => 8087,
            'doctrine_cache.sqlite3.class' => 'Doctrine\\Common\\Cache\\SQLite3Cache',
            'doctrine_cache.sqlite3.connection.class' => 'SQLite3',
            'doctrine_cache.void.class' => 'Doctrine\\Common\\Cache\\VoidCache',
            'doctrine_cache.wincache.class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
            'doctrine_cache.xcache.class' => 'Doctrine\\Common\\Cache\\XcacheCache',
            'doctrine_cache.zenddata.class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
            'doctrine_cache.security.acl.cache.class' => 'Doctrine\\Bundle\\DoctrineCacheBundle\\Acl\\Model\\AclCache',
            'doctrine.dbal.logger.chain.class' => 'Doctrine\\DBAL\\Logging\\LoggerChain',
            'doctrine.dbal.logger.profiling.class' => 'Doctrine\\DBAL\\Logging\\DebugStack',
            'doctrine.dbal.logger.class' => 'Symfony\\Bridge\\Doctrine\\Logger\\DbalLogger',
            'doctrine.dbal.configuration.class' => 'Doctrine\\DBAL\\Configuration',
            'doctrine.data_collector.class' => 'Doctrine\\Bundle\\DoctrineBundle\\DataCollector\\DoctrineDataCollector',
            'doctrine.dbal.connection.event_manager.class' => 'Symfony\\Bridge\\Doctrine\\ContainerAwareEventManager',
            'doctrine.dbal.connection_factory.class' => 'Doctrine\\Bundle\\DoctrineBundle\\ConnectionFactory',
            'doctrine.dbal.events.mysql_session_init.class' => 'Doctrine\\DBAL\\Event\\Listeners\\MysqlSessionInit',
            'doctrine.dbal.events.oracle_session_init.class' => 'Doctrine\\DBAL\\Event\\Listeners\\OracleSessionInit',
            'doctrine.class' => 'Doctrine\\Bundle\\DoctrineBundle\\Registry',
            'doctrine.entity_managers' => [
                'default' => 'doctrine.orm.default_entity_manager',
            ],
            'doctrine.default_entity_manager' => 'default',
            'doctrine.dbal.connection_factory.types' => [
                'oauth2_grant' => [
                    'class' => 'Trikoder\\Bundle\\OAuth2Bundle\\DBAL\\Type\\Grant',
                    'commented' => NULL,
                ],
                'oauth2_redirect_uri' => [
                    'class' => 'Trikoder\\Bundle\\OAuth2Bundle\\DBAL\\Type\\RedirectUri',
                    'commented' => NULL,
                ],
                'oauth2_scope' => [
                    'class' => 'Trikoder\\Bundle\\OAuth2Bundle\\DBAL\\Type\\Scope',
                    'commented' => NULL,
                ],
                'datetime' => [
                    'class' => 'Eccube\\Doctrine\\DBAL\\Types\\UTCDateTimeType',
                    'commented' => NULL,
                ],
                'datetimetz' => [
                    'class' => 'Eccube\\Doctrine\\DBAL\\Types\\UTCDateTimeTzType',
                    'commented' => NULL,
                ],
            ],
            'doctrine.connections' => [
                'default' => 'doctrine.dbal.default_connection',
            ],
            'doctrine.default_connection' => 'default',
            'doctrine.orm.configuration.class' => 'Doctrine\\ORM\\Configuration',
            'doctrine.orm.entity_manager.class' => 'Doctrine\\ORM\\EntityManager',
            'doctrine.orm.manager_configurator.class' => 'Doctrine\\Bundle\\DoctrineBundle\\ManagerConfigurator',
            'doctrine.orm.cache.array.class' => 'Doctrine\\Common\\Cache\\ArrayCache',
            'doctrine.orm.cache.apc.class' => 'Doctrine\\Common\\Cache\\ApcCache',
            'doctrine.orm.cache.memcache.class' => 'Doctrine\\Common\\Cache\\MemcacheCache',
            'doctrine.orm.cache.memcache_host' => 'localhost',
            'doctrine.orm.cache.memcache_port' => 11211,
            'doctrine.orm.cache.memcache_instance.class' => 'Memcache',
            'doctrine.orm.cache.memcached.class' => 'Doctrine\\Common\\Cache\\MemcachedCache',
            'doctrine.orm.cache.memcached_host' => 'localhost',
            'doctrine.orm.cache.memcached_port' => 11211,
            'doctrine.orm.cache.memcached_instance.class' => 'Memcached',
            'doctrine.orm.cache.redis.class' => 'Doctrine\\Common\\Cache\\RedisCache',
            'doctrine.orm.cache.redis_host' => 'localhost',
            'doctrine.orm.cache.redis_port' => 6379,
            'doctrine.orm.cache.redis_instance.class' => 'Redis',
            'doctrine.orm.cache.xcache.class' => 'Doctrine\\Common\\Cache\\XcacheCache',
            'doctrine.orm.cache.wincache.class' => 'Doctrine\\Common\\Cache\\WinCacheCache',
            'doctrine.orm.cache.zenddata.class' => 'Doctrine\\Common\\Cache\\ZendDataCache',
            'doctrine.orm.metadata.driver_chain.class' => 'Doctrine\\Persistence\\Mapping\\Driver\\MappingDriverChain',
            'doctrine.orm.metadata.annotation.class' => 'Doctrine\\ORM\\Mapping\\Driver\\AnnotationDriver',
            'doctrine.orm.metadata.xml.class' => 'Doctrine\\ORM\\Mapping\\Driver\\SimplifiedXmlDriver',
            'doctrine.orm.metadata.yml.class' => 'Doctrine\\ORM\\Mapping\\Driver\\SimplifiedYamlDriver',
            'doctrine.orm.metadata.php.class' => 'Doctrine\\ORM\\Mapping\\Driver\\PHPDriver',
            'doctrine.orm.metadata.staticphp.class' => 'Doctrine\\ORM\\Mapping\\Driver\\StaticPHPDriver',
            'doctrine.orm.proxy_cache_warmer.class' => 'Symfony\\Bridge\\Doctrine\\CacheWarmer\\ProxyCacheWarmer',
            'form.type_guesser.doctrine.class' => 'Symfony\\Bridge\\Doctrine\\Form\\DoctrineOrmTypeGuesser',
            'doctrine.orm.validator.unique.class' => 'Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntityValidator',
            'doctrine.orm.validator_initializer.class' => 'Symfony\\Bridge\\Doctrine\\Validator\\DoctrineInitializer',
            'doctrine.orm.security.user.provider.class' => 'Symfony\\Bridge\\Doctrine\\Security\\User\\EntityUserProvider',
            'doctrine.orm.listeners.resolve_target_entity.class' => 'Doctrine\\ORM\\Tools\\ResolveTargetEntityListener',
            'doctrine.orm.listeners.attach_entity_listeners.class' => 'Doctrine\\ORM\\Tools\\AttachEntityListenersListener',
            'doctrine.orm.naming_strategy.default.class' => 'Doctrine\\ORM\\Mapping\\DefaultNamingStrategy',
            'doctrine.orm.naming_strategy.underscore.class' => 'Doctrine\\ORM\\Mapping\\UnderscoreNamingStrategy',
            'doctrine.orm.quote_strategy.default.class' => 'Doctrine\\ORM\\Mapping\\DefaultQuoteStrategy',
            'doctrine.orm.quote_strategy.ansi.class' => 'Doctrine\\ORM\\Mapping\\AnsiQuoteStrategy',
            'doctrine.orm.entity_listener_resolver.class' => 'Doctrine\\Bundle\\DoctrineBundle\\Mapping\\ContainerEntityListenerResolver',
            'doctrine.orm.second_level_cache.default_cache_factory.class' => 'Doctrine\\ORM\\Cache\\DefaultCacheFactory',
            'doctrine.orm.second_level_cache.default_region.class' => 'Doctrine\\ORM\\Cache\\Region\\DefaultRegion',
            'doctrine.orm.second_level_cache.filelock_region.class' => 'Doctrine\\ORM\\Cache\\Region\\FileLockRegion',
            'doctrine.orm.second_level_cache.logger_chain.class' => 'Doctrine\\ORM\\Cache\\Logging\\CacheLoggerChain',
            'doctrine.orm.second_level_cache.logger_statistics.class' => 'Doctrine\\ORM\\Cache\\Logging\\StatisticsCacheLogger',
            'doctrine.orm.second_level_cache.cache_configuration.class' => 'Doctrine\\ORM\\Cache\\CacheConfiguration',
            'doctrine.orm.second_level_cache.regions_configuration.class' => 'Doctrine\\ORM\\Cache\\RegionsConfiguration',
            'doctrine.orm.auto_generate_proxy_classes' => false,
            'doctrine.orm.proxy_namespace' => 'Proxies',
            'doctrine_migrations.dir_name' => (\dirname(__DIR__, 4).'/app/DoctrineMigrations'),
            'doctrine_migrations.namespace' => 'DoctrineMigrations',
            'doctrine_migrations.organize_migrations' => false,
            'doctrine_migrations.table_name' => 'migration_versions',
            'doctrine_migrations.name' => 'Application Migrations',
            'doctrine_migrations.custom_template' => NULL,
            'monolog.use_microseconds' => true,
            'monolog.swift_mailer.handlers' => [

            ],
            'monolog.handlers_to_channels' => [
                'monolog.handler.console' => [
                    'type' => 'exclusive',
                    'elements' => [
                        0 => 'event',
                        1 => 'doctrine',
                    ],
                ],
                'monolog.handler.admin' => [
                    'type' => 'inclusive',
                    'elements' => [
                        0 => 'admin',
                        1 => 'app',
                        2 => 'php',
                    ],
                ],
                'monolog.handler.front' => [
                    'type' => 'inclusive',
                    'elements' => [
                        0 => 'front',
                        1 => 'app',
                        2 => 'php',
                    ],
                ],
                'monolog.handler.main' => NULL,
            ],
            'swiftmailer.mailer.default.transport.name' => 'dynamic',
            'swiftmailer.mailer.default.spool.enabled' => true,
            'swiftmailer.mailer.default.plugin.impersonate' => NULL,
            'swiftmailer.mailer.default.single_address' => NULL,
            'swiftmailer.mailer.default.delivery.enabled' => true,
            'swiftmailer.spool.enabled' => true,
            'swiftmailer.delivery.enabled' => true,
            'swiftmailer.single_address' => NULL,
            'swiftmailer.mailers' => [
                'default' => 'swiftmailer.mailer.default',
            ],
            'swiftmailer.default_mailer' => 'default',
            'twig.exception_listener.controller' => NULL,
            'twig.form.resources' => [
                0 => 'form_div_layout.html.twig',
                1 => 'bootstrap_4_layout.html.twig',
            ],
            'twig.default_path' => (\dirname(__DIR__, 4).'/templates'),
            'mobile_detect.mobile_detector.class' => 'SunCat\\MobileDetectBundle\\DeviceDetector\\MobileDetector',
            'mobile_detect.device_view.class' => 'SunCat\\MobileDetectBundle\\Helper\\DeviceView',
            'mobile_detect.cookie_key' => 'device_view',
            'mobile_detect.switch_param' => 'device_view',
            'mobile_detect.cookie_expire_datetime_modifier' => '1 month',
            'mobile_detect.request_response_listener.class' => 'SunCat\\MobileDetectBundle\\EventListener\\RequestResponseListener',
            'mobile_detect.redirect' => [
                'mobile' => [
                    'is_enabled' => false,
                    'host' => NULL,
                    'status_code' => 302,
                    'action' => 'redirect',
                ],
                'tablet' => [
                    'is_enabled' => false,
                    'host' => NULL,
                    'status_code' => 302,
                    'action' => 'redirect',
                ],
                'full' => [
                    'is_enabled' => false,
                    'host' => NULL,
                    'status_code' => 302,
                    'action' => 'redirect',
                ],
                'detect_tablet_as_mobile' => false,
            ],
            'mobile_detect.switch_device_view.save_referer_path' => true,
            'mobile_detect.twig.extension.class' => 'SunCat\\MobileDetectBundle\\Twig\\Extension\\MobileDetectExtension',
            'mobile_detect.cookie_path' => '/',
            'mobile_detect.cookie_domain' => '',
            'mobile_detect.cookie_secure' => false,
            'mobile_detect.cookie_httponly' => true,
            'knp_paginator.class' => 'Knp\\Component\\Pager\\Paginator',
            'knp_paginator.helper.processor.class' => 'Knp\\Bundle\\PaginatorBundle\\Helper\\Processor',
            'knp_paginator.template.pagination' => '@KnpPaginator/Pagination/sliding.html.twig',
            'knp_paginator.template.filtration' => '@KnpPaginator/Pagination/filtration.html.twig',
            'knp_paginator.template.sortable' => '@KnpPaginator/Pagination/sortable_link.html.twig',
            'knp_paginator.page_range' => 5,
            'trikoder.oauth2.persistence.doctrine.enabled' => true,
            'trikoder.oauth2.persistence.doctrine.manager' => 'default',
            'console.command.ids' => [
                0 => 'console.command.public_alias.Eccube\\Command\\UpdateSchemaDoctrineCommand',
                1 => 'console.command.public_alias.doctrine_cache.contains_command',
                2 => 'console.command.public_alias.doctrine_cache.delete_command',
                3 => 'console.command.public_alias.doctrine_cache.flush_command',
                4 => 'console.command.public_alias.doctrine_cache.stats_command',
                5 => 'console.command.public_alias.doctrine_migrations.diff_command',
                6 => 'console.command.public_alias.doctrine_migrations.execute_command',
                7 => 'console.command.public_alias.doctrine_migrations.generate_command',
                8 => 'console.command.public_alias.doctrine_migrations.latest_command',
                9 => 'console.command.public_alias.doctrine_migrations.migrate_command',
                10 => 'console.command.public_alias.doctrine_migrations.status_command',
                11 => 'console.command.public_alias.doctrine_migrations.version_command',
            ],
        ];
    }

    protected function throw($message)
    {
        throw new RuntimeException($message);
    }
}
