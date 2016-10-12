<?php

namespace Dgame\Wrapper;

/**
 * Class PathInfo
 * @package Dgame\Wrapper
 */
final class PathInfo
{
    /**
     * @var string|null
     */
    private $dirname;
    /**
     * @var string|null
     */
    private $filename;
    /**
     * @var string|null
     */
    private $basename;
    /**
     * @var string|null
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
        $info->at('dirname')->isSome($this->dirname);
        $info->at('filename')->isSome($this->filename);
        $info->at('basename')->isSome($this->basename);
        $info->at('extension')->isSome($this->extension);
    }

    /**
     * @return null|string
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * @return null|string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return null|string
     */
    public function getBasename()
    {
        return $this->basename;
    }

    /**
     * @return null|string
     */
    public function getExtension()
    {
        return $this->extension;
    }
}