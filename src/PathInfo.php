<?php

namespace Dgame\Wrapper;

/**
 * Class PathInfo
 * @package Dgame\Wrapper
 */
final class PathInfo
{
    /**
     * @var string
     */
    private $dirname;
    /**
     * @var string
     */
    private $filename;
    /**
     * @var string
     */
    private $basename;
    /**
     * @var string
     */
    private $extension;

    /**
     * PathInfo constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $info = assoc(pathinfo($path));

        $this->dirname   = $info->valueOf('dirname')->default('');
        $this->filename  = $info->valueOf('filename')->default('');
        $this->basename  = $info->valueOf('basename')->default('');
        $this->extension = $info->valueOf('extension')->default('');
    }

    /**
     * @return string
     */
    public function getDirname(): string
    {
        return $this->dirname;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getBasename(): string
    {
        return $this->basename;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }
}