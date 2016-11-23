<?php

namespace Dgame\Wrapper;

/**
 * Class NamespaceInfo
 * @package Dgame\Wrapper
 */
final class NamespaceInfo
{
    /**
     * @var string
     */
    private $namespace;
    /**
     * @var string
     */
    private $class;

    /**
     * NamespaceInfo constructor.
     *
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        $info = string($namespace)->explode('\\');

        $this->class     = $info->popBack()->default('');
        $this->namespace = $info->implode('\\')->get();
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}