<?php

namespace Dgame\Wrapper;

use ReflectionClass;

/**
 * Class ObjectWrapper
 * @package Dgame\Wrapper
 */
final class ObjectWrapper
{
    /**
     * @var object
     */
    private $object;
    /**
     * @var string
     */
    private $class;
    /**
     * @var ReflectionClass
     */
    private $reflection;

    /**
     * ObjectWrapper constructor.
     *
     * @param $object
     *
     * @throws \Exception
     */
    public function __construct($object)
    {
        if (is_object($object)) {
            $this->class  = get_class($object);
            $this->object = $object;
        } else if (is_string($object) && class_exists($object)) {
            $this->class  = $object;
            $this->object = $this->getObject();
        } else {
            throw new \Exception('$object must be either a valid object or an existing class name');
        }
    }

    /**
     * @return object
     * @throws \Exception
     */
    public function getObject()
    {
        if ($this->object === null) {
            if ($this->getReflection()->isInstantiable()) {
                $this->object = $this->getReflection()->newInstance();
            } else {
                throw new \Exception('object is not instantiable');
            }
        }

        return $this->object;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return ReflectionClass
     */
    public function getReflection(): ReflectionClass
    {
        if ($this->reflection === null) {
            $this->reflection = new ReflectionClass($this->object ?? $this->class);
        }

        return $this->reflection;
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    public function hasMethod(string $method): bool
    {
        return method_exists($this->object, $method);
    }

    /**
     * @param string $method
     * @param array  ...$args
     *
     * @return mixed
     */
    public function call(string $method, ...$args)
    {
        return call_user_func_array([$this->object, $method], $args);
    }

    /**
     * @param string $property
     *
     * @return bool
     */
    public function hasProperty(string $property): bool
    {
        return property_exists($this->class, $property);
    }
}