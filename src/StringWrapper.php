<?php

namespace Dgame\Wrapper;

use Dgame\Optional\Optional;
use Exception;
use function Dgame\Optional\maybe;
use function Dgame\Optional\none;
use function Dgame\Optional\some;

/**
 * Class StringWrapper
 * @package Dgame\Wrapper
 *
 * @method StringWrapper between(string $left, string $right)
 * @method StringIterator popFront(string $delimiter)
 * @method StringIterator popBack(string $delimiter)
 * @method StringWrapper before(string $value)
 * @method StringWrapper after(string $value)
 * @method StringWrapper from(string $value)
 * @method StringWrapper until(string $value)
 * @method StringWrapper underscored()
 * @method StringWrapper dasherize()
 * @method StringWrapper camelize()
 * @method StringWrapper unCamelize(string $delimiter = '-')
 * @method StringWrapper titelize()
 * @method StringWrapper unTitelize(string $delimiter = '-')
 * @method StringWrapper slugify(string $delimiter = '-')
 */
final class StringWrapper
{
    /**
     * @var string
     */
    private $input;

    /**
     * StringWrapper constructor.
     *
     * @param string|null $input
     */
    public function __construct(string $input = null)
    {
        $this->input = $input;
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     * @throws Exception
     */
    public function __call(string $method, array $arguments)
    {
        $converter = new StringConverter($this);
        if (method_exists($converter, $method)) {
            return call_user_func_array([$converter, $method], $arguments);
        }

        $iterator = new StringIterator($this);
        if (method_exists($iterator, $method)) {
            return call_user_func_array([$iterator, $method], $arguments);
        }

        throw new Exception('Undefined method call: ' . $method);
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->input ?? '';
    }

    /**
     * @param string   $delimeter
     * @param int|null $limit
     *
     * @return ArrayWrapper
     */
    public function explode(string $delimeter, int $limit = null): ArrayWrapper
    {
        if ($limit !== null) {
            $output = explode($delimeter, $this->input, $limit);
        } else {
            $output = explode($delimeter, $this->input);
        }

        return new ArrayWrapper($output);
    }

    /**
     * @param string   $pattern
     * @param int|null $limit
     *
     * @return ArrayWrapper
     */
    public function pregSplit(string $pattern, int $limit = null): ArrayWrapper
    {
        return new ArrayWrapper(preg_split($pattern, $this->input, $limit, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * @param int         $length
     * @param string|null $end
     *
     * @return StringWrapper
     */
    public function chunkSplit(int $length, string $end = null): StringWrapper
    {
        return new self(chunk_split($this->input, $length, $end));
    }

    /**
     * @param int $size
     *
     * @return ArrayWrapper
     */
    public function split(int $size): ArrayWrapper
    {
        return new ArrayWrapper(str_split($this->input, $size));
    }

    /**
     * @return ArrayWrapper
     */
    public function chars(): ArrayWrapper
    {
        return $this->split(1);
    }

    /**
     * @param string $prefix
     *
     * @return bool
     */
    public function beginsWith(string $prefix): bool
    {
        return substr($this->input, 0, strlen($prefix)) === $prefix;
    }

    /**
     * @param string $suffix
     *
     * @return bool
     */
    public function endsWith(string $suffix): bool
    {
        return substr($this->input, -strlen($suffix)) === $suffix;
    }

    /**
     * @param string $prefix
     *
     * @return StringWrapper
     */
    public function prefix(string $prefix): StringWrapper
    {
        $this->input = $prefix . $this->input;

        return $this;
    }

    /**
     * @param string $suffix
     *
     * @return StringWrapper
     */
    public function suffix(string $suffix): StringWrapper
    {
        $this->input .= $suffix;

        return $this;
    }

    /**
     * @param string     $pattern
     * @param array|null $matches
     *
     * @return bool
     */
    public function match(string $pattern, array &$matches = null): bool
    {
        return preg_match($pattern, $this->input, $matches) === 1;
    }

    /**
     * @return StringWrapper
     */
    public function toUpperCase(): StringWrapper
    {
        return new self(strtoupper($this->input));
    }

    /**
     * @return StringWrapper
     */
    public function toLowerCase(): StringWrapper
    {
        return new self(strtolower($this->input));
    }

    /**
     * @return StringWrapper
     */
    public function toUpperCaseFirst(): StringWrapper
    {
        return new self(ucfirst($this->input));
    }

    /**
     * @return StringWrapper
     */
    public function toLowerCaseFirst(): StringWrapper
    {
        return new self(lcfirst($this->input));
    }

    /**
     * @param string|null $mask
     *
     * @return StringWrapper
     */
    public function trim(string $mask = null): StringWrapper
    {
        if ($mask === null) {
            $this->input = trim($this->input);
        } else {
            $this->input = trim($this->input, $mask);
        }

        return $this;
    }

    /**
     * @param string|null $mask
     *
     * @return StringWrapper
     */
    public function leftTrim(string $mask = null): StringWrapper
    {
        if ($mask === null) {
            $this->input = ltrim($this->input);
        } else {
            $this->input = ltrim($this->input, $mask);
        }

        return $this;
    }

    /**
     * @param string|null $mask
     *
     * @return StringWrapper
     */
    public function rightTrim(string $mask = null): StringWrapper
    {
        if ($mask === null) {
            $this->input = rtrim($this->input);
        } else {
            $this->input = rtrim($this->input, $mask);
        }

        return $this;
    }

    /**
     * @param int $lhs
     * @param int $rhs
     *
     * @return StringWrapper
     */
    public function slice(int $lhs, int $rhs): StringWrapper
    {
        return $this->substring($lhs, $rhs - $lhs);
    }

    /**
     * @param int      $offset
     * @param int|null $length
     *
     * @return StringWrapper
     */
    public function substring(int $offset, int $length = null): StringWrapper
    {
        return new self(substr($this->input, $offset, $length ?? $this->length()));
    }

    /**
     * @param string $needle
     *
     * @return Optional
     */
    public function fromFirstOccurrenceOf(string $needle): Optional
    {
        return maybe(strstr($this->input, $needle))->ensureNotFalse();
    }

    /**
     * @param string $needle
     *
     * @return Optional
     */
    public function fromLastOccurrenceOf(string $needle): Optional
    {
        return maybe(strrchr($this->input, $needle))->ensureNotFalse();
    }

    /**
     * @param string $needle
     * @param int    $offset
     *
     * @return Optional
     */
    public function indexOf(string $needle, int $offset = 0): Optional
    {
        return maybe(strpos($this->input, $needle, $offset))->ensureNotFalse();
    }

    /**
     * @param string $needle
     * @param int    $offset
     *
     * @return Optional
     */
    public function lastIndexOf(string $needle, int $offset = 0): Optional
    {
        return maybe(strrpos($this->input, $needle, $offset))->ensureNotFalse();
    }

    /**
     * @param string $input
     *
     * @return StringWrapper
     */
    public function default(string $input): StringWrapper
    {
        if ($this->isEmpty()) {
            $this->input = $input;
        }

        return $this;
    }

    /**
     * @param int $index
     *
     * @return Optional
     */
    public function at(int $index): Optional
    {
        if ($index >= 0 && $index < $this->length()) {
            return some($this->input[$index]);
        }

        return none();
    }

    /**
     * @return StringWrapper
     */
    public function reverse(): StringWrapper
    {
        return new self(strrev($this->input));
    }

    /**
     * @return int
     */
    public function length(): int
    {
        return strlen($this->input);
    }

    /**
     * @return StringWrapper
     */
    public function copy(): StringWrapper
    {
        return new self($this->input);
    }

    /**
     * @param $pattern
     * @param $replace
     *
     * @return StringWrapper
     */
    public function pregReplace($pattern, $replace): StringWrapper
    {
        $this->input = preg_replace($pattern, $replace, $this->input);

        return $this;
    }

    /**
     * @param string   $pattern
     * @param callable $callback
     *
     * @return StringWrapper
     */
    public function pregReplaceCallback(string $pattern, callable $callback): StringWrapper
    {
        $result = preg_replace_callback($pattern, $callback, $this->input);

        return new self($result);
    }

    /**
     * @param $search
     * @param $replace
     *
     * @return StringWrapper
     */
    public function replace($search, $replace): StringWrapper
    {
        $this->input = str_replace($search, $replace, $this->input);

        return $this;
    }

    /**
     * @param array $replacement
     *
     * @return StringWrapper
     */
    public function replaceFirst(array $replacement): StringWrapper
    {
        foreach ($replacement as $needle => $replace) {
            if ($this->indexOf($needle)->isSome($pos)) {
                $this->input = substr_replace($this->input, $replace, $pos, strlen($needle));
            }
        }

        return $this;
    }

    /**
     * @param array $replacement
     *
     * @return StringWrapper
     */
    public function replaceLast(array $replacement): StringWrapper
    {
        foreach ($replacement as $needle => $replace) {
            if ($this->lastIndexOf($needle)->isSome($pos)) {
                $this->input = substr_replace($this->input, $replace, $pos, strlen($needle));
            }
        }

        return $this;
    }

    /**
     * @param int $times
     *
     * @return StringWrapper
     */
    public function repeat(int $times): StringWrapper
    {
        return new self(str_repeat($this->input, $times));
    }

    /**
     * @param array ...$args
     *
     * @return StringWrapper
     */
    public function format(...$args): StringWrapper
    {
        if (!empty($args)) {
            $this->input = sprintf($this->input, ...$args);
        }

        return $this;
    }

    /**
     * @param string $input
     *
     * @return bool
     */
    public function isEqualTo(string $input): bool
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
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->input === null;
    }

    /**
     * @return bool
     */
    public function isNotNull(): bool
    {
        return $this->input !== null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->input;
    }
}