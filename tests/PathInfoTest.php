<?php

use PHPUnit\Framework\TestCase;
use function Dgame\Wrapper\string;

class PathInfoTest extends TestCase
{
    public function testSingle()
    {
        $path = string('foo')->pathInfo();

        $this->assertTrue($path->getDirname()->isSome($dirname));
        $this->assertEquals('.', $dirname);
        $this->assertTrue($path->getBasename()->isSome($basename));
        $this->assertEquals('foo', $basename);
        $this->assertTrue($path->getExtension()->isNone());
        $this->assertTrue($path->getFilename()->isSome($filename));
        $this->assertEquals('foo', $filename);
    }

    public function testDirectory()
    {
        $path = string('foo/')->pathInfo();

        $this->assertTrue($path->getDirname()->isSome($dirname));
        $this->assertEquals('.', $dirname);
        $this->assertTrue($path->getBasename()->isSome($basename));
        $this->assertEquals('foo', $basename);
        $this->assertTrue($path->getExtension()->isNone());
        $this->assertTrue($path->getFilename()->isSome($filename));
        $this->assertEquals('foo', $filename);
    }

    public function testPath()
    {
        $path = string('foo/bar')->pathInfo();

        $this->assertTrue($path->getDirname()->isSome($dirname));
        $this->assertEquals('foo', $dirname);
        $this->assertTrue($path->getBasename()->isSome($basename));
        $this->assertEquals('bar', $basename);
        $this->assertTrue($path->getExtension()->isNone());
        $this->assertTrue($path->getFilename()->isSome($filename));
        $this->assertEquals('bar', $filename);
    }

    public function testFile()
    {
        $path = string('index.php')->pathInfo();

        $this->assertTrue($path->getDirname()->isSome($dirname));
        $this->assertEquals('.', $dirname);
        $this->assertTrue($path->getBasename()->isSome($basename));
        $this->assertEquals('index.php', $basename);
        $this->assertTrue($path->getExtension()->isSome($extension));
        $this->assertEquals('php', $extension);
        $this->assertTrue($path->getFilename()->isSome($filename));
        $this->assertEquals('index', $filename);
    }

    public function testfilePath()
    {
        $path = string('foo/bar/index.php')->pathInfo();

        $this->assertTrue($path->getDirname()->isSome($dirname));
        $this->assertEquals('foo/bar', $dirname);
        $this->assertTrue($path->getBasename()->isSome($basename));
        $this->assertEquals('index.php', $basename);
        $this->assertTrue($path->getExtension()->isSome($extension));
        $this->assertEquals('php', $extension);
        $this->assertTrue($path->getFilename()->isSome($filename));
        $this->assertEquals('index', $filename);
    }
}