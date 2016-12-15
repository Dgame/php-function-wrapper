<?php

use function Dgame\Wrapper\filename;
use PHPUnit\Framework\TestCase;

class pathOfTest extends TestCase
{
    public function testSingle()
    {
        $path = filename('foo')->info();

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('foo', $path->getBasename());
        $this->assertEmpty($path->getExtension());
        $this->assertEquals('foo', $path->getFilename());
    }

    public function testDirectory()
    {
        $path = filename('foo/')->info();

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('foo', $path->getBasename());
        $this->assertEmpty($path->getExtension());
        $this->assertEquals('foo', $path->getFilename());
    }

    public function testPath()
    {
        $path = filename('foo/bar')->info();

        $this->assertEquals('foo', $path->getDirname());
        $this->assertEquals('bar', $path->getBasename());
        $this->assertEmpty($path->getExtension());
        $this->assertEquals('bar', $path->getFilename());
    }

    public function testFile()
    {
        $path = filename('index.php')->info();

        $this->assertEquals('.', $path->getDirname());
        $this->assertEquals('index.php', $path->getBasename());
        $this->assertEquals('php', $path->getExtension());
        $this->assertEquals('index', $path->getFilename());
    }

    public function testfilePath()
    {
        $path = filename('foo/bar/index.php')->info();

        $this->assertEquals('foo/bar', $path->getDirname());
        $this->assertEquals('index.php', $path->getBasename());
        $this->assertEquals('php', $path->getExtension());
        $this->assertEquals('index', $path->getFilename());
    }
}