<?php

namespace Dgame\Wrapper;

use Dgame\Optional\Optional;
use function Dgame\Optional\maybe;
use function Dgame\Optional\none;
use function Dgame\Optional\some;

/**
 * Class ArrayWrapper
 * @package Dgame\Wrapper
 */
final class ArrayWrapper extends \ArrayObject
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
        parent::__construct($input);

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
     * @param string|null $glue
     *
     * @return StringWrapper
     */
    public function implode(string $glue = null): StringWrapper
    {
        return new StringWrapper(implode($glue, $this->input));
    }

    /**
     * @param int $times
     *
     * @return ArrayWrapper
     */
    public function repeat(int $times): ArrayWrapper
    {
        $cycle = [];
        for ($i = 0; $i < $times; $i++) {
            $cycle = array_merge($this->input, $cycle);
        }

        return new self($cycle);
    }

    /**
     * @return ArrayWrapper
     */
    public function group(): ArrayWrapper
    {
        $result = [];
        foreach ($this->input as $key => $value) {
            $result[$value][$key] = $value;
        }

        return new self(array_values($result));
    }

    /**
     * @param int  $size
     * @param bool $preserveKeys
     *
     * @return ArrayWrapper
     */
    public function chunks(int $size, bool $preserveKeys = false): ArrayWrapper
    {
        return new self(array_chunk($this->input, $size, $preserveKeys));
    }

    /**
     * @param      $column
     * @param null $indexKey
     *
     * @return ArrayWrapper
     */
    public function columns($column, $indexKey = null): ArrayWrapper
    {
        return new self(array_column($this->input, $column, $indexKey));
    }

    /**
     * @param array $input
     *
     * @return ArrayWrapper
     */
    public function combineWith(array $input): ArrayWrapper
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
     * @param callable $callback
     * @param null     $initial
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
     * @param mixed|null $key
     *
     * @return ArrayWrapper
     */
    public function keys($key = null): ArrayWrapper
    {
        return new self(array_keys($this->input, $key));
    }

    /**
     * @return ArrayWrapper
     */
    public function values(): ArrayWrapper
    {
        return new self(array_values($this->input));
    }

    /**
     * @param array[] ...$input
     *
     * @return ArrayWrapper
     */
    public function mergeWith(array ...$input): ArrayWrapper
    {
        $this->input = array_merge($this->input, ...$input);

        return $this;
    }

    /**
     * @return Optional
     */
    public function first(): Optional
    {
        return $this->at(0);
    }

    /**
     * @return Optional
     */
    public function last(): Optional
    {
        return $this->at($this->length() - 1);
    }

    /**
     * @return Optional
     */
    public function pop(): Optional
    {
        return maybe(array_pop($this->input));
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function push($value): int
    {
        return array_push($this->input, $value);
    }

    /**
     * @return Optional
     */
    public function shift(): Optional
    {
        return maybe(array_shift($this->input));
    }

    /**
     * @param $value
     *
     * @return int
     */
    public function unshift($value): int
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
     * @param array $replacement
     *
     * @return ArrayWrapper
     */
    public function replace(array $replacement): ArrayWrapper
    {
        $this->input = array_replace($this->input, $replacement);

        return $this;
    }

    /**
     * @param bool $preserveKeys
     *
     * @return ArrayWrapper
     */
    public function reverse(bool $preserveKeys = false): ArrayWrapper
    {
        return new self(array_reverse($this->input, $preserveKeys));
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
     * @return Optional
     */
    public function indexOf($value): Optional
    {
        return $this->values()->search($value);
    }

    /**
     * @return ArrayWrapper
     */
    public function unique(): ArrayWrapper
    {
        return new self(array_unique($this->input));
    }

    /**
     * @param int      $offset
     * @param int|null $length
     * @param bool     $preserveKeys
     *
     * @return ArrayWrapper
     */
    public function slice(int $offset, int $length = null, bool $preserveKeys = false): ArrayWrapper
    {
        return new self(array_slice($this->input, $offset, $length ?? $this->length(), $preserveKeys));
    }

    /**
     * @param int   $offset
     * @param int   $length
     * @param array $replacement
     *
     * @return ArrayWrapper
     */
    public function splice(int $offset, int $length = 0, array $replacement = []): ArrayWrapper
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
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function take(int $n): ArrayWrapper
    {
        return $this->slice(0, $n);
    }

    /**
     * @param int $n
     *
     * @return ArrayWrapper
     */
    public function skip(int $n): ArrayWrapper
    {
        return $this->slice($n);
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
     * @param $left
     * @param $right
     *
     * @return ArrayWrapper
     */
    public function between($left, $right): ArrayWrapper
    {
        if ($this->indexOf($left)->isSome($offset)) {
            if ($this->indexOf($right)->isSome($length)) {
                return $this->slice($offset + 1, $length - $offset - 1);
            }

            return $this->skip($offset + 1);
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
    public function at($key): Optional
    {
        if ($this->hasKey($key)) {
            return some($this->input[$key]);
        }

        return none();
    }

    /**
     * @param $value
     *
     * @return Optional
     */
    public function find($value): Optional
    {
        if ($this->search($value)->isSome($key)) {
            return some($this->input[$key]);
        }

        return none();
    }

    /**
     * @param callable $callback
     *
     * @return array
     */
    public function findBy(callable $callback): array
    {
        $results = [];
        foreach ($this->input as $key => $value) {
            if ($callback($value, $key)) {
                $results[$key] = $value;
            }
        }

        return $results;
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
     * @return float
     */
    public function average(): float
    {
        return $this->sum() / $this->length();
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
}