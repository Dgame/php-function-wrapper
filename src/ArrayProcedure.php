<?php

namespace Dgame\Wrapper;

/**
 * Class ArrayProcedure
 * @package Dgame\Wrapper
 */
final class ArrayProcedure
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
     * @return ArrayWrapper
     */
    public function flatten(): ArrayWrapper
    {
        $output = [];
        foreach ($this->input as $key => $value) {
            if (is_array($value)) {
                $procedure = new self($value);
                $output    = array_merge($output, $procedure->flatten()->get());
            } else {
                $output[$key] = $value;
            }
        }

        return new ArrayWrapper($output);
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
            $assoc = new ArrayWrapper($value);
            if ($assoc->valueOf($lhs)->isSome($key) && $assoc->valueOf($rhs)->isSome($item)) {
                $output[$key] = $item;
            }
        }

        return new ArrayWrapper($output);
    }
}