<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\pathOf;

class pathOfTest extends TestCase
{
    public function testSingle()
    {
        $path = pathOf('foo');

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('foo', $path->getBasename());
        $this->assertEmpty($path->getExtension());
        $this->assertEquals('foo', $path->getFilename());
    }

    public function testDirectory()
    {
        $path = pathOf('foo/');

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('foo', $path->getBasename());
        $this->assertEmpty($path->getExtension());
        $this->assertEquals('foo', $path->getFilename());
    }

    public function testPath()
    {
        $path = pathOf('foo/bar');

        $this->assertEquals('foo', $path->getDirname());
        $this->assertEquals('bar', $path->getBasename());
        $this->assertEmpty($path->getExtension());
        $this->assertEquals('bar', $path->getFilename());
    }

    public function testFile()
    {
        $path = pathOf('index.php');

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('index.php', $path->getBasename());
        $this->assertEquals('php', $path->getExtension());
        $this->assertEquals('index', $path->getFilename());
    }

    public function testfilePath()
    {
        $path = pathOf('foo/bar/index.php');

        $this->assertEquals('foo/bar', $path->getDirname());
        $this->assertEquals('index.php', $path->getBasename());
        $this->assertEquals('php', $path->getExtension());
        $this->assertEquals('index', $path->getFilename());
    }
}