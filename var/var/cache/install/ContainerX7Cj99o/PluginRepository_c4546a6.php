<?php

include_once \dirname(__DIR__, 4).'/src/Eccube/Repository/PluginRepository.php';
class PluginRepository_c4546a6 extends \Eccube\Repository\PluginRepository implements \ProxyManager\Proxy\VirtualProxyInterface
{
    private $valueHolderd802a = null;
    private $initializer232ec = null;
    private static $publicPropertiese25b0 = [
        
    ];
    public function findAllEnabled()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'findAllEnabled', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->findAllEnabled();
    }
    public function findByCode($code)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'findByCode', array('code' => $code), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->findByCode($code);
    }
    public function delete($entity)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'delete', array('entity' => $entity), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->delete($entity);
    }
    public function save($entity)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'save', array('entity' => $entity), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->save($entity);
    }
    public function createQueryBuilder($alias, $indexBy = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'createQueryBuilder', array('alias' => $alias, 'indexBy' => $indexBy), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->createQueryBuilder($alias, $indexBy);
    }
    public function createResultSetMappingBuilder($alias)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'createResultSetMappingBuilder', array('alias' => $alias), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->createResultSetMappingBuilder($alias);
    }
    public function createNamedQuery($queryName)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'createNamedQuery', array('queryName' => $queryName), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->createNamedQuery($queryName);
    }
    public function createNativeNamedQuery($queryName)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'createNativeNamedQuery', array('queryName' => $queryName), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->createNativeNamedQuery($queryName);
    }
    public function clear()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'clear', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->clear();
    }
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'find', array('id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->find($id, $lockMode, $lockVersion);
    }
    public function findAll()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'findAll', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->findAll();
    }
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'findBy', array('criteria' => $criteria, 'orderBy' => $orderBy, 'limit' => $limit, 'offset' => $offset), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->findBy($criteria, $orderBy, $limit, $offset);
    }
    public function findOneBy(array $criteria, ?array $orderBy = null)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'findOneBy', array('criteria' => $criteria, 'orderBy' => $orderBy), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->findOneBy($criteria, $orderBy);
    }
    public function count(array $criteria)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'count', array('criteria' => $criteria), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->count($criteria);
    }
    public function __call($method, $arguments)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__call', array('method' => $method, 'arguments' => $arguments), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->__call($method, $arguments);
    }
    public function getClassName()
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'getClassName', array(), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->getClassName();
    }
    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, 'matching', array('criteria' => $criteria), $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        return $this->valueHolderd802a->matching($criteria);
    }
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;
        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();
        unset($instance->eccubeConfig, $instance->_entityName, $instance->_em, $instance->_class);
        $instance->initializer232ec = $initializer;
        return $instance;
    }
    public function __construct(\Symfony\Bridge\Doctrine\RegistryInterface $registry)
    {
        static $reflection;
        if (! $this->valueHolderd802a) {
            $reflection = $reflection ?? new \ReflectionClass('Eccube\\Repository\\PluginRepository');
            $this->valueHolderd802a = $reflection->newInstanceWithoutConstructor();
        unset($this->eccubeConfig, $this->_entityName, $this->_em, $this->_class);
        }
        $this->valueHolderd802a->__construct($registry);
    }
    public function & __get($name)
    {
        $this->initializer232ec && ($this->initializer232ec->__invoke($valueHolderd802a, $this, '__get', ['name' => $name], $this->initializer232ec) || 1) && $this->valueHolderd802a = $valueHolderd802a;
        if (isset(self::$publicPropertiese25b0[$name])) {
            return $this->valueHolderd802a->$name;
        }
        $realInstanceReflection = new \ReflectionClass('Eccube\\Repository\\PluginRepository');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Repository\\PluginRepository');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Repository\\PluginRepository');
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
        $realInstanceReflection = new \ReflectionClass('Eccube\\Repository\\PluginRepository');
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
        unset($this->eccubeConfig, $this->_entityName, $this->_em, $this->_class);
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
