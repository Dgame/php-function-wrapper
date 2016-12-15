<?php

use function Dgame\Wrapper\object;
use PHPUnit\Framework\TestCase;

class NamespaceInfoTest extends TestCase
{
    public function testClass()
    {
        $ns = object(static::class)->getNamespaceInfo();

        $this->assertEquals('NamespaceInfoTest', $ns->getClass());
        $this->assertEquals(static::class, $ns->getClass());
        $this->assertEmpty($ns->getNamespace());
    }

    public function testExternalClass()
    {
        $ns = object('\Exception')->getNamespaceInfo();

        $this->assertEquals('Exception', $ns->getClass());
        $this->assertEmpty($ns->getNamespace());
    }

    public function testNamespace()
    {
        $ns = object(TestCase::class)->getNamespaceInfo();

        $this->assertEquals('TestCase', $ns->getClass());
        $this->assertEquals('PHPUnit\Framework', $ns->getNamespace());
    }
}