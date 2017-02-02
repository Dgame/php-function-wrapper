<?php

namespace Dgame\Wrapper;

use Dgame\Optional\OptionalInterface;
use function Dgame\Optional\maybe;
use function Dgame\Optional\none;
use function Dgame\Optional\some;

/**
 * Class StringWrapper
 * @package Dgame\Wrapper
 */
final class StringWrapper implements StringConvertInterface, StringIteratorInterface
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
     * @param string $pattern
     * @param array  $matches
     *
     * @return bool
     */
    public function match(string $pattern, array &$matches = []): bool
    {
        return preg_match($pattern, $this->input, $matches) === 1;
    }

    /**
     * @return StringWrapper
     */
    public function underscored(): StringWrapper
    {
        $converter = new StringConverter($this);

        return $converter->underscored();
    }

    /**
     * @return StringWrapper
     */
    public function dasherize(): StringWrapper
    {
        $converter = new StringConverter($this);

        return $converter->dasherize();
    }

    /**
     * @return StringWrapper
     */
    public function camelize(): StringWrapper
    {
        $converter = new StringConverter($this);

        return $converter->camelize();
    }

    /**
     * @return StringWrapper
     */
    public function titelize(): StringWrapper
    {
        $converter = new StringConverter($this);

        return $converter->titelize();
    }

    /**
     * @param string $delimiter
     *
     * @return StringWrapper
     */
    public function slugify(string $delimiter = '-'): StringWrapper
    {
        $converter = new StringConverter($this);

        return $converter->slugify($delimiter);
    }

    /**
     * @param string $left
     * @param string $right
     *
     * @return StringWrapper
     */
    public function between(string $left, string $right): StringWrapper
    {
        $iterator = new StringIterator($this);

        return $iterator->between($left, $right);
    }

    /**
     * @param string $delimiter
     *
     * @return StringIterator
     */
    public function popFront(string $delimiter): StringIterator
    {
        $iterator = new StringIterator($this);

        return $iterator->popFront($delimiter);
    }

    /**
     * @param string $delimiter
     *
     * @return StringIterator
     */
    public function popBack(string $delimiter): StringIterator
    {
        $iterator = new StringIterator($this);

        return $iterator->popBack($delimiter);
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function before(string $value): StringWrapper
    {
        $iterator = new StringIterator($this);

        return $iterator->before($value);
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function after(string $value): StringWrapper
    {
        $iterator = new StringIterator($this);

        return $iterator->after($value);
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function from(string $value): StringWrapper
    {
        $iterator = new StringIterator($this);

        return $iterator->from($value);
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function until(string $value): StringWrapper
    {
        $iterator = new StringIterator($this);

        return $iterator->until($value);
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
     * @return OptionalInterface
     */
    public function fromFirstOccurrenceOf(string $needle): OptionalInterface
    {
        return maybe(strstr($this->input, $needle))->ensureNotFalse();
    }

    /**
     * @param string $needle
     *
     * @return OptionalInterface
     */
    public function fromLastOccurrenceOf(string $needle): OptionalInterface
    {
        return maybe(strrchr($this->input, $needle))->ensureNotFalse();
    }

    /**
     * @param string $needle
     * @param int    $offset
     *
     * @return OptionalInterface
     */
    public function indexOf(string $needle, int $offset = 0): OptionalInterface
    {
        return maybe(strpos($this->input, $needle, $offset))->ensureNotFalse();
    }

    /**
     * @param string $needle
     * @param int    $offset
     *
     * @return OptionalInterface
     */
    public function lastIndexOf(string $needle, int $offset = 0): OptionalInterface
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
     * @return OptionalInterface
     */
    public function at(int $index): OptionalInterface
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