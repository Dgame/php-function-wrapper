<?php

namespace Dgame\Wrapper;

/**
 * Class StringIterator
 * @package Dgame\Wrapper
 */
final class StringIterator implements StringIteratorInterface
{
    /**
     * @var StringWrapper
     */
    private $wrapper;

    /**
     * StringIterator constructor.
     *
     * @param StringWrapper $wrapper
     */
    public function __construct(StringWrapper $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->wrapper->get();
    }

    /**
     * @return StringWrapper
     */
    public function getWrapper(): StringWrapper
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
        if ($this->wrapper->indexOf($left)->isSome($i1) && $this->wrapper->indexOf($right)->isSome($i2)) {
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

        return new self($result->implode($delimiter));
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

        return new self($result->implode($delimiter));
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function before(string $value): StringWrapper
    {
        if ($this->wrapper->indexOf($value)->isSome($index)) {
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
        if ($this->wrapper->indexOf($value)->isSome($index)) {
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
        if ($this->wrapper->indexOf($value)->isSome($index)) {
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
        if ($this->wrapper->indexOf($value)->isSome($index)) {
            return $this->wrapper->substring(0, $index);
        }

        return $this->wrapper;
    }
}