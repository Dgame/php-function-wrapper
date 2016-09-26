<?php

namespace Dgame\Wrapper\Optional;

/**
 * Class None
 * @package Dgame\Wrapper\Optional
 */
final class None implements Optional
{
    /**
     * @var None
     */
    private static $instance;

    /**
     * None constructor.
     */
    private function __construct()
    {
    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     * @return None
     */
    public static function Instance(): None
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param null $data
     *
     * @return bool
     */
    public function isSome(&$data = null): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isNone(): bool
    {
        return true;
    }
}