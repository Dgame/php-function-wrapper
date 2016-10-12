<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\string;

class PathInfoTest extends TestCase
{
    public function testSingle()
    {
        $path = string('foo')->pathInfo();

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('foo', $path->getBasename());
        $this->assertNull($path->getExtension());
        $this->assertEquals('foo', $path->getFilename());
    }

    public function testDirectory()
    {
        $path = string('foo/')->pathInfo();

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('foo', $path->getBasename());
        $this->assertNull($path->getExtension());
        $this->assertEquals('foo', $path->getFilename());
    }

    public function testPath()
    {
        $path = string('foo/bar')->pathInfo();

        $this->assertEquals('foo', $path->getDirname());
        $this->assertEquals('bar', $path->getBasename());
        $this->assertNull($path->getExtension());
        $this->assertEquals('bar', $path->getFilename());
    }

    public function testFile()
    {
        $path = string('index.php')->pathInfo();

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('index.php', $path->getBasename());
        $this->assertEquals('php', $path->getExtension());
        $this->assertEquals('index', $path->getFilename());
    }

    public function testfilePath()
    {
        $path = string('foo/bar/index.php')->pathInfo();

        $this->assertEquals('foo/bar', $path->getDirname());
        $this->assertEquals('index.php', $path->getBasename());
        $this->assertEquals('php', $path->getExtension());
        $this->assertEquals('index', $path->getFilename());
    }
}