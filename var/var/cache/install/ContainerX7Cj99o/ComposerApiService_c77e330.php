<?php

include_once \dirname(__DIR__, 4).'/src/Eccube/Service/Composer/ComposerServiceInterface.php';
include_once \dirname(__DIR__, 4).'/src/Eccube/Service/Composer/ComposerApiService.php';
class ComposerApiService_c77e330 extends \Eccube\Service\Composer\ComposerApiService implements \ProxyManager\Proxy\VirtualProxyInterface
{
    private $valueHolderd802a = null;
    private $initializer232ec = null;
    private static $publicPropertiese25b0 = [
        
    ];
    public function execInfo($pluginName, $version)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'execInfo', array('pluginName' => $pluginName, 'version' => $version), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->execInfo($pluginName, $version);
    }
    public function execRequire($packageName, $output = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'execRequire', array('packageName' => $packageName, 'output' => $output), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->execRequire($packageName, $output);
    }
    public function execRemove($packageName, $output = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'execRemove', array('packageName' => $packageName, 'output' => $output), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->execRemove($packageName, $output);
    }
    public function execUpdate($dryRun, $output = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'execUpdate', array('dryRun' => $dryRun, 'output' => $output), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->execUpdate($dryRun, $output);
    }
    public function execInstall($dryRun, $output = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'execInstall', array('dryRun' => $dryRun, 'output' => $output), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->execInstall($dryRun, $output);
    }
    public function foreachRequires($packageName, $version, $callback, $typeFilter = null, $level = 0)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'foreachRequires', array('packageName' => $packageName, 'version' => $version, 'callback' => $callback, 'typeFilter' => $typeFilter, 'level' => $level), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->foreachRequires($packageName, $version, $callback, $typeFilter, $level);
    }
    public function execConfig($key, $value = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'execConfig', array('key' => $key, 'value' => $value), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->execConfig($key, $value);
    }
    public function getConfig()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'getConfig', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->getConfig();
    }
    public function setWorkingDir($workingDir)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'setWorkingDir', array('workingDir' => $workingDir), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->setWorkingDir($workingDir);
    }
    public function runCommand($commands, $output = null, $init = true)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'runCommand', array('commands' => $commands, 'output' => $output, 'init' => $init), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->runCommand($commands, $output, $init);
    }
    public function configureRepository(\Eccube\Entity\BaseInfo $BaseInfo)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'configureRepository', array('BaseInfo' => $BaseInfo), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->configureRepository($BaseInfo);
    }
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;
        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();
        unset($instance->eccubeConfig);
        \Closure::bind(function (\Eccube\Service\Composer\ComposerApiService $instance) {
            unset($instance->consoleApplication, $instance->workingDir, $instance->baseInfoRepository, $instance->schemaService, $instance->pluginContext);
        }, $instance, 'Eccube\\Service\\Composer\\ComposerApiService')->__invoke($instance);
        $instance->initializer232ec = $initializer;
        return $instance;
    }
    public function __construct(\Eccube\Common\EccubeConfig $eccubeConfig, \Eccube\Repository\BaseInfoRepository $baseInfoRepository, \Eccube\Service\SchemaService $schemaService, \Eccube\Service\PluginContext $pluginContext)
    {
        static $reflection;
        if (! $this->valueHolderd802a) {
            $reflection = $reflection ?? new \ReflectionClass('Eccube\\Service\\Composer\\ComposerApiService');
            $this->valueHolderd802a = $reflection->newInstanceWithoutConstructor();
        unset($this->eccubeConfig);
        \Closure::bind(function (\Eccube\Service\Composer\ComposerApiService $instance) {
            unset($instance->consoleApplication, $instance->workingDir, $instance->baseInfoRepository, $instance->schemaService, $instance->pluginContext);
        }, $this, 'Eccube\\Service\\Composer\\ComposerApiService')->__invoke($this);
        }
        $this->valueHolderd802a->__construct($eccubeConfig, $baseInfoRepository, $schemaService, $pluginContext);
    }
    public function & __get($name)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__get', ['name' => $name], $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        if (isset(self::$publicPropertiese25b0[$name])) {
            return $this->valueHolderd802a->$name;
        }
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\Composer\\ComposerApiService');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\Composer\\ComposerApiService');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\Composer\\ComposerApiService');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\Composer\\ComposerApiService');
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
        unset($this->eccubeConfig);
        \Closure::bind(function (\Eccube\Service\Composer\ComposerApiService $instance) {
            unset($instance->consoleApplication, $instance->workingDir, $instance->baseInfoRepository, $instance->schemaService, $instance->pluginContext);
        }, $this, 'Eccube\\Service\\Composer\\ComposerApiService')->__invoke($this);
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
