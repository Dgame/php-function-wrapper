<?php

namespace Dgame\Wrapper;

/**
 * Class ArrayIterator
 * @package Dgame\Wrapper
 */
final class ArrayIterator implements ArrayIteratorInterface
{
    /**
     * @var ArrayWrapper
     */
    private $wrapper;

    /**
     * ArrayIterator constructor.
     *
     * @param ArrayWrapper $wrapper
     */
    public function __construct(ArrayWrapper $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    /**
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function take(int $n): ArrayWrapper
    {
        return new ArrayWrapper(array_slice($this->wrapper->get(), 0, $n));
    }

    /**
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function skip(int $n): ArrayWrapper
    {
        return new ArrayWrapper(array_slice($this->wrapper->get(), $n));
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function takeWhile(callable $callback): ArrayWrapper
    {
        $n = 0;
        foreach ($this->wrapper->get() as $value) {
            if (!$callback($value)) {
                break;
            }
            $n++;
        }

        return $this->take($n);
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function skipWhile(callable $callback): ArrayWrapper
    {
        $n = 0;
        foreach ($this->wrapper->get() as $value) {
            if (!$callback($value)) {
                break;
            }
            $n++;
        }

        return $this->skip($n);
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function takeIf(callable $callback): ArrayWrapper
    {
        $output = [];
        foreach ($this->wrapper->get() as $key => $value) {
            if ($callback($value)) {
                $output[$key] = $value;
            }
        }

        return new ArrayWrapper($output);
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function skipIf(callable $callback): ArrayWrapper
    {
        $output = [];
        foreach ($this->wrapper->get() as $key => $value) {
            if (!$callback($value)) {
                $output[$key] = $value;
            }
        }

        return new ArrayWrapper($output);
    }

    /**
     * @param $left
     * @param $right
     *
     * @return ArrayWrapper
     */
    public function between($left, $right): ArrayWrapper
    {
        if ($this->wrapper->indexOf($left)->isSome($lhs)) {
            if ($this->wrapper->indexOf($right)->isSome($rhs)) {
                return $this->wrapper->slice($lhs + 1, $rhs);
            }

            return $this->skip($lhs + 1);
        }

        return new ArrayWrapper([]);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function before($value): ArrayWrapper
    {
        if ($this->wrapper->indexOf($value)->isSome($index)) {
            return $this->take($index);
        }

        return $this->wrapper;
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function after($value): ArrayWrapper
    {
        if ($this->wrapper->indexOf($value)->isSome($index)) {
            return $this->skip($index + 1);
        }

        return new ArrayWrapper([]);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function from($value): ArrayWrapper
    {
        if ($this->wrapper->indexOf($value)->isSome($index)) {
            return $this->skip($index);
        }

        return new ArrayWrapper([]);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function until($value): ArrayWrapper
    {
        if ($this->wrapper->indexOf($value)->isSome($index)) {
            return $this->take($index + 1);
        }

        return $this->wrapper;
    }

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function all(callable $callback): bool
    {
        foreach ($this->wrapper->get() as $value) {
            if (!$callback($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function any(callable $callback): bool
    {
        foreach ($this->wrapper->get() as $value) {
            if ($callback($value)) {
                return true;
            }
        }

        return false;
    }
}