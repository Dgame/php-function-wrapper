<?php

namespace Dgame\Wrapper;

use Dgame\Optional\Optional;
use function Dgame\Optional\maybe;

/**
 * Class NamespaceInfo
 * @package Dgame\Wrapper
 */
final class NamespaceInfo
{
    /**
     * @var Optional
     */
    private $namespace;
    /**
     * @var Optional
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

        $this->class     = $info->popBack();
        $this->namespace = maybe($info->implode('\\')->get(), function (string $namespace) {
            return !empty($namespace);
        });
    }

    /**
     * @return Optional
     */
    public function getNamespace(): Optional
    {
        return $this->namespace;
    }

    /**
     * @return Optional
     */
    public function getClass(): Optional
    {
        return $this->class;
    }
}