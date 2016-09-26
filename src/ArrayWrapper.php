<?php

namespace Dgame\Wrapper;

/**
 * Class ArrayWrapper
 * @package Dgame\Wrapper
 */
final class ArrayWrapper
{
    /**
     * @var array
     */
    private $input = [];

    /**
     * ArrayWrapper constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->input = $data;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->input;
    }

    /**
     * @param int  $size
     * @param bool $preserveKeys
     *
     * @return ArrayWrapper
     */
    public function chunk(int $size, bool $preserveKeys = false): ArrayWrapper
    {
        return new self(array_chunk($this->input, $size, $preserveKeys));
    }

    /**
     * @param      $column
     * @param null $indexKey
     *
     * @return ArrayWrapper
     */
    public function column($column, $indexKey = null): ArrayWrapper
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
        $this->input = array_combine($this->input, $input);

        return $this;
    }

    /**
     * @return ArrayWrapper
     */
    public function filter(): ArrayWrapper
    {
        return new self(array_filter($this->input));
    }

    /**
     * @param callable $callback
     * @param int      $flag
     *
     * @return ArrayWrapper
     */
    public function filterBy(callable $callback, int $flag = 0): ArrayWrapper
    {
        return new self(array_filter($this->input, $callback, $flag));
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
    public function contains($needle): bool
    {
        return in_array($needle, $this->input);
    }

    /**
     * @param null $key
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
     * @param array $input
     *
     * @return ArrayWrapper
     */
    public function mergeWith(array $input): ArrayWrapper
    {
        $this->input = array_merge($this->input, $input);

        return $this;
    }

    /**
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->input);
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
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->input);
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
     * @param array $replace
     *
     * @return ArrayWrapper
     */
    public function replace(array $replace): ArrayWrapper
    {
        return new self(array_replace($this->input, $replace));
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
     * @param $needle
     *
     * @return mixed
     */
    public function search($needle)
    {
        return array_search($needle, $this->input);
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
        $this->input = array_slice($this->input, $offset, $length, $replacement);

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
}