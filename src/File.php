<?php

namespace Dgame\Wrapper;

/**
 * Class File
 * @package Dgame\Wrapper
 */
final class File
{
    /**
     * @var resource
     */
    private $handler;

    /**
     * File constructor.
     *
     * @param string $filename
     * @param string $mode
     *
     * @throws \Exception
     */
    public function __construct(string $filename, string $mode)
    {
        $this->handler = fopen($filename, $mode);
        if ($this->handler === false) {
            throw new \Exception('Could not open file ' . $filename);
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        if ($this->handler !== false) {
            fclose($this->handler);
        }
    }

    /**
     * @param int $size
     *
     * @return bool
     */
    public function truncate(int $size): bool
    {
        return ftruncate($this->handler, $size);
    }

    /**
     * @return bool
     */
    public function isEof(): bool
    {
        return feof($this->handler);
    }

    /**
     * @return string
     */
    public function readChar(): string
    {
        $c = fgetc($this->handler);

        return $c !== false ? $c : '';
    }

    /**
     * @param int|null $length
     *
     * @return string
     */
    public function readLine(int $length = null): string
    {
        $line = fgets($this->handler, $length);

        return $line !== false ? $line : '';
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function read(int $length): string
    {
        $line = fread($this->handler, $length);

        return $line !== false ? $line : '';
    }

    /**
     * @param string   $content
     * @param int|null $length
     *
     * @return int
     */
    public function write(string $content, int $length = null): int
    {
        $bytes = fwrite($this->handler, $content, $length);

        return $bytes !== false ? $bytes : -1;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return bool
     */
    public function seek(int $offset, int $whence = SEEK_SET): bool
    {
        return fseek($this->handler, $offset, $whence) === 0;
    }

    /**
     * @return int
     */
    public function tell(): int
    {
        $pos = ftell($this->handler);

        return $pos !== false ? $pos : -1;
    }

    /**
     * @return array
     */
    public function getStatistics(): array
    {
        return fstat($this->handler);
    }
}