<?php

namespace Dgame\Wrapper;

/**
 * Class NamespaceInfo
 * @package Dgame\Wrapper
 */
final class NamespaceInfo
{
    /**
     * @var string|null
     */
    private $namespace;
    /**
     * @var string|null
     */
    private $class;

    /**
     * NamespaceInfo constructor.
     *
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        $info            = string($namespace)->explode('\\');
        $this->class     = $info->popBack()->unwrap();
        $ns              = $info->implode('\\');
        $this->namespace = $ns->isEmpty() ? null : $ns->get();
    }

    /**
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string|null
     */
    public function getClass()
    {
        return $this->class;
    }
}