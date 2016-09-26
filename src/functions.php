<?php

namespace Dgame\Wrapper;

/**
 * @param string $subject
 *
 * @return StringWrapper
 */
function string(string $subject): StringWrapper
{
    return new StringWrapper($subject);
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