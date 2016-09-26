<?php

namespace Dgame\Wrapper;
use Dgame\Wrapper\Optional\Optional;

/**
 * Class StringWrapper
 * @package Dgame\Wrapper
 */
final class StringWrapper
{
    /**
     * @var string
     */
    private $subject;

    /**
     * StringWrapper constructor.
     *
     * @param string|null $subject
     */
    public function __construct(string $subject = null)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->subject;
    }

    /**
     * @param string $delimeter
     *
     * @return ArrayWrapper
     */
    public function explode(string $delimeter): ArrayWrapper
    {
        return new ArrayWrapper(explode($delimeter, $this->subject));
    }

    /**
     * @return ArrayWrapper
     */
    public function chars(): ArrayWrapper
    {
        return $this->split(1);
    }

    /**
     * @param int $length
     *
     * @return ArrayWrapper
     */
    public function split(int $length): ArrayWrapper
    {
        return new ArrayWrapper(str_split($this->subject, $length));
    }

    /**
     * @param string $prefix
     *
     * @return bool
     */
    public function beginsWith(string $prefix): bool
    {
        return substr($this->subject, 0, strlen($prefix)) === $prefix;
    }

    /**
     * @param string $suffix
     *
     * @return bool
     */
    public function endsWith(string $suffix): bool
    {
        return substr($this->subject, -strlen($suffix)) === $suffix;
    }

    /**
     * @param string $prefix
     *
     * @return StringWrapper
     */
    public function prefix(string $prefix): StringWrapper
    {
        $this->subject = $prefix . $this->subject;

        return $this;
    }

    /**
     * @param string $suffix
     *
     * @return StringWrapper
     */
    public function suffix(string $suffix): StringWrapper
    {
        $this->subject .= $suffix;

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
        return preg_match($pattern, $this->subject, $matches) === 1;
    }

    /**
     * @param string $needle
     * @param int    $offset
     *
     * @return StringWrapper
     */
    public function from(string $needle, int $offset = 0): StringWrapper
    {
        if ($this->contains($needle, $pos)) {
            return $this->substring($pos + $offset);
        }

        return new self();
    }

    /**
     * @param string $needle
     *
     * @return StringWrapper
     */
    public function until(string $needle): StringWrapper
    {
        if ($this->contains($needle, $pos)) {
            return $this->substring(0, $pos);
        }

        return new self();
    }

    /**
     * @return StringWrapper
     */
    public function toUpper(): StringWrapper
    {
        $this->subject = strtoupper($this->subject);

        return $this;
    }

    /**
     * @return StringWrapper
     */
    public function toLower(): StringWrapper
    {
        $this->subject = strtolower($this->subject);

        return $this;
    }

    /**
     * @return StringWrapper
     */
    public function toUpperFirst(): StringWrapper
    {
        $this->subject = ucfirst($this->subject);

        return $this;
    }

    /**
     * @return StringWrapper
     */
    public function toLowerFirst(): StringWrapper
    {
        $this->subject = lcfirst($this->subject);

        return $this;
    }

    /**
     * @param string|null $mask
     *
     * @return StringWrapper
     */
    public function trim(string $mask = null): StringWrapper
    {
        if ($mask === null) {
            $this->subject = trim($this->subject);
        } else {
            $this->subject = trim($this->subject, $mask);
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
            $this->subject = ltrim($this->subject);
        } else {
            $this->subject = ltrim($this->subject, $mask);
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
            $this->subject = rtrim($this->subject);
        } else {
            $this->subject = rtrim($this->subject, $mask);
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
        return new self(substr($this->subject, $start, $length ?? $this->length()));
    }

    /**
     * @param string $needle
     * @param bool   $beforeNeedle
     *
     * @return StringWrapper
     */
    public function fromFirstOccurenceOf(string $needle, bool $beforeNeedle = false): StringWrapper
    {
        return new self(strstr($this->subject, $needle, $beforeNeedle));
    }

    /**
     * @param string $needle
     *
     * @return StringWrapper
     */
    public function fromLastOccurenceOf(string $needle): StringWrapper
    {
        return new self(strchr($this->subject, $needle));
    }

    /**
     * @param string   $needle
     * @param int|null $pos
     *
     * @return bool
     */
    public function contains(string $needle, int &$pos = null): bool
    {
        return $this->firstPositionOf($needle)->isSome($pos);
    }

    /**
     * @param string $needle
     *
     * @return Optional
     */
    public function firstPositionOf(string $needle): Optional
    {
        return ($pos = strpos($this->subject, $needle)) === false ? none() : some($pos);
    }

    /**
     * @param string $needle
     * @param int    $offset
     *
     * @return Optional
     */
    public function lastPositionOf(string $needle, int $offset = 0): Optional
    {
        return ($pos = strrpos($this->subject, $needle, $offset)) === false ? none() : some($pos);
    }

    /**
     * @return StringWrapper
     */
    public function reverse(): StringWrapper
    {
        $this->subject = strrev($this->subject);

        return $this;
    }

    /**
     * @return int
     */
    public function length(): int
    {
        return strlen($this->subject);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->subject);
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->subject === null;
    }

    /**
     * @param string $search
     * @param string $replace
     *
     * @return StringWrapper
     */
    public function replace(string $search, string $replace): StringWrapper
    {
        $this->subject = str_replace($search, $replace, $this->subject);

        return $this;
    }

    /**
     * @param int $times
     *
     * @return StringWrapper
     */
    public function repeat(int $times): StringWrapper
    {
        $this->subject = str_repeat($this->subject, $times);

        return $this;
    }

    /**
     * @param array ...$args
     *
     * @return StringWrapper
     */
    public function format(...$args): StringWrapper
    {
        if (!empty($args)) {
            $this->subject = sprintf($this->subject, ...$args);
        }

        return $this;
    }
}