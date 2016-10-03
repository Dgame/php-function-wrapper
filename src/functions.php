<?php

namespace Dgame\Wrapper;

use Dgame\Wrapper\Optional\None;
use Dgame\Wrapper\Optional\Some;

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
 * @param $data
 *
 * @return Some
 */
function some($data): Some
{
    return new Some($data);
}

/**
 * @return None
 */
function none(): None
{
    return None::Instance();
}
