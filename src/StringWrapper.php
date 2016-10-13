<?php

namespace Dgame\Wrapper;

use Dgame\Optional\Optional;
use function Dgame\Optional\maybe;
use function Dgame\Optional\none;
use function Dgame\Optional\some;

/**
 * Class StringWrapper
 * @package Dgame\Wrapper
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
    public function split(string $pattern, int $limit = null): ArrayWrapper
    {
        return new ArrayWrapper(preg_split($pattern, $this->input, $limit, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * @param int $length
     *
     * @return ArrayWrapper
     */
    public function chunks(int $length): ArrayWrapper
    {
        return new ArrayWrapper(str_split($this->input, $length));
    }

    /**
     * @return ArrayWrapper
     */
    public function chars(): ArrayWrapper
    {
        return $this->chunks(1);
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
    public function matches(string $pattern, array &$matches = []): bool
    {
        return preg_match($pattern, $this->input, $matches) === 1;
    }

    /**
     * @return StringWrapper
     */
    public function asUpperCase(): StringWrapper
    {
        return new self(strtoupper($this->input));
    }

    /**
     * @return StringWrapper
     */
    public function asLowerCase(): StringWrapper
    {
        return new self(strtolower($this->input));
    }

    /**
     * @return StringWrapper
     */
    public function asCapitalized(): StringWrapper
    {
        return new self(ucfirst($this->input));
    }

    /**
     * @return StringWrapper
     */
    public function asUncapitalized(): StringWrapper
    {
        return new self(lcfirst($this->input));
    }

    /**
     * @return bool
     */
    public function isAlphaNumeric(): bool
    {
        return ctype_alnum($this->input);
    }

    /**
     * @return bool
     */
    public function isAlpha(): bool
    {
        return ctype_alpha($this->input);
    }

    /**
     * @return bool
     */
    public function isControl(): bool
    {
        return ctype_cntrl($this->input);
    }

    /**
     * @return bool
     */
    public function isDigit(): bool
    {
        return ctype_digit($this->input);
    }

    /**
     * @return bool
     */
    public function isLowerCase(): bool
    {
        return ctype_lower($this->input);
    }

    /**
     * @return bool
     */
    public function isUpperCase(): bool
    {
        return ctype_upper($this->input);
    }

    /**
     * @return bool
     */
    public function isPunctation(): bool
    {
        return ctype_punct($this->input);
    }

    /**
     * @return bool
     */
    public function isSpace(): bool
    {
        return ctype_space($this->input);
    }

    /**
     * @return bool
     */
    public function isHexaDecimal(): bool
    {
        return ctype_xdigit($this->input);
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
     * @param int      $start
     * @param int|null $length
     *
     * @return StringWrapper
     */
    public function substring(int $start, int $length = null): StringWrapper
    {
        return new self(substr($this->input, $start, $length ?? $this->length()));
    }

    /**
     * @param string $needle
     * @param bool   $beforeNeedle
     *
     * @return StringWrapper
     */
    public function fromFirstOccurrenceOf(string $needle, bool $beforeNeedle = false): StringWrapper
    {
        return new self(strstr($this->input, $needle, $beforeNeedle));
    }

    /**
     * @param string $needle
     *
     * @return StringWrapper
     */
    public function fromLastOccurrenceOf(string $needle): StringWrapper
    {
        return new self(strchr($this->input, $needle));
    }

    /**
     * @param string $needle
     * @param int    $offset
     *
     * @return Optional
     */
    public function firstOccurrenceOf(string $needle, int $offset = 0): Optional
    {
        return maybe(strpos($this->input, $needle, $offset));
    }

    /**
     * @param string $needle
     * @param int    $offset
     *
     * @return Optional
     */
    public function lastOccurrenceOf(string $needle, int $offset = 0): Optional
    {
        return maybe(strrpos($this->input, $needle, $offset));
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function before(string $value): StringWrapper
    {
        if ($this->firstOccurrenceOf($value)->isSome($index)) {
            return $this->substring(0, $index);
        }

        return $this;
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function after(string $value): StringWrapper
    {
        if ($this->firstOccurrenceOf($value)->isSome($index)) {
            return $this->substring($index + strlen($value));
        }

        return new self();
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function from(string $value): StringWrapper
    {
        if ($this->firstOccurrenceOf($value)->isSome($index)) {
            return $this->substring($index);
        }

        return new self();
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public function until(string $value): StringWrapper
    {
        if ($this->firstOccurrenceOf($value)->isSome($index)) {
            return $this->substring(0, $index);
        }

        return $this;
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
     * @param array $replacement
     *
     * @return StringWrapper
     */
    public function replace(array $replacement): StringWrapper
    {
        $this->input = str_replace(
            array_keys($replacement),
            array_values($replacement),
            $this->input
        );

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
            if ($this->firstOccurrenceOf($needle)->isSome($pos)) {
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
            if ($this->lastOccurrenceOf($needle)->isSome($pos)) {
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
     * @return string
     */
    public function encode(): string
    {
        return htmlspecialchars($this->input);
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
     * @return NamespaceInfo
     */
    public function namespaceInfo(): NamespaceInfo
    {
        return new NamespaceInfo($this->input);
    }

    /**
     * @return PathInfo
     */
    public function pathInfo(): PathInfo
    {
        return new PathInfo($this->input);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->input;
    }
}