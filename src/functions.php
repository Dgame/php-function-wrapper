<?php

namespace Dgame\Wrapper;

use Dgame\Wrapper\Optional\None;
use Dgame\Wrapper\Optional\Some;

/**
 * @param string $str
 *
 * @return StringWrapper
 */
function string(string $str): StringWrapper
{
    return new StringWrapper($str);
}

/**
 * @param string $str
 *
 * @return ArrayWrapper
 */
function chars(string $str): ArrayWrapper
{
    return string($str)->chars();
}

/**
 * @param array $data
 *
 * @return ArrayWrapper
 */
function assoc(array $data): ArrayWrapper
{
    return new ArrayWrapper($data);
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