<?php

namespace Dgame\Wrapper\Optional;

/**
 * Interface Optional
 * @package Dgame\Wrapper\Optional
 */
interface Optional
{
    /**
     * @param null $data
     *
     * @return bool
     */
    public function isSome(&$data = null): bool;

    /**
     * @return bool
     */
    public function isNone(): bool;
}