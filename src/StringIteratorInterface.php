<?php

namespace Dgame\Wrapper;

/**
 * Class StringIterator
 * @package Dgame\Wrapper
 */
interface StringIteratorInterface
{
    /**
     * @param string $left
     * @param string $right
     *
     * @return StringWrapper
     */
    public function between(string $left, string $right): StringWrapper;

    /**
     * @param string $delimiter
     *
     * @return StringIterator
     */
    public function popFront(string $delimiter): StringIterator;

    /**
     * @param string $delimiter
     *
     * @return StringIterator
     */
    public function popBack(string $delimiter): StringIterator;

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function before(string $value): StringWrapper;

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function after(string $value): StringWrapper;

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function from(string $value): StringWrapper;

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function until(string $value): StringWrapper;
}