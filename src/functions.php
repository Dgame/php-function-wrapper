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
 * @param string $filename
 *
 * @return FileWrapper
 */
function filename(string $filename): FileWrapper
{
    return new FileWrapper($filename);
}