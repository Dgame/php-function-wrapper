<?php

namespace Dgame\Wrapper;

/**
 * Class FileWrapper
 * @package Dgame\Wrapper
 */
final class FileWrapper
{
    /**
     * @var string
     */
    private $filename;

    /**
     * FileWrapper constructor.
     *
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return file_exists($this->filename);
    }

    /**
     * @return bool
     */
    public function isFile(): bool
    {
        return is_file($this->filename);
    }

    /**
     * @return bool
     */
    public function isDir(): bool
    {
        return is_dir($this->filename);
    }

    /**
     * @return int
     */
    public function size(): int
    {
        if (!$this->isFile()) {
            return -1;
        }

        return filesize($this->filename);
    }

    /**
     * @param string $mode
     *
     * @return File
     */
    public function open(string $mode): File
    {
        return new File($this->filename, $mode);
    }

    /**
     * @return string
     */
    public function read(): string
    {
        $content = false;
        if ($this->isFile()) {
            $content = file_get_contents($this->filename);
        }

        return $content !== false ? $content : '';
    }

    /**
     * @param string $content
     * @param int    $flags
     *
     * @return int
     */
    public function write(string $content, int $flags = 0): int
    {
        $bytes = false;
        if ($this->isFile()) {
            $bytes = file_put_contents($this->filename, $content, $flags);
        }

        return $bytes !== false ? $bytes : -1;
    }

    /**
     * @param string $content
     *
     * @return int
     */
    public function append(string $content): int
    {
        return $this->write($content, FILE_APPEND);
    }

    /**
     * @return int
     */
    public function truncate(): int
    {
        return $this->write('');
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        if ($this->isFile()) {
            return unlink($this->filename);
        }

        if ($this->isDir()) {
            return rmdir($this->filename);
        }

        return false;
    }

    /**
     * @param string $destination
     *
     * @return bool
     */
    public function copy(string $destination): bool
    {
        return copy($this->filename, $destination);
    }

    /**
     * @param string|null $suffix
     *
     * @return string
     */
    public function basename(string $suffix = null): string
    {
        return basename($this->filename, $suffix);
    }

    /**
     * @param int $level
     *
     * @return string
     */
    public function dirname(int $level = 1): string
    {
        return dirname($this->filename, $level);
    }

    /**
     * @return PathInfo
     */
    public function info(): PathInfo
    {
        return new PathInfo($this->filename);
    }
}