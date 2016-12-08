<?php

namespace Dgame\Wrapper;

/**
 * @param string|null $input
 *
 * @return StringWrapper
 */
function string(string $input = null): StringWrapper
{
    return new StringWrapper($input);
}

/**
 * @param string $input
 *
 * @return ArrayWrapper
 */
function chars(string $input): ArrayWrapper
{
    return string($input)->chars();
}

/**
 * @param array $input
 *
 * @return ArrayWrapper
 */
function assoc(array $input): ArrayWrapper
{
    return new ArrayWrapper($input);
}

/**
 * @param object|string $object
 *
 * @return ObjectWrapper
 */
function object($object): ObjectWrapper
{
    return new ObjectWrapper($object);
}

/**
 * @param string $path
 *
 * @return PathInfo
 */
function pathOf(string $path): PathInfo
{
    return new PathInfo($path);
}

/**
 * @param string $namespace
 *
 * @return NamespaceInfo
 */
function namespaceOf(string $namespace): NamespaceInfo
{
    return new NamespaceInfo($namespace);
}