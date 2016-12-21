<?php

namespace Dgame\Wrapper;

use ArrayAccess;
use ArrayIterator;
use Dgame\Optional\Optional;
use IteratorAggregate;
use function Dgame\Optional\maybe;
use function Dgame\Optional\none;
use function Dgame\Optional\some;

/**
 * Class ArrayWrapper
 * @package Dgame\Wrapper
 */
final class ArrayWrapper implements ArrayAccess, IteratorAggregate
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
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->input);
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
     * @return ArrayWrapper
     */
    public function groupValues(): ArrayWrapper
    {
        $output = [];
        foreach ($this->input as $value) {
            $output[$value][] = $value;
        }

        return new self(array_values($output));
    }

    /**
     * @return ArrayWrapper
     */
    public function groupValuesWithKeys(): ArrayWrapper
    {
        $output = [];
        foreach ($this->input as $key => $value) {
            $output[$value][$key] = $value;
        }

        return new self(array_values($output));
    }

    /**
     * @param $key
     *
     * @return ArrayWrapper
     */
    public function groupByKey($key): ArrayWrapper
    {
        $output = [];
        foreach ($this->input as $value) {
            if (is_array($value) && assoc($value)->valueOf($key)->isSome($item)) {
                $output[$item] = $value;
            }
        }

        return new self($output);
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
     * @return Optional
     */
    public function first(): Optional
    {
        return maybe(reset($this->input));
    }

    /**
     * @return Optional
     */
    public function last(): Optional
    {
        return maybe(end($this->input));
    }

    /**
     * @return Optional
     */
    public function popBack(): Optional
    {
        return maybe(array_pop($this->input));
    }

    /**
     * @return Optional
     */
    public function popFront(): Optional
    {
        if ($this->isNotEmpty()) {
            $value = reset($this->input);
            unset($this->input[key($this->input)]);

            return some($value);
        }

        return none();
    }

    /**
     * @return Optional
     */
    public function shift(): Optional
    {
        return maybe(array_shift($this->input));
    }

    /**
     * @param $key
     *
     * @return Optional
     */
    public function pop($key): Optional
    {
        if ($this->hasKey($key)) {
            $value = some($this->input[$key]);
            unset($this->input[$key]);

            return $value;
        }

        return none();
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
     * @return Optional
     */
    public function search($value): Optional
    {
        return maybe(array_search($value, $this->input));
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
     * @return Optional
     */
    public function indexOf($value): Optional
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
    public function flatten(): ArrayWrapper
    {
        $output = [];
        foreach ($this->input as $key => $value) {
            if (is_array($value)) {
                $output = array_merge($output, assoc($value)->flatten()->get());
            } else {
                $output[$key] = $value;
            }
        }

        return new self($output);
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     *
     * @return ArrayWrapper
     */
    public function mapping($lhs, $rhs): ArrayWrapper
    {
        $output = [];
        foreach ($this->input as $value) {
            $assoc = new self($value);
            if ($assoc->valueOf($lhs)->isSome($key) && $assoc->valueOf($rhs)->isSome($item)) {
                $output[$key] = $item;
            }
        }

        return new self($output);
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
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function take(int $n): ArrayWrapper
    {
        return new self(array_slice($this->input, 0, $n));
    }

    /**
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function skip(int $n): ArrayWrapper
    {
        return new self(array_slice($this->input, $n));
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function takeWhile(callable $callback): ArrayWrapper
    {
        $n = 0;
        foreach ($this->input as $value) {
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
        foreach ($this->input as $value) {
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
        foreach ($this->input as $key => $value) {
            if ($callback($value)) {
                $output[$key] = $value;
            }
        }

        return new self($output);
    }

    /**
     * @param callable $callback
     *
     * @return ArrayWrapper
     */
    public function skipIf(callable $callback): ArrayWrapper
    {
        $output = [];
        foreach ($this->input as $key => $value) {
            if (!$callback($value)) {
                $output[$key] = $value;
            }
        }

        return new self($output);
    }

    /**
     * @param $left
     * @param $right
     *
     * @return ArrayWrapper
     */
    public function between($left, $right): ArrayWrapper
    {
        if ($this->indexOf($left)->isSome($lhs)) {
            if ($this->indexOf($right)->isSome($rhs)) {
                return $this->slice($lhs + 1, $rhs);
            }

            return $this->skip($lhs + 1);
        }

        return new self([]);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function before($value): ArrayWrapper
    {
        if ($this->indexOf($value)->isSome($index)) {
            return $this->take($index);
        }

        return $this;
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function after($value): ArrayWrapper
    {
        if ($this->indexOf($value)->isSome($index)) {
            return $this->skip($index + 1);
        }

        return new self([]);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function from($value): ArrayWrapper
    {
        if ($this->indexOf($value)->isSome($index)) {
            return $this->skip($index);
        }

        return new self([]);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper
     */
    public function until($value): ArrayWrapper
    {
        if ($this->indexOf($value)->isSome($index)) {
            return $this->take($index + 1);
        }

        return $this;
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
     * @return Optional
     */
    public function valueOf($key): Optional
    {
        if ($this->hasKey($key)) {
            return some($this->input[$key]);
        }

        return none();
    }

    /**
     * @param callable $callback
     *
     * @return bool
     */
    public function all(callable $callback): bool
    {
        foreach ($this->input as $value) {
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
        foreach ($this->input as $value) {
            if ($callback($value)) {
                return true;
            }
        }

        return false;
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
     * @return Optional
     */
    public function currentValue(): Optional
    {
        return maybe(current($this->input));
    }

    /**
     * @return Optional
     */
    public function currentKey(): Optional
    {
        return maybe(key($this->input));
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->hasKey($key);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->valueOf($key)->default(null);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        if ($key === null) {
            $this->input[] = $value;
        } else {
            $this->input[$key] = $value;
        }
    }

    /**
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        unset($this->input[$key]);
    }
}