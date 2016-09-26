<?php

namespace Dgame\Wrapper\Optional;

/**
 * Class Some
 * @package Dgame\Wrapper\Optional
 */
final class Some implements Optional
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * Some constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->data;
    }

    /**
     * @param null $data
     *
     * @return bool
     */
    public function isSome(&$data = null): bool
    {
        $data = $this->data;

        return true;
    }

    /**
     * @return bool
     */
    public function isNone(): bool
    {
        return false;
    }
}