<?php

include_once \dirname(__DIR__, 4).'/src/Eccube/Service/TaxRuleService.php';
class TaxRuleService_289f969 extends \Eccube\Service\TaxRuleService implements \ProxyManager\Proxy\VirtualProxyInterface
{
    private $valueHolderd802a = null;
    private $initializer232ec = null;
    private static $publicPropertiese25b0 = [
        
    ];
    public function getTax($price, $product = null, $productClass = null, $pref = null, $country = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'getTax', array('price' => $price, 'product' => $product, 'productClass' => $productClass, 'pref' => $pref, 'country' => $country), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->getTax($price, $product, $productClass, $pref, $country);
    }
    public function getPriceIncTax($price, $product = null, $productClass = null, $pref = null, $country = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'getPriceIncTax', array('price' => $price, 'product' => $product, 'productClass' => $productClass, 'pref' => $pref, 'country' => $country), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->getPriceIncTax($price, $product, $productClass, $pref, $country);
    }
    public function calcTax($price, $taxRate, $RoundingType, $taxAdjust = 0)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'calcTax', array('price' => $price, 'taxRate' => $taxRate, 'RoundingType' => $RoundingType, 'taxAdjust' => $taxAdjust), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->calcTax($price, $taxRate, $RoundingType, $taxAdjust);
    }
    public function calcTaxIncluded($price, $taxRate, $RoundingType, $taxAdjust = 0)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'calcTaxIncluded', array('price' => $price, 'taxRate' => $taxRate, 'RoundingType' => $RoundingType, 'taxAdjust' => $taxAdjust), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->calcTaxIncluded($price, $taxRate, $RoundingType, $taxAdjust);
    }
    public function roundByRoundingType($value, $RoundingType)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'roundByRoundingType', array('value' => $value, 'RoundingType' => $RoundingType), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->roundByRoundingType($value, $RoundingType);
    }
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;
        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();
        unset($instance->BaseInfo, $instance->taxRuleRepository);
        $instance->initializer232ec = $initializer;
        return $instance;
    }
    public function __construct(\Eccube\Repository\TaxRuleRepository $taxRuleRepository, \Eccube\Repository\BaseInfoRepository $baseInfoRepository)
    {
        static $reflection;
        if (! $this->valueHolderd802a) {
            $reflection = $reflection ?? new \ReflectionClass('Eccube\\Service\\TaxRuleService');
            $this->valueHolderd802a = $reflection->newInstanceWithoutConstructor();
        unset($this->BaseInfo, $this->taxRuleRepository);
        }
        $this->valueHolderd802a->__construct($taxRuleRepository, $baseInfoRepository);
    }
    public function & __get($name)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__get', ['name' => $name], $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        if (isset(self::$publicPropertiese25b0[$name])) {
            return $this->valueHolderd802a->$name;
        }
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\TaxRuleService');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\TaxRuleService');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\TaxRuleService');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Service\\TaxRuleService');
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
        unset($this->BaseInfo, $this->taxRuleRepository);
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
