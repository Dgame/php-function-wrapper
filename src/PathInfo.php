<?php

namespace Dgame\Wrapper;

use Dgame\Optional\Optional;

/**
 * Class PathInfo
 * @package Dgame\Wrapper
 */
final class PathInfo
{
    /**
     * @var Optional
     */
    private $dirname;
    /**
     * @var Optional
     */
    private $filename;
    /**
     * @var Optional
     */
    private $basename;
    /**
     * @var Optional
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

        $this->dirname   = $info->valueOf('dirname');
        $this->filename  = $info->valueOf('filename');
        $this->basename  = $info->valueOf('basename');
        $this->extension = $info->valueOf('extension');
    }

    /**
     * @return Optional
     */
    public function getDirname(): Optional
    {
        return $this->dirname;
    }

    /**
     * @return Optional
     */
    public function getFilename(): Optional
    {
        return $this->filename;
    }

    /**
     * @return Optional
     */
    public function getBasename(): Optional
    {
        return $this->basename;
    }

    /**
     * @return Optional
     */
    public function getExtension(): Optional
    {
        return $this->extension;
    }
}