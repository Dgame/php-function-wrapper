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
