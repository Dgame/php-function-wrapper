<?php

namespace Dgame\Wrapper;

/**
 * Class ArrayIterator
 * @package Dgame\Wrapper
 */
interface ArrayIteratorInterface
{
    /**
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function take(int $n): ArrayWrapper;

    /**
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function skip(int $n): ArrayWrapper;

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function takeWhile(callable $callback): ArrayWrapper;

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function skipWhile(callable $callback): ArrayWrapper;

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function takeIf(callable $callback): ArrayWrapper;

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function skipIf(callable $callback): ArrayWrapper;

    /**
     * @param $left
     * @param $right
     *
     * @return ArrayWrapper
     */
    public function between($left, $right): ArrayWrapper;

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function before($value): ArrayWrapper;

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function after($value): ArrayWrapper;

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function from($value): ArrayWrapper;

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function until($value): ArrayWrapper;

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function all(callable $callback): bool;

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function any(callable $callback): bool;
}