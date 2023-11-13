<?php

include_once \dirname(__DIR__, 4).'/vendor/psr/log/Psr/Log/AbstractLogger.php';
include_once \dirname(__DIR__, 4).'/src/Eccube/Log/Logger.php';
class Logger_fadf7f2 extends \Eccube\Log\Logger implements \ProxyManager\Proxy\VirtualProxyInterface
{
    private $valueHolderd802a = null;
    private $initializer232ec = null;
    private static $publicPropertiese25b0 = [
        
    ];
    public function log($level, $message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'log', array('level' => $level, 'message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->log($level, $message, $context);
    }
    public function emergency($message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'emergency', array('message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->emergency($message, $context);
    }
    public function alert($message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'alert', array('message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->alert($message, $context);
    }
    public function critical($message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'critical', array('message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->critical($message, $context);
    }
    public function error($message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'error', array('message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->error($message, $context);
    }
    public function warning($message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'warning', array('message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->warning($message, $context);
    }
    public function notice($message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'notice', array('message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->notice($message, $context);
    }
    public function info($message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'info', array('message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->info($message, $context);
    }
    public function debug($message, array $context = [])
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'debug', array('message' => $message, 'context' => $context), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->debug($message, $context);
    }
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;
        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();
        unset($instance->context, $instance->logger, $instance->frontLogger, $instance->adminLogger);
        $instance->initializer232ec = $initializer;
        return $instance;
    }
    public function __construct(\Eccube\Request\Context $context, \Psr\Log\LoggerInterface $logger, \Psr\Log\LoggerInterface $frontLogger, \Psr\Log\LoggerInterface $adminLogger)
    {
        static $reflection;
        if (! $this->valueHolderd802a) {
            $reflection = $reflection ?? new \ReflectionClass('Eccube\\Log\\Logger');
            $this->valueHolderd802a = $reflection->newInstanceWithoutConstructor();
        unset($this->context, $this->logger, $this->frontLogger, $this->adminLogger);
        }
        $this->valueHolderd802a->__construct($context, $logger, $frontLogger, $adminLogger);
    }
    public function & __get($name)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__get', ['name' => $name], $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        if (isset(self::$publicPropertiese25b0[$name])) {
            return $this->valueHolderd802a->$name;
        }
        $realInstanceReflection = new \ReflectionClass('Eccube\\Log\\Logger');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Log\\Logger');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Log\\Logger');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Log\\Logger');
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
        unset($this->context, $this->logger, $this->frontLogger, $this->adminLogger);
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
