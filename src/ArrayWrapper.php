<?php

namespace Dgame\Wrapper;

use Dgame\Optional\OptionalInterface;
use function Dgame\Optional\maybe;
use function Dgame\Optional\none;
use function Dgame\Optional\some;

/**
 * Class ArrayWrapper
 * @package Dgame\Wrapper
 */
final class ArrayWrapper implements ArrayIteratorInterface
{
    /**
     * @var array
     */
    private $input = [];

    /**
     * ArrayWrapper constructor.
     *
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->input;
    }

    /**
     * @return array
     */
    public function slurp(): array
    {
        try {
            return $this->input;
        } finally {
            $this->input = [];
        }
    }

    /**
     * @param string|null $glue
     *
     * @return StringWrapper
     */
    public function implode(string $glue = null): StringWrapper
    {
        return new StringWrapper(implode($glue, $this->input));
    }

    /**
     * @return ArrayGroup
     */
    public function group(): ArrayGroup
    {
        return new ArrayGroup($this->input);
    }

    /**
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function take(int $n): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->take($n);
    }

    /**
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function skip(int $n): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->skip($n);
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function takeWhile(callable $callback): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->takeWhile($callback);
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function skipWhile(callable $callback): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->skipWhile($callback);
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function takeIf(callable $callback): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->takeIf($callback);
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function skipIf(callable $callback): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->skipIf($callback);
    }

    /**
     * @param $left
     * @param $right
     *
     * @return ArrayWrapper
     */
    public function between($left, $right): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->between($left, $right);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function before($value): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->before($value);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function after($value): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->after($value);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function from($value): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->from($value);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function until($value): ArrayWrapper
    {
        $iterator = new ArrayIterator($this);

        return $iterator->until($value);
    }

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function all(callable $callback): bool
    {
        $iterator = new ArrayIterator($this);

        return $iterator->all($callback);
    }

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function any(callable $callback): bool
    {
        $iterator = new ArrayIterator($this);

        return $iterator->any($callback);
    }

    /**
     * @return ArrayProcedure
     */
    public function process(): ArrayProcedure
    {
        return new ArrayProcedure($this->input);
    }

    /**
     * @param int $size
     *
     * @return ArrayWrapper
     */
    public function chunks(int $size): ArrayWrapper
    {
        return new self(array_chunk($this->input, $size));
    }

    /**
     * @param int $size
     *
     * @return ArrayWrapper
     */
    public function chunksWithKey(int $size): ArrayWrapper
    {
        return new self(array_chunk($this->input, $size, true));
    }

    /**
     * @param      $column
     * @param null $key
     *
     * @return ArrayWrapper
     */
    public function column($column, $key = null): ArrayWrapper
    {
        return new self(array_column($this->input, $column, $key));
    }

    /**
     * @param array $input
     *
     * @return ArrayWrapper
     */
    public function combine(array $input): ArrayWrapper
    {
        return new self(array_combine($this->input, $input));
    }

    /**
     * @return ArrayWrapper
     */
    public function filterEmpty(): ArrayWrapper
    {
        return new self(array_filter($this->input));
    }

    /**
     * @param callable $callback
     * @param int      $flag
     *
     * @return ArrayWrapper
     */
    public function filter(callable $callback, int $flag = 0): ArrayWrapper
    {
        return new self(array_filter($this->input, $callback, $flag));
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function map(callable $callback): ArrayWrapper
    {
        $this->input = array_map($callback, $this->input);

        return $this;
    }

    /**
     * @param callable   $callback
     * @param mixed|null $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->input, $callback, $initial);
    }

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function walk(callable $callback): bool
    {
        return array_walk($this->input, $callback);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function hasKey($key): bool
    {
        return array_key_exists($key, $this->input);
    }

    /**
     * @param $needle
     *
     * @return bool
     */
    public function hasValue($needle): bool
    {
        return in_array($needle, $this->input);
    }

    /**
     * @return ArrayWrapper
     */
    public function keys(): ArrayWrapper
    {
        return new self(array_keys($this->input));
    }

    /**
     * @return ArrayWrapper
     */
    public function values(): ArrayWrapper
    {
        return new self(array_values($this->input));
    }

    /**
     * @param array[] ...$args
     *
     * @return ArrayWrapper
     */
    public function merge(array ...$args): ArrayWrapper
    {
        return new self(array_merge($this->input, ...$args));
    }

    /**
     * @return OptionalInterface
     */
    public function first(): OptionalInterface
    {
        return maybe(reset($this->input))->ensureNotFalse();
    }

    /**
     * @return OptionalInterface
     */
    public function last(): OptionalInterface
    {
        return maybe(end($this->input))->ensureNotFalse();
    }

    /**
     * @return OptionalInterface
     */
    public function popFront(): OptionalInterface
    {
        if ($this->isNotEmpty()) {
            $value = reset($this->input);
            unset($this->input[key($this->input)]);

            return some($value);
        }

        return none();
    }

    /**
     * @param $key
     *
     * @return OptionalInterface
     */
    public function pop($key): OptionalInterface
    {
        if ($this->hasKey($key)) {
            $value = some($this->input[$key]);
            unset($this->input[$key]);

            return $value;
        }

        return none();
    }

    /**
     * @return OptionalInterface
     */
    public function shift(): OptionalInterface
    {
        return maybe(array_shift($this->input));
    }

    /**
     * @return OptionalInterface
     */
    public function popBack(): OptionalInterface
    {
        return maybe(array_pop($this->input));
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function pushBack($value): int
    {
        return array_push($this->input, $value);
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function pushFront($value): int
    {
        return array_unshift($this->input, $value);
    }

    /**
     * @return ArrayWrapper
     */
    public function copy(): ArrayWrapper
    {
        return new self($this->input);
    }

    /**
     * @param \array[] ...$replacement
     *
     * @return ArrayWrapper
     */
    public function replace(array ...$replacement): ArrayWrapper
    {
        $this->input = array_replace($this->input, ...$replacement);

        return $this;
    }

    /**
     * @return ArrayWrapper
     */
    public function reverse(): ArrayWrapper
    {
        return new self(array_reverse($this->input));
    }

    /**
     * @return ArrayWrapper
     */
    public function reverseWithKeys(): ArrayWrapper
    {
        return new self(array_reverse($this->input, true));
    }

    /**
     * @param $value
     *
     * @return OptionalInterface
     */
    public function search($value): OptionalInterface
    {
        return maybe(array_search($value, $this->input))->ensureNotFalse();
    }

    /**
     * @param $value
     *
     * @return array
     */
    public function searchAll($value): array
    {
        return array_keys($this->input, $value);
    }

    /**
     * @param $value
     *
     * @return OptionalInterface
     */
    public function indexOf($value): OptionalInterface
    {
        return $this->values()->search($value);
    }

    /**
     * @param            $key
     * @param mixed|null $value
     *
     * @return ArrayWrapper
     */
    public function removeKey($key, &$value = null): ArrayWrapper
    {
        if ($this->hasKey($key)) {
            $value = $this->input[$key];
            unset($this->input[$key]);
        }

        return $this;
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function removeValue($value): ArrayWrapper
    {
        foreach ($this->searchAll($value) as $key) {
            unset($this->input[$key]);
        }

        return $this;
    }

    /**
     * @return ArrayWrapper
     */
    public function unique(): ArrayWrapper
    {
        return new self(array_unique($this->input));
    }

    /**
     * @param int $lhs
     * @param int $rhs
     *
     * @return ArrayWrapper
     */
    public function slice(int $lhs, int $rhs): ArrayWrapper
    {
        return $this->range($lhs, $rhs - $lhs);
    }

    /**
     * @param int      $offset
     * @param int|null $length
     *
     * @return ArrayWrapper
     */
    public function range(int $offset, int $length = null): ArrayWrapper
    {
        return new self(array_slice($this->input, $offset, $length ?? $this->length()));
    }

    /**
     * @return ArrayWrapper
     */
    public function flip(): ArrayWrapper
    {
        return new self(array_flip($this->input));
    }

    /**
     * @param \array[] ...$other
     *
     * @return ArrayWrapper
     */
    public function diff(array ...$other): ArrayWrapper
    {
        return new self(array_diff($this->input, ...$other));
    }

    /**
     * @param \array[] ...$other
     *
     * @return ArrayWrapper
     */
    public function diffAssoc(array ...$other): ArrayWrapper
    {
        return new self(array_diff_assoc($this->input, ...$other));
    }

    /**
     * @param int   $offset
     * @param int   $length
     * @param array $replacement
     *
     * @return ArrayWrapper
     */
    public function replacePart(int $offset, int $length = 0, array $replacement = []): ArrayWrapper
    {
        $this->input = array_splice($this->input, $offset, $length, $replacement);

        return $this;
    }

    /**
     * @return int
     */
    public function length(): int
    {
        return count($this->input);
    }

    /**
     * @param array $keys
     *
     * @return ArrayWrapper
     */
    public function only(array $keys): ArrayWrapper
    {
        return new self(array_intersect_key($this->input, assoc($keys)->flip()->get()));
    }

    /**
     * @param array $input
     *
     * @return ArrayWrapper
     */
    public function default(array $input): ArrayWrapper
    {
        if ($this->isEmpty()) {
            $this->input = $input;
        }

        return $this;
    }

    /**
     * @param $key
     *
     * @return OptionalInterface
     */
    public function valueOf($key): OptionalInterface
    {
        if ($this->hasKey($key)) {
            return some($this->input[$key]);
        }

        return none();
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function at($key)
    {
        return $this->valueOf($key)->default(null);
    }

    /**
     * @return float
     */
    public function sum(): float
    {
        return array_sum($this->input);
    }

    /**
     * @return float
     */
    public function product(): float
    {
        return array_product($this->input);
    }

    /**
     * @return mixed
     */
    public function max()
    {
        return max($this->input);
    }

    /**
     * @return mixed
     */
    public function min()
    {
        return min($this->input);
    }

    /**
     * @return array
     */
    public function countOccurrences(): array
    {
        return array_count_values($this->input);
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function isEqualTo(array $input): bool
    {
        return $this->input === $input;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->input);
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !empty($this->input);
    }

    /**
     * @return OptionalInterface
     */
    public function currentValue(): OptionalInterface
    {
        return maybe(current($this->input))->ensureNotFalse();
    }

    /**
     * @return OptionalInterface
     */
    public function currentKey(): OptionalInterface
    {
        return maybe(key($this->input));
    }
}