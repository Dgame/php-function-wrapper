<?php

namespace Dgame\Wrapper;

/**
 * Class StringIterator
 * @package Dgame\Wrapper
 */
final class StringIterator
{
    /**
     * @var StringWrapper
     */
    private $wrapper;

    /**
     * StringIterator constructor.
     *
     * @param string $input
     */
    public function __construct(string $input)
    {
        $this->wrapper = new StringWrapper($input);
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->wrapper->get();
    }

    /**
     * @return StringWrapper
     */
    public function asWrapper(): StringWrapper
    {
        return $this->wrapper;
    }

    /**
     * @param string $left
     * @param string $right
     *
     * @return StringWrapper
     */
    public function between(string $left, string $right): StringWrapper
    {
        if ($this->wrapper->firstIndexOf($left)->isSome($i1) && $this->wrapper->firstIndexOf($right)->isSome($i2)) {
            $start = $i1 + strlen($left);

            return $this->wrapper->substring($start, $i2 - $start)->trim();
        }

        return new StringWrapper();
    }

    /**
     * @param string $delimiter
     *
     * @return StringIterator
     */
    public function popFront(string $delimiter): self
    {
        $result = $this->wrapper->explode($delimiter);
        $result->popFront();

        return new self($result->implode($delimiter)->get());
    }

    /**
     * @param string $delimiter
     *
     * @return StringIterator
     */
    public function popBack(string $delimiter): self
    {
        $result = $this->wrapper->explode($delimiter);
        $result->popBack();

        return new self($result->implode($delimiter)->get());
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function before(string $value): StringWrapper
    {
        if ($this->wrapper->firstIndexOf($value)->isSome($index)) {
            return $this->wrapper->substring(0, $index);
        }

        return $this->wrapper;
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function after(string $value): StringWrapper
    {
        if ($this->wrapper->firstIndexOf($value)->isSome($index)) {
            return $this->wrapper->substring($index + strlen($value));
        }

        return new StringWrapper();
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function from(string $value): StringWrapper
    {
        if ($this->wrapper->firstIndexOf($value)->isSome($index)) {
            return $this->wrapper->substring($index);
        }

        return new StringWrapper();
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function until(string $value): StringWrapper
    {
        if ($this->wrapper->firstIndexOf($value)->isSome($index)) {
            return $this->wrapper->substring(0, $index);
        }

        return $this->wrapper;
    }
}