<?php

include_once \dirname(__DIR__, 4).'/src/Eccube/Service/PluginService.php';
class PluginService_e75fd88 extends \Eccube\Service\PluginService implements \ProxyManager\Proxy\VirtualProxyInterface
{
    private $valueHolderd802a = null;
    private $initializer232ec = null;
    private static $publicPropertiese25b0 = [
        
    ];
    public function install($path, $source = 0)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'install', array('path' => $path, 'source' => $source), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->install($path, $source);
    }
    public function installWithCode($code)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'installWithCode', array('code' => $code), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->installWithCode($code);
    }
    public function preInstall()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'preInstall', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->preInstall();
    }
    public function postInstall($config, $source)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'postInstall', array('config' => $config, 'source' => $source), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->postInstall($config, $source);
    }
    public function generateProxyAndUpdateSchema(\Eccube\Entity\Plugin $plugin, $config, $uninstall = false, $saveMode = true)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'generateProxyAndUpdateSchema', array('plugin' => $plugin, 'config' => $config, 'uninstall' => $uninstall, 'saveMode' => $saveMode), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->generateProxyAndUpdateSchema($plugin, $config, $uninstall, $saveMode);
    }
    public function generateProxyAndCallback(callable $callback, \Eccube\Entity\Plugin $plugin, $config, $uninstall = false, $tmpProxyOutputDir = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'generateProxyAndCallback', array('callback' => $callback, 'plugin' => $plugin, 'config' => $config, 'uninstall' => $uninstall, 'tmpProxyOutputDir' => $tmpProxyOutputDir), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->generateProxyAndCallback($callback, $plugin, $config, $uninstall, $tmpProxyOutputDir);
    }
    public function createTempDir()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'createTempDir', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->createTempDir();
    }
    public function deleteDirs($arr)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'deleteDirs', array('arr' => $arr), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->deleteDirs($arr);
    }
    public function unpackPluginArchive($archive, $dir)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'unpackPluginArchive', array('archive' => $archive, 'dir' => $dir), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->unpackPluginArchive($archive, $dir);
    }
    public function checkPluginArchiveContent($dir, array $config_cache = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'checkPluginArchiveContent', array('dir' => $dir, 'config_cache' => $config_cache), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->checkPluginArchiveContent($dir, $config_cache);
    }
    public function readConfig($pluginDir)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'readConfig', array('pluginDir' => $pluginDir), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->readConfig($pluginDir);
    }
    public function checkSymbolName($string)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'checkSymbolName', array('string' => $string), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->checkSymbolName($string);
    }
    public function deleteFile($path)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'deleteFile', array('path' => $path), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->deleteFile($path);
    }
    public function checkSamePlugin($code)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'checkSamePlugin', array('code' => $code), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->checkSamePlugin($code);
    }
    public function calcPluginDir($code)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'calcPluginDir', array('code' => $code), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->calcPluginDir($code);
    }
    public function createPluginDir($d)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'createPluginDir', array('d' => $d), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->createPluginDir($d);
    }
    public function registerPlugin($meta, $source = 0)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'registerPlugin', array('meta' => $meta, 'source' => $source), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->registerPlugin($meta, $source);
    }
    public function callPluginManagerMethod($meta, $method)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'callPluginManagerMethod', array('meta' => $meta, 'method' => $method), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->callPluginManagerMethod($meta, $method);
    }
    public function uninstall(\Eccube\Entity\Plugin $plugin, $force = true)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'uninstall', array('plugin' => $plugin, 'force' => $force), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->uninstall($plugin, $force);
    }
    public function unregisterPlugin(\Eccube\Entity\Plugin $p)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'unregisterPlugin', array('p' => $p), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->unregisterPlugin($p);
    }
    public function disable(\Eccube\Entity\Plugin $plugin)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'disable', array('plugin' => $plugin), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->disable($plugin);
    }
    public function enable(\Eccube\Entity\Plugin $plugin, $enable = true)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'enable', array('plugin' => $plugin, 'enable' => $enable), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->enable($plugin, $enable);
    }
    public function update(\Eccube\Entity\Plugin $plugin, $path)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'update', array('plugin' => $plugin, 'path' => $path), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->update($plugin, $path);
    }
    public function updatePlugin(\Eccube\Entity\Plugin $plugin, $meta)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'updatePlugin', array('plugin' => $plugin, 'meta' => $meta), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->updatePlugin($plugin, $meta);
    }
    public function getPluginRequired($plugin)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'getPluginRequired', array('plugin' => $plugin), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->getPluginRequired($plugin);
    }
    public function findDependentPluginNeedDisable($pluginCode)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'findDependentPluginNeedDisable', array('pluginCode' => $pluginCode), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->findDependentPluginNeedDisable($pluginCode);
    }
    public function findDependentPlugin($pluginCode, $enableOnly = false)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'findDependentPlugin', array('pluginCode' => $pluginCode, 'enableOnly' => $enableOnly), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->findDependentPlugin($pluginCode, $enableOnly);
    }
    public function getDependentByCode($pluginCode, $libraryType = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'getDependentByCode', array('pluginCode' => $pluginCode, 'libraryType' => $libraryType), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->getDependentByCode($pluginCode, $libraryType);
    }
    public function parseToComposerCommand(array $packages, $getVersion = true)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'parseToComposerCommand', array('packages' => $packages, 'getVersion' => $getVersion), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->parseToComposerCommand($packages, $getVersion);
    }
    public function copyAssets($pluginCode)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'copyAssets', array('pluginCode' => $pluginCode), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->copyAssets($pluginCode);
    }
    public function removeAssets($pluginCode)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'removeAssets', array('pluginCode' => $pluginCode), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->removeAssets($pluginCode);
    }
    public function checkPluginExist($plugins, $pluginCode)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'checkPluginExist', array('plugins' => $plugins, 'pluginCode' => $pluginCode), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->checkPluginExist($plugins, $pluginCode);
    }
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;
        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();
        unset($instance->eccubeConfig, $instance->entityManager, $instance->pluginRepository, $instance->entityProxyService, $instance->schemaService, $instance->composerService, $instance->container, $instance->cacheUtil);
        \Closure::bind(function (\Eccube\Service\PluginService $instance) {
            unset($instance->projectRoot, $instance->environment, $instance->pluginApiService, $instance->systemService, $instance->pluginContext);
        }, $instance, 'Eccube\\Service\\PluginService')->__invoke($instance);
        $instance->initializer232ec = $initializer;
        return $instance;
    }
    public function __construct(\Doctrine\ORM\EntityManagerInterface $entityManager, \Eccube\Repository\PluginRepository $pluginRepository, \Eccube\Service\EntityProxyService $entityProxyService, \Eccube\Service\SchemaService $schemaService, \Eccube\Common\EccubeConfig $eccubeConfig, \Symfony\Component\DependencyInjection\ContainerInterface $container, \Eccube\Util\CacheUtil $cacheUtil, \Eccube\Service\Composer\ComposerServiceInterface $composerService, \Eccube\Service\PluginApiService $pluginApiService, \Eccube\Service\SystemService $systemService, \Eccube\Service\PluginContext $pluginContext)
    {
        static $reflection;
        if (! $this->valueHolderd802a) {
            $reflection = $reflection ?? new \ReflectionClass('Eccube\\Service\\PluginService');
            $this->valueHolderd802a = $reflection->newInstanceWithoutConstructor();
        unset($this->eccubeConfig, $this->entityManager, $this->pluginRepository, $this->entityProxyService, $this->schemaService, $this->composerService, $this->container, $this->cacheUtil);
        \Closure::bind(function (\Eccube\Service\PluginService $instance) {
            unset($instance->projectRoot, $instance->environment, $instance->pluginApiService, $instance->systemService, $instance->pluginContext);
        }, $this, 'Eccube\\Service\\PluginService')->__invoke($this);
        }
        $this->valueHolderd802a->__construct($entityManager, $pluginRepository, $entityProxyService, $schemaService, $eccubeConfig, $container, $cacheUtil, $composerService, $pluginApiService, $systemService, $pluginContext);
    }
    public function & __get($name)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__get', ['name' => $name], $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        if (isset(self::$publicPropertiese25b0[$name])) {
            return $this->valueHolderd802a->$name;
        }
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\PluginService');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderd802a;
            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }
        $targetObject = $this->valueHolderd802a;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();
        return $returnValue;
    }
    public function __set($name, $value)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\PluginService');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderd802a;
            $targetObject->$name = $value;
            return $targetObject->$name;
        }
        $targetObject = $this->valueHolderd802a;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();
        return $returnValue;
    }
    public function __isset($name)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__isset', array('name' => $name), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\PluginService');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderd802a;
            return isset($targetObject->$name);
        }
        $targetObject = $this->valueHolderd802a;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();
        return $returnValue;
    }
    public function __unset($name)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__unset', array('name' => $name), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\PluginService');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderd802a;
            unset($targetObject->$name);
            return;
        }
        $targetObject = $this->valueHolderd802a;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);
            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }
    public function __clone()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__clone', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        $this->valueHolderd802a = clone $this->valueHolderd802a;
    }
    public function __sleep()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__sleep', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return array('valueHolderd802a');
    }
    public function __wakeup()
    {
        unset($this->eccubeConfig, $this->entityManager, $this->pluginRepository, $this->entityProxyService, $this->schemaService, $this->composerService, $this->container, $this->cacheUtil);
        \Closure::bind(function (\Eccube\Service\PluginService $instance) {
            unset($instance->projectRoot, $instance->environment, $instance->pluginApiService, $instance->systemService, $instance->pluginContext);
        }, $this, 'Eccube\\Service\\PluginService')->__invoke($this);
    }
    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer232ec = $initializer;
    }
    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer232ec;
    }
    public function initializeProxy() : bool
    {
        return $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'initializeProxy', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
    }
    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderd802a;
    }
    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderd802a;
    }
}
