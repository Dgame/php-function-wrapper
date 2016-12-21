<?php

namespace Dgame\Wrapper;

/**
 * Class ArrayGroup
 * @package Dgame\Wrapper
 */
final class ArrayGroup
{
    /**
     * @var array
     */
    private $input = [];

    /**
     * ArrayGroup constructor.
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
    public function asArray(): array
    {
        return $this->input;
    }

    /**
     * @return ArrayWrapper
     */
    public function asWrapper(): ArrayWrapper
    {
        return new ArrayWrapper($this->input);
    }

    /**
     * @return ArrayGroup
     */
    public function byValues(): self
    {
        $output = [];
        foreach ($this->input as $value) {
            $output[$value][] = $value;
        }

        return new self(array_values($output));
    }

    /**
     * @return ArrayGroup
     */
    public function byValuesWithKeys(): self
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
     * @return ArrayGroup
     */
    public function byKey($key): self
    {
        $output = [];
        foreach ($this->input as $value) {
            if (is_array($value) && assoc($value)->valueOf($key)->isSome($item)) {
                $output[$item] = $value;
            }
        }

        return new self($output);
    }
}